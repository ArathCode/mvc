document.addEventListener("DOMContentLoaded", () => {
    listarProductos();
    listarVentasDelDia();
    cargarTiposProductoVenta();

    document.querySelector("#ListaProductosventas tbody").addEventListener("click", (event) => {
        if (event.target.tagName === "TD") {
            const fila = event.target.parentElement;
            agregarProductoAVenta(fila);
        }
    });

    document.getElementById("btnConfirmarVenta").addEventListener("click", confirmarVenta);
    
    //Filtros
    document.querySelector("#filtroNombreVenta").addEventListener("input", mostrarProductosFiltradosVentas);
    document.querySelector("#filtroDisponibleVenta").addEventListener("change", mostrarProductosFiltradosVentas);
    document.querySelector("#filtroTipoVenta").addEventListener("change", mostrarProductosFiltradosVentas);
    document.querySelector("#resetFiltrosVenta").addEventListener("click", () => {
        document.querySelector("#filtroNombreVenta").value = "";
        document.querySelector("#filtroDisponibleVenta").value = "";
        document.querySelector("#filtroTipoVenta").value = "";
        mostrarProductosFiltradosVentas();
    });

});

let productosSeleccionados = [];
let productosGlobalVentas = [];

//listar productos
function listarProductos() {
    fetch('controlador/controladorventas.php', {
        method: 'POST',
        body: new URLSearchParams({ "ope": "LISTAPRODUCTOS" })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        const tbody = document.querySelector("#ListaProductosventas tbody");
        tbody.innerHTML = "";

        productosGlobalVentas = data.lista;
        mostrarProductosFiltradosVentas();


        agregarEventosVenta();
    })
    .catch(error => {
        Swal.fire("Error", "No se pudo cargar la lista de productos: " + error.message, "error");
    });
}

//Agregar al carrito
function agregarProductoAVenta(fila) {
    const id = fila.getAttribute("data-id");
    if (productosSeleccionados.find(p => p.id === id)) return;

    const descripcion = fila.getAttribute("data-desc");
    const precio = parseFloat(fila.getAttribute("data-precio"));

    const producto = { id, descripcion, precio, cantidad: 1 };
    productosSeleccionados.push(producto);
    actualizarTablaVenta();
}

//listar carrito
function actualizarTablaVenta() {
    const tbody = document.querySelector("#tablaVenta tbody");
    tbody.innerHTML = "";

    let total = 0;

    productosSeleccionados.forEach((producto, index) => {
        total += producto.precio * producto.cantidad;

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

    // Actualizar el total en la interfaz
    document.getElementById("totalCarrito").textContent = total.toFixed(2);

    listarProductos();
}


//cantidad a vender
function modificarCantidad(index, delta) {
    if (productosSeleccionados[index].cantidad + delta > 0) {
        productosSeleccionados[index].cantidad += delta;
        actualizarTablaVenta();
    }
}

//quitar del carrito
function eliminarProducto(index) {
    productosSeleccionados.splice(index, 1);
    actualizarTablaVenta();
}

//aler confirmar
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

//Vender
function registrarVenta() {
    const idUsuario = document.getElementById("ID_UsuarioVenta").value;
    fetch('controlador/controladorventas.php', {
        method: 'POST',
        body: new URLSearchParams({ 
            "ope": "CONFIRMARVENTA", 
            "productos": JSON.stringify(productosSeleccionados),
            "ID_Usuario": idUsuario 
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire("Éxito", "Venta registrada correctamente", "success");
            productosSeleccionados = [];
            actualizarTablaVenta();
            listarVentasDelDia();
        } else {
            Swal.fire("Error", data.msg, "error");
        }
    })
    .catch(error => {
        Swal.fire("Error", "No se pudo registrar la venta: " + error.message, "error");
    });
}

// Listar ventas del día
function listarVentasDelDia() {
    fetch('controlador/controladorventas.php', {
        method: 'POST',
        body: new URLSearchParams({ "ope": "VENTAS_DE_HOY" })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        const tbody = document.querySelector("#VentasDelDia tbody");
        tbody.innerHTML = "";
        data.lista.forEach(venta => {
            tbody.innerHTML += `
            <tr>
                <td>${venta.ID_Venta}</td>
                <td>${venta.Fecha}</td>
                <td>${venta.Usuario}</td>
                <td>${venta.Producto}</td>
                <td>${venta.Cantidad}</td>
                <td>${venta.Subtotal}</td>
            </tr>`;
        });
    })
    .catch(error => {
        Swal.fire("Error", "No se pudieron cargar las ventas del día: " + error.message, "error");
    });
}

//No clickear 0 o menos
function agregarEventosVenta() {
    document.querySelectorAll("#ListaProductosventas tbody tr").forEach(fila => {
        if (fila.classList.contains("sin-stock")) {
            fila.style.pointerEvents = "none"; 
        } else {
            fila.style.cursor = "pointer"; 
            fila.addEventListener("click", function() {
                agregarProductoAVenta(this);
            });
        }
    });
}


function mostrarProductosFiltradosVentas() {
    const nombreFiltro = document.querySelector("#filtroNombreVenta").value.toLowerCase();
    const disponibilidadFiltro = document.querySelector("#filtroDisponibleVenta").value;
    const tipoFiltro = document.querySelector("#filtroTipoVenta").value;

    const tbody = document.querySelector("#ListaProductosventas tbody");
    tbody.innerHTML = "";

    const filtrados = productosGlobalVentas.filter(producto => {
        const nombreCoincide = producto.Descripcion.toLowerCase().includes(nombreFiltro);
        const disponibleCoincide =
            disponibilidadFiltro === "" ||
            (disponibilidadFiltro === "disponible" && parseFloat(producto.Disponible) > 0) ||
            (disponibilidadFiltro === "nodisponible" && parseFloat(producto.Disponible) <= 0);

        const tipoCoincide = tipoFiltro === "" || producto.TipoProducto == tipoFiltro;

        return nombreCoincide && disponibleCoincide && tipoCoincide;
    });

    filtrados.forEach(producto => {
        let claseFila = producto.Disponible <= 0 ? "sin-stock" : "con-stock";
        tbody.innerHTML += `
            <tr class="${claseFila}" data-id="${producto.ID_Producto}" 
                data-desc="${producto.Descripcion}" 
                data-precio="${producto.Precio}" 
                data-disponible="${producto.Disponible}">
                <td>${producto.ID_Producto}</td>
                <td><img src="${producto.img}" width="50" height="50"></td>
                <td>${producto.Descripcion}</td>
                <td>${producto.Precio}</td>
                <td>${producto.Disponible}</td>
                <td>${producto.TipoProducto}</td>
            </tr>`;
    });

    agregarEventosVenta();
}

function cargarTiposProductoVenta() {
    fetch('controlador/obtener_tipos.php')
        .then(response => response.json())
        .then(data => {
            const selectTipo = document.querySelector("#filtroTipoVenta");
            selectTipo.innerHTML = '<option value="">-- Seleccione un tipo --</option>';
            data.forEach(tipo => {
                selectTipo.innerHTML += `<option value="${tipo.Descripcion}">${tipo.Descripcion}</option>`;
            });
        })
        .catch(error => {
            console.error("Error cargando tipos de producto:", error);
        });
}
