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

// Obtener los datos de la factura
$sql = 'SELECT * FROM Facturas WHERE id_factura = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id_factura);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Factura no encontrada.";
    exit;
}

$row = $result->fetch_assoc();

// Obtener los paquetes
$sql_paquetes = 'SELECT * FROM Paquetes';
$result_paquetes = $conn->query($sql_paquetes);

if (!$result_paquetes) {
    echo "Error en la consulta de paquetes: " . $conn->error;
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_cliente = $_POST['nombre_cliente'];
    $telefono_cliente = $_POST['telefono_cliente'];
    $correo_cliente = $_POST['correo_cliente'];
    $cedula_cliente = $_POST['cedula_cliente'];
    $id_paquete = intval($_POST['id_paquete']);
    $duracion_mes = intval($_POST['duracion_mes']);
    $fecha_pago = $_POST['fecha_pago'];
    $total = floatval($_POST['total']);

    $sql_update = 'UPDATE Facturas SET nombre_cliente = ?, telefono_cliente = ?, correo_cliente = ?, cedula_cliente = ?, id_paquete = ?, duracion_mes = ?, fecha_pago = ?, total = ? WHERE id_factura = ?';
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param('sssssissi', $nombre_cliente, $telefono_cliente, $correo_cliente, $cedula_cliente, $id_paquete, $duracion_mes, $fecha_pago, $total, $id_factura);

    if ($stmt_update->execute()) {
        header('Location: facturas.php');
        exit;
    } else {
        echo "Error al actualizar la factura: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Editar Factura - Serenity Space</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../../../public/build/css/stylesDash.css" />
    <link rel="icon" href="../../../public/build/img/icon.png" type="image/x-icon" />
    <link rel="shortcut icon" href="../../../public/build/img/icon.png" type="image/x-icon" />
</head>
<body>
    <!-- Sidebar -->
    <?php include '../../templates/sidebar.php'; ?>

    <!-- Content -->
    <div class="content">
        <!-- Header -->
        <header class="header_area">
            <a href="../dashboard.php" class="header_link">
                <h1>Serenity Space</h1>
            </a>
        </header>

        <!-- Main Content -->
        <section class="options_area">
            <div class="container mt-5">
                <h1 style="color: #333">Editar Factura</h1>
                
                <!-- Formulario de Edición -->
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="nombre_cliente">Nombre Cliente:</label>
                        <input type="text" id="nombre_cliente" name="nombre_cliente" class="form-control" value="<?php echo htmlspecialchars($row['nombre_cliente'], ENT_QUOTES); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono_cliente">Teléfono Cliente:</label>
                        <input type="text" id="telefono_cliente" name="telefono_cliente" class="form-control" value="<?php echo htmlspecialchars($row['telefono_cliente'], ENT_QUOTES); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="correo_cliente">Correo Cliente:</label>
                        <input type="email" id="correo_cliente" name="correo_cliente" class="form-control" value="<?php echo htmlspecialchars($row['correo_cliente'], ENT_QUOTES); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="cedula_cliente">Cédula Cliente:</label>
                        <input type="text" id="cedula_cliente" name="cedula_cliente" class="form-control" value="<?php echo htmlspecialchars($row['cedula_cliente'], ENT_QUOTES); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="id_paquete">Paquete:</label>
                        <select id="id_paquete" name="id_paquete" class="form-control" required>
                            <?php while ($row_paquete = $result_paquetes->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($row_paquete['id_paquete'], ENT_QUOTES); ?>"
                                    <?php echo $row['id_paquete'] == $row_paquete['id_paquete'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($row_paquete['nombre'], ENT_QUOTES); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="duracion_mes">Duración (Meses):</label>
                        <input type="number" id="duracion_mes" name="duracion_mes" class="form-control" value="<?php echo htmlspecialchars($row['duracion_mes'], ENT_QUOTES); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha_pago">Fecha de Pago:</label>
                        <input type="datetime-local" id="fecha_pago" name="fecha_pago" class="form-control" value="<?php echo htmlspecialchars(date('Y-m-d\TH:i', strtotime($row['fecha_pago'])), ENT_QUOTES); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="total">Total:</label>
                        <input type="number" id="total" name="total" class="form-control" step="0.01" value="<?php echo htmlspecialchars($row['total'], ENT_QUOTES); ?>" required>
                    </div>
                    <button type="submit" class="btn" style="background-color: #2ba8bd; color: white;">Actualizar</button>
                </form>
            </div>
        </section>

        <!-- Footer -->
        <footer class="footer_area">
            <p class="footer_text">
                &copy; 2024 Serenity Space. Todos los derechos reservados.
            </p>
        </footer>
    </div>

    <?php
    $stmt->close();
    $conn->close();
    ?>
</body>
</html>
