
let MOPantallaEditar = false;

const guardarEdicion = (id) =>{
    //window.location.href = "./index.php?module=usuarios";
    document.getElementById(id).style.display ="none";
}
//verifico si la pantalla de editar esta a la vista y si lo esta le cambio el display para ocultarla
const mostrarOcultarPantallaEditar = (id,inUse) =>{
    let contDisplay = document.getElementById(id).style.display;
    document.getElementById(id).style.display = contDisplay == "flex" & inUse == '0' ? "none" : contDisplay == "none" & inUse =='1' && "flex";
}

const agregarComponenteProducto = () =>{
    let contProductos = document.getElementById("contProductos");
    let contComponente = document.createElement("div");
    let numContenedores = contProductos.childElementCount;
    let id = "producto"+(numContenedores+1);
    let productoSeleccionado;
    const queryString = window.location.search;
    const params = new URLSearchParams(queryString);
    const modulo = params.get('module');

    productos.forEach(producto=>{
        const checkSeleccion = document.getElementById("seleccion"+producto[0]);
        if (checkSeleccion.checked)
            productoSeleccionado = producto;
    });
    contComponente.className = "input-group input-group-sm mb-3";
    contComponente.id = id;

    contComponente.innerHTML = `<button class="btn btn-outline-secondary button ms-7 align-self-start" onclick="quitarComponenteProducto('${id}')" type="button" id="quitar">-</button>
                                <label class="input-group-text" for="producto" id="inputGroup-sizing-sm">Producto:</label>
                                <input type="text" class="form-control w-25" disabled id="producto" value = "${productoSeleccionado[1]}">
                                <label class="input-group-text" for="cantidad" id="inputGroup-sizing-sm">Cantidad:</label>
                                <input type="text" class="form-control" aria-label="0" onchange="cantidadOnChange('${productoSeleccionado[0]}','${id}')" id="cantidad" name="cantidad[]">
                                <label class="input-group-text" for="valorunt" id="inputGroup-sizing-sm">Valor unitario:</label>
                                <input type="text" class="form-control" disabled value= "${currencyFormatter(modulo == "pedidos"?productoSeleccionado[6]:productoSeleccionado[7])}" id="valorunt">
                                <label class="input-group-text" for="totañ" id="inputGroup-sizing-sm">Total:</label>
                                <input type="text" class="form-control me-7" disabled aria-label="0" id="total">
                                <input type="hidden" class="form-control me-7" aria-label="0" value="${productoSeleccionado[0]}" id="idproductos" name="idproductos[]">`;
    contProductos.appendChild(contComponente);
    cerrarGrilla('contGrillaProducto');
}

const currencyFormatter =(value)=> {
    const currency = "USD";
    const formatter = new Intl.NumberFormat('en-US', {
      style: 'currency',
      minimumFractionDigits: 2,
      currency
    }) 
    return formatter.format(value)
}

const mostrarGrillaProductos = ()=>{
    cerrarGrilla('contGrillaProducto');
    let contGrilla = document.getElementById('contGrillaProducto');
    let contenedor = document.createElement("div");
    let cuerpoGrilla = '';
    contenedor.className = "grilla d-flex flex-column align-items-center rounded-4";
    contenedor.style.width = "95%";
    
    productos.forEach(producto => {
       cuerpoGrilla =cuerpoGrilla+ `<tr class="grilla__cuerpo">
                                        <td>${producto[1]}</td>
                                        <td>${producto[2]}</td>
                                        <td>${producto[3]}</td>
                                        <td>${producto[4]}</td>
                                        <td>${producto[5]}</td>
                                        <td>${producto[6]}</td>
                                        <td>${producto[7]}</td>
                                        <td>
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="seleccion${producto[0]}">
                                            </div>
                                        </td>
                                    </tr>`;  
    });
    contenedor.innerHTML = `<div class="d-flex mt-3 justify-content-end" style="width:90%;">
                                <div class="input-group input-group-sm w-25">
                                    <input type="text" class="form-control" placeholder="Ingrese su busqueda" aria-label="Recipient's username" aria-describedby="buscar">
                                    <input class="btn btn-outline-secondary button" type="button" id="buscar" value="Buscar"></button>
                                </div>
                            </div>
                            <div class="border mt-3 mb-5 rounded-4" style="width:90%;">
                                <table class="grilla__contenedor border-0">
                                    <tr class="grilla grilla__cabecera">
                                        <th>Nombre</th>
                                        <th>Marca</th>
                                        <th>Detalle</th>
                                        <th>Stock</th>
                                        <th>Tipo</th>
                                        <th>preciocompra</th>
                                        <th>precioventa</th>
                                        <th>selección</th>
                                    </tr>
                                    ${cuerpoGrilla}
                                </table>
                                <div class="d-flex justify-content-center">
                                    <div class="input-group input-group-sm mb-3 w-25">
                                        <label class="input-group-text" for="cantidad" id="inputGroup-sizing-sm">Cantidad:</label>
                                        <input type="text" class="form-control" aria-label="0" id="cantidadProducto" value="1">
                                    </div>
                                </div>
                            </div>`;
    contGrilla.appendChild(contenedor);
}


const cerrarGrilla = (id) =>{
    let grilla = document.getElementById(id).childNodes[0];
    if(grilla)
        grilla.remove();
}

const quitarComponenteProducto = (id) =>{
    document.getElementById(id).remove();
}

const recalcularTotal = () =>{
    const totalesProductos = document.querySelectorAll('#total');
    const importeTotal = document.getElementById('totalproductos');
    let total = parseFloat(0);
    totalesProductos.forEach(totalProducto =>{
        total = total + parseFloat(totalProducto.value.replace(/[$,]/g, ""));
        
    });
    importeTotal.value = currencyFormatter(total);
}

const recalcularTotall = () =>{
    const totalesProductos = document.querySelectorAll('#total');
    const importeTotal = document.getElementById('totalproductos');
    let total = parseFloat(0);
    totalesProductos.forEach(totalProducto =>{
        total = total + parseFloat(totalProducto.childNodes[0].data.replace(/[$,]/g, ""));
        
    });
    importeTotal.value = currencyFormatter(total);
}

const cantidadOnChange = (idProducto,id) =>{
    const inputTotal = document.querySelector('#'+id+' #total');
    const cantidad = document.querySelector('#'+id+' #cantidad').value;
    let i = 0;
    while (productos[i][0] != parseInt(idProducto)) {
        i++;
    }
    const producto = productos[i];
    inputTotal.value =currencyFormatter(esVenta? producto[7]:producto[6] * parseInt(cantidad));
    recalcularTotal();
}

const mostrarVentanaModal = (id) =>{
    var miModal = new bootstrap.Modal(document.getElementById(id));
    miModal.show();

}    

const validarFormulario = () =>{
    
} 

const cargarGrillaProducto = () =>{
    let contProductos = document.getElementById("grilla");
    let contComponente = document.createElement("div");
    const cantidad = document.getElementById("cantidadProducto").value;
    let productoSeleccionado;
    productos.forEach(producto=>{
        const checkSeleccion = document.getElementById("seleccion"+producto[0]);
        if (checkSeleccion.checked)
            productoSeleccionado = producto;
    });
    let id = "producto"+(productoSeleccionado[0]);
    // contComponente.className = "input-group input-group-sm mb-3";
    contComponente.id = id;

    contProductos.innerHTML = contProductos.innerHTML + `<tr class="grilla__cuerpo">
                                                            <td id="producto"> ${productoSeleccionado[1]} </td>
                                                            <td> <input type="number" value="${cantidad}" class="form-control" onchange="cantidadOnChange('${productoSeleccionado[0]}','${id}')" id="cantidad" name="cantidad[]" min="1"</td>
                                                            <td id="valorunt"> ${currencyFormatter(productoSeleccionado[7])} </td>
                                                            <td id="total"> ${currencyFormatter(parseInt(cantidad) * productoSeleccionado[7])} </td>
                                                            <td><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></td>
                                                            <input type="hidden" class="form-control me-7" aria-label="0" value="${productoSeleccionado[0]}" id="idproductos" name="idproductos[]">
                                                        </tr>`;
    contProductos.appendChild(contComponente);
    recalcularTotall();
    cerrarGrilla('contGrillaProducto');
}

const tipoOnChange = (selector) =>{
    console.log(selector.target.value);
    const tipo = selector.target.value;
    tipo == 'Reparacion';
}

const clickBorrarBusqueda = () =>{
    // Seleccionar el input de búsqueda
    const input = document.getElementById('termino');

    // Agregar un listener de eventos al input para detectar cambios
    input.addEventListener('input', function() {
    // Verificar si el input está vacío
    if (input.value.trim() === '') {
        // Si está vacío, enviar el formulario
        document.getElementById('formBuscador').submit();
    }
    });
}