<?php
$id = isset($_GET['id']) ? $_GET['id'] : '';
$PresupuestoCtr = new PresupuestoCtr();
$action = isset($_GET['action']) ? $_GET['action'] : '';
$presupuesto = $PresupuestoCtr->getPresupuestoDAO()->getPresupuestoById($id);

$clientes = $PresupuestoCtr->getAllClientes();
$GestionPantallasCtr = new GestionPantallasControlador();
$productos = $PresupuestoCtr->getProductosPresupuestoById($id);
$jsonProductosPre = json_encode($productos);
$json = json_encode($PresupuestoCtr->getAllProductos());
echo "<script>const productos = $json;</script>";
?>
<?php
if ($action == 'edit' && $id != '') {

    ?>
    <html>

    <head>
        <title>Editar Presupuesto</title>
    </head>

    <body>
        <main class="d-flex flex-column align-items-center mt-2 mb-4 main__flex" id="editPresupuesto">
            <article class="mt-4">
                <h2 class="main__title mb-5">
                    Editar Presupuesto
                </h2>
            </article>
            <article class="editar__contenedor rounded-4">
                <form action="" method="POST" class="d-flex flex-column align-items-center border-1 border m-4 rounded-4">
                    <div class="d-flex flex-column align-items-center contenedor__mayor" id="contenedor">
                        <div class="my-3 d-flex flex-row w-100">
                            <div class="input-group input-group-sm ms-7">
                                <label class="input-group-text" for="cliente">Cliente:</label>
                                <select class="form-select" id="idcliente" name="idcliente" required>
                                    <?php foreach ($clientes as $cliente) { ?>
                                        <option value="<?php echo $cliente['idcliente'] ?>" <?php echo ($presupuesto['idcliente'] == $cliente['idcliente']) ? 'selected' : ''; ?>>
                                            <?php echo $cliente['nombre'] . ' ' . $cliente['apellido'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="input-group input-group-sm mx-7">
                                <label class="input-group-text NroComprobanteTxt" for="nroComprobante"
                                    id="inputGroup-sizing-sm">Comprobante
                                    Nro:</label>
                                <input type="text" disabled class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-sm" id="nrocomprobante" name="nrocomprobante"
                                    value="<?php echo $presupuesto['nrocomprobante'] ?>" required>
                            </div>
                            <div class="input-group input-group-sm me-7">
                                <label class="input-group-text" for="tipo" id="inputGroup-sizing-sm">Tipo:</label>
                                <input type="text" class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-sm" disabled id="tipo" name="tipo"
                                    value="<?php echo $presupuesto['tipo'] ?>" required>
                            </div>
                        </div>
                        <div class="my-3 d-flex flex-row w-100">
                            <div class="input-group input-group-sm ms-7">
                                <label class="input-group-text" for="estado" id="inputGroup-sizing-sm">Estado:</label>
                                <input type="text" class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-sm" id="estado" name="estado"
                                    value="<?php echo $presupuesto['estado'] ?>" disabled required>
                            </div>
                            <div class="input-group input-group-sm mx-7">
                                <label class="input-group-text" for="fecha" id="inputGroup-sizing-sm">Fecha:</label>
                                <input type="text" disabled class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-sm" id="fecha" name="fecha"
                                    value="<?php echo $presupuesto['fecha'] ?>" required>
                            </div>
                            <div class="input-group input-group-sm me-7">
                                <label class="input-group-text" for="puntoVenta" id="inputGroup-sizing-sm">Punto de
                                    venta:</label>
                                <input type="text" class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-sm" id="puntoVenta" name="puntoVenta"
                                    value="<?php echo $presupuesto['puntoventa'] ?>" disabled required>
                            </div>
                        </div>
                        <div class="d-flex flex-column align-items-center contenedor__mayor" id="contGrillaFormulario">
                            <h4 class="mt-2 text__white">
                                <?php echo !isset($_GET["type"]) || $_GET["type"] != "Reparacion" ? "Productos" : "Equipo a reparar" ?>
                            </h4>
                            <?php if (isset($_GET['type']) && $_GET['type'] == "Reparacion") {
                                $reparacion = $PresupuestoCtr->getReparacionPresupuestoById($id); ?>
                                <div class="my-3 d-flex flex-row w-95">
                                    <div class="input-group input-group-sm">
                                        <label class="input-group-text" for="marca" id="inputGroup-sizing-sm">Marca:</label>
                                        <input type="text" class="form-control w-25" value="<?php echo $reparacion['marca']; ?>"
                                            id="marca" name="marca" required>
                                    </div>
                                    <div class="input-group input-group-sm ms-3">
                                        <label class="input-group-text" for="nroserie" id="inputGroup-sizing-sm">Numero de
                                            serie:</label>
                                        <input type="text" class="form-control w-25" id="nroserie" name="nroserie"
                                            value="<?php echo $reparacion['numeroserie']; ?>" required>
                                    </div>
                                    <div class="input-group input-group-sm ms-3">
                                        <label class="input-group-text" for="modelo" id="inputGroup-sizing-sm">Modelo:</label>
                                        <input type="text" class="form-control w-25" id="modelo" name="modelo"
                                            value="<?php echo $reparacion['modelo']; ?>" required>
                                    </div>
                                </div>
                                <div class="input-group w-75">
                                    <label class="input-group-text" for="descripcion" id="input-group">Descripción:</label>
                                    <textarea class="form-control" aria-label="Descripción" id="descripcion"
                                        name="descripcion"><?php echo $reparacion['descripcion']; ?></textarea>
                                </div>
                            <?php } else { ?>
                                <div class="d-flex justify-content-start w-100">
                                    <button class="btn btn-outline-secondary button align-self-start ms-5"
                                        data-bs-target="#grillaProductos" data-bs-toggle="modal" type="button" id="agregar"
                                        onclick="mostrarGrillaProductos()">Agregar producto</button>
                                    <button class="btn btn-outline-secondary button ms-3 align-self-start" disabled
                                        onclick="quitarComponenteProducto()" type="button" id="btnQuitar">Quitar
                                        productos</button>
                                </div>

                                <div class="my-3 d-flex flex-column w-100" id="contProductos">
                                    <?php include_once "vistas/otros/grillaProductosSeleccionados.php" ?>
                                </div>
                                <div class="d-flex" id="">
                                    <div class="input-group input-group-sm mb-3">
                                        <label class="input-group-text" for="totalProductos"
                                            id="inputGroup-sizing-sm">Total:</label>
                                        <input type="text" class="form-control" disabled aria-label="0" id="totalproductos"
                                            value="$0,00">
                                    </div>
                                </div>

                            <?php } ?>
                            <!-- aca falta un boton de cancelar -->
                            <input class="btn button my-2" type="submit" value="Guardar cambios">
                        </div>


                    </div>
                </form>
                <?php $gestionPantallaCtr->crearPopUp(new PopUpMdl('grillaProductos', 'Productos', "", BOTONES_POPUP_PRODUCTOS, '')); ?>
            </article>
        </main>
    </body>
    <?php
    echo "<script>cargarGrillaProducto('presupuesto', " . $jsonProductosPre . ")</script>"
        ?>

    </html>
<?php } ?>