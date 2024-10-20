USE vetcaredb;


-- Se crean las tablas

-- Tabla: Roles
CREATE TABLE tRoles (
    Id bigint NOT NULL AUTO_INCREMENT PRIMARY KEY,
    NombreRol VARCHAR(50) NOT NULL
);

-- Tabla: Usuarios
CREATE TABLE tUsuarios (
    Id bigint(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Identificacion varchar(20) NOT NULL,
    Nombre VARCHAR(100) NOT NULL,
    CorreoElectronico VARCHAR(100) UNIQUE NOT NULL,
    Contrasena VARCHAR(255) NOT NULL,
    Activo bit(1) NOT NULL,
    tRol_id bigint(11)
);

-- Tabla: Dueños
CREATE TABLE tDuenos (
    Id bigint(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    Telefono VARCHAR(15),
    Email VARCHAR(100),
    Direccion VARCHAR(255)
);

-- Tabla: Mascotas
CREATE TABLE tMascotas (
    Id bigint(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    Tipo VARCHAR(50) NOT NULL,
    Raza VARCHAR(50),
    Edad INT,
    Peso DECIMAL(5, 2),
    Fecha_Registro DATE NOT NULL,
    tDueño_Id bigint(11)
);

-- Tabla: Citas
CREATE TABLE tCitas (
    Id bigint(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    tMascota_id bigint(11),
    Fecha_Cita DATETIME NOT NULL,
    Motivo TEXT,
    Estado ENUM('pendiente', 'completada', 'cancelada')
);

-- Tabla: Tratamientos
CREATE TABLE tTratamientos (
    Id bigint(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    tMascota_Id bigint(11),
    Fecha_Tratamiento DATE NOT NULL,
    Descripcion TEXT,
    Costo DECIMAL(10, 2)
);

-- Tabla: Veterinarios
CREATE TABLE tVeterinarios (
    Id bigint(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    Especialidad VARCHAR(50),
    Telefono VARCHAR(15),
    Email VARCHAR(100)
);

-- Tabla: Medicamentos
CREATE TABLE tMedicamentos (
    Id bigint(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    Descripcion TEXT,
    Dosis VARCHAR(50)
);

-- Tabla: Facturas
CREATE TABLE tFacturas (
    Id bigint(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    tDueno_Id bigint(11),
    Fecha_Emision DATE NOT NULL,
    Total DECIMAL(10, 2)
);


-- Añadir llaves foráneas
ALTER TABLE tUsuarios
ADD FOREIGN KEY (tRol_id) REFERENCES tRoles(id);

ALTER TABLE tMascotas
ADD FOREIGN KEY (tDueño_id) REFERENCES tDuenos(id);

ALTER TABLE tCitas
ADD FOREIGN KEY (tMascota_id) REFERENCES tMascotas(id);

ALTER TABLE tTratamientos
ADD FOREIGN KEY (tMascota_id) REFERENCES tMascotas(id);

ALTER TABLE tFacturas
ADD FOREIGN KEY (tDueno_id) REFERENCES tDuenos(id);
