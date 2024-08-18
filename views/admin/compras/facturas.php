<?php
include '../../../database/database.php';

if (!$conn) {
    echo "No se pudo conectar a la base de datos.";
    exit;
}

// Consulta para obtener los paquetes
$sql_paquetes = 'SELECT * FROM Paquetes';
$result_paquetes = $conn->query($sql_paquetes);

if (!$result_paquetes) {
    echo "Error en la consulta de paquetes: " . $conn->error;
    exit;
}

$selected_paquete = isset($_GET['paquete']) ? intval($_GET['paquete']) : 0;

$sql = 'SELECT f.*, p.nombre AS nombre_paquete 
        FROM Facturas f 
        JOIN Paquetes p ON f.id_paquete = p.id_paquete';

if ($selected_paquete > 0) {
    $sql .= ' WHERE f.id_paquete = ' . $selected_paquete;
}

$sql .= ' ORDER BY f.fecha_pago DESC';

$result = $conn->query($sql);

if (!$result) {
    echo "Error en la consulta SQL: " . $conn->error;
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Facturas - Serenity Space</title>
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
                <h1 style="color: #333">Facturas</h1>
                
                <!-- Filtro por Paquete -->
                <form method="GET" action="">
                    <div class="form-group">
                        <label for="paquete">Filtrar por Paquete:</label>
                        <select id="paquete" name="paquete" class="form-control">
                            <option value="">Todos los Paquetes</option>
                            <?php while ($row_paquete = $result_paquetes->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($row_paquete['id_paquete'], ENT_QUOTES); ?>"
                                    <?php echo $selected_paquete == $row_paquete['id_paquete'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($row_paquete['nombre'], ENT_QUOTES); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn-filter" style="border-color: #2ba8bd; font-weight: bold; box-shadow: none;">Filtrar</button>
                    
                </form>
                
                <!-- Tabla de Facturas -->
                <table class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th>ID Factura</th>
                            <th>Nombre Cliente</th>
                            <th>Teléfono Cliente</th>
                            <th>Correo Cliente</th>
                            <th>Cédula Cliente</th>
                            <th>Paquete</th>
                            <th>Duración (Meses)</th>
                            <th>Fecha de Pago</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id_factura'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['nombre_cliente'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['telefono_cliente'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['correo_cliente'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['cedula_cliente'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['nombre_paquete'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['duracion_mes'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['fecha_pago'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['total'], ENT_QUOTES); ?></td>
                                <td>
                                    <a href="editar_factura.php?id=<?php echo htmlspecialchars($row['id_factura'], ENT_QUOTES); ?>" class="btn" style="background-color: #2ba8bd; color: white;">Editar</a>
                                    <a href="eliminar_factura.php?id=<?php echo htmlspecialchars($row['id_factura'], ENT_QUOTES); ?>" class="btn" style="background-color: #e74c3c; color: white;">Eliminar</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
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
    $result->free();
    $result_paquetes->free();
    $conn->close();
    ?>
</body>
</html>
