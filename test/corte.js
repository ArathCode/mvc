function generarCorteCaja(ventaProductos, ventaVisitas, ventaMembresias) {
    const fecha = new Date().toLocaleDateString('es-ES');
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
    
    const blob = new Blob([contenido], { type: 'text/plain' });
    const url = URL.createObjectURL(blob);
    
    const a = document.createElement('a');
    a.href = url;
    a.download = 'corte_caja.txt';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}

// Ejemplo de uso
const ventaProductos = 1500;
const ventaVisitas = 800;
const ventaMembresias = 2000;

generarCorteCaja(ventaProductos, ventaVisitas, ventaMembresias);