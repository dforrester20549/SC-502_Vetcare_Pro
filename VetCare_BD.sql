USE vetcaredb;

-- Crear usuario y darle todos los privilegios
CREATE USER 'system'@'localhost' IDENTIFIED BY '';
GRANT ALL PRIVILEGES ON *.* TO 'system'@'localhost' WITH GRANT OPTION;
FLUSH PRIVILEGES;

DROP TABLE tDuenos;

-- Eliminar tablas
DROP TABLE tmascotas;


-- Se crean las tablas

-- Tabla: Log
CREATE TABLE Log (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    accion VARCHAR(100) NOT NULL,       
    descripcion TEXT,                   
    usuario_id INT                                
);


-- Tabla: Roles
CREATE TABLE tRoles (
    Id bigint NOT NULL AUTO_INCREMENT PRIMARY KEY,
    NombreRol VARCHAR(50) NOT NULL
);

-- Tabla: Usuarios
CREATE TABLE tUsuarios (
    Id BIGINT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Identificacion VARCHAR(20) NOT NULL,
    Nombre VARCHAR(100) NOT NULL,
    Correo VARCHAR(100) UNIQUE NOT NULL,
    Contrasenna VARCHAR(255) NOT NULL,
    ContrasennaTemporal BOOLEAN DEFAULT FALSE, 
    CodigoRecuperacion VARCHAR(10) DEFAULT NULL,  
    Activo BIT(1) NOT NULL,
    tRol_id BIGINT(11),
    ImagePath VARCHAR(400) NOT NULL,
    Destacado BIT(1) NOT NULL
);

-- Tabla: Dueños
CREATE TABLE tDuenos (
    Id bigint(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    NombreDuenos VARCHAR(100) NOT NULL,
    Telefono VARCHAR(15),
    Email VARCHAR(100),
    Direccion VARCHAR(255),
    Activo bit(1) NOT NULL
);

-- Tabla: Mascotas
CREATE TABLE tMascotas (
    Id bigint(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    NombreMascotas VARCHAR(100) NOT NULL,
    Tipo VARCHAR(50) NOT NULL,
    Raza VARCHAR(50),
    Edad INT,
    Peso DECIMAL(5, 2),
    Fecha_Registro DATE NOT NULL,
    tDueño_Id bigint(11),
    Activo bit(1) NOT NULL
);

-- Tabla: Citas
CREATE TABLE tCitas (
    Id bigint(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    tMascota_id bigint(11),
    Fecha_Cita DATETIME NOT NULL,
    Motivo TEXT,
    Estado ENUM('pendiente', 'completada', 'cancelada'),
    Activo bit(1) NOT NULL,
    tVeterinario_id BIGINT(11)
);

-- Tabla: Tratamientos
CREATE TABLE tTratamientos (
    Id bigint(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    tMascota_Id bigint(11),
    Fecha_Tratamiento DATE NOT NULL,
    Descripcion TEXT,
    Costo DECIMAL(10, 2),
    Activo bit(1) NOT NULL,
    tMedicamento_id BIGINT(11)
);

-- Tabla: Veterinarios
CREATE TABLE tVeterinarios (
    Id bigint(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    NombreVeterinarios VARCHAR(100) NOT NULL,
    Especialidad VARCHAR(50),
    Telefono VARCHAR(15),
    Email VARCHAR(100),
    Activo bit(1) NOT NULL,
    RolId bigint(11) NOT NULL
);

-- Tabla: Medicamentos
CREATE TABLE tMedicamentos (
    Id bigint(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    Descripcion TEXT,
    Dosis VARCHAR(50),
    Activo bit(1) NOT NULL
);

-- Tabla: Facturas
CREATE TABLE tFacturas (
    Id bigint(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    tDueno_Id bigint(11),
    Fecha_Emision DATE NOT NULL,
    Total DECIMAL(10, 2),
    Activo bit(1) NOT NULL
);

-- Tabla: Recuperacion 
CREATE TABLE tRecuperacion (
    id bigint(11) AUTO_INCREMENT PRIMARY KEY,
    tUsuarios_id bigint(11),
    token VARCHAR(255) NOT NULL,
    fecha_expiracion DATETIME NOT NULL,
    Activo bit(1) NOT NULL
);


-- Relacionar tUsuarios con tRoles
ALTER TABLE tUsuarios
ADD CONSTRAINT FK_tUsuarios_tRoles
FOREIGN KEY (tRol_id) REFERENCES tRoles(Id);

-- Relacionar tMascotas con tDuenos
ALTER TABLE tMascotas
ADD CONSTRAINT FK_tMascotas_tDuenos
FOREIGN KEY (tDueno_Id) REFERENCES tDuenos(Id);

-- Relacionar tCitas con tMascotas y tVeterinarios
ALTER TABLE tCitas
ADD CONSTRAINT FK_tCitas_tMascotas
FOREIGN KEY (tMascota_id) REFERENCES tMascotas(Id) ON DELETE CASCADE;


-- Relacionar tTratamientos con tMascotas, tVeterinarios, y tMedicamentos
ALTER TABLE tTratamientos
ADD CONSTRAINT FK_tTratamientos_tMascotas
FOREIGN KEY (tMascota_Id) REFERENCES tMascotas(Id) ON DELETE CASCADE;


-- Relacionar tFacturas con tDuenos
ALTER TABLE tFacturas
ADD CONSTRAINT FK_tFacturas_tDuenos
FOREIGN KEY (tDueno_Id) REFERENCES tDuenos(Id) ON DELETE SET NULL;

-- Relacionar tRecuperacion con tUsuarios
ALTER TABLE tRecuperacion
ADD CONSTRAINT FK_tRecuperacion_tUsuarios
FOREIGN KEY (tUsuarios_id) REFERENCES tUsuarios(Id) ON DELETE CASCADE;

-- Crear la llave foránea de tTratamientos hacia tMedicamentos
ALTER TABLE tTratamientos
ADD CONSTRAINT fk_ttratamientos_tmedicamentos
FOREIGN KEY (tMedicamento_id) REFERENCES tMedicamentos(Id);

-- Crear la llave foránea de tCitas hacia tVeterinarios
ALTER TABLE tCitas
ADD CONSTRAINT fk_tcitas_tveterinarios
FOREIGN KEY (tVeterinario_id) REFERENCES tVeterinarios(Id);

-- Crear la llave foránea de tVeterinarios hacia tRoles
ALTER TABLE tVeterinarios
ADD CONSTRAINT FK_Veterinarios_Roles
FOREIGN KEY (RolId) REFERENCES tRoles(Id);