-- Tabla Categoria
CREATE TABLE Categoria (
    idcategoria INT AUTO_INCREMENT PRIMARY KEY,
    titulocategoria VARCHAR(100) NOT NULL
);
INSERT INTO Categoria (titulocategoria) VALUES
('Electrodomestico'),
('Equipo de cómputo');

-- Tabla Proveedor
CREATE TABLE Proveedor (
    idproveedor INT AUTO_INCREMENT PRIMARY KEY,
    ruc VARCHAR(11) NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    tipo VARCHAR(255),
    direccion VARCHAR(255) NOT NULL,
    telefono VARCHAR(12) NOT NULL,
    correo VARCHAR(100)
);
INSERT INTO Proveedor (ruc, nombre, tipo, direccion, telefono, correo) VALUES
('20704015448', 'COMPUTADORAS Y TELECOMUNICACIONES S.A', 'ADQUISICIÓN DE SOFTWARE, EQUIPOS Y SERVICIOS TI','Av Ejercito 404', '954987456', 'computele@gmail.com'),
('20804015582', 'AVATAR S.A.C.', 'ADQUISICIÓN DE SOFTWARE, EQUIPOS Y SERVICIOS TI', 'Av Aviación 1050', '954654321', 'avatar400@gmail.com');

-- Tabla Producto
CREATE TABLE Producto (
    idproducto INT AUTO_INCREMENT PRIMARY KEY,
    tituloproducto VARCHAR(100) NOT NULL,
    categoria_id INT,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL,
    proveedor_id INT,
    FOREIGN KEY (categoria_id) REFERENCES Categoria(idcategoria),
    FOREIGN KEY (proveedor_id) REFERENCES Proveedor(idproveedor)
);
INSERT INTO Producto (tituloproducto, categoria_id, descripcion, precio, stock, proveedor_id) VALUES
('Licuadora', 1, '4 velocidades', 70.00, 15, 1),
('Monitor', 2, 'Gaming 30"', 450.00, 5, 2);
