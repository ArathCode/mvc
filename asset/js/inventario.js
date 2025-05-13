document.addEventListener("DOMContentLoaded", () => {
    //leer
    listarProductos();
    cargarTiposProducto();

    // agregar NUEVO producto
    const formProducto = document.querySelector("#formAgregarProducto");
    if (formProducto) {
        formProducto.addEventListener("submit", (event) => {
            event.preventDefault();
            agregarProducto();
        });
    }

    // editar 
    const listaProductos = document.querySelector("#ListaProductos");
    if (listaProductos) {
        listaProductos.addEventListener("click", (event) => {
            event.preventDefault();
            const target = event.target;
            cargarProducto(target.dataset.id);
            if (target.classList.contains("btn-editar")) {
                console.log("Producto seleccionado para editar:", target.dataset.id);
                cargarProducto(target.dataset.id);
            }
            
        });
    }

    //modal editar
    const formEditarProdcuto = document.querySelector("#formEditarProducto");
    if (formEditarProdcuto) {
        formEditarProdcuto.addEventListener("submit", (event) => {
            event.preventDefault();
            editarProducto();
        });
    }

    //agregar
    const modalAgregarCantidad = document.querySelector("#modalAgregarCantidad");
    modalAgregarCantidad.addEventListener("show.bs.modal", (event) => {
        const button = event.relatedTarget; // Botón que activó el modal
        const productoId = button.dataset.id;
        const productoDescripcion = button.closest("tr").querySelector("td:nth-child(3)").innerText; 
        
        document.querySelector("#productoIdCantidad").value = productoId;
        document.querySelector("#productoDescripcion").value = productoDescripcion;
    });


    //filtros
    document.querySelector("#filtroNombre").addEventListener("input", mostrarProductosFiltrados);
    document.querySelector("#filtroDisponible").addEventListener("change", mostrarProductosFiltrados);
    document.querySelector("#filtroTipo").addEventListener("change", mostrarProductosFiltrados);
    document.querySelector("#resetFiltros").addEventListener("click", () => {
        document.querySelector("#filtroNombre").value = "";
        document.querySelector("#filtroDisponible").value = "";
        document.querySelector("#filtroTipo").value = "";
        mostrarProductosFiltrados();

    });

});

//Listar productos
let productosGlobal = [];

function listarProductos() {
    fetch('controlador/controladorinventario.php', {
        method: 'POST',
        body: new URLSearchParams({ "ope": "LISTAPRODUCTOS" })
    })
    .then(response => response.json())
    .then(data => {
        productosGlobal = data.lista;
        mostrarProductosFiltrados(); // Nuevo render con filtros aplicados
    })
    .catch(error => {
        Swal.fire("Error", "No se pudo cargar la lista de productos: " + error.message, "error");
    });
}

//agregar nuevo
function agregarProducto() {
    cargarTiposProducto();
    const form = document.querySelector("#formAgregarProducto");
    const datos = new FormData(form); // Captura el archivo y demás datos
    datos.append("ope", "AGREGAR");

    fetch('controlador/controladorinventario.php', {
        method: 'POST',
        body: datos
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        if (data.success) {
            Swal.fire("Éxito", "Producto agregado correctamente", "success");
            form.reset();
            document.querySelector("#modalAgregarProducto .btn-close").click();
            listarProductos(); // Asegúrate de llamar a listarProductos()
        } else {
            Swal.fire("Error", data.msg, "error");
        }
    })
    .catch(error => {
        Swal.fire("Error", "No se pudo agregar el producto: " + error.message, "error");
    });
}

// select nuevo producto
function cargarTiposProducto() {

    fetch('controlador/obtener_tipos.php')
        .then(response => response.json())
        .then(data => {
            const selectTipo = document.querySelector("#ID_TipoProducto");
            const selectTipoe = document.querySelector("#ID_TipoProductoe");
            const selectFiltroTipo = document.querySelector("#filtroTipo");

            selectTipo.innerHTML = '<option value="">Seleccione un tipo</option>'; 
            selectTipoe.innerHTML = '<option value="">Seleccione un tipo</option>';
            selectFiltroTipo.innerHTML = '<option value="">Seleccione un tipo</option>';

            data.forEach(tipo => {
                selectTipo.innerHTML += `<option value="${tipo.ID_TipoProducto}">${tipo.Descripcion}</option>`;
                selectTipoe.innerHTML += `<option value="${tipo.ID_TipoProductoe}">${tipo.Descripcion}</option>`;
                selectFiltroTipo.innerHTML += `<option value="${tipo.ID_TipoProducto}">${tipo.Descripcion}</option>`;

            });
        })
        .catch(error => {
            console.error("Error cargando tipos de producto:", error);
        });
}

//editar
function editarProducto() {
    const form = document.querySelector("#formEditarProducto");
    const datos = new FormData(form);
    const idProducto = document.querySelector("#ID_Producto").value;

    if (!idProducto) {
        Swal.fire("Error", "ID de producto no válido", "error");
        return;
    }

    datos.append("ope", "EDITAR");  
    datos.append("ID_Producto", idProducto);

    console.log("Datos enviados:", Object.fromEntries(datos)); 

    fetch('controlador/controladorinventario.php', {
        method: 'POST',
        body: datos
    })
    .then(response => response.json())
    .then(data => {
        console.log("Respuesta del servidor:", data); 
        if (data.success) {
            Swal.fire("Éxito", "Producto actualizado correctamente", "success");
            document.querySelector("#modalEditarProducto .btn-close").click();
            listarProductos();
        } else {
            Swal.fire("Error", data.msg, "error");
        }
    })
    .catch(error => {
        Swal.fire("Error", "No se pudo actualizar el producto: " + error.message, "error");
    });
}

//cargar
function cargarProducto(id) {
    if (!id) {
        console.error("ID de producto no válido:", id);
        return;
    }
    
    fetch('controlador/controladorinventario.php', {
        method: 'POST',
        body: new URLSearchParams({ "ope": "OBTENER", "ID_Producto": id })
    })
    .then(response => response.json())
    .then(data => {
        console.log("Datos obtenidos del servidor:", data);
        if (data.success) {
            document.querySelector("#ID_Producto").value = data.producto.ID_Producto;
            document.querySelector("#imge").value = data.producto.img;
            document.querySelector("#Descripcione").value = data.producto.Descripcion;
            document.querySelector("#precioe").value = data.producto.Precio;
            document.querySelector("#ID_TipoProductoe").value = data.producto.ID_TipoProducto;
        } else {
            Swal.fire("Error", "No se pudo obtener la información del producto", "error");
        }
    })
    .catch(error => {
        Swal.fire("Error", "No se pudo obtener la información del producto: " + error.message, "error");
    });
}


//agregar cantidad

// Llamar a la función cuando se abra el modal
document.addEventListener("DOMContentLoaded", () => {
    const modalAgregarCantidad = document.querySelector("#modalAgregarCantidad");
    modalAgregarCantidad.addEventListener("show.bs.modal", () => {
        cargarProductosEnSelect();
    });
});

// Función agregar ingreso
function agregarIngreso() {
    const form = document.querySelector("#formAgregarCantidad");
    const datos = new FormData(form);
    datos.append("ope", "AGREGAR_INGRESO");

    fetch("controlador/controladorinventario.php", {
        method: "POST",
        body: datos
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire("Éxito", "Ingreso registrado correctamente", "success");
            form.reset();
            document.querySelector("#modalAgregarCantidad .btn-close").click();
            listarProductos(); 
        } else {
            Swal.fire("Error", data.msg, "error");
        }
    })
    .catch(error => {
        Swal.fire("Error", "No se pudo registrar el ingreso: " + error.message, "error");
    });
}

// formulario agregar
document.addEventListener("DOMContentLoaded", () => {
    const formAgregarCantidad = document.querySelector("#formAgregarCantidad");
    if (formAgregarCantidad) {
        formAgregarCantidad.addEventListener("submit", (event) => {
            event.preventDefault();
            agregarIngreso();
        });
    }
});

//filtros
function mostrarProductosFiltrados() {
    const nombreFiltro = document.querySelector("#filtroNombre").value.toLowerCase();
    const disponibilidadFiltro = document.querySelector("#filtroDisponible").value;
    const tipoFiltro = document.querySelector("#filtroTipo").value;

    const tbody = document.querySelector("#ListaProductos tbody");
    tbody.innerHTML = "";

    const filtrados = productosGlobal.filter(producto => {
        const nombreCoincide = producto.Descripcion.toLowerCase().includes(nombreFiltro);
        const disponibleCoincide = 
            disponibilidadFiltro === "" || 
            (disponibilidadFiltro === "disponible" && parseFloat(producto.Disponible) > 0) ||
            (disponibilidadFiltro === "nodisponible" && parseFloat(producto.Disponible) <= 0);

        const tipoCoincide = tipoFiltro === "" || producto.ID_TipoProducto == tipoFiltro;

        return nombreCoincide && disponibleCoincide && tipoCoincide;
    });

    filtrados.forEach(producto => {
        tbody.innerHTML += `
        <tr>
            <td>${producto.ID_Producto}</td>
            <td><img src="${producto.img}" width="50" height="50"></td>
            <td>${producto.Descripcion}</td>
            <td>${producto.Precio}</td>
            <td>${producto.Disponible}</td>
            <td>${producto.TipoProducto}</td>
            <td>
                <button type="button" class="btn btn-success btn-editar" data-bs-toggle="modal" data-bs-target="#modalEditarProducto" data-id="${producto.ID_Producto}">Editar</button>
                <button type="button" class="btn btn-primary btn-agregar" 
                    data-bs-toggle="modal" 
                    data-bs-target="#modalAgregarCantidad" 
                    data-id="${producto.ID_Producto}" 
                    data-descripcion="${producto.Descripcion}">
                    Agregar
                </button>
            </td>
        </tr>
        `;
    });
}
