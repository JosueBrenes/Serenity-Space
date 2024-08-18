<!DOCTYPE html>
<html lang="es">
<head>
  <?php include '../templates/head.php'; ?>
  <link rel="stylesheet" href="../css/styles.css"> <!-- Asegúrate de incluir tu archivo CSS -->
  <!-- Incluye Bootstrap CSS si no lo tienes en head.php -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <!-- Header -->
  <?php include '../templates/header.php'; ?>

  <!-- Contenido principal -->
  <section class="thank-you">
    <div class="container mt-5">
      <h2 class="text-center">¡Pago Exitoso!</h2>
      <p class="text-center">Tu pago ha sido procesado con éxito. Aquí están los detalles de tu factura:</p>
      
      <div class="card mb-3">
        <div class="card-header bg-info text-white">
          <h5 class="card-title mb-0" style="color: #fff">Detalles de la Factura</h5>
        </div>
        <div class="card-body">
          <p><strong>Número de Factura:</strong> <?php echo htmlspecialchars($_GET['factura_id']); ?></p>
          <p><strong>Nombre del Cliente:</strong> <?php echo htmlspecialchars($_GET['nombre']); ?></p>
          <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($_GET['telefono']); ?></p>
          <p><strong>Correo Electrónico:</strong> <?php echo htmlspecialchars($_GET['correo']); ?></p>
          <p><strong>Cédula:</strong> <?php echo htmlspecialchars($_GET['cedula']); ?></p>
          <p><strong>Paquete Seleccionado:</strong> <?php echo htmlspecialchars($_GET['id_paquete']); ?></p>
          <p><strong>Duración (Meses):</strong> <?php echo htmlspecialchars($_GET['duracion_mes']); ?></p>
          <p><strong>Total Pagado:</strong> ₡<?php echo number_format($_GET['total_pagar'], 2); ?></p>
          <p><strong>Fecha del Pago:</strong> <?php echo htmlspecialchars($_GET['fecha_pago']); ?></p>
        </div>
        <div class="card-footer text-center">
          <p>Gracias por tu preferencia. Si tienes alguna duda, por favor, contáctanos.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <?php include '../templates/footer.php'; ?>

  <!-- Incluye Bootstrap JS y dependencias si no los tienes en head.php -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
