<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    // =========================
    // VER CARRITO
    // =========================
    public function index()
    {
        $cart = session('cart', []);

        $total = collect($cart)->sum(function ($item) {
            return $item['precio'] * $item['cantidad'];
        });

        return view('clientes.carrito', compact('cart', 'total'));
    }

    // =========================
    // AGREGAR PRODUCTO
    // =========================
    public function add(Request $request, $productoId)
    {
        $producto = Producto::with('inventario')->findOrFail($productoId);

        $cantidad = max(1, (int) $request->input('cantidad', 1));
        $stock    = optional($producto->inventario)->stock ?? 0;

        if ($stock <= 0) {
            return back()->with('error', 'Este producto está agotado.');
        }

        if ($cantidad > $stock) {
            return back()->with(
                'error',
                "Solo hay {$stock} unidades disponibles de {$producto->nombre}."
            );
        }

        $cart = session('cart', []);

        if (isset($cart[$productoId])) {
            $nuevaCantidad = $cart[$productoId]['cantidad'] + $cantidad;

            if ($nuevaCantidad > $stock) {
                return back()->with(
                    'error',
                    "No puedes agregar más de {$stock} unidades de {$producto->nombre}."
                );
            }

            $cart[$productoId]['cantidad'] = $nuevaCantidad;
        } else {
            $cart[$productoId] = [
                'id_producto' => $producto->id_producto,
                'nombre'      => $producto->nombre,
                'precio'      => (float) $producto->precio_venta,
                'cantidad'    => $cantidad,
            ];
        }

        session(['cart' => $cart]);

        return back()->with('success', 'Producto añadido al carrito.');
    }

    // =========================
    // ELIMINAR RENGLÓN
    // =========================
    public function remove($productoId)
    {
        $cart = session('cart', []);

        if (isset($cart[$productoId])) {
            unset($cart[$productoId]);
            session(['cart' => $cart]);
        }

        return back()->with('success', 'Producto eliminado del carrito.');
    }

    // =========================
    // VACIAR CARRITO
    // =========================
    public function clear()
    {
        session()->forget('cart');

        return back()->with('success', 'Carrito vaciado.');
    }

    // =========================
    // CONFIRMAR PEDIDO
    //   - Inserta en pedidos
    //   - Inserta renglones en pedidos_detalle
    //   - Descuenta stock en inventario
    // =========================
    public function confirm()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Tu carrito está vacío.');
        }

        $user = Auth::user();

        // En tabla clientes (veggourmet) el campo es "email"
        $cliente = Cliente::where('email', $user->email)->first();

        if (!$cliente) {
            return back()->with(
                'error',
                'No se encontró un registro en "clientes" para el correo ' . $user->email
            );
        }

        try {
            DB::beginTransaction();

            // Total sólo para mostrar al usuario (la tabla pedidos no tiene columna total)
            $total = collect($cart)->sum(function ($item) {
                return $item['precio'] * $item['cantidad'];
            });

            // 1) Crear encabezado en tabla veggourmet.pedidos
            // columnas: id_pedido, id_cliente, fecha, id_estado, tipo, id_empleado_toma
            $idPedido = DB::table('pedidos')->insertGetId([
                'id_cliente'       => $cliente->id_cliente,
                'fecha'            => now(),
                'id_estado'        => 1,
                'tipo'             => 'Delivery',
                'id_empleado_toma' => null,
            ]);

            // 2) Renglones y actualización de inventario
            foreach ($cart as $productoId => $item) {

                // Bloquear fila de inventario
                $inventario = DB::table('inventario')
                    ->where('id_producto', $productoId)
                    ->lockForUpdate()
                    ->first();

                if (!$inventario) {
                    throw new \Exception("No existe inventario para el producto ID {$productoId}.");
                }

                if ($inventario->stock < $item['cantidad']) {
                    throw new \Exception("No hay stock suficiente de {$item['nombre']}.");
                }

                // Insertar en pedidos_detalle (veggourmet)
                // columnas: id_pedido_detalle, id_pedido, id_producto, cantidad
                DB::table('pedidos_detalle')->insert([
                    'id_pedido'   => $idPedido,
                    'id_producto' => $productoId,
                    'cantidad'    => $item['cantidad'],
                ]);

                // Descontar stock
                DB::table('inventario')
                    ->where('id_producto', $productoId)
                    ->update([
                        'stock' => $inventario->stock - $item['cantidad'],
                    ]);
            }

            DB::commit();

            // Limpiar carrito en sesión
            session()->forget('cart');

            return redirect()
                ->route('clientes.productos')
                ->with(
                    'success',
                    "Tu pedido #{$idPedido} se registró correctamente. Total aproximado: $" .
                    number_format($total, 2)
                );

        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with(
                'error',
                'No se pudo registrar tu pedido: ' . $e->getMessage()
            );
        }
    }
}
