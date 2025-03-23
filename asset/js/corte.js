document.addEventListener("DOMContentLoaded", () => {
    const btnCorte = document.getElementById("btnCorte");

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
            throw new Error("Los datos recibidos son inválidos o están vacíos.");
        }

        let ventaVisitas = 0, ventaProductos = 0, ventaMembresias = 0;
        let totalVisitas = 0, totalVentas = 0, totalMembresias = 0;

        data.corte.forEach(row => {
            switch (row.Tipo) {
                case "Visita":
                    ventaVisitas = parseFloat(row.Total_Visitas_Monto) || 0;
                    totalVisitas += parseInt(row.Total_Visitas) || 0;
                    break;
                case "Venta":
                    ventaProductos = parseFloat(row.Total_Ventas_Monto) || 0;
                    totalVentas += parseInt(row.Total_Ventas) || 0;
                    break;
                case "Membresia":
                    ventaMembresias = parseFloat(row.Total_Membresias_Monto) || 0;
                    totalMembresias += parseInt(row.Total_Membresias) || 0;
                    break;
            }
        });

        // Llamamos a la función que genera el archivo de corte
        generarCorteCaja(ventaProductos, ventaVisitas, ventaMembresias, totalVisitas, totalVentas, totalMembresias);
    } catch (error) {
        console.error("Error:", error);
        alert("Ocurrió un error al obtener los datos del corte.");
    }
}

function generarCorteCaja(ventaProductos, ventaVisitas, ventaMembresias, totalVisitas, totalVentas, totalMembresias) {
    const fecha = new Date().toLocaleDateString("es-ES").replace(/\//g, "-"); 
    const gananciaTotal = ventaProductos + ventaVisitas + ventaMembresias;
    
    const contenido = `Corte de cuenta \nDragon's Gym Dia\n(${fecha})\n` +
                      `---------------------------------------------\n` +
                      `                 Corte general\n` +
                      `Venta de productos $${ventaProductos.toFixed(2)}\n` +
                      `Venta de visitas $${ventaVisitas.toFixed(2)}\n` +
                      `Venta de membresias $${ventaMembresias.toFixed(2)}\n` +
                      `----------------------------------------------\n` +
                      `Ganancia total: $${gananciaTotal.toFixed(2)}\n` +
                      `----------------------------------------------\n` +
                      `Total visitas: ${totalVisitas}\n` +
                      `Total ventas: ${totalVentas}\n` +
                      `Total membresías: ${totalMembresias}\n` +
                      `----------------------------------------------\n` +
                      `FIN DE CORTE`;

    const blob = new Blob([contenido], { type: "text/plain" });
    const url = URL.createObjectURL(blob);
    
    const nombreArchivo = `CorteCajaDragonGym_${fecha}.txt`;

    const a = document.createElement("a");
    a.href = url;
    a.download = nombreArchivo; 
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}
