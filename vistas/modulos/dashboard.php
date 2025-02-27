<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Gestión de Clientes</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Gestión de Clientes</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-sm-12">
                <label for="view-mode">Modo de Vista:</label>
                <select id="view-mode" class="form-control">
                    <option value="Day">Día</option>
                    <option value="Week">Semana</option>
                    <option value="Month" selected>Mes</option>
                </select>
            </div>
        </div>
        <h4 id="current-date" class="text-center font-weight-bold"></h4>
        <div id="gantt-container"></div>
    </div>
</section>

<link rel="stylesheet" href="/internet/vistas/assets/dist/css/frappe-gantt.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/frappe-gantt/0.5.0/frappe-gantt.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const tasks = [
            { start: "2025-01-24", end: "2025-02-23", name: "ALE • HBO_MAX", id: "1", progress: 50 },
            { start: "2025-01-24", end: "2025-02-23", name: "ALE • PRIME", id: "2", progress: 60 },
            { start: "2025-01-28", end: "2025-02-27", name: "VALIA • NETFLIX", id: "3", progress: 30 },
            { start: "2025-02-10", end: "2025-03-12", name: "Miguel • NETFLIX", id: "4", progress: 80 },
            { start: "2025-02-10", end: "2025-03-12", name: "Miguel • DISNEY", id: "5", progress: 50 },
            { start: "2025-02-10", end: "2025-03-12", name: "Miguel • PARAMOUNT", id: "6", progress: 40 },
            { start: "2025-02-23", end: "2025-03-25", name: "Nina • NETFLIX", id: "7", progress: 70 }
        ];

        const gantt = new Gantt("#gantt-container", tasks, {
            view_mode: "Month",
            date_format: "YYYY-MM-DD",
            custom_popup_html: function(task) {
                return `<strong>${task.name}</strong><br>Inicio: ${task.start}<br>Fin: ${task.end}`;
            },
            on_date_change: function(task, start, end) {
                console.log(`Task ${task.name} changed to start at ${start} and end at ${end}`);
            },
            on_view_change: function(mode) {
                console.log(`View mode changed to ${mode}`);
            }
        });

        // Mostrar la fecha actual en la pantalla
        function mostrarFechaActual() {
            const today = new Date();
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById("current-date").textContent = "Hoy es " + today.toLocaleDateString('es-ES', options);
        }
        mostrarFechaActual();

        // Cambiar la vista del Gantt
        document.getElementById("view-mode").addEventListener("change", function() {
            gantt.change_view_mode(this.value);
        });

        // Agregar línea azul para la fecha actual
        function agregarLineaHoy() {
            const today = new Date();
            const todayStr = today.toISOString().split('T')[0];

            const todayPos = gantt.date_to_pos(today);
            const todayLine = document.createElement('div');
            todayLine.style.position = 'absolute';
            todayLine.style.top = '0';
            todayLine.style.bottom = '0';
            todayLine.style.left = `${todayPos}px`;
            todayLine.style.width = '2px';
            todayLine.style.backgroundColor = 'blue';
            todayLine.style.zIndex = '1000';
            document.getElementById("gantt-container").appendChild(todayLine);
        }

        // Resaltar el día actual en la escala de fechas
        function resaltarDiaActual() {
            const today = new Date().toISOString().split('T')[0];
            const labels = document.querySelectorAll(".tick text");

            labels.forEach(label => {
                if (label.textContent === today) {
                    label.style.fontWeight = "bold";
                    label.style.fill = "white";
                    label.parentNode.style.fill = "blue";
                    label.parentNode.style.rx = "4";  // Bordes redondeados
                }
            });
        }
        function agregarLineaHoy() {
    const today = new Date().toISOString().split('T')[0];

    // Buscar la columna de la fecha actual
    const labels = document.querySelectorAll(".tick text");
    let todayColumn = null;
    labels.forEach(label => {
        if (label.textContent === today) {
            todayColumn = label.parentNode;
        }
    });

    if (todayColumn) {
        const bbox = todayColumn.getBoundingClientRect();
        const container = document.getElementById("gantt-container");
        const containerRect = container.getBoundingClientRect();
        const todayPos = bbox.left - containerRect.left;

        const todayLine = document.createElement('div');
        todayLine.style.position = 'absolute';
        todayLine.style.top = '0';
        todayLine.style.bottom = '0';
        todayLine.style.left = `${todayPos}px`;
        todayLine.style.width = '2px';
        todayLine.style.backgroundColor = 'blue';
        todayLine.style.zIndex = '1000';
        todayLine.style.pointerEvents = 'none';

        container.appendChild(todayLine);
    } else {
        console.warn("No se encontró la columna de la fecha actual en el gráfico Gantt.");
    }
}

        setTimeout(() => {
            agregarLineaHoy();
            resaltarDiaActual();
        }, 500);
    });
</script>