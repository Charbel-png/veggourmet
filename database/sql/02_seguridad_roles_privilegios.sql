-- Script de roles y privilegios para la base veggourmet

USE veggourmet;

-- 1. Crear roles (si tu versión soporta DROP ROLE IF EXISTS, puedes activarlo)
-- DROP ROLE IF EXISTS 'rol_admin', 'rol_operador', 'rol_cliente';

CREATE ROLE 'rol_admin';
CREATE ROLE 'rol_operador';
CREATE ROLE 'rol_cliente';

-- 2. Privilegios del rol_admin: control total sobre el esquema
GRANT SELECT, INSERT, UPDATE, DELETE
ON veggourmet.*
TO 'rol_admin';

-- 3. Privilegios del rol_operador (operaciones del día a día)

-- Catálogos y productos
GRANT SELECT, INSERT, UPDATE
ON veggourmet.categorias
TO 'rol_operador';

GRANT SELECT, INSERT, UPDATE
ON veggourmet.productos
TO 'rol_operador';

GRANT SELECT, INSERT, UPDATE
ON veggourmet.ingredientes
TO 'rol_operador';

GRANT SELECT
ON veggourmet.unidades_medida
TO 'rol_operador';

GRANT SELECT, INSERT, UPDATE
ON veggourmet.recetas
TO 'rol_operador';

-- Inventario
GRANT SELECT, INSERT, UPDATE
ON veggourmet.inventario
TO 'rol_operador';

-- Clientes y pedidos
GRANT SELECT, INSERT, UPDATE
ON veggourmet.clientes
TO 'rol_operador';

GRANT SELECT, INSERT, UPDATE
ON veggourmet.pedidos
TO 'rol_operador';

GRANT SELECT, INSERT, UPDATE, DELETE
ON veggourmet.pedidos_detalle
TO 'rol_operador';

-- Proveedores y compras
GRANT SELECT, INSERT, UPDATE
ON veggourmet.proveedores
TO 'rol_operador';

GRANT SELECT, INSERT, UPDATE
ON veggourmet.compras
TO 'rol_operador';

GRANT SELECT, INSERT, UPDATE, DELETE
ON veggourmet.compras_detalle
TO 'rol_operador';

-- Catálogos de estados y RRHH (solo lectura)
GRANT SELECT
ON veggourmet.estados_pedido
TO 'rol_operador';

GRANT SELECT
ON veggourmet.estados_compra
TO 'rol_operador';

GRANT SELECT
ON veggourmet.empleados
TO 'rol_operador';

GRANT SELECT
ON veggourmet.puestos
TO 'rol_operador';

GRANT SELECT
ON veggourmet.usuarios
TO 'rol_operador';

-- 4. Privilegios del rol_cliente (limitado; filtro por id_cliente va en la app)

-- Catálogos visibles
GRANT SELECT
ON veggourmet.categorias
TO 'rol_cliente';

GRANT SELECT
ON veggourmet.productos
TO 'rol_cliente';

-- Datos del propio cliente y sus pedidos
GRANT SELECT, INSERT, UPDATE
ON veggourmet.clientes
TO 'rol_cliente';

GRANT SELECT, INSERT, UPDATE
ON veggourmet.pedidos
TO 'rol_cliente';

GRANT SELECT, INSERT
ON veggourmet.pedidos_detalle
TO 'rol_cliente';

-- Estado del pedido (solo lectura)
GRANT SELECT
ON veggourmet.estados_pedido
TO 'rol_cliente';

-- No se otorgan privilegios sobre:
-- proveedores, compras, compras_detalle,
-- estados_compra, empleados, puestos, usuarios para rol_cliente.

-- 5. (Opcional) Ejemplo de usuarios físicos que usarían estos roles

-- CREATE USER 'admin_app'@'localhost'    IDENTIFIED BY 'Admin123!';
-- CREATE USER 'operador_app'@'localhost' IDENTIFIED BY 'Operador123!';
-- CREATE USER 'cliente_app'@'localhost'  IDENTIFIED BY 'Cliente123!';

-- GRANT 'rol_admin'    TO 'admin_app'@'localhost';
-- GRANT 'rol_operador' TO 'operador_app'@'localhost';
-- GRANT 'rol_cliente'  TO 'cliente_app'@'localhost';

-- SET DEFAULT ROLE 'rol_admin'    TO 'admin_app'@'localhost';
-- SET DEFAULT ROLE 'rol_operador' TO 'operador_app'@'localhost';
-- SET DEFAULT ROLE 'rol_cliente'  TO 'cliente_app'@'localhost';

-- FLUSH PRIVILEGES;
