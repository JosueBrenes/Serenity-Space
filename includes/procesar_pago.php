<?php
include '../database/database.php';

if (!$conn) {
    echo "Error al procesar la solicitud.";
    exit;
}

// Recibir los datos del formulario
$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$cedula = $_POST['cedula'];
$id_paquete = $_POST['id_paquete'];
$duracion_mes = $_POST['duracion_mes'];

// Consulta para obtener el precio del paquete seleccionado
$sql_paquete = "SELECT precio FROM Paquetes WHERE id_paquete = ?";
$stmt_paquete = $conn->prepare($sql_paquete);
$stmt_paquete->bind_param("i", $id_paquete);
$stmt_paquete->execute();
$result_paquete = $stmt_paquete->get_result();
$paquete = $result_paquete->fetch_assoc();

if (!$paquete) {
    echo '<div class="alert alert-danger">Paquete no encontrado.</div>';
    exit;
}

// Calcular el total basado en el precio y la duración del plan
$precio_paquete = $paquete['precio'];
$total = $precio_paquete * $duracion_mes;

// Insertar los datos en la tabla facturas con la fecha actual generada automáticamente
$sql_insert = "INSERT INTO facturas (nombre_cliente, telefono_cliente, correo_cliente, cedula_cliente, id_paquete, duracion_mes, fecha_pago, total)
                VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)";
$stmt_insert = $conn->prepare($sql_insert);
$stmt_insert->bind_param("ssssiid", $nombre, $telefono, $correo, $cedula, $id_paquete, $duracion_mes, $total);

if ($stmt_insert->execute()) {
    // Obtener el ID de la factura recién creada
    $factura_id = $conn->insert_id;
    
    // Redirigir a factura.php pasando los datos de la factura
    header("Location: ../views/paginas/factura.php?factura_id=$factura_id&nombre=" . urlencode($nombre) . "&telefono=" . urlencode($telefono) . "&correo=" . urlencode($correo) . "&cedula=" . urlencode($cedula) . "&id_paquete=$id_paquete&duracion_mes=$duracion_mes&total_pagar=$total&fecha_pago=" . urlencode(date('Y-m-d H:i:s')));
    exit();
} else {
    echo '<div class="alert alert-danger">Error al procesar el pago: ' . $conn->error . '</div>';
}

$stmt_insert->close();
$conn->close();
?>
