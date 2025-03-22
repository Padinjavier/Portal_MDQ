<?php
// C:\wamp64\www\helpmdq\modelos\TrabajadoresModelo.php

class TrabajadoresModelo {
    private $db;

    public function __construct($db) {
        $this->db = $db->getConexion();
    }

    public function obtenerClientes() {
        $stmt = $this->db->prepare("SELECT * FROM clientes");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function agregarCliente($datos) {
        $stmt = $this->db->prepare("INSERT INTO clientes (nombre, apellido, dni, telefono, correo, fecha_inicio_contrato, tipo_contrato, servicio, costo, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $datos['nombre'], $datos['apellido'], $datos['dni'], $datos['telefono'], $datos['correo'],
            $datos['fecha_inicio_contrato'], $datos['tipo_contrato'], $datos['servicio'], $datos['costo'], $datos['estado']
        ]);
    }
    
    public function obtenerCliente($id) {
        $stmt = $this->db->prepare("SELECT * FROM clientes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function actualizarCliente($datos) {
        $stmt = $this->db->prepare("UPDATE clientes SET nombre=?, apellido=?, dni=?, telefono=?, correo=?, fecha_inicio_contrato=?, tipo_contrato=?, servicio=?, costo=?, estado=? WHERE id=?");
        return $stmt->execute([
            $datos['nombre'], $datos['apellido'], $datos['dni'], $datos['telefono'], $datos['correo'],
            $datos['fecha_inicio_contrato'], $datos['tipo_contrato'], $datos['servicio'], $datos['costo'], $datos['estado'], $datos['idCliente']
        ]);
    }
    
    public function eliminarCliente($id) {
        $stmt = $this->db->prepare("DELETE FROM clientes WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
}
?>