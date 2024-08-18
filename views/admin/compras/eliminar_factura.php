<?php
include '../../../database/database.php';

if (!$conn) {
    echo "No se pudo conectar a la base de datos.";
    exit;
}

$id_factura = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_factura <= 0) {
    echo "ID de factura no válido.";
    exit;
}

$sql_delete = 'DELETE FROM Facturas WHERE id_factura = ?';
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bind_param('i', $id_factura);

if ($stmt_delete->execute()) {
    header('Location: facturas.php');
    exit;
} else {
    echo "Error al eliminar la factura: " . $conn->error;
}

$stmt_delete->close();
$conn->close();
?>
