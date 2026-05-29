USE doa_db; 

-- =======================================================
-- 1. CREACIÓN DE USUARIOS BASE (Con Password)
-- =======================================================

-- Alumnos
INSERT INTO Usuario (Rol, Nombre, Apellido, Email, Password, Telefono) VALUES
('alumno', 'Lief', 'Simants Dredge', 'l.simdre@epsg.upv.es', '123456', '9218611'),
('alumno', 'Merline', 'Kirdsch Kampshell', 'm.kirkam@epsg.upv.es', '123456', '1320191'),
('alumno', 'Debora', 'Rawstorne', 'd.rawabc@epsg.upv.es', '123456', '9971924');

-- Profesores
INSERT INTO Usuario (Rol, Nombre, Apellido, Email, Password, Telefono) VALUES
('profesor', 'Kevan', 'Pounds Mainston', 'k.poumai@upv.es', '123456', '4525956'),
('profesor', 'Luelle', 'Pridmore Starsmeare', 'l.prista@upv.es', '123456', '6055365'),
('profesor', 'Eolande', 'Merriton Mizzi', 'e.mermiz@upv.es', '123456', '6738133'),
('cliente', 'Daniel', 'Palacio', 'dapasa@har.upv.es', '123456', '1234'),
('cliente', 'José Luis', 'Gimenez', 'jogilo@upvnet.upv.es', '123456', '4567');

-- Admins (Los "pas")
INSERT INTO Usuario (Rol, Nombre, Apellido, Email, Password, Telefono) VALUES
('admin', 'Ondrea', 'Brezlaw Sherwill', 'o.breshe@upv.es', '123456', '1316390'),
('admin', 'Brooke', 'Malimoe Thomerson', 'b.maltho@upv.es', '123456', '1970980');

-- =======================================================
-- 2. COMPLETANDO LAS TABLAS HIJAS (DNI y Fechas inventadas para poder probar)
-- =======================================================

-- Alumnos (IDs 1, 2, 3)
INSERT INTO Alumno (ID_user, DNI, Fecha_nacimiento) VALUES
(1, '01-9218611', '2005-03-15'),
(2, '04-1320191', '2004-06-22'),
(3, '05-9971924', '2005-11-02');

-- Profesores (IDs 4, 5, 6)
INSERT INTO Profesor (ID_user, DNI, Fecha_nacimiento) VALUES
(4, '60-4525956', '1980-01-10'),
(5, '64-6055365', '1975-05-20'),
(6, '64-6738133', '1982-08-30');

-- Clientes (IDs 7, 8)
INSERT INTO Cliente (ID_user, NIF) VALUES
(7, '00-0001234'),
(8, '00-0004567');

-- Admins (IDs 9, 10)
INSERT INTO Admin (ID_user, DNI, Fecha_nacimiento) VALUES
(9, '88-1316390', '1990-07-14'),
(10, '91-1970980', '1988-09-09');

-- =======================================================
-- 3. CREANDO GRADOS, CURSOS Y ASIGNATURAS
-- =======================================================

INSERT INTO Grado (Nombre) VALUES ('Desarrollo de Aplicaciones Web');

INSERT INTO Curso (ID_grado, Nombre) VALUES 
(1, 'Primer Curso DAW'), 
(1, 'Segundo Curso DAW');

INSERT INTO Asignatura (ID_curso, Nombre) VALUES
(1, 'Programación'),         -- Asignatura ID 1
(1, 'Bases de Datos'),       -- Asignatura ID 2
(2, 'HCI');  -- Asignatura ID 3

-- =======================================================
-- 4. MATRICULANDO Y ASIGNANDO
-- =======================================================

-- Matrículas de los alumnos (Lief, Merline y Debora) a las asignaturas
INSERT INTO Alumno_Asignatura (ID_alumno, ID_asignatura) VALUES
(1, 1), (1, 2), -- Lief está en Programación y Bases de Datos
(2, 2), (2, 3), -- Merline en Bases de Datos y Servidor
(3, 1), (3, 3); -- Debora en Programación y Servidor

-- Profesores dando clase (Kevan, Luelle, Eolande)
INSERT INTO Profesor_Asignatura (ID_profesor, ID_asignatura) VALUES
(4, 1), -- Kevan da Programación
(5, 2), -- Luelle da Bases de Datos
(6, 3); -- Eolande da Servidor

-- =======================================================
-- 5. RECURSOS, TAREAS Y EXÁMENES (Dejamos los archivos vacíos de momento)
-- =======================================================

INSERT INTO Recurso (ID_asignatura, ID_profesor, Titulo, Descripcion, Estado) VALUES
(1, 4, 'Diapositivas Tema 1', 'Introducción básica a Java', 'activo'),
(2, 5, 'Chuleta de SQL', 'Todos los comandos básicos para MySQL', 'activo');

INSERT INTO Tarea (ID_asignatura, ID_profesor, Titulo, Descripcion, Fecha_limite) VALUES
(1, 4, 'Práctica 1: Calculadora', 'Haced una calculadora funcional', '2026-06-01 23:59:00'),
(2, 5, 'Diseño de Modelo E/R', 'Crear la base de datos de un videoclub', '2026-06-10 23:59:00');

INSERT INTO Examen (ID_asignatura, ID_profesor, Titulo, Fecha_examen) VALUES
(3, 6, 'Examen Parcial 1', '2026-06-15 10:00:00');

-- =======================================================
-- 6. LOS ANUNCIOS
-- =======================================================

INSERT INTO Anuncio (Titulo, Contenido, ID_autor, ID_asignatura, Tipo) VALUES
('¡Bienvenidos a DOA!', 'Estamos en fase beta, perdonen las molestias.', 9, NULL, 'global'),
('Reunión de Evaluación', 'Nos vemos el viernes en la sala de profesores.', 10, NULL, 'solo_profesores'),
('Retraso en la entrega', 'Chicos, he ampliado un día más la fecha límite de la Calculadora.', 4, 1, 'asignatura');


INSERT INTO Entrega_Tarea 
(ID_tarea, ID_alumno, Archivo_URL, Fecha_entrega, Nota, Comentario_profesor)
VALUES
(1, 1, '', '2026-05-28 18:30:00', 8.50, 'Buen trabajo'),
(2, 2, '', '2026-06-02 12:00:00', NULL, NULL),
(1, 3, '', '2026-05-30 20:15:00', NULL, NULL);

INSERT INTO Nota_Examen
(ID_examen, ID_alumno, Nota)
VALUES
(1, 1, 7.25),
(1, 2, 8.00),
(1, 3, NULL);
