<?php
include '../../database/database.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

try {
    $stmtUsuarios = $conn->query("SELECT COUNT(*) AS total_usuarios FROM Usuarios");
    $rowUsuarios = $stmtUsuarios->fetch_assoc();
    $usuarios = $rowUsuarios['total_usuarios'];

    $stmtTerapeutas = $conn->query("SELECT COUNT(*) AS total_terapeutas FROM Terapeutas");
    $rowTerapeutas = $stmtTerapeutas->fetch_assoc();
    $terapeutas = $rowTerapeutas['total_terapeutas'];

    $stmtTerapias = $conn->query("SELECT COUNT(*) AS total_terapias FROM Terapias");
    $rowTerapias = $stmtTerapias->fetch_assoc();
    $terapias = $rowTerapias['total_terapias'];
} catch(Exception $e) {
    echo "Error: " . $e->getMessage();
}

// Cerrar conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Administrativa - Serenity Space</title>
  <link
    rel="stylesheet"
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
  />
  <link rel="stylesheet" href="../../public/build/css/stylesDash.css" />
  <link rel="icon" href="../../public/build/img/icon.png" type="image/x-icon" />
  <link
    rel="shortcut icon"
    href="../public/build/img/icon.png"
    type="image/x-icon"
  />
</head>
<body>

  <!-- Sidebar -->
  <nav class="sidebar">
    <h2>Opciones</h2>
    <a href="usuarios/usuarios.php">Usuarios</a>
    <a href="terapeutas/terapeutas.php">Terapeutas</a>
    <a href="terapias/terapias.php">Terapias</a>
    <a href="citas/citas.php">Citas</a>
    <a href="paquetes/paquetes.php">Paquetes</a>
    <a href="servicios/servicios.php">Servicios</a>
    <a href="compras/facturas.php">Facturas</a>
    <div class="sidebar-footer">
      <a href="../../public/index.php" class="btn btn-danger btn-logout">Salir</a>
    </div>
  </nav>


  <!-- Content -->
  <div class="content">
    <!-- Header -->
    <header class="header_area">
      <a href="./dashboard.php" class="header_link">
        <h1>Serenity Space</h1>
      </a>
    </header>


    <!-- Main Content -->
    <section class="options_area">
      <div class="container">
        <div class="center-cards">
        
          <!-- Tarjeta de Total de Terapeutas -->
          <div class="card-container">
            <div class="card border-primary bg-primary text-white">
              <div class="card-body text-center">
                <h1 class="card-title display-4"><?php echo $terapeutas; ?></h1>
                <h3>Terapeutas</h3>
              </div>
            </div>
          </div>

          <!-- Tarjeta de Total de Terapias -->
          <div class="card-container">
            <div class="card border-primary bg-primary text-white">
              <div class="card-body text-center">
                <h1 class="card-title display-4"><?php echo $terapias; ?></h1>
                <h3>Terapias</h3>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="footer_area">
      <p class="footer_text">&copy; 2024 Serenity Space. Todos los derechos reservados.</p>
    </footer>
  </div>

</body>
</html>
