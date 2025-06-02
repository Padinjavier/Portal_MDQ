<?php

require '../../vendor/autoload.php';
require '../../Config/Config.php';
require '../../modelos/reportetickets/ReporteticketsPDFModelo.php';
require '../../vendor/tecnickcom/tcpdf/tcpdf.php';

class ReporteticketsPDFControlador
{
    private $modelo;

    public function __construct()
    {
        $db = new Conexion();
        $this->modelo = new ReporteticketsPDFModelo($db);
    }

    
    public function SelectTrabajadores()
    {
        try {
            $usuarios = $this->modelo->SelectTrabajadores();
            echo json_encode(['success' => true, 'data' => $usuarios]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al obtener usuarios: ' . $e->getMessage()]);
        }
    }

    public function SelectSoportes()
    {
        try {
            $soportes = $this->modelo->SelectSoportes();
            echo json_encode(['success' => true, 'data' => $soportes]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al obtener usuarios: ' . $e->getMessage()]);
        }
    }




    public function CodigoTicketPDF($codigo)
    {
        try {
            $data = $this->modelo->ObtenerTicketYComentarios($codigo);
            // Crear instancia TCPDF
            $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
            // Desactivar encabezado y pie de página
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            // Márgenes y configuración de página
            $pdf->SetMargins(25, 30, 25);
            $pdf->SetAutoPageBreak(false, 0);
            // Añadir una página
            $pdf->AddPage();
            // Imagen de Fondo
            $pdf->Image(LOGO_EMPRESA, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
            // Fecha Actual y Hora
            $fechaActual = date('d') . " de " . getMesEnEspañol(date('Y-m-d')) . " del " . date('Y');
            $horaActual = date('H:i');
            $ticketData = $data[0] ?? [];
            $creador = $ticketData['Creador'] ?? 'Sin asignar';
            $problema = $ticketData['NombreProblema'] ?? 'No especificado';
            $subproblema = $ticketData['NombreSubproblema'] ?? 'No asignado';
            $departamento = $ticketData['DepartamentoTicket'] ?? 'No especificado';
            $fechaCreacion = $ticketData['DataCreateTicket'] ?? 'Sin fecha';
            $fechaActualizacion = $ticketData['DataUpdateTicket'] ?? 'Sin fecha';
            $estado = getEstadoTicket($ticketData['StatusTicket'] ?? -1);
            $soporte = $ticketData['UsuarioSoporte'] ?? 'No asignado';
            // Título del Año
            $nombreAño = getNombreAño($fechaCreacion);
            $pdf->SetFont('helvetica', 'I', 10);
            $pdf->Cell(0, 10, '"' . $nombreAño . '"', 0, 1, 'C');
            $pdf->Ln(10);
            // Título del Reporte
            $pdf->SetFont('helvetica', 'B', 16);
            $pdf->Cell(0, 10, "REPORTE DE TICKETS", 0, 1, 'C');
            $pdf->SetFont('helvetica', '', 12);
            $pdf->Cell(0, 10, "N° " . ($ticketData['CodTicket'] ?? 'Sin Código'), 0, 1, 'C');
            $pdf->Ln(10);
            // Fecha y Lugar
            $pdf->Cell(0, 10, "Quilmaná, $fechaActual", 0, 1, 'R');
            $pdf->Ln(10);
            // Descripción del Reporte
            $descripcion = "El encargado de la Unidad de Informática de la Municipalidad Distrital de Quilmaná, siendo las $horaActual horas del día $fechaActual, emite el presente reporte identificado con el código N° {$ticketData['CodTicket']} registrado el $fechaCreacion por $creador del área $departamento.";
            $pdf->MultiCell(0, 10, $descripcion, 0, 'L');
            $pdf->Ln(10); // Espacio para iniciar sección de comentarios
            // Tabla de Datos del Ticket
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->Cell(0, 10, "DETALLES DEL TICKET", 0, 1, 'L');
            $pdf->SetFont('helvetica', '', 12);
            $pdf->SetFillColor(50, 50, 50); // Blanco
            // Datos del Ticket
            $datos = [
                "Código:" => $ticketData['CodTicket'],
                "Trabajador:" => $creador,
                "Departamento:" => $departamento,
                "Fecha Creación:" => $fechaCreacion,
                "Fecha Actualización:" => $fechaActualizacion,
                "Soporte:" => $soporte,
                "Problema:" => $problema,
                "Subproblema:" => $subproblema,
                "Estado:" => $estado,
            ];
            foreach ($datos as $campo => $valor) {
                $pdf->Cell(50, 10, $campo, 1, 0, 'L');
                $pdf->Cell(110, 10, $valor, 1, 1, 'L');
            }
            $pdf->Ln(10); // Espacio antes de COMENTARIOS


            // ----------------------
            // SECCIÓN DE COMENTARIOS
            // ----------------------

            $comentarios = array_filter($data, fn($c) => !empty($c['Comentario']));
            // Verificar si hay comentarios
            if (!empty($comentarios)) {
                $pdf->Ln(40); // Espacio antes de COMENTARIOS
                $pdf->AddPage();
                $pdf->Image(LOGO_EMPRESA, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
                $pdf->SetFont('helvetica', 'B', 14);
                $pdf->Cell(0, 10, "COMENTARIOS", 0, 1, 'C');
                $pdf->Ln(5);
                $pdf->SetFont('helvetica', '', 12);
                foreach ($comentarios as $comentario) {
                    $usuario = $comentario['UsuarioComentario'];
                    $fechaComentario = date('d') . " de " . getMesEnEspañol(date('Y-m-d', strtotime($comentario['FechaComentario']))) . " del " . date('Y H:i', strtotime($comentario['FechaComentario']));
                    $pdf->SetFont('helvetica', 'B', 12);
                    $pdf->MultiCell(0, 10, "De: $usuario\nFecha: $fechaComentario", 0, 'L');
                    $pdf->Ln(2);
                    $pdf->SetFont('helvetica', '', 12);
                    // Verificar espacio disponible para el comentario
                    $currentY = $pdf->GetY();
                    if ($currentY > 230) {
                        $pdf->AddPage();
                        $pdf->Image(LOGO_EMPRESA, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
                        $pdf->SetY(30); // Espacio para nuevos comentarios
                    }
                    $pdf->writeHTML($comentario['Comentario'], true, false, true, false, '');
                    $pdf->Ln(10);
                }
            } else {
                $pdf->SetFont('helvetica', 'B', 14);
                $pdf->Cell(0, 10, "COMENTARIOS", 0, 1, 'C');
                $pdf->Ln(5);
                $pdf->SetFont('helvetica', '', 12);
                $pdf->Cell(0, 10, "Sin comentarios registrados.", 0, 1, 'C');
            }

            ob_end_clean();
            $pdf->Output("Reporte_Ticket_{$codigo}.pdf", 'I');

        } catch (Exception $e) {
            echo "Error al generar el PDF: " . $e->getMessage();
        }
    }





    public function PorFechaPDF($fechaDesde, $fechaHasta)
    {
        try {
            $data = $this->modelo->ObtenerTicketsPorFechaHora($fechaDesde, $fechaHasta);

            if (empty($data)) {
                echo "No se encontraron tickets en el rango de fechas.";
                exit;
            }

            // Agrupar tickets y comentarios
            $ticketsAgrupados = [];
            foreach ($data as $fila) {
                $cod = $fila['CodTicket'];
                if (!isset($ticketsAgrupados[$cod])) {
                    $ticketsAgrupados[$cod] = [
                        'CodTicket' => $fila['CodTicket'],
                        'Creador' => $fila['Creador'],
                        'DepartamentoTicket' => $fila['DepartamentoTicket'] ?? 'No especificado',
                        'FechaCreacion' => $fila['DataCreateTicket'],
                        'FechaActualizacion' => $fila['DataUpdateTicket'] ?? 'No disponible',
                        'Soporte' => $fila['UsuarioSoporte'] ?? 'No asignado',
                        'Problema' => $fila['NombreProblema'] ?? 'No especificado',
                        'Subproblema' => $fila['NombreSubproblema'] ?? 'No asignado',
                        'Estado' => getEstadoTicket($fila['StatusTicket'] ?? -1),
                        'Comentarios' => []
                    ];
                }
                if (!empty($fila['Comentario'])) {
                    $ticketsAgrupados[$cod]['Comentarios'][] = [
                        'UsuarioComentario' => $fila['UsuarioComentario'],
                        'FechaComentario' => $fila['FechaComentario'],
                        'Comentario' => $fila['Comentario']
                    ];
                }
            }

            // Crear PDF
            $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->SetMargins(25, 30, 25);
            $pdf->SetAutoPageBreak(false, 0);
            $pdf->AddPage();
            $pdf->Image(LOGO_EMPRESA, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);

            $fechaActual = date('d') . " de " . getMesEnEspañol(date('Y-m-d')) . " del " . date('Y');
            $nombreAño = getNombreAño($fechaDesde);

            $pdf->SetFont('helvetica', 'I', 10);
            $pdf->Cell(0, 10, '"' . $nombreAño . '"', 0, 1, 'C');
            $pdf->Ln(10);

            $pdf->SetFont('helvetica', 'B', 16);
            $pdf->Cell(0, 10, "REPORTE DE TICKETS POR FECHA", 0, 1, 'C');
            $pdf->Ln(5);

            $pdf->SetFont('helvetica', '', 12);
            $pdf->Cell(0, 10, "Quilmaná, $fechaActual", 0, 1, 'R');
            $pdf->Ln(5);

            $descripcion = "El presente documento registra la relación de tickets generados entre el " .
                date('d/m/Y', strtotime($fechaDesde)) . " y el " .
                date('d/m/Y', strtotime($fechaHasta)) . ". Este informe ha sido generado automáticamente por el sistema de gestión de soporte técnico de la Municipalidad Distrital de Quilmaná.";
            $pdf->MultiCell(0, 10, $descripcion, 0, 'L');
            $pdf->Ln(10);

            // Recorremos los tickets
            foreach ($ticketsAgrupados as $ticket) {
                $pdf->SetFont('helvetica', 'B', 12);
                $pdf->Cell(0, 10, "DETALLES DEL TICKET: " . $ticket['CodTicket'], 0, 1, 'L');

                // Tabla de datos del ticket
                $pdf->SetFont('helvetica', '', 11);
                $datos = [
                    "Trabajador:" => $ticket['Creador'],
                    "Departamento:" => $ticket['DepartamentoTicket'],
                    "Fecha Creación:" => $ticket['FechaCreacion'],
                    "Fecha Actualización:" => $ticket['FechaActualizacion'],
                    "Soporte:" => $ticket['Soporte'],
                    "Problema:" => $ticket['Problema'],
                    "Subproblema:" => $ticket['Subproblema'],
                    "Estado:" => $ticket['Estado'],
                ];
                foreach ($datos as $campo => $valor) {
                    $pdf->Cell(50, 10, $campo, 1, 0, 'L');
                    $pdf->Cell(110, 10, $valor, 1, 1, 'L');
                }
                $pdf->Ln(5);

                // Comentarios del ticket
                if (!empty($ticket['Comentarios'])) {
                    $pdf->SetFont('helvetica', 'B', 12);
                    $pdf->Cell(0, 10, "COMENTARIOS", 0, 1, 'C');
                    foreach ($ticket['Comentarios'] as $comentario) {
                        $fechaComentario = date('d') . " de " . getMesEnEspañol(date('Y-m-d', strtotime($comentario['FechaComentario']))) . " del " . date('Y H:i', strtotime($comentario['FechaComentario']));
                        $pdf->SetFont('helvetica', 'B', 11);
                        $pdf->MultiCell(0, 6, "De: {$comentario['UsuarioComentario']}\nFecha: $fechaComentario", 0, 'L');
                        $pdf->Ln(1);
                        $pdf->SetFont('helvetica', '', 11);
                        $pdf->writeHTML($comentario['Comentario'], true, false, true, false, '');
                        $pdf->Ln(6);

                        if ($pdf->GetY() > 220) {
                            $pdf->AddPage();
                            $pdf->Image(LOGO_EMPRESA, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
                        }
                    }
                } else {
                    $pdf->Cell(0, 10, "COMENTARIOS", 0, 1, 'C');
                    $pdf->Ln(5);
                    $pdf->SetFont('helvetica', 'I', 11);
                    $pdf->Cell(0, 8, "Sin comentarios.", 0, 1, 'L');
                    $pdf->Ln(10);
                }

                $pdf->Ln(10);

                if ($pdf->GetY() > 240) {
                    $pdf->AddPage();
                    $pdf->Image(LOGO_EMPRESA, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
                }
            }

            ob_end_clean();
            $pdf->Output("Reporte_Tickets_Fecha.pdf", 'I');

        } catch (Exception $e) {
            echo "Error al generar el PDF: " . $e->getMessage();
        }
    }
    


    public function PorTrabajadorPDF($IdUsuarioCreadorTicketReporte)
{
    try {
        $data = $this->modelo->PorTrabajadorPDF($IdUsuarioCreadorTicketReporte);

        if (empty($data)) {
            echo "No se encontraron tickets asignados a este trabajador.";
            exit;
        }

        // Agrupar tickets
        $ticketsAgrupados = [];
        foreach ($data as $fila) {
            $cod = $fila['CodTicket'];
            if (!isset($ticketsAgrupados[$cod])) {
                $ticketsAgrupados[$cod] = [
                    'CodTicket' => $fila['CodTicket'],
                    'Creador' => $fila['Creador'],
                    'DepartamentoTicket' => $fila['DepartamentoTicket'] ?? 'No especificado',
                    'FechaCreacion' => $fila['DataCreateTicket'],
                    'FechaActualizacion' => $fila['DataUpdateTicket'] ?? 'No disponible',
                    'Soporte' => $fila['UsuarioSoporte'] ?? 'No asignado',
                    'Problema' => $fila['NombreProblema'] ?? 'No especificado',
                    'Subproblema' => $fila['NombreSubproblema'] ?? 'No asignado',
                    'Estado' => getEstadoTicket($fila['StatusTicket'] ?? -1),
                    'Comentarios' => []
                ];
            }
            if (!empty($fila['Comentario'])) {
                $ticketsAgrupados[$cod]['Comentarios'][] = [
                    'UsuarioComentario' => $fila['UsuarioComentario'],
                    'FechaComentario' => $fila['FechaComentario'],
                    'Comentario' => $fila['Comentario']
                ];
            }
        }

        // Crear PDF
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(25, 30, 25);
        $pdf->SetAutoPageBreak(false, 0);
        $pdf->AddPage();
        $pdf->Image(LOGO_EMPRESA, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);

        $fechaActual = date('d') . " de " . getMesEnEspañol(date('Y-m-d')) . " del " . date('Y');
        $nombreAño = getNombreAño(date('Y-m-d'));

        $pdf->SetFont('helvetica', 'I', 10);
        $pdf->Cell(0, 10, '"' . $nombreAño . '"', 0, 1, 'C');
        $pdf->Ln(10);

        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, "REPORTE DE TICKETS POR TRABAJADOR", 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 10, "Quilmaná, $fechaActual", 0, 1, 'R');
        $pdf->Ln(5);

        $descripcion = "El presente documento registra la relación de tickets generados por el trabajador seleccionado. "
            . "Este informe ha sido generado automáticamente por el sistema de gestión de soporte técnico de la Municipalidad Distrital de Quilmaná.";
        $pdf->MultiCell(0, 10, $descripcion, 0, 'L');
        $pdf->Ln(10);

        // Recorremos los tickets
        foreach ($ticketsAgrupados as $ticket) {
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->Cell(0, 10, "DETALLES DEL TICKET: " . $ticket['CodTicket'], 0, 1, 'L');

            // Tabla de datos del ticket
            $pdf->SetFont('helvetica', '', 11);
            $datos = [
                "Trabajador:" => $ticket['Creador'],
                "Departamento:" => $ticket['DepartamentoTicket'],
                "Fecha Creación:" => $ticket['FechaCreacion'],
                "Fecha Actualización:" => $ticket['FechaActualizacion'],
                "Soporte:" => $ticket['Soporte'],
                "Problema:" => $ticket['Problema'],
                "Subproblema:" => $ticket['Subproblema'],
                "Estado:" => $ticket['Estado'],
            ];
            foreach ($datos as $campo => $valor) {
                $pdf->Cell(50, 10, $campo, 1, 0, 'L');
                $pdf->Cell(110, 10, $valor, 1, 1, 'L');
            }
            $pdf->Ln(5);

            // Comentarios
            if (!empty($ticket['Comentarios'])) {
                $pdf->SetFont('helvetica', 'B', 12);
                $pdf->Cell(0, 10, "COMENTARIOS", 0, 1, 'C');
                foreach ($ticket['Comentarios'] as $comentario) {
                    $fechaComentario = date('d') . " de " . getMesEnEspañol(date('Y-m-d', strtotime($comentario['FechaComentario']))) . " del " . date('Y H:i', strtotime($comentario['FechaComentario']));
                    $pdf->SetFont('helvetica', 'B', 11);
                    $pdf->MultiCell(0, 6, "De: {$comentario['UsuarioComentario']}\nFecha: $fechaComentario", 0, 'L');
                    $pdf->Ln(1);
                    $pdf->SetFont('helvetica', '', 11);
                    $pdf->writeHTML($comentario['Comentario'], true, false, true, false, '');
                    $pdf->Ln(6);

                    if ($pdf->GetY() > 220) {
                        $pdf->AddPage();
                        $pdf->Image(LOGO_EMPRESA, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
                    }
                }
            } else {
                $pdf->Cell(0, 10, "COMENTARIOS", 0, 1, 'C');
                $pdf->Ln(5);
                $pdf->SetFont('helvetica', 'I', 11);
                $pdf->Cell(0, 8, "Sin comentarios.", 0, 1, 'L');
                $pdf->Ln(10);
            }

            $pdf->Ln(10);

            if ($pdf->GetY() > 240) {
                $pdf->AddPage();
                $pdf->Image(LOGO_EMPRESA, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
            }
        }

        ob_end_clean();
        $pdf->Output("Reporte_Tickets_Trabajador.pdf", 'I');

    } catch (Exception $e) {
        echo "Error al generar el PDF: " . $e->getMessage();
    }
}




public function PorSoportePDF($IdUsuarioSoporteTicketReporte)
{
    try {
        $data = $this->modelo->PorSoportePDF($IdUsuarioSoporteTicketReporte);

        if (empty($data)) {
            echo "No se encontraron tickets asignados a este soporte.";
            exit;
        }

        $ticketsAgrupados = [];
        foreach ($data as $fila) {
            $cod = $fila['CodTicket'];
            if (!isset($ticketsAgrupados[$cod])) {
                $ticketsAgrupados[$cod] = [
                    'CodTicket' => $fila['CodTicket'],
                    'Creador' => $fila['Creador'],
                    'DepartamentoTicket' => $fila['DepartamentoTicket'] ?? 'No especificado',
                    'FechaCreacion' => $fila['DataCreateTicket'],
                    'FechaActualizacion' => $fila['DataUpdateTicket'] ?? 'No disponible',
                    'Soporte' => $fila['UsuarioSoporte'] ?? 'No asignado',
                    'Problema' => $fila['NombreProblema'] ?? 'No especificado',
                    'Subproblema' => $fila['NombreSubproblema'] ?? 'No asignado',
                    'Estado' => getEstadoTicket($fila['StatusTicket'] ?? -1),
                    'Comentarios' => []
                ];
            }
            if (!empty($fila['Comentario'])) {
                $ticketsAgrupados[$cod]['Comentarios'][] = [
                    'UsuarioComentario' => $fila['UsuarioComentario'],
                    'FechaComentario' => $fila['FechaComentario'],
                    'Comentario' => $fila['Comentario']
                ];
            }
        }

        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(25, 30, 25);
        $pdf->SetAutoPageBreak(false, 0);
        $pdf->AddPage();
        $pdf->Image(LOGO_EMPRESA, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);

        $fechaActual = date('d') . " de " . getMesEnEspañol(date('Y-m-d')) . " del " . date('Y');
        $nombreAño = getNombreAño(date('Y-m-d'));

        $pdf->SetFont('helvetica', 'I', 10);
        $pdf->Cell(0, 10, '"' . $nombreAño . '"', 0, 1, 'C');
        $pdf->Ln(10);

        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, "REPORTE DE TICKETS POR SOPORTE", 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 10, "Quilmaná, $fechaActual", 0, 1, 'R');
        $pdf->Ln(5);

        $descripcion = "El presente documento registra la relación de tickets asignados al trabajador de soporte técnico seleccionado. "
            . "Este informe ha sido generado automáticamente por el sistema de gestión de soporte técnico de la Municipalidad Distrital de Quilmaná.";
        $pdf->MultiCell(0, 10, $descripcion, 0, 'L');
        $pdf->Ln(10);

        foreach ($ticketsAgrupados as $ticket) {
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->Cell(0, 10, "DETALLES DEL TICKET: " . $ticket['CodTicket'], 0, 1, 'L');

            $pdf->SetFont('helvetica', '', 11);
            $datos = [
                "Trabajador:" => $ticket['Creador'],
                "Departamento:" => $ticket['DepartamentoTicket'],
                "Fecha Creación:" => $ticket['FechaCreacion'],
                "Fecha Actualización:" => $ticket['FechaActualizacion'],
                "Soporte:" => $ticket['Soporte'],
                "Problema:" => $ticket['Problema'],
                "Subproblema:" => $ticket['Subproblema'],
                "Estado:" => $ticket['Estado'],
            ];
            foreach ($datos as $campo => $valor) {
                $pdf->Cell(50, 10, $campo, 1, 0, 'L');
                $pdf->Cell(110, 10, $valor, 1, 1, 'L');
            }
            $pdf->Ln(5);

            if (!empty($ticket['Comentarios'])) {
                $pdf->SetFont('helvetica', 'B', 12);
                $pdf->Cell(0, 10, "COMENTARIOS", 0, 1, 'C');
                foreach ($ticket['Comentarios'] as $comentario) {
                    $fechaComentario = date('d') . " de " . getMesEnEspañol(date('Y-m-d', strtotime($comentario['FechaComentario']))) . " del " . date('Y H:i', strtotime($comentario['FechaComentario']));
                    $pdf->SetFont('helvetica', 'B', 11);
                    $pdf->MultiCell(0, 6, "De: {$comentario['UsuarioComentario']}\nFecha: $fechaComentario", 0, 'L');
                    $pdf->Ln(1);
                    $pdf->SetFont('helvetica', '', 11);
                    $pdf->writeHTML($comentario['Comentario'], true, false, true, false, '');
                    $pdf->Ln(6);

                    if ($pdf->GetY() > 220) {
                        $pdf->AddPage();
                        $pdf->Image(LOGO_EMPRESA, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
                    }
                }
            } else {
                $pdf->Cell(0, 10, "COMENTARIOS", 0, 1, 'C');
                $pdf->Ln(5);
                $pdf->SetFont('helvetica', 'I', 11);
                $pdf->Cell(0, 8, "Sin comentarios.", 0, 1, 'L');
                $pdf->Ln(10);
            }

            $pdf->Ln(10);

            if ($pdf->GetY() > 240) {
                $pdf->AddPage();
                $pdf->Image(LOGO_EMPRESA, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
            }
        }

        ob_end_clean();
        $pdf->Output("Reporte_Tickets_Soporte.pdf", 'I');

    } catch (Exception $e) {
        echo "Error al generar el PDF: " . $e->getMessage();
    }
}




}













// Validar acción
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $controlador = new ReporteticketsPDFControlador();
    $codigo = $_GET['codigo'] ?? 'Sin Código';

    switch ($_GET['action']) {
        case 'CodigoTicketPDF':
            $controlador->CodigoTicketPDF($codigo);
            break;
        case 'PorFechaPDF':
            $fechaDesde = $_GET['fechaDesde'] ?? '';
            $fechaHasta = $_GET['fechaHasta'] ?? '';
            $controlador->PorFechaPDF($fechaDesde, $fechaHasta);
            break;
        case 'PorTrabajadorPDF':
            $IdUsuarioCreadorTicketReporte = $_GET['IdUsuarioCreadorTicketReporte'] ?? '';
            $controlador->PorTrabajadorPDF($IdUsuarioCreadorTicketReporte);
            break;
        case 'PorSoportePDF':
            $IdUsuarioSoporteTicketReporte = $_GET['IdUsuarioSoporteTicketReporte'] ?? '';
            $controlador->PorSoportePDF($IdUsuarioSoporteTicketReporte);
            break;
        case 'SelectTrabajadores':
            $controlador->SelectTrabajadores();
            break;
        case 'SelectSoportes':
            $controlador->SelectSoportes();
            break;
        default:
            echo json_encode(['success' => false, 'msg' => 'Acción GET no válida']);
            break;
    }
} else {
    echo json_encode(['success' => false, 'msg' => 'Método no válido o acción no especificada']);
}
