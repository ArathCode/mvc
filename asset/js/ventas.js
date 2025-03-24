document.addEventListener("DOMContentLoaded", () => {
    listarProductos();

    document.querySelector("#ListaProductosventas").addEventListener("click", (event) => {
        if (event.target.closest(".productoC")) {
            const divProducto = event.target.closest(".productoC");
            agregarProductoAVenta(divProducto);
        }
    });

    document.getElementById("btnConfirmarVenta").addEventListener("click", confirmarVenta);
});

let productosSeleccionados = [];

function listarProductos() {
    fetch('controlador/controladorventas.php', {
        method: 'POST',
        body: new URLSearchParams({ "ope": "LISTAPRODUCTOS" })
    })
    .then(response => response.json())
    .then(data => {
        const contenedor = document.querySelector("#ListaProductosventas");
        contenedor.innerHTML = "";
        data.lista.forEach(producto => {
            contenedor.innerHTML += `
            <div class="productoC" data-id="${producto.ID_Producto}" data-desc="${producto.Descripcion}" data-precio="${producto.Precio}">
                <div class="imgP">
                    <img src="${producto.img}" >
                </div>
                <div class="descP">
                    <p id="DescripcionyId">#${producto.ID_Producto} ${producto.Descripcion}</p> 
                </div>
                <div class="precioC">
                    <p id="Precio">$${producto.Precio}</p>
                </div>
                <div class="restanteC">
                    <p id="Disponible">${producto.Disponible} restantes</p>
                </div>
            </div>`;
        });
    })
    .catch(error => {
        Swal.fire("Error", "No se pudo cargar la lista de productos: " + error.message, "error");
    });
}

function agregarProductoAVenta(divProducto) {
    const id = divProducto.getAttribute("data-id");
    if (productosSeleccionados.find(p => p.id === id)) return;

    const descripcion = divProducto.getAttribute("data-desc");
    const precio = parseFloat(divProducto.getAttribute("data-precio"));

    const producto = { id, descripcion, precio, cantidad: 1 };
    productosSeleccionados.push(producto);
    actualizarTablaVenta();
}

function actualizarTablaVenta() {
    const tbody = document.querySelector("#tablaVenta tbody");
    tbody.innerHTML = "";

    productosSeleccionados.forEach((producto, index) => {
        tbody.innerHTML += `
        <tr>
            <td>${producto.descripcion}</td>
            <td>${producto.precio.toFixed(2)}</td>
            <td>
                <button onclick="modificarCantidad(${index}, -1)">-</button>
                ${producto.cantidad}
                <button onclick="modificarCantidad(${index}, 1)">+</button>
            </td>
            <td><button onclick="eliminarProducto(${index})">Borrar</button></td>
        </tr>`;
    });
}

function modificarCantidad(index, delta) {
    if (productosSeleccionados[index].cantidad + delta > 0) {
        productosSeleccionados[index].cantidad += delta;
        actualizarTablaVenta();
    }
}

function eliminarProducto(index) {
    productosSeleccionados.splice(index, 1);
    actualizarTablaVenta();
}

function confirmarVenta() {
    if (productosSeleccionados.length === 0) {
        Swal.fire("Error", "No hay productos en la venta", "error");
        return;
    }

    Swal.fire({
        title: "¿Confirmar venta?",
        text: "Se procederá a registrar la venta",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, confirmar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            registrarVenta();
        }
    });
}

function registrarVenta() {
    fetch('controlador/controladorventas.php', {
        method: 'POST',
        body: new URLSearchParams({ 
            "ope": "CONFIRMARVENTA", 
            "productos": JSON.stringify(productosSeleccionados) 
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire("Éxito", "Venta registrada correctamente", "success");
            productosSeleccionados = [];
            actualizarTablaVenta();
        } else {
            Swal.fire("Error", data.msg, "error");
        }
    })
    .catch(error => {
        Swal.fire("Error", "No se pudo registrar la venta: " + error.message, "error");
    });
}
