<?php
include '../../../database/database.php';

if (!$conn) {
    echo "No se pudo conectar a la base de datos.";
    exit;
}

$message = '';
$id_usuario = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $tipo_usuario = $_POST['tipo_usuario'];
    
    // Preparar la consulta SQL para actualizar datos
    $sql = "UPDATE Usuarios SET nombre = ?, correo = ?, id_tipo_usuario = ? WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nombre, $correo, $tipo_usuario, $id_usuario);

    if ($stmt->execute()) {
        $message = "Usuario actualizado exitosamente.";
    } else {
        $message = "Error al actualizar el usuario: " . $stmt->error;
    }

    $stmt->close();
}

// Obtener los datos del usuario
$sql_usuario = "SELECT * FROM Usuarios WHERE id_usuario = ?";
$stmt_usuario = $conn->prepare($sql_usuario);
$stmt_usuario->bind_param("i", $id_usuario);
$stmt_usuario->execute();
$result_usuario = $stmt_usuario->get_result();
$user = $result_usuario->fetch_assoc();
$stmt_usuario->close();

// Obtener tipos de usuario
$sql_tipo_usuario = 'SELECT * FROM TipoUsuario';
$result_tipo_usuario = $conn->query($sql_tipo_usuario);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Editar Usuario - Serenity Space</title>
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
                <h1 style="color: #333">Editar Usuario</h1>
                <?php if ($message): ?>
                    <div class="alert <?php echo strpos($message, 'exitosamente') !== false ? 'alert-success' : 'alert-danger'; ?>">
                        <?php echo htmlspecialchars($message, ENT_QUOTES); ?>
                    </div>
                <?php endif; ?>
                <form action="editar_usuario.php?id=<?php echo htmlspecialchars($id_usuario, ENT_QUOTES); ?>" method="post">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo htmlspecialchars($user['nombre'], ENT_QUOTES); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo</label>
                        <input type="email" id="correo" name="correo" class="form-control" value="<?php echo htmlspecialchars($user['correo'], ENT_QUOTES); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="tipo_usuario">Tipo de Usuario</label>
                        <select id="tipo_usuario" name="tipo_usuario" class="form-control" required>
                            <?php while ($row_tipo_usuario = $result_tipo_usuario->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($row_tipo_usuario['id_tipo_usuario'], ENT_QUOTES); ?>"
                                    <?php echo $row_tipo_usuario['id_tipo_usuario'] == $user['id_tipo_usuario'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($row_tipo_usuario['nombre'], ENT_QUOTES); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn" style="background-color: #2ba8bd; color: white;">Actualizar Usuario</button>
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
    $result_tipo_usuario->free();
    $conn->close();
    ?>
</body>
</html>
