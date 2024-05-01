<!DOCTYPE html>
<html>
<head>
    <title>Productos</title>
</head>
<body>
    <main class="main__flex">
        <article class="mt-4">
                <h2 class="main__title">
                    Productos
                </h2>
        </article>
        <article class="mt-5 d-flex flex-column align-items-center">
            <div class="grilla w-75 d-flex flex-column align-items-center rounded-4">
                <div class="d-flex w-75 justify-content-end mt-3">
                    <div class="input-group input-group-sm w-25">
                        <input type="text" class="form-control" placeholder="Ingrese su busqueda" aria-label="Recipient's username" aria-describedby="buscar">
                        <input class="btn btn-outline-secondary button" type="button" id="buscar" value="Buscar"></button>
                    </div>
                </div>
                <?php $grillaCtr->mostrarGrilla(); ?>
            </div>
            <?php 
            $action = isset($_GET['action'])?$_GET['action']:'';
            if(($action != 'edit' && $action != 'create') ){ ?>
                <a class="my-5 btn button" type="button" href="index.php?module=productos&action=create">Crear nuevo producto</a>
            <?php } ?>
        </article>
    </main>
    <?php echo $action == 'delete' ? '<script> mostrarVentanaModal("delete"); </script>':''?> 
</body>
</html>
