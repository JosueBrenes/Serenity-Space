<?php
include '../database/database.php';

// Verificar si la conexión a la base de datos es exitosa
if (!$conn) {
    echo '<div class="alert alert-danger">Error al conectar con la base de datos.</div>';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Obtener datos del formulario
    $nombre_cliente = $_POST['nombre'] ?? '';
    $telefono_cliente = $_POST['telefono'] ?? '';
    $correo_cliente = $_POST['correo'] ?? '';
    $cedula_cliente = $_POST['cedula'] ?? '';
    $id_paquete = intval($_POST['id_paquete'] ?? 0);
    $duracion_mes = intval($_POST['duracion_mes'] ?? 0);
    $fecha_pago = date('Y-m-d H:i:s');

    // Verificar que los datos del formulario no están vacíos
    if (empty($nombre_cliente) || empty($telefono_cliente) || empty($correo_cliente) || empty($cedula_cliente) || $id_paquete <= 0 || $duracion_mes <= 0) {
        echo '<div class="alert alert-danger">Por favor, complete todos los campos del formulario correctamente.</div>';
        exit;
    }

    // Obtener el precio del paquete seleccionado
    $sql_paquete = 'SELECT precio FROM Paquetes WHERE id_paquete = ?';
    $stmt_paquete = $conn->prepare($sql_paquete);

    if ($stmt_paquete === false) {
        echo '<div class="alert alert-danger">Error al preparar la consulta del paquete: ' . $conn->error . '</div>';
        exit;
    }

    $stmt_paquete->bind_param('i', $id_paquete);
    $stmt_paquete->execute();
    $result_paquete = $stmt_paquete->get_result();

    if ($result_paquete && $row_paquete = $result_paquete->fetch_assoc()) {
        $precio_paquete = $row_paquete['precio'];
        $total_pagar = $precio_paquete * $duracion_mes;
    } else {
        echo '<div class="alert alert-danger">Error al obtener el precio del paquete.</div>';
        $stmt_paquete->close();
        $conn->close();
        exit;
    }

    // Insertar los datos en la tabla Facturas
    $sql_factura = 'INSERT INTO Facturas (nombre_cliente, telefono_cliente, correo_cliente, cedula_cliente, id_paquete, duracion_mes, fecha_pago, total) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
    $stmt_factura = $conn->prepare($sql_factura);

    if ($stmt_factura === false) {
        echo '<div class="alert alert-danger">Error al preparar la consulta de la factura: ' . $conn->error . '</div>';
        $stmt_paquete->close();
        $conn->close();
        exit;
    }

    // Vincular los parámetros y ejecutar la consulta
    $stmt_factura->bind_param('ssssiiis', $nombre_cliente, $telefono_cliente, $correo_cliente, $cedula_cliente, $id_paquete, $duracion_mes, $fecha_pago, $total_pagar);

    if ($stmt_factura->execute()) {
        // Obtener el ID de la última factura insertada
        $factura_id = $conn->insert_id;

        // Redirigir a la página de agradecimiento con los detalles de la factura
        header('Location: ../views/paginas/factura.php?factura_id=' . urlencode($factura_id) . '&nombre=' . urlencode($nombre_cliente) . '&telefono=' . urlencode($telefono_cliente) . '&correo=' . urlencode($correo_cliente) . '&cedula=' . urlencode($cedula_cliente) . '&id_paquete=' . urlencode($id_paquete) . '&duracion_mes=' . urlencode($duracion_mes) . '&total_pagar=' . urlencode($total_pagar) . '&fecha_pago=' . urlencode($fecha_pago));
        exit;
    } else {
        echo '<div class="alert alert-danger">Error al procesar el pago: ' . $stmt_factura->error . '</div>';
    }

    $stmt_factura->close();
    $stmt_paquete->close();
    $conn->close();
} else {
    echo '<div class="alert alert-danger">Método no permitido.</div>';
}
?>
