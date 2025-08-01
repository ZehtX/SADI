USE `SADI`;

-- ##################################################################
-- ############### PARTE 1: INSERCIÓN DE DATOS DE PRUEBA #############
-- ##################################################################

-- INSERT para la entidad Rol
INSERT INTO Rol (PK_ID, Nombre, Descripcion) VALUES (1, 'Administrador', 'Rol con permisos totales.');
INSERT INTO Rol (PK_ID, Nombre, Descripcion) VALUES (2, 'Empleado', 'Rol con permisos limitados.');

-- INSERT para la entidad Usuario
INSERT INTO Usuario (PK_ID, Nombre, Email, Password, FK_ID_Rol) VALUES (1, 'Juan Perez', 'juan.perez@empresa.com', 'pass123', 1);
INSERT INTO Usuario (PK_ID, Nombre, Email, Password, FK_ID_Rol) VALUES (2, 'Maria Lopez', 'maria.lopez@empresa.com', 'pass456', 2);

-- INSERT para la entidad Categoria_Materia_Prima
INSERT INTO Categoria_Materia_Prima (PK_ID, Nombre, Descripcion) VALUES (1, 'Granos', 'Productos de granos y cereales.');
INSERT INTO Categoria_Materia_Prima (PK_ID, Nombre, Descripcion) VALUES (2, 'Lácteos', 'Productos lácteos y derivados.');

-- INSERT para la entidad Proveedor
INSERT INTO Proveedor (PK_ID, Nombre_Comercial, Nombre_Fiscal, Rif, Telefono, Email, Direccion_Fiscal) VALUES (1, 'Provedora A', 'Provedora A S.A.', 'J-12345678-9', '0212-1112233', 'contacto@provedoraa.com', 'Av. Principal, Caracas.');
INSERT INTO Proveedor (PK_ID, Nombre_Comercial, Nombre_Fiscal, Rif, Telefono, Email, Direccion_Fiscal) VALUES (2, 'Lacteos C.A.', 'Lacteos de Venezuela C.A.', 'J-98765432-1', '0212-9988776', 'ventas@lacteos.com', 'Calle El Sol, Maracay.');

-- INSERT para la entidad Categoria_Producto
INSERT INTO Categoria_Producto (PK_ID, Nombre, Descripcion) VALUES (1, 'Bebidas', 'Bebidas alcohólicas y no alcohólicas.');
INSERT INTO Categoria_Producto (PK_ID, Nombre, Descripcion) VALUES (2, 'Postres', 'Postres y dulces.');

-- INSERT para la entidad Materia_Prima
INSERT INTO Materia_Prima (PK_ID, Nombre, Stock, Stock_Minimo, Precio_Costo, Unidad_Medida, FK_ID_Categoria_Mat_Prima, FK_ID_Proveedor) VALUES (1, 'Café en grano', 50, 10, 5.50, 'kg', 1, 1);
INSERT INTO Materia_Prima (PK_ID, Nombre, Stock, Stock_Minimo, Precio_Costo, Unidad_Medida, FK_ID_Categoria_Mat_Prima, FK_ID_Proveedor) VALUES (2, 'Leche entera', 100, 20, 1.25, 'litro', 2, 2);

-- INSERT para la entidad Producto
INSERT INTO Producto (PK_ID, Nombre, Stock, Stock_Minimo, Precio_Costo, Precio_Venta, FK_ID_Categoria_Prod, FK_ID_Proveedor) VALUES (1, 'Torta de chocolate', 30, 5, 8.00, 15.00, 2, 1);
INSERT INTO Producto (PK_ID, Nombre, Stock, Stock_Minimo, Precio_Costo, Precio_Venta, FK_ID_Categoria_Prod, FK_ID_Proveedor) VALUES (2, 'Jugo de Naranja', 50, 10, 2.50, 4.50, 1, 1);

-- INSERT para la entidad Cliente
INSERT INTO Cliente (PK_ID, Nombre, Direccion_Fiscal, Rif_Cedula, Telefono, Email, Tipo_Cliente) VALUES (1, 'Comercializadora Z', 'Av. Bolivar, Valencia.', 'V-12345678', '0414-1234567', 'ventas@comercializadoraz.com', 'Empresa');
INSERT INTO Cliente (PK_ID, Nombre, Direccion_Fiscal, Rif_Cedula, Telefono, Email, Tipo_Cliente) VALUES (2, 'Pedro Salazar', 'Calle 10, El Viñedo.', 'V-87654321', '0424-9876543', 'pedro.s@gmail.com', 'Persona Natural');

-- INSERT para la entidad Forma_Pago
INSERT INTO Forma_Pago (PK_ID, Nombre, Descripcion) VALUES (1, 'Efectivo', 'Pago en moneda local.');
INSERT INTO Forma_Pago (PK_ID, Nombre, Descripcion) VALUES (2, 'Tarjeta de Crédito', 'Pago a través de tarjeta de crédito.');

-- INSERT para la entidad Movimiento_Inventario
INSERT INTO Movimiento_Inventario (PK_ID, Tipo, Fecha, Cantidad, FK_ID_Materia_Prima, FK_ID_Usuario) VALUES (1, 'Entrada', '2025-07-25', 20, 1, 1);
INSERT INTO Movimiento_Inventario (PK_ID, Tipo, Fecha, Cantidad, FK_ID_Materia_Prima, FK_ID_Usuario) VALUES (2, 'Salida', '2025-07-26', 5, 2, 2);

-- INSERT para la entidad Orden_Compra
INSERT INTO Orden_Compra (PK_ID, Fecha_Emision, Fecha_Entrega_Est, Monto_Total, FK_ID_Proveedor) VALUES (1, '2025-07-20', '2025-07-27 10:00:00', 110.00, 1);
INSERT INTO Orden_Compra (PK_ID, Fecha_Emision, Fecha_Entrega_Est, Monto_Total, FK_ID_Proveedor) VALUES (2, '2025-07-22', '2025-07-29 15:00:00', 125.00, 2);

-- INSERT para la entidad Detalle_Compra
INSERT INTO Detalle_Compra (PK_ID, Cantidad, Precio_Compra, FK_ID_Orden_Compra, FK_ID_Materia_Prima) VALUES (1, 10, 5.50, 1, 1);
INSERT INTO Detalle_Compra (PK_ID, Cantidad, Precio_Compra, FK_ID_Orden_Compra, FK_ID_Materia_Prima) VALUES (2, 20, 6.25, 2, 2);

-- INSERT para la entidad Factura
INSERT INTO Factura (PK_ID, Numero_Factura, Fecha, Total, Status, FK_ID_Cliente) VALUES (1, 'FAC-001', '2025-07-28', 150.00, 'Pagada', 1);
INSERT INTO Factura (PK_ID, Numero_Factura, Fecha, Total, Status, FK_ID_Cliente) VALUES (2, 'FAC-002', '2025-07-29', 45.00, 'Pendiente', 2);

-- INSERT para la entidad Presupuesto
INSERT INTO Presupuesto (PK_ID, Nombre, Direccion, Telefono, Email, Fecha_Llegada, Fecha_Salida, FK_ID_Factura) VALUES (1, 'Luis Hernandez', 'Av. 2, Urb. Las Acacias', '0412-5556677', 'luis.h@email.com', '2025-07-28', '2025-07-30', 1);
INSERT INTO Presupuesto (PK_ID, Nombre, Direccion, Telefono, Email, Fecha_Llegada, Fecha_Salida, FK_ID_Factura) VALUES (2, 'Ana Gomez', 'Calle 5, El Trigal', '0414-3334455', 'ana.g@email.com', '2025-07-29', '2025-08-01', 2);

-- INSERT para la entidad Pago_Factura
INSERT INTO Pago_Factura (PK_ID, Monto, Fecha_Pago, FK_ID_Factura, FK_ID_Forma_Pago) VALUES (1, 150.00, '2025-07-28', 1, 1);
INSERT INTO Pago_Factura (PK_ID, Monto, Fecha_Pago, FK_ID_Factura, FK_ID_Forma_Pago) VALUES (2, 20.00, '2025-07-29', 2, 2);

-- INSERT para la entidad Detalle (de Factura)
INSERT INTO Detalle (PK_ID, Cantidad, Precio_Unitario, Subtotal, FK_ID_Factura, FK_ID_Producto) VALUES (1, 1, 15.00, 15.00, 1, 1);
INSERT INTO Detalle (PK_ID, Cantidad, Precio_Unitario, Subtotal, FK_ID_Factura, FK_ID_Producto) VALUES (2, 5, 4.50, 22.50, 2, 2);

-- INSERT para la entidad Nota_Entrega
INSERT INTO Nota_Entrega (PK_ID, Numero_Nota, Fecha_Emision, Direccion_Despacho, FK_ID_Cliente, FK_ID_Factura) VALUES (1, 'NE-001', '2025-07-28', 'Av. Principal, Edificio B.', 1, 1);
INSERT INTO Nota_Entrega (PK_ID, Numero_Nota, Fecha_Emision, Direccion_Despacho, FK_ID_Cliente, FK_ID_Factura) VALUES (2, 'NE-002', '2025-07-29', 'Calle 10, El Trigal.', 2, 2);

-- INSERT para la entidad Nota_Credito
INSERT INTO Nota_Credito (PK_ID, Numero_Nota, Fecha, Monto_Total, FK_ID_Factura) VALUES (1, 'NC-001', '2025-07-30', 25.00, 1);
INSERT INTO Nota_Credito (PK_ID, Numero_Nota, Fecha, Monto_Total, FK_ID_Factura) VALUES (2, 'NC-002', '2025-07-31', 10.00, 2);


-- ##################################################################
-- ########## PARTE 2: LECTURA Y ACTUALIZACIÓN DE DATOS #############
-- ##################################################################

-- READ y UPDATE de cada tabla

-- Rol
SELECT '--- Rol antes del UPDATE ---';
SELECT * FROM Rol WHERE PK_ID = 1;
UPDATE Rol SET Descripcion = 'Rol con todos los permisos (actualizado).' WHERE PK_ID = 1;
SELECT '--- Rol después del UPDATE ---';
SELECT * FROM Rol WHERE PK_ID = 1;

-- Usuario
SELECT '--- Usuario antes del UPDATE ---';
SELECT * FROM Usuario WHERE PK_ID = 1;
UPDATE Usuario SET Email = 'juan.perez.nuevo@empresa.com' WHERE PK_ID = 1;
SELECT '--- Usuario después del UPDATE ---';
SELECT * FROM Usuario WHERE PK_ID = 1;

-- Presupuesto
SELECT '--- Presupuesto antes del UPDATE ---';
SELECT * FROM Presupuesto WHERE PK_ID = 1;
UPDATE Presupuesto SET Telefono = '0412-5551111' WHERE PK_ID = 1;
SELECT '--- Presupuesto después del UPDATE ---';
SELECT * FROM Presupuesto WHERE PK_ID = 1;

-- Factura
SELECT '--- Factura antes del UPDATE ---';
SELECT * FROM Factura WHERE PK_ID = 2;
UPDATE Factura SET Total = 55.00 WHERE PK_ID = 2;
SELECT '--- Factura después del UPDATE ---';
SELECT * FROM Factura WHERE PK_ID = 2;

-- Forma_Pago
SELECT '--- Forma_Pago antes del UPDATE ---';
SELECT * FROM Forma_Pago WHERE PK_ID = 2;
UPDATE Forma_Pago SET Nombre = 'Tarjeta de Débito' WHERE PK_ID = 2;
SELECT '--- Forma_Pago después del UPDATE ---';
SELECT * FROM Forma_Pago WHERE PK_ID = 2;

-- Pago_Factura
SELECT '--- Pago_Factura antes del UPDATE ---';
SELECT * FROM Pago_Factura WHERE PK_ID = 2;
UPDATE Pago_Factura SET Monto = 25.00 WHERE PK_ID = 2;
SELECT '--- Pago_Factura después del UPDATE ---';
SELECT * FROM Pago_Factura WHERE PK_ID = 2;

-- Cliente
SELECT '--- Cliente antes del UPDATE ---';
SELECT * FROM Cliente WHERE PK_ID = 1;
UPDATE Cliente SET Telefono = '0414-9998877' WHERE PK_ID = 1;
SELECT '--- Cliente después del UPDATE ---';
SELECT * FROM Cliente WHERE PK_ID = 1;

-- Detalle
SELECT '--- Detalle antes del UPDATE ---';
SELECT * FROM Detalle WHERE PK_ID = 1;
UPDATE Detalle SET Cantidad = 2 WHERE PK_ID = 1;
SELECT '--- Detalle después del UPDATE ---';
SELECT * FROM Detalle WHERE PK_ID = 1;

-- Nota_Entrega
SELECT '--- Nota_Entrega antes del UPDATE ---';
SELECT * FROM Nota_Entrega WHERE PK_ID = 1;
UPDATE Nota_Entrega SET Direccion_Despacho = 'Nueva Dirección de Envío' WHERE PK_ID = 1;
SELECT '--- Nota_Entrega después del UPDATE ---';
SELECT * FROM Nota_Entrega WHERE PK_ID = 1;

-- Nota_Credito
SELECT '--- Nota_Credito antes del UPDATE ---';
SELECT * FROM Nota_Credito WHERE PK_ID = 1;
UPDATE Nota_Credito SET Monto_Total = 30.00 WHERE PK_ID = 1;
SELECT '--- Nota_Credito después del UPDATE ---';
SELECT * FROM Nota_Credito WHERE PK_ID = 1;

-- Movimiento_Inventario
SELECT '--- Movimiento_Inventario antes del UPDATE ---';
SELECT * FROM Movimiento_Inventario WHERE PK_ID = 1;
UPDATE Movimiento_Inventario SET Cantidad = 25 WHERE PK_ID = 1;
SELECT '--- Movimiento_Inventario después del UPDATE ---';
SELECT * FROM Movimiento_Inventario WHERE PK_ID = 1;

-- Materia_Prima
SELECT '--- Materia_Prima antes del UPDATE ---';
SELECT * FROM Materia_Prima WHERE PK_ID = 1;
UPDATE Materia_Prima SET Stock = 60 WHERE PK_ID = 1;
SELECT '--- Materia_Prima después del UPDATE ---';
SELECT * FROM Materia_Prima WHERE PK_ID = 1;

-- Categoria_Materia_Prima
SELECT '--- Categoria_Materia_Prima antes del UPDATE ---';
SELECT * FROM Categoria_Materia_Prima WHERE PK_ID = 1;
UPDATE Categoria_Materia_Prima SET Nombre = 'Granos y Cereales' WHERE PK_ID = 1;
SELECT '--- Categoria_Materia_Prima después del UPDATE ---';
SELECT * FROM Categoria_Materia_Prima WHERE PK_ID = 1;

-- Producto
SELECT '--- Producto antes del UPDATE ---';
SELECT * FROM Producto WHERE PK_ID = 1;
UPDATE Producto SET Precio_Venta = 16.50 WHERE PK_ID = 1;
SELECT '--- Producto después del UPDATE ---';
SELECT * FROM Producto WHERE PK_ID = 1;

-- Categoria_Producto
SELECT '--- Categoria_Producto antes del UPDATE ---';
SELECT * FROM Categoria_Producto WHERE PK_ID = 1;
UPDATE Categoria_Producto SET Nombre = 'Bebidas y Jugos' WHERE PK_ID = 1;
SELECT '--- Categoria_Producto después del UPDATE ---';
SELECT * FROM Categoria_Producto WHERE PK_ID = 1;

-- Proveedor
SELECT '--- Proveedor antes del UPDATE ---';
SELECT * FROM Proveedor WHERE PK_ID = 1;
UPDATE Proveedor SET Telefono = '0212-3334455' WHERE PK_ID = 1;
SELECT '--- Proveedor después del UPDATE ---';
SELECT * FROM Proveedor WHERE PK_ID = 1;

-- Orden_Compra
SELECT '--- Orden_Compra antes del UPDATE ---';
SELECT * FROM Orden_Compra WHERE PK_ID = 1;
UPDATE Orden_Compra SET Monto_Total = 120.00 WHERE PK_ID = 1;
SELECT '--- Orden_Compra después del UPDATE ---';
SELECT * FROM Orden_Compra WHERE PK_ID = 1;

-- Detalle_Compra
SELECT '--- Detalle_Compra antes del UPDATE ---';
SELECT * FROM Detalle_Compra WHERE PK_ID = 1;
UPDATE Detalle_Compra SET Cantidad = 15 WHERE PK_ID = 1;
SELECT '--- Detalle_Compra después del UPDATE ---';
SELECT * FROM Detalle_Compra WHERE PK_ID = 1;


-- ##################################################################
-- ############### PARTE 3: ELIMINACIÓN DE DATOS DE PRUEBA ###########
-- ##################################################################
-- Las eliminaciones se realizan en orden inverso para evitar errores de llaves foráneas.

DELETE FROM Detalle WHERE FK_ID_Factura IN (1, 2);
DELETE FROM Nota_Entrega WHERE FK_ID_Factura IN (1, 2);
DELETE FROM Nota_Credito WHERE FK_ID_Factura IN (1, 2);
DELETE FROM Pago_Factura WHERE FK_ID_Factura IN (1, 2);
DELETE FROM Presupuesto WHERE FK_ID_Factura IN (1, 2);
DELETE FROM Factura WHERE PK_ID IN (1, 2);

DELETE FROM Detalle_Compra WHERE FK_ID_Orden_Compra IN (1, 2);
DELETE FROM Orden_Compra WHERE PK_ID IN (1, 2);
DELETE FROM Movimiento_Inventario WHERE FK_ID_Materia_Prima IN (1, 2);
DELETE FROM Materia_Prima WHERE PK_ID IN (1, 2);
DELETE FROM Producto WHERE PK_ID IN (1, 2);
DELETE FROM Categoria_Materia_Prima WHERE PK_ID IN (1, 2);
DELETE FROM Categoria_Producto WHERE PK_ID IN (1, 2);
DELETE FROM Proveedor WHERE PK_ID IN (1, 2);
DELETE FROM Cliente WHERE PK_ID IN (1, 2);
DELETE FROM Usuario WHERE PK_ID IN (1, 2);
DELETE FROM Rol WHERE PK_ID IN (1, 2);
DELETE FROM Forma_Pago WHERE PK_ID IN (1, 2);

SELECT '--- Eliminación completada ---';