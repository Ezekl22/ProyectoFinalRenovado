<!DOCTYPE html>
<html>
<head>
    <title>Clientes</title>
</head>
<body>
    <main class="main__flex">
        <article class="mt-4">
                <h2 class="main__title">
                    Crear Cliente
                </h2>
        </article>
        <article class="mt-5 d-flex flex-column align-items-center">
            <div class="grilla w-75 d-flex flex-column align-items-center rounded-4">
                <form action="" method="POST" class="w-100 d-flex align-items-center flex-column">
                    <div class="border w-75 mt-5 mb-2 rounded-4 d-flex flex-column align-items-center">
                        <div class="w-75 d-flex mt-3">
                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Nombre</span>
                                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="nombre" name="nombre" required>
                            </div>
                            <div class="input-group input-group-sm mb-3 ms-4">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Apellido</span>
                                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="apellido" name="apellido" required>
                            </div>
                            <div class="input-group input-group-sm mb-3 ms-4">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Dni</span>
                                <input type="number" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="dni" name="dni" required>
                            </div>
                            <div class="input-group input-group-sm mb-3 ms-4">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Telefono</span>
                                <input type="number" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="telefono" name="telefono" required>
                            </div>
                            <div class="input-group input-group-sm mb-3 ms-4">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Direccion</span>
                                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="direccion" name="direccion" required>
                            </div>
                            <div class="input-group input-group-sm mb-3 ms-4">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Correo</span>
                                <input type="email" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="mail" name="mail" required>
                            </div>
                            <div class="input-group input-group-sm mb-3 ms-4">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Saldo</span>
                                <input type="number" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="saldo" name="saldo" required>
                            </div>
                    </div>
                    <div class="d-flex justify-content-evenly w-75">
                        <input class="my-5 btn button w-25" type="submit"  value="Guardar">
                        <a class="my-5 btn button w-25" type="button" href="index.php?module=clientes">Cancelar</a>
                    </div>
                    
                </form> 
            </div>
        </article>
    </main>
</body>
</html>


