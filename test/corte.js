document.addEventListener("DOMContentLoaded", () => {
    // Detectamos el botón con el id "btnCorte"
    const btnCorte = document.getElementById("btnCorte");

    // Si el botón existe, agregamos el evento de clic
    if (btnCorte) {
        btnCorte.addEventListener("click", () => {
            obtenerDatosYCorte();
        });
    }
});

async function obtenerDatosYCorte() {
    try {
        const response = await fetch("../controlador/controladorCorte.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "ope=OBTENER_CORTE"
        });

        if (!response.ok) {
            throw new Error("Error en la respuesta del servidor");
        }

        const data = await response.json();

        if (!data.success || !data.corte || !Array.isArray(data.corte)) {
            throw new Error("Los datos recibidos son inválidos");
        }

        let ventaVisitas = 0, ventaProductos = 0, ventaMembresias = 0;

        // Procesamos los datos recibidos
        data.corte.forEach(row => {
            switch (row.Tipo) {
                case "Visita":
                    ventaVisitas = parseFloat(row.Total_Visitas_Monto) || 0;
                    break;
                case "Venta":
                    ventaProductos = parseFloat(row.Total_Ventas_Monto) || 0;
                    break;
                case "Membresia":
                    ventaMembresias = parseFloat(row.Total_Membresias_Monto) || 0;
                    break;
            }
        });

        // Llamamos a la función que genera el archivo de corte
        generarCorteCaja(ventaProductos, ventaVisitas, ventaMembresias);
    } catch (error) {
        console.error("Error:", error);
    }
}

function generarCorteCaja(ventaProductos, ventaVisitas, ventaMembresias) {
    const fecha = new Date().toLocaleDateString("es-ES");
    const gananciaTotal = ventaProductos + ventaVisitas + ventaMembresias;
    
    const contenido = `Corte de cuenta Coach(Arath)\nDragon's Gym Dia\n(${fecha})\n` +
                      `---------------------------------------------\n` +
                      `                 Corte general\n` +
                      `Venta de productos $${ventaProductos.toFixed(2)}\n` +
                      `Venta de visitas $${ventaVisitas.toFixed(2)}\n` +
                      `Venta de membresias $${ventaMembresias.toFixed(2)}\n` +
                      `----------------------------------------------\n` +
                      `Ganancia total: $${gananciaTotal.toFixed(2)}\n` +
                      `FIN DE CORTE`;

    // Creamos el archivo de texto
    const blob = new Blob([contenido], { type: "text/plain" });
    const url = URL.createObjectURL(blob);
    
    // Creamos un enlace de descarga
    const a = document.createElement("a");
    a.href = url;
    a.download = "corte_caja.txt";
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}
