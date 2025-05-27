google.charts.load('current', {
            'packages': ['corechart' ]
        });

        google.charts.setOnLoadCallback(cargarMiembrosPorSexo);
        google.charts.setOnLoadCallback(cargarEstadoMembresias);
        google.charts.setOnLoadCallback(cargarActivasTipo);
        google.charts.setOnLoadCallback(cargarAccesos);
        google.charts.setOnLoadCallback(cargarComparativa);
        google.charts.setOnLoadCallback(cargarIngresos);

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
function cargarAccesos() {
    let params = new URLSearchParams();
    params.append("ope", "OBTENER_Accesos_Diarios");

    fetch("../controlador/controladorEstadisticas.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: params.toString(),
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            console.error("Error al cargar accesos diarios:", data.msg);
            return;
        }

        // Dibujar la gráfica con los datos
        dibujarGraficaAccesosDiarios(data.accesos_diarios);
    })
    .catch(error => {
        console.error("Error en la solicitud:", error);
    });
}
function cargarComparativa() {
    let params = new URLSearchParams();
    params.append("ope", "OBTENER_Comparativa_Ingresos_Gastos");

    fetch("../controlador/controladorEstadisticas.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: params.toString(),
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            console.error("Error al cargar comparativa ingresos vs gastos:", data.msg);
            return;
        }

        // Dibujar la gráfica
        dibujarGraficaComparativaIngresosGastos(data.comparativa_ingresos_gastos);
    })
    .catch(error => {
        console.error("Error en la solicitud:", error);
    });
}
function cargarIngresos() {
    let params = new URLSearchParams();
    params.append("ope", "OBTENER_Ingresos_Mensuales");

    fetch("../controlador/controladorEstadisticas.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: params.toString(),
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            console.error("Error al cargar ingresos mensuales:", data.msg);
            return;
        }

        // Dibujar la gráfica con los datos
        dibujarGraficaIngresosMensuales(data.ingresos_mensuales);
    })
    .catch(error => {
        console.error("Error en la solicitud:", error);
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
function cargarActivasTipo() {
    let params = new URLSearchParams();
    params.append("ope", "OBTENER_Membresias_Activas_Tipo");

    fetch("../controlador/controladorEstadisticas.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: params.toString(),
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            console.error("Error al cargar membresías activas por tipo:", data.msg);
            return;
        }

        // Llamar a la función que dibuja la gráfica
        dibujarGraficaMembresiasActivasTipo(data.membresias_activas_tipo);
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
function dibujarGraficaMembresiasActivasTipo(membresias_activas_tipo) {
    const datosTransformados = membresias_activas_tipo.map(item => [item.tipousu, parseInt(item.sum)]);
    
    const data = google.visualization.arrayToDataTable([
        ['Tipo de Membresía', 'Cantidad Activa'],
        ...datosTransformados
    ]);

    const options = {
        title: 'Membresías Activas por Tipo',
        height: 400,
        pieHole: 0.4,
        colors: ['#4caf50', '#ff9800', '#00bcd4'],
        chartArea: { width: '90%', height: '80%' },
        legend: { position: 'bottom' }
    };

    const chart = new google.visualization.PieChart(document.getElementById('chart_membresias'));
    chart.draw(data, options);
}
function dibujarGraficaAccesosDiarios(accesos_diarios) {
    const datosTransformados = accesos_diarios.map(item => [item.tipousu, parseInt(item.sum)]);

    const data = google.visualization.arrayToDataTable([
        ['Fecha', 'Accesos'],
        ...datosTransformados
    ]);

    const options = {
        title: 'Accesos Diarios (últimos 30 días)',
        curveType: 'function',
        legend: { position: 'bottom' },
        height: 400,
        chartArea: { width: '85%', height: '75%' },
        colors: ['#1976d2']
    };

    const chart = new google.visualization.LineChart(document.getElementById('chart_accesos'));
    chart.draw(data, options);
}
function dibujarGraficaIngresosMensuales(ingresos_mensuales) {
    const datosTransformados = ingresos_mensuales.map(item => [item.tipousu, parseFloat(item.sum)]);

    const data = google.visualization.arrayToDataTable([
        ['Mes', 'Ingresos'],
        ...datosTransformados
    ]);

    const options = {
        title: 'Ingresos Mensuales por Ventas',
        height: 400,
        chartArea: { width: '85%', height: '75%' },
        legend: { position: 'none' },
        colors: ['#009688']
    };

    const chart = new google.visualization.ColumnChart(document.getElementById('chart_ingresos'));
    chart.draw(data, options);
}
function dibujarGraficaComparativaIngresosGastos(data_comp) {
    const datosTransformados = data_comp.map(item => [
        item.tipousu,
        parseFloat(item.ingresos),
        parseFloat(item.gastos)
    ]);

    const data = google.visualization.arrayToDataTable([
        ['Mes', 'Ingresos', 'Gastos'],
        ...datosTransformados
    ]);

    const options = {
        title: 'Comparativa de Ingresos vs Gastos Mensuales',
        height: 400,
        chartArea: { width: '85%', height: '75%' },
        bars: 'group',
        legend: { position: 'bottom' },
        colors: ['#4caf50', '#f44336']
    };

    const chart = new google.visualization.ColumnChart(document.getElementById('chart_comparativa'));
    chart.draw(data, options);
}
