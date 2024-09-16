--Tabla Administradores 
CREATE TABLE Administrador (
    idadmin INT AUTO_INCREMENT PRIMARY KEY,
    nombreadmin VARCHAR(255) NOT NULL,
    apellidoadmin VARCHAR(255) NOT NULL,
    dniadmin VARCHAR(8) NOT NULL,
    direccionadmin VARCHAR(255) NOT NULL,
    telefonoadmin VARCHAR(9) NOT NULL,
    passwordadmin VARCHAR(255) NOT NULL,
    habilitadoadmin INT(2)NOT NULL
);
INSERT INTO Administrador (nombreadmin, apellidoadmin, dniadmin, direccionadmin, telefonoadmin, passwordadmin, habilitadoadmin) VALUES
('Carlos Abel', 'Catari Mamani', '70407040', 'Av. Ejercito 500','987654321', 'admin', '1'),
('Angel Gabriel', 'Coaquira Santos', "84519652", 'Av. Aviacion 1000', '986548154', 'angel55', '0');

--Tabla Administradores 
CREATE TABLE Personal (
    idpersonal INT AUTO_INCREMENT PRIMARY KEY,
    nombreperso VARCHAR(255) NOT NULL,
    apellidoperso VARCHAR(255) NOT NULL,
    dniperso VARCHAR(8) NOT NULL,
    direccionperso VARCHAR(255) NOT NULL,
    telefonoperso VARCHAR(9) NOT NULL,
    passwordperso VARCHAR(255) NOT NULL,
    habilitadoperso INT(2)NOT NULL
);
INSERT INTO Administrador (nombreperso, apellidoperso, dniperso, direccionperso, telefonoperso, passwordperso, habilitadoperso) VALUES
('Sebastian', 'Santos Paz', '70457740', 'Av. Arequipa 500','987654561', 'sebas123', '1'),
('Gabriel', 'Coaquira Santos', "84598652", 'Av. Bustamante 1220', '986589154', 'gabriel123', '0');

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
