document.addEventListener("DOMContentLoaded", () => {
    listarProductos();

    document.querySelector("#ListaProductosventas tbody").addEventListener("click", (event) => {
        if (event.target.tagName === "TD") {
            const fila = event.target.parentElement;
            agregarProductoAVenta(fila);
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
        const tbody = document.querySelector("#ListaProductosventas tbody");
        tbody.innerHTML = "";
        data.lista.forEach(producto => {
            tbody.innerHTML += `
            <tr data-id="${producto.ID_Producto}" data-desc="${producto.Descripcion}" data-precio="${producto.Precio}">
                <td>${producto.ID_Producto}</td>
                <td><img src="${producto.img}" width="50" height="50"></td>
                <td>${producto.Descripcion}</td>
                <td>${producto.Precio}</td>
                <td>${producto.Disponible}</td>
                <td>${producto.TipoProducto}</td>
            </tr>`;
        });
    })
    .catch(error => {
        Swal.fire("Error", "No se pudo cargar la lista de productos: " + error.message, "error");
    });
}

function agregarProductoAVenta(fila) {
    const id = fila.getAttribute("data-id");
    if (productosSeleccionados.find(p => p.id === id)) return;

    const descripcion = fila.getAttribute("data-desc");
    const precio = parseFloat(fila.getAttribute("data-precio"));

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
    listarProductos();
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

