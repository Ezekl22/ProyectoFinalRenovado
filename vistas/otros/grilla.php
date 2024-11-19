<div class="border w-95 mt-3 mb-5 rounded-4">
    <div class="table-responsive">
        <table class="table grilla__contenedor w-95 border-0">
            <thead>
                <tr class="grilla grilla__cabecera">
                    <?php
                    foreach ($grillaMdl->getDatosCabecera() as $datoCabecera) {
                        echo "<th>$datoCabecera</th>";
                    }
                    ?>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($grillaMdl->getDatosCuerpo() as $datoCuerpo) { ?>
                    <tr class="grilla__cuerpo">
                        <?php $index = count($grillaMdl->getDatosCabecera());
                        for ($i = 1; $i <= $index; $i++) {
                            echo '<td>' . $datoCuerpo[$i] . '</td>';
                        } ?>
                        <td>
                            <!--------------- ACCIONES ----------------->

                        <?php if (in_array($gestionPantallaCtr->getModule(), ["presupuestos", "pedidos"])) { ?>
                        <!-- VER -->
                                <?php if ($datoCuerpo[4] != "pendiente presupuesto") { ?>
                                    <a class="icono__contenedor me-2" title="ver"
                                        href="index.php?module=<?php echo $gestionPantallaCtr->getModule(); ?>&action=see&id=<?php echo $datoCuerpo[0]; ?>">
                                        <img class="icono__imagen" src="./assets/img/iconoVer.png" alt="icono de ver">
                                    </a>
                                <?php } else { ?>
                                    <label class="icono__contenedor me-2" title="ver">
                                        <img class="icono__imagen" src="./assets/img/iconoVerDeshabilitado.png" alt="icono de ver">
                                    </label>
                                <?php } ?>
                                <?php if (strtoupper($datoCuerpo[4]) == "FACTURADO" || strtoupper($datoCuerpo[4]) == "PENDIENTE PRESUPUESTO") { ?>
                                    <!-- FACTURAR - DESACTIVADO -->
                                    <label class="icono__contenedor me-2" title="Facturar">
                                        <img class="icono__imagen" src="./assets/img/iconoFacturarDeshabilitado.svg"
                                            alt="icono de Facturar">
                                    </label>
                                <?php } else { ?>
                                    <!-- FACTURAR - ACTIVO -->
                                    <a class="icono__contenedor me-2" title="Facturar"
                                        href="index.php?module=<?php echo $gestionPantallaCtr->getModule(); ?>&action=facturar&id=<?php echo $datoCuerpo[0]; ?>">
                                        <img class="icono__imagen" src="./assets/img/iconoFacturar.svg" alt="icono de Facturar">
                                    </a>
                                <?php } ?>

                            <?php }
                        if (in_array($gestionPantallaCtr->getModule(), ["presupuestos", "pedidos"]) && strtoupper($datoCuerpo[4]) == "FACTURADO") { ?>
                                <!-- EDITAR - DESACTIVADO-->
                                <label class="icono__contenedor me-2" title="Editar">
                                    <img class="icono__imagen" src="./assets/img/iconoEditarDeshabilitado.png"
                                        alt="icono de editar deshabilitado">
                                </label>
                            <?php } else { ?>
                                <!-- EDITAR - ACTIVADO-->
                                <a class="icono__contenedor me-2" href="index.php?module=<?php echo $gestionPantallaCtr->getModule(); ?>&action=edit&id=<?php echo $datoCuerpo[0];
                                   echo "&type=" . $datoCuerpo[3]; ?>">
                                    <img class="icono__imagen" src="./assets/img/iconoEditar.png" alt="icono de editar">
                                </a>
                            <?php } ?>
                            <?php if (in_array($gestionPantallaCtr->getModule(), ["usuarios", "clientes", "proveedores", "productos"])) { ?>
                                <?php if ($gestionPantallaCtr->getModule() === "usuarios" && strtoupper($datoCuerpo[3]) === "ADMINISTRADOR BASE") { ?>
                                    <!-- ELIMINAR - DESACTIVADO -->
                                    <label class="icono__contenedor" title="Eliminar">
                                        <img class="icono__imagen svg-disabled-color"
                                            src="./assets/img/iconoEliminarDeshabilitado.svg" alt="icono de eliminar">
                                    </label>
                                <?php } else { ?>
                                    <!-- ELIMINAR - ACTIVADO -->
                                    <a class="icono__contenedor"
                                        href="index.php?module=<?php echo $gestionPantallaCtr->getModule(); ?>&action=delete&id=<?php echo $datoCuerpo[0]; ?>">
                                        <img class="icono__imagen " src="./assets/img/iconoEliminar.svg" alt="icono de eliminar">
                                    </a>
                                <?php } ?>
                            <?php } else {
                                if (strtoupper($datoCuerpo[4]) == "FACTURADO") { ?>
                                    <!-- ANULAR - DESACTIVADO -->
                                    <label class="icono__contenedor me-2" title="Anular">
                                        <img class="icono__imagen" src="./assets/img/iconoAnularDeshabilitar.png"
                                            alt="icono de anular">
                                    </label>
                                <?php } else { ?>
                                    <!-- ANULAR - ACTIVADO -->
                                    <a class="icono__contenedor me-2" title="Anular"
                                        href="index.php?module=presupuestos&action=annul&id=<?php echo $datoCuerpo[0]; ?>">
                                        <img class="icono__imagen" src="./assets/img/iconoAnular.png" alt="icono de anular">
                                    </a>
                                <?php } ?>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>