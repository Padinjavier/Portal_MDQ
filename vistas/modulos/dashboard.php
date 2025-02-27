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
        <div id="gantt-container"></div>
    </div>
</section>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/frappe-gantt/0.5.0/frappe-gantt.css" />
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
            }
        });
    });
</script>
