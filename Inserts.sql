USE VETCAREDB;

-- Inserta el usuario SYSTEM
INSERT INTO tUsuarios (Identificacion, Nombre, Correo, Contrasenna, Activo, tRol_id)
VALUES ('102220222', 'SYSTEM', 'sys.vetcare@gmail.com', 'VetCare123', 1, 1);

-- Se crean los roles
INSERT INTO tRoles (NombreRol) VALUES 
('system'),
('admin'),
('veterinario'),
('cliente');

INSERT INTO tmedicamentos (Nombre, Descripcion, Precio, Cantidad)
VALUES ('Epiotic spherulites x 100 Ml', 'Su uso regular ayuda a prevenir las recaídas en animales predispuestos y a mantener el equilibrio microbiano natural.', 37.60, '10')
