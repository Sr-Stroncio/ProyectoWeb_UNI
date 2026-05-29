DROP DATABASE IF EXISTS doa_db;
CREATE DATABASE doa_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE doa_db; 

CREATE TABLE Usuario (
	ID INT AUTO_INCREMENT PRIMARY KEY,
	Rol enum ("alumno","profesor","admin","cliente"),
	Nombre varchar(30) not null,
	Apellido varchar(30),
    Password varchar(255),
	Email varchar (55) UNIQUE NOT NULL,
	Telefono varchar(20),
	CONSTRAINT chk_telefono_numerico CHECK (Telefono REGEXP '^[+]?[0-9]+$')
);

CREATE TABLE Alumno (
	ID_user INT PRIMARY KEY,
	DNI varchar(10) not null,
	Fecha_nacimiento DATE,
	FOREIGN KEY(ID_user) REFERENCES Usuario(ID) ON DELETE CASCADE
);

CREATE TABLE Profesor (
	ID_user INT PRIMARY KEY,
	DNI varchar(10) not null,
	Fecha_nacimiento DATE,
	FOREIGN KEY(ID_user) REFERENCES Usuario(ID) ON DELETE CASCADE
);

CREATE TABLE Admin (
	ID_user INT PRIMARY KEY,
	DNI varchar(10) not null,
	Fecha_nacimiento DATE,
	FOREIGN KEY(ID_user) REFERENCES Usuario(ID) ON DELETE CASCADE
);

CREATE TABLE Cliente (
	ID_user INT PRIMARY KEY,
	NIF varchar(10) not null,
	FOREIGN KEY(ID_user) REFERENCES Usuario(ID) ON DELETE CASCADE
);

CREATE TABLE Grado (
	ID INT AUTO_INCREMENT PRIMARY KEY,
	Nombre varchar(60) NOT NULL
);

CREATE TABLE Curso (
	ID INT AUTO_INCREMENT PRIMARY KEY,
    ID_grado INT,
	Nombre varchar(60) NOT NULL,
    FOREIGN KEY(ID_grado) REFERENCES Grado(ID) ON DELETE CASCADE
);

CREATE TABLE Asignatura (
    ID INT AUTO_INCREMENT PRIMARY KEY,
	ID_curso INT,
    Nombre varchar(60) NOT NULL,
    FOREIGN KEY(ID_curso) REFERENCES Curso(ID) ON DELETE CASCADE
);

CREATE TABLE Alumno_Asignatura (
    ID_alumno INT,
    ID_asignatura INT,
    FOREIGN KEY (ID_alumno) REFERENCES Alumno(ID_user) ON DELETE CASCADE,
    FOREIGN KEY (ID_asignatura) REFERENCES Asignatura(ID) ON DELETE CASCADE,
	PRIMARY KEY (ID_alumno, ID_asignatura)
);

CREATE TABLE Profesor_Asignatura (
    ID_profesor INT,
    ID_asignatura INT,
    PRIMARY KEY (ID_profesor, ID_asignatura),
    FOREIGN KEY (ID_profesor) REFERENCES Profesor(ID_user) ON DELETE CASCADE,
    FOREIGN KEY (ID_asignatura) REFERENCES Asignatura(ID) ON DELETE CASCADE
);

CREATE TABLE Recurso (
    ID INT AUTO_INCREMENT PRIMARY KEY,
	ID_asignatura INT,
    ID_profesor INT,
    Titulo VARCHAR(60) NOT NULL,
    Descripcion TEXT,
    Estado ENUM("activo","inactivo"),
    Archivo_URL VARCHAR(255),
    FOREIGN KEY (ID_asignatura) REFERENCES Asignatura(ID) ON DELETE CASCADE,
    FOREIGN KEY (ID_profesor) REFERENCES Profesor(ID_user) ON DELETE CASCADE
);

CREATE TABLE Tarea (
    ID INT AUTO_INCREMENT PRIMARY KEY,
	ID_asignatura INT,
    ID_profesor INT,
    Titulo VARCHAR(100) NOT NULL,
    Descripcion TEXT,
	Archivo_URL VARCHAR(255),
    Fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    Fecha_limite DATETIME,
    FOREIGN KEY (ID_asignatura) REFERENCES Asignatura(ID) ON DELETE CASCADE,
    FOREIGN KEY (ID_profesor) REFERENCES Profesor(ID_user) ON DELETE CASCADE
);

CREATE TABLE Examen (
    ID INT AUTO_INCREMENT PRIMARY KEY,
	ID_asignatura INT,
    ID_profesor INT,
    Titulo VARCHAR(100) NOT NULL,
    Fecha_examen DATETIME,
    FOREIGN KEY (ID_asignatura) REFERENCES Asignatura(ID) ON DELETE CASCADE,
    FOREIGN KEY (ID_profesor) REFERENCES Profesor(ID_user) ON DELETE CASCADE
);

CREATE TABLE Entrega_Tarea (
    ID_tarea INT,
    ID_alumno INT,
    Archivo_URL VARCHAR(255) NOT NULL,
    Fecha_entrega DATETIME DEFAULT CURRENT_TIMESTAMP,
    Nota DECIMAL(4,2), -- Ej: 10.00 o 05.50
    Comentario_profesor TEXT,
    FOREIGN KEY (ID_tarea) REFERENCES Tarea(ID) ON DELETE CASCADE,
    FOREIGN KEY (ID_alumno) REFERENCES Alumno(ID_user) ON DELETE CASCADE,
	PRIMARY KEY (ID_tarea, ID_alumno)
);

CREATE TABLE Nota_Examen (
    ID_examen INT,
    ID_alumno INT,
    Nota DECIMAL(4,2),
    PRIMARY KEY (ID_examen, ID_alumno),
    FOREIGN KEY (ID_examen) REFERENCES Examen(ID) ON DELETE CASCADE,
    FOREIGN KEY (ID_alumno) REFERENCES Alumno(ID_user) ON DELETE CASCADE
);

CREATE TABLE Anuncio (
    ID INT AUTO_INCREMENT PRIMARY KEY,
	ID_autor INT NOT NULL, 
    ID_asignatura INT, 
    Titulo VARCHAR(100) NOT NULL,
    Contenido TEXT NOT NULL,
    Fecha_publicacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    Tipo ENUM('global', 'solo_profesores', 'asignatura') DEFAULT 'global',
    FOREIGN KEY (ID_autor) REFERENCES Usuario(ID) ON DELETE CASCADE,
    FOREIGN KEY (ID_asignatura) REFERENCES Asignatura(ID) ON DELETE CASCADE
);
