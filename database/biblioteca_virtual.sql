-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-03-2026 a las 00:49:40
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `biblioteca_virtual`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(4, 'Ciencia'),
(5, 'Educación'),
(3, 'Historia'),
(1, 'Novela'),
(2, 'Tecnología');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `autor` varchar(120) NOT NULL,
  `edicion` varchar(150) NOT NULL,
  `anio_publicacion` year(4) NOT NULL,
  `estado` enum('disponible','prestado') NOT NULL DEFAULT 'disponible',
  `categoria_id` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libros`
--
-- Los libros con año de publicación '0000' representan obras clásicas sin fecha específica o con fecha desconocida. 
INSERT INTO `libros` (`id`, `titulo`, `autor`, `edicion`, `anio_publicacion`, `estado`, `categoria_id`, `descripcion`, `fecha_registro`) VALUES
(1, 'Cien años de soledad', 'Gabriel García Márquez', 'Editorial Sudamericana', '1967', 'disponible', 1, 'Novela emblemática del realismo mágico latinoamericano.', '2026-03-20 01:02:54'),
(2, 'Don Quijote de la Mancha', 'Miguel de Cervantes', 'Alfaguara', '0000', 'prestado', 1, 'Clásico de la literatura española sobre las aventuras de un caballero idealista.', '2026-03-20 01:02:54'),
(3, 'La sombra del viento', 'Carlos Ruiz Zafón', 'Planeta', '2001', 'disponible', 1, 'Historia de misterio y libros ambientada en la Barcelona de posguerra.', '2026-03-20 01:02:54'),
(4, 'Orgullo y prejuicio', 'Jane Austen', 'Penguin Classics', '0000', 'disponible', 1, 'Novela romántica y social sobre Elizabeth Bennet y Mr. Darcy.', '2026-03-20 01:02:54'),
(5, '1984', 'George Orwell', 'Debolsillo', '1949', 'prestado', 1, 'Distopía sobre vigilancia, control social y manipulación política.', '2026-03-20 01:02:54'),
(6, 'El principito', 'Antoine de Saint-Exupéry', 'Salamandra', '1943', 'disponible', 1, 'Relato poético sobre amistad, amor y sentido de la vida.', '2026-03-20 01:02:54'),
(7, 'Crónica de una muerte anunciada', 'Gabriel García Márquez', 'Debolsillo', '1981', 'disponible', 1, 'Novela corta sobre un crimen anunciado y el destino inevitable.', '2026-03-20 01:02:54'),
(8, 'Rayuela', 'Julio Cortázar', 'Cátedra', '1963', 'prestado', 1, 'Obra innovadora con múltiples formas de lectura.', '2026-03-20 01:02:54'),
(9, 'Pedro Páramo', 'Juan Rulfo', 'RM Verlag', '1955', 'disponible', 1, 'Novela mexicana sobre memoria, muerte y fantasmas.', '2026-03-20 01:02:54'),
(10, 'La casa de los espíritus', 'Isabel Allende', 'Plaza & Janés', '1982', 'disponible', 1, 'Saga familiar con elementos históricos y mágicos.', '2026-03-20 01:02:54'),
(11, 'Clean Code', 'Robert C. Martin', 'Prentice Hall', '2008', 'disponible', 2, 'Buenas prácticas para escribir código claro, mantenible y profesional.', '2026-03-20 01:02:54'),
(12, 'Código limpio en PHP', 'Laura Méndez', 'TechPress', '2021', 'disponible', 2, 'Guía práctica de organización y buenas prácticas en proyectos PHP.', '2026-03-20 01:02:54'),
(13, 'Estructuras de datos en JavaScript', 'Andrés Paredes', 'CodeHouse', '2020', 'prestado', 2, 'Introducción a arreglos, pilas, colas, listas y árboles en JavaScript.', '2026-03-20 01:02:54'),
(14, 'Aprendiendo PHP y MySQL', 'María González', 'Alfaomega', '2019', 'disponible', 2, 'Manual básico para desarrollar aplicaciones web dinámicas con PHP y MySQL.', '2026-03-20 01:02:54'),
(15, 'JavaScript moderno', 'Carlos Herrera', 'Ra-Ma', '2022', 'disponible', 2, 'Conceptos actuales de JavaScript aplicados al desarrollo web.', '2026-03-20 01:02:54'),
(16, 'Introducción a bases de datos', 'Silvia Torres', 'McGraw-Hill', '2018', 'prestado', 2, 'Fundamentos de modelado, consultas SQL y diseño relacional.', '2026-03-20 01:02:54'),
(17, 'Diseño web con HTML y CSS', 'Patricia López', 'Anaya Multimedia', '2021', 'disponible', 2, 'Creación de interfaces web modernas y responsivas.', '2026-03-20 01:02:54'),
(18, 'Programación orientada a objetos', 'José Ramírez', 'Pearson', '2017', 'disponible', 2, 'Conceptos de clases, objetos, herencia y encapsulamiento.', '2026-03-20 01:02:54'),
(19, 'Seguridad en aplicaciones web', 'Fernando Silva', 'CyberBooks', '2023', 'prestado', 2, 'Principios básicos para proteger formularios, sesiones y bases de datos.', '2026-03-20 01:02:54'),
(20, 'Algoritmos y lógica computacional', 'Andrea Castillo', 'Ecoe Ediciones', '2016', 'disponible', 2, 'Desarrollo del pensamiento lógico para resolver problemas de programación.', '2026-03-20 01:02:54'),
(21, 'Sapiens: De animales a dioses', 'Yuval Noah Harari', 'Debate (Penguin Random House)', '2014', 'disponible', 3, 'Análisis de la evolución histórica de la humanidad.', '2026-03-20 01:02:54'),
(22, 'Historia mínima de América Latina', 'Carlos Malamud', 'Turner', '2019', 'prestado', 3, 'Panorama general de los procesos históricos latinoamericanos.', '2026-03-20 01:02:54'),
(23, 'Breve historia del mundo', 'Ernst H. Gombrich', 'Península', '2008', 'disponible', 3, 'Recorrido accesible por los principales momentos de la historia universal.', '2026-03-20 01:02:54'),
(24, 'La Segunda Guerra Mundial', 'Antony Beevor', 'Pasado & Presente', '2012', 'disponible', 3, 'Obra amplia sobre uno de los conflictos más importantes del siglo XX.', '2026-03-20 01:02:54'),
(25, 'Historia de la República Dominicana', 'Frank Moya Pons', 'Academia Dominicana de la Historia', '2010', 'prestado', 3, 'Resumen de los procesos políticos y sociales dominicanos.', '2026-03-20 01:02:54'),
(26, 'Las venas abiertas de América Latina', 'Eduardo Galeano', 'Siglo XXI', '1971', 'disponible', 3, 'Ensayo histórico sobre explotación y dependencia en América Latina.', '2026-03-20 01:02:54'),
(27, 'Guns, Germs, and Steel', 'Jared Diamond', 'W. W. Norton', '1997', 'disponible', 3, 'Explicación histórica del desarrollo desigual de las civilizaciones.', '2026-03-20 01:02:54'),
(28, 'La revolución francesa', 'Georges Lefebvre', 'Akal', '1989', 'prestado', 3, 'Estudio sobre las causas y consecuencias de la revolución francesa.', '2026-03-20 01:02:54'),
(29, 'Historia contemporánea', 'Eric Hobsbawm', 'Crítica', '1995', 'disponible', 3, 'Síntesis de los cambios políticos y sociales de la era moderna.', '2026-03-20 01:02:54'),
(30, 'Civilización', 'Niall Ferguson', 'Debate', '2011', 'disponible', 3, 'Análisis de factores históricos que influyeron en el desarrollo de Occidente.', '2026-03-20 01:02:54'),
(31, 'Breve historia del tiempo', 'Stephen Hawking', 'Bantam Books', '1988', 'disponible', 4, 'Introducción divulgativa al tiempo, el universo y los agujeros negros.', '2026-03-20 01:02:54'),
(32, 'El gen egoísta', 'Richard Dawkins', 'Salvat', '1976', 'prestado', 4, 'Explicación evolutiva del papel de los genes en la selección natural.', '2026-03-20 01:02:54'),
(33, 'Cosmos', 'Carl Sagan', 'Planeta', '1980', 'disponible', 4, 'Viaje por el universo y la historia de la ciencia.', '2026-03-20 01:02:54'),
(35, 'Física para principiantes', 'Miguel Santos', 'Didáctica Press', '2020', 'prestado', 4, 'Conceptos básicos de movimiento, energía y fuerzas.', '2026-03-20 01:02:54'),
(36, 'Química general', 'Ana Belén Cruz', 'Santillana', '2018', 'disponible', 4, 'Manual introductorio sobre materia, reacciones y estructura atómica.', '2026-03-20 01:02:54'),
(37, 'Biología humana', 'Lucía Herrera', 'Pearson Educación', '2021', 'disponible', 4, 'Estudio básico de sistemas del cuerpo humano y sus funciones.', '2026-03-20 01:02:54'),
(38, 'Astronomía esencial', 'Pedro Salcedo', 'Marcombo', '2019', 'prestado', 4, 'Guía introductoria de planetas, estrellas y galaxias.', '2026-03-20 01:02:54'),
(39, 'Matemática aplicada', 'Rosa Jiménez', 'McGraw-Hill', '2017', 'disponible', 4, 'Aplicaciones prácticas de álgebra, funciones y estadística.', '2026-03-20 01:02:54'),
(40, 'Ecología y medio ambiente', 'Verónica Peña', 'EcoLibro', '2022', 'disponible', 4, 'Relación entre seres vivos, recursos naturales y sostenibilidad.', '2026-03-20 01:02:54'),
(41, 'Pedagogía general', 'Luis Alberto Núñez', 'Trillas', '2015', 'disponible', 5, 'Fundamentos básicos de la enseñanza y el aprendizaje.', '2026-03-20 01:02:54'),
(42, 'Didáctica moderna', 'Elena Fuentes', 'Narcea', '2018', 'prestado', 5, 'Métodos y estrategias de enseñanza aplicados al aula.', '2026-03-20 01:02:54'),
(43, 'Psicología educativa', 'Diana Romero', 'Pearson', '2020', 'disponible', 5, 'Procesos psicológicos involucrados en el aprendizaje escolar.', '2026-03-20 01:02:54'),
(44, 'Evaluación del aprendizaje', 'Marta Cedeño', 'Ecoe Ediciones', '2021', 'disponible', 5, 'Técnicas e instrumentos para evaluar competencias y conocimientos.', '2026-03-20 01:02:54'),
(45, 'Aprendizaje significativo', 'David Ausubel', 'Paidós', '1983', 'prestado', 5, 'Teoría educativa centrada en la relación entre conocimientos previos y nuevos.', '2026-03-20 01:02:54'),
(46, 'Planeación educativa', 'Julio Valdez', 'Limusa', '2019', 'disponible', 5, 'Diseño de objetivos, actividades y recursos de enseñanza.', '2026-03-20 01:02:54'),
(47, 'Tecnología educativa', 'Paula Méndez', 'Alfaomega', '2022', 'disponible', 5, 'Uso de herramientas digitales para apoyar procesos de aprendizaje.', '2026-03-20 01:02:54'),
(48, 'Metodología de la investigación', 'Roberto Hernández Sampieri', 'McGraw-Hill', '2014', 'prestado', 5, 'Guía clásica para desarrollar proyectos de investigación académica.', '2026-03-20 01:02:54'),
(49, 'Comprensión lectora', 'Natalia Pérez', 'SM', '2017', 'disponible', 5, 'Estrategias para fortalecer análisis e interpretación de textos.', '2026-03-20 01:02:54'),
(50, 'Gestión del aula', 'Ricardo Molina', 'Graó', '2023', 'disponible', 5, 'Organización, disciplina y ambiente positivo en el salón de clases.', '2026-03-20 01:02:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','usuario') NOT NULL DEFAULT 'usuario',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `rol`, `fecha_registro`) VALUES
(1, 'Emmanuel Goméz Lebrón', 'emmanuel5678912345@gmail.com', '$2y$10$LCbEoji6ezvoQHoPJCFvHuFbEiGWIeLcqADDd7FwXnMSYGx0RJYV.', 'admin', '2026-03-20 01:04:30');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_categoria_libro` (`categoria_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `libros`
--
ALTER TABLE `libros`
  ADD CONSTRAINT `fk_categoria_libro` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
