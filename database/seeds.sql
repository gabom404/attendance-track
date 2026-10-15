-- AttendanceTrack: Smart Attendance & Shift Control
-- Database Seed Data with Synthetic Demonstration Records
-- Note: Contains NO production data or personally identifiable information (PII).

USE `attendancetrack_db`;

-- --------------------------------------------------------
-- Users (Administrators and Project Supervisors)
-- Passwords:
-- Admin User: Admin2024!
-- Alice Smith: password123
-- Bob Johnson: password123
-- --------------------------------------------------------
INSERT INTO `users` (`id`, `nombre_empleado`, `user_email`, `password`, `salt`, `nivel`) VALUES
(1, 'Admin User', 'admin@attendancetrack.local', '$2y$12$XnCIz0UP.ehUA/2mw31zouqGgFc5u27wD2p7GlUvXY.Jv6i82nBE.', 'attendancetrack_salt', 2),
(2, 'Alice Smith', 'alice.smith@attendancetrack.local', '$2y$12$X0efpPtmA9WuZclzmMv2De3bHK58t.eVGAcnjVtnQtLwIr4Tm8aDK', 'attendancetrack_salt', 2),
(3, 'Bob Johnson', 'bob.johnson@attendancetrack.local', '$2y$12$X0efpPtmA9WuZclzmMv2De3bHK58t.eVGAcnjVtnQtLwIr4Tm8aDK', 'attendancetrack_salt', 1);

-- --------------------------------------------------------
-- Projects (Work Sites)
-- --------------------------------------------------------
INSERT INTO `proyectos` (`id`, `nombre_proyecto`, `id_encargado`, `nombre_encargado`, `id_encargado2`, `nombre_encargado2`, `id_encargado3`, `nombre_encargado3`, `id_encargado4`, `nombre_encargado4`) VALUES
(1, 'Solar Plant Alpha - North Facility', 2, 'Alice Smith', 3, 'Bob Johnson', 0, '', 0, ''),
(2, 'Industrial Substation Expansion', 3, 'Bob Johnson', 2, 'Alice Smith', 0, '', 0, ''),
(3, 'Central Operations Headquarters', 1, 'Admin User', 0, '', 0, '', 0, '');

-- --------------------------------------------------------
-- Planilla (Synthetic Demo Employees with Shift Profiles)
-- --------------------------------------------------------
INSERT INTO `planilla` (`id`, `nombre`, `cod_empleado`, `lunes_entrada`, `lunes_salida`, `martes_entrada`, `martes_salida`, `miercoles_entrada`, `miercoles_salida`, `jueves_entrada`, `jueves_salida`, `viernes_entrada`, `viernes_salida`, `sabado_entrada`, `sabado_salida`, `domingo_entrada`, `domingo_salida`, `status`, `img_empleado`, `rol`, `tipo`, `tel`, `dui`) VALUES
(1, 'Alice Smith', 'EMP-001', '07:00:00', '17:00:00', '07:00:00', '17:00:00', '07:00:00', '17:00:00', '07:00:00', '17:00:00', '07:00:00', '16:00:00', '07:00:00', '12:00:00', '00:00:00', '00:00:00', 'Activo', 'images/picture.png', 'Lead Project Engineer', 'Fijo', '+1 555-0101', '01234567-1'),
(2, 'Bob Johnson', 'EMP-002', '07:00:00', '17:00:00', '07:00:00', '17:00:00', '07:00:00', '17:00:00', '07:00:00', '17:00:00', '07:00:00', '16:00:00', '07:00:00', '12:00:00', '00:00:00', '00:00:00', 'Activo', 'images/picture.png', 'Electrical Specialist', 'Fijo', '+1 555-0102', '02345678-2'),
(3, 'Charlie Brown', 'EMP-003', '08:00:00', '17:00:00', '08:00:00', '17:00:00', '08:00:00', '17:00:00', '08:00:00', '17:00:00', '08:00:00', '16:30:00', '08:00:00', '12:00:00', '00:00:00', '00:00:00', 'Activo', 'images/picture.png', 'Field Operations Assistant', 'Eventual', '+1 555-0103', '03456789-3');

-- --------------------------------------------------------
-- Empleados Proyectos (Site Assignment Mapping)
-- --------------------------------------------------------
INSERT INTO `empleados_proyectos` (`id`, `nombre_empleado`, `nombre_proyecto`, `cod_empleado`, `date`, `img`) VALUES
(1, 'Alice Smith', 'Solar Plant Alpha - North Facility', 'EMP-001', '2024-01-15', 'images/picture.png'),
(2, 'Bob Johnson', 'Industrial Substation Expansion', 'EMP-002', '2024-01-15', 'images/picture.png'),
(3, 'Charlie Brown', 'Solar Plant Alpha - North Facility', 'EMP-003', '2024-01-15', 'images/picture.png');

-- --------------------------------------------------------
-- Empleados (Attendance & Shift Punch Logs)
-- --------------------------------------------------------
INSERT INTO `empleados` (`id`, `nombre`, `cod_empleado`, `day`, `proyecto`, `entrada`, `salida`, `status_entrada`, `status_salida`, `status_horas`, `horas_extra`, `justificacion`, `justificado_por`, `img`, `notas`) VALUES
(1, 'Alice Smith', 'EMP-001', '2024-05-20', 'Solar Plant Alpha - North Facility', '06:55:12', '17:05:30', 'Presente', 'Completo', 'Sin H.E', 0, 'SI SE PRESENTÓ', 'SI SE PRESENTÓ', '', 'Turno regular completado'),
(2, 'Bob Johnson', 'EMP-002', '2024-05-20', 'Industrial Substation Expansion', '07:18:45', '17:00:10', 'Tarde', 'Completo', 'Sin H.E', 0, 'SI SE PRESENTÓ', 'SI SE PRESENTÓ', '', 'Demora por tráfico en ruta'),
(3, 'Charlie Brown', 'EMP-003', '2024-05-20', 'Solar Plant Alpha - North Facility', '07:58:22', '18:45:00', 'Presente', 'Completo', 'H.E NO AUTORIZADA', 1.8, 'SI SE PRESENTÓ', 'SI SE PRESENTÓ', '', 'Soporte en tendido eléctrico'),
(4, 'Alice Smith', 'EMP-001', '2024-05-21', 'Solar Plant Alpha - North Facility', '06:58:00', '17:10:00', 'Presente', 'Completo', 'Sin H.E', 0, 'SI SE PRESENTÓ', 'SI SE PRESENTÓ', '', 'No hay notas para mostrar'),
(5, 'Bob Johnson', 'EMP-002', '2024-05-21', 'Industrial Substation Expansion', '06:50:30', '17:02:15', 'Presente', 'Completo', 'Sin H.E', 0, 'SI SE PRESENTÓ', 'SI SE PRESENTÓ', '', 'No hay notas para mostrar');

-- Synchronize into asistencias table
INSERT INTO `asistencias` SELECT * FROM `empleados`;

-- --------------------------------------------------------
-- Sample Equipment & Inventory (Optional Components)
-- --------------------------------------------------------
INSERT INTO `herramientas` (`id`, `herramienta`, `cantidad`, `img`) VALUES
(1, 'Multímetro Digital Industrial', 6, ''),
(2, 'Taladro Inalámbrico 20V', 4, ''),
(3, 'Crimpadora Terminales MC4', 5, '');

INSERT INTO `materiales` (`id`, `nombre`, `cantidad`, `cantidad_minima`, `cantidad_maxima`, `proyecto`, `detalles`) VALUES
(1, 'Cable Solar 4mm2 UV-Resistant (m)', 1200, 200, 3000, 'Solar Plant Alpha - North Facility', 'Bobinas de cable con certificación TÜV'),
(2, 'Conectores MC4 Macho/Hembra (pares)', 350, 50, 500, 'Solar Plant Alpha - North Facility', 'Cajas de conectores estancos IP68');

COMMIT;
