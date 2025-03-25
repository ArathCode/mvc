document.addEventListener("DOMContentLoaded", () => {
    const btnCorte = document.getElementById("btnCorte");
    const btnCortePdf = document.getElementById("btnCortePdf");

    if (btnCorte) {
        btnCorte.addEventListener("click", () => {
            obtenerDatosYCorte("txt"); 
        });
    }

    if (btnCortePdf) {
        btnCortePdf.addEventListener("click", () => {
            obtenerDatosYCorte("pdf"); 
        });
    }

    const notepadImg = document.getElementById("notepadImg");
    const pdfImg = document.getElementById("pdfImg");

    btnCorte.addEventListener("mouseenter", function () {
        cambiarImagen(notepadImg, "../asset/images/notepad.png");
    });

    btnCorte.addEventListener("mouseleave", function () {
        cambiarImagen(notepadImg, "../asset/images/notepadO.png");
    });

    btnCortePdf.addEventListener("mouseenter", function () {
        cambiarImagen(pdfImg, "../asset/images/pdf.png");
    });

    btnCortePdf.addEventListener("mouseleave", function () {
        cambiarImagen(pdfImg, "../asset/images/pdfO.png");
    });

    function cambiarImagen(img, nuevaSrc) {
        img.style.transition = "transform 0.2s ease-in-out";
        img.style.transform = "translateY(-7px)";
        setTimeout(() => {
            img.src = nuevaSrc;
            img.style.transform = "translateY(0)";
        }, 200);
    }

    const fechayHora = () => {
        const fecha = new Date();

        const opcionesMes = { month: 'long', year: 'numeric' };
        let mesAño = fecha.toLocaleString("es-ES", opcionesMes);
        mesAño = mesAño.charAt(0).toUpperCase() + mesAño.slice(1); 

        const opcionesDia = { weekday: 'long', day: 'numeric' };
        const dia = fecha.toLocaleString("es-ES", opcionesDia);

        const opcionesHora = { hour: '2-digit', minute: '2-digit', hour12: true };
        const hora = fecha.toLocaleString("es-ES", opcionesHora);

        document.getElementById("MesAct").textContent = mesAño;
        document.getElementById("DiaAct").textContent = dia;
        document.getElementById("horaAct").textContent = hora;
    };
    setInterval(fechayHora, 1000);
    fechayHora();
});

async function obtenerDatosYCorte(tipo) {
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

        if (tipo === "txt") {
            generarCorteCaja(ventaProductos, ventaVisitas, ventaMembresias, totalVisitas, totalVentas, totalMembresias);
        } else if (tipo === "pdf") {
            generarReportePdf(ventaProductos, ventaVisitas, ventaMembresias, totalVisitas, totalVentas, totalMembresias);
        }
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

function generarReportePdf(ventaProductos, ventaVisitas, ventaMembresias, totalVisitas, totalVentas, totalMembresias) {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    const fecha = new Date().toLocaleDateString("es-ES").replace(/\//g, "-"); 
    const gananciaTotal = ventaProductos + ventaVisitas + ventaMembresias;

    doc.text(`Corte de cuenta \nDragon's Gym Día (${fecha})`, 10, 10);
    doc.text('---------------------------------------------', 10, 20);
    doc.text('                 Corte general', 10, 30);
    doc.text(`Venta de productos $${ventaProductos.toFixed(2)}`, 10, 40);
    doc.text(`Venta de visitas $${ventaVisitas.toFixed(2)}`, 10, 50);
    doc.text(`Venta de membresias $${ventaMembresias.toFixed(2)}`, 10, 60);
    doc.text('----------------------------------------------', 10, 70);
    doc.text(`Ganancia total: $${gananciaTotal.toFixed(2)}`, 10, 80);
    doc.text('----------------------------------------------', 10, 90);
    doc.text(`Total visitas: ${totalVisitas}`, 10, 100);
    doc.text(`Total ventas: ${totalVentas}`, 10, 110);
    doc.text(`Total membresías: ${totalMembresias}`, 10, 120);
    doc.text('----------------------------------------------', 10, 130);
    doc.text('FIN DE CORTE', 10, 140);

    doc.save(`CorteCajaDragonGym_${fecha}.pdf`);
}
