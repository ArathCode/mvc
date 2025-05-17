

function cargarMiembrosPorSexo() {
    
    let params = new URLSearchParams();
    params.append("ope", "OBTENER_Miembros_Sexo");

    fetch("../controlador/controladorEstadisticas.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: params.toString(),
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            console.error("Error al cargar miembros por sexo:", data.msg);
            return;
        }
        llenarTablaSexo(data.miembros_sexo);
        dibujarGraficaMiembrosSexo(data.miembros_sexo);
    })
    .catch(error => {
        console.error("Error en la solicitud:", error);
    });
}
function llenarTablaSexo(miembros_sexo) {
    const tbody = document.getElementById("tbodySexo");
    tbody.innerHTML = "";
    console.log(miembros_sexo);
    miembros_sexo.forEach(item => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
            <td>${item.tipousu}</td>
            <td>${item.sum}</td>
        `;
        tbody.appendChild(tr);
    });
}
function cargarEstadoMembresias() {
    let params = new URLSearchParams();
    params.append("ope", "OBTENER_Estado_Membresias");

    fetch("../controlador/controladorEstadisticas.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: params.toString(),
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            console.error("Error al cargar estado de membresías:", data.msg);
            return;
        }
        dibujarGraficaEstadoMembresias(data.estado_membresias);
    })
    .catch(error => {
        console.error("Error en la solicitud:", error);
    });
}

function cargarGastosMensuales() {
    let params = new URLSearchParams();
    params.append("ope", "OBTENER_Gastos_Mensuales");

    fetch("../controlador/controladorEstadisticas.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: params.toString(),
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            console.error("Error al cargar gastos mensuales:", data.msg);
            return;
        }
        dibujarGraficaGastosMensuales(data.gastos_mensuales);
        dibujarGraficaGastosMensualess(data.gastos_mensuales);
    })
    .catch(error => {
        console.error("Error en la solicitud:", error);
    });
}

// Dibujar las gráficas

function dibujarGraficaMiembrosSexo(miembros_sexo) {
    // Transformar los datos correctamente
    var datosTransformados = miembros_sexo.map(item => [item.tipousu, parseInt(item.sum)]);
    console.log(datosTransformados);  // Verifica que el formato sea correcto

    // Crear la tabla de datos para Google Charts
    var data = google.visualization.arrayToDataTable([
        ['Tipos de usuario', 'Cantidad por tipo'],
        ...datosTransformados  // Usamos los datos transformados
    ]);
    console.log(data);  // Asegúrate de que la tabla de datos esté bien construida

    // Opciones de la gráfica
    var options = {
        title: 'Conteo de Miembros por Sexo',
        height: 400,
        pieHole: 0.5,
        colors: ['#67b4f5', '#d823a7'],
        chartArea: {
        width: '90%',  // Esto ayuda a que la gráfica use mejor el espacio
        height: '80%'
    },
        legend: { position: 'bottom' }
    };


    // Crear y dibujar el gráfico
    var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
    chart.draw(data, options);
}

function dibujarGraficaEstadoMembresias(datos) {
    let arrayData = [
        ['Estado', 'Cantidad'],
        ['Vigentes', parseInt(datos.Vigentes)],
        ['Caducados', parseInt(datos.Caducados)]
    ];

    let data = google.visualization.arrayToDataTable(arrayData);

    let options = {
    title: 'Estado de Membresías',
    height: 400, 
     // Puedes ajustar la altura, pero no pongas width fijo
    pieHole: 0.5,
    colors: ['#2ECC71', '#E74C3C'],
    legend: { position: 'bottom' },
    chartArea: {
        width: '90%',  // Esto ayuda a que la gráfica use mejor el espacio
        height: '80%'
    }
};


    let chart = new google.visualization.PieChart(document.getElementById('chart_div2'));
    chart.draw(data, options);
}

function dibujarGraficaGastosMensuales(lista) {
    let arrayData = [['Mes', 'Total Gasto']];
    lista.forEach(item => {
        arrayData.push([item.Mes, parseFloat(item.Total)]);
    });

    let data = google.visualization.arrayToDataTable(arrayData);

    let options = {
        title: 'Gasto Mensual',
        width: 600,
        hAxis: {
            title: 'Mes',
            slantedText: true
        },
        vAxis: {
            title: 'Total Gasto'
        },
        legend: {  position: 'bottom'},
        chartArea: {
        width: '90%',  // Esto ayuda a que la gráfica use mejor el espacio
        height: '80%'
    },
        colors: ['#4285F4']
    };

    let chart = new google.visualization.ColumnChart(document.getElementById('chart_div3'));
    chart.draw(data, options);
}
function dibujarGraficaGastosMensualess(lista) {
    let arrayData = [['Mes', 'Total Gasto']];
    lista.forEach(item => {
        arrayData.push([item.Mes, parseFloat(item.Total)]);
    });

    let data = google.visualization.arrayToDataTable(arrayData);

    let options = {
        title: 'Gasto Mensual',
        width: 600,
        hAxis: {
            title: 'Mes',
            slantedText: true
        },
        vAxis: {
            title: 'Total Gasto'
        },
        legend: {  position: 'bottom'},
        chartArea: {
        width: '90%',  // Esto ayuda a que la gráfica use mejor el espacio
        height: '80%'
    },
        colors: ['#4285F4']
    };

    let chart = new google.visualization.ColumnChart(document.getElementById('chart_div4'));
    chart.draw(data, options);
}
