
<?php 
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $ProductoCtr = new ProductoCtr();
    $producto = $ProductoCtr->productoDAO->getProductoById($id);

    if($action == 'edit' && $id != ''){

?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Editar producto</title>
        </head>
        <body>
            <main class="main__flex mb-5">
                <article class="mt-4">
                        <h2 class="main__title">
                        Editar Producto
                        </h2>
                </article>
                <article class="mt-5 d-flex flex-column align-items-center">
                    <div class="grilla w-85 d-flex flex-column align-items-center rounded-4">
                        <form action="index.php?module=productos&action=edited&id=<?php echo $id?>" method="POST" class="w-100 d-flex align-items-center flex-column">
                            <div class="border w-85 mt-5 mb-2 rounded-4 d-flex flex-column align-items-center">
                                <div class="w-85 d-flex mt-3">
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Nombre</span>
                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="nombre" name="nombre" value="<?php echo $producto['nombre']; ?>" required>
                                    </div>
                                    <div class="input-group input-group-sm mb-3 ms-4">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Marca</span>
                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="marca" name="marca" value="<?php echo $producto['marca']; ?>" required>
                                    </div>
                                    <div class="input-group input-group-sm mb-3 ms-4">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Detalle</span>
                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="detalle" name="detalle" value="<?php echo $producto['detalle']; ?>" required>
                                    </div>
                                </div>
                                <div class="w-85 d-flex mt-3">
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Stock</span>
                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="stock" name="stock" value="<?php echo $producto['stock']; ?>" required>
                                    </div>
                                    <div class="input-group input-group-sm mb-3 ms-4">
                                        <label class="input-group-text" for="tipo">Tipo</label>
                                        <select class="form-select" id="tipo" name="tipo" required>
                                            <option value="Producto" <?php echo ($producto['tipo'] == 'Producto') ? 'selected' : ''; ?> selected>Producto</option>
                                            <option value="Repuesto" <?php echo ($producto['tipo'] == 'Repuesto') ? 'selected' : ''; ?> >Repuesto</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="w-85 d-flex mt-3">
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Precio de compra</span>
                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="preciocompra" name="preciocompra" value="<?php echo $producto['preciocompra']; ?>" required>
                                    </div>
                                    <div class="input-group input-group-sm mb-3 ms-4">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Precio de venta</span>
                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="precioventa" name="precioventa" value="<?php echo $producto['precioventa']; ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-evenly w-75">
                                <input class="my-5 btn button w-25" type="submit" value="Guardar">
                                <a class="my-5 btn button w-25" type="button" href="index.php?module=productos">Cancelar</a>
                            </div>
                            
                        </form> 
                    </div>
                </article>
            </main>
        </body>
        </html>
<?php }?>
