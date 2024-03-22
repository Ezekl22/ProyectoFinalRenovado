<?php
$id = isset ($_GET['id']) ? $_GET['id'] : '';
$ProveedorCtr = new ProveedorCtr();
$action = isset ($_GET['action']) ? $_GET['action'] : '';
$proveedorr = $ProveedorCtr->proveedorDAO->getProveedorById($id);
$ProveedorCtr->update($id);
$fecha = new DateTime($proveedorr['fechaCreacion']);

if ($action == 'edit' && $id != '') {
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Editar Proveedor</title>
    </head>

    <body>
        <main class="d-flex flex-column align-items-center mt-2 mb-5" id="editProveedor">
            <article class="editar__contenedor rounded-4">
                <form action="index.php?module=proveedores&action=edited&id=<?php echo $id ?>" method="POST"
                    class="d-flex flex-column align-items-center border-1 border m-4 rounded-4">
                    <div class="d-flex flex-column align-items-center" id="contenedor">

                        <h2 class="mt-2 text__white">Editar Proveedor</h2>
                        <div class="my-3 d-flex flex-row">
                            <div class="input-group input-group-sm mb-3">
                                <label class="input-group-text" for="nombre" id="inputGroup-sizing-sm">Nombre:</label>
                                <input type="text" class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-sm" id="nombre" name="nombre"
                                    value="<?php echo $proveedorr['nombre']; ?>" required>
                            </div>
                            <div class="input-group input-group-sm mb-2 ms-5">
                                <label class="input-group-text" for="tipo">Categoria Fiscal:</label>
                                <select class="form-select" id="tipo" name="tipo" required>
                                    <option value="Monotributista" <?php echo ($proveedorr['categoria_fiscal'] == 'Monotributista') ? 'selected' : ''; ?>>
                                        Monotributista</option>
                                    <option value="Responsable Inscripto" <?php echo ($proveedorr['categoria_fiscal'] == 'Responsable inscripto') ? 'selected' : ''; ?>>
                                        Responsable Inscripto</option>
                                    <option value="Excento" <?php echo ($proveedorr['categoria_fiscal'] == 'Excento') ? 'selected' : ''; ?>>Excento</option>
                                </select>
                            </div>
                            <div class="input-group input-group-sm mb-3 ms-5">
                                <label class="input-group-text" for="direccion" id="inputGroup-sizing-sm">Direccion:</label>
                                <input type="text" class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-sm" id="direccion" name="direccion"
                                    value="<?php echo $proveedorr['direccion']; ?>" required>
                            </div>
                        </div>
                        <div class="d-flex flex-row">
                            <div class="input-group input-group-sm mb-3 ms-5">
                                <label class="input-group-text" for="telefono" id="inputGroup-sizing-sm">Telefono:</label>
                                <input type="number" class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-sm" id="telefono" name="telefono"
                                    value="<?php echo $proveedorr['telefono']; ?>" required>
                            </div>
                            <div class="input-group input-group-sm mb-3 ms-5">
                                <label class="input-group-text" for="correo" id="inputGroup-sizing-sm">Correo:</label>
                                <input type="email" class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-sm" id="correo" name="correo"
                                    value="<?php echo $proveedorr['correo']; ?>" required>
                            </div>
                            <div class="input-group input-group-sm mb-3 ms-5">
                                <label class="input-group-text" for="saldo" id="inputGroup-sizing-sm">Saldo:</label>
                                <input type="number" class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-sm" id="saldo" name="saldo"
                                    value="<?php echo $proveedorr['saldo']; ?>" required>
                            </div>
                            <div class="input-group input-group-sm mb-3 ms-5">
                                <label class="input-group-text" for="saldo" id="inputGroup-sizing-sm">Fecha:</label>
                                <input type="text" class="form-control" disabled aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-sm" id="saldo" name="saldo"
                                    value="<?php echo $fecha->format('Y-m-d'); ?>" required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-evenly w-75">
                            <a class="my-5 btn button w-25" type="button" href="index.php?module=proveedores">Cancelar</a>
                            <input class="my-5 btn button w-25" type="submit" value="Guardar cambios"
                                onclick="guardarEdicion('editProveedor')">
                        </div>
                    </div>
                </form>
            </article>
        </main>
    </body>
    <script>mostrarOcultarPantallaEditar('editProveedor')</script>

    </html>
<?php } ?>