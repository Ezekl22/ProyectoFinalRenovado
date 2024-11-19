DROP TABLE IF EXISTS reparaciones;
CREATE TABLE `reparaciones` (
  `idreparacion` int(11) NOT NULL,
  `idpresupuesto` int(11) NOT NULL,
  `modelo` text NOT NULL,
  `marca` text NOT NULL,
  `numeroserie` text NOT NULL,
  `descripcion` text NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `reparaciones`
  ADD PRIMARY KEY (`idreparacion`),
  ADD KEY `idpresupuesto` (`idpresupuesto`);

ALTER TABLE `reparaciones`
  MODIFY `idreparacion` int(11) NOT NULL AUTO_INCREMENT;
