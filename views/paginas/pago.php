<?php
include '../../database/database.php';

if (!$conn) {
    echo "Error al procesar la solicitud.";
    exit;
}

$sql = 'SELECT id_paquete, nombre, precio FROM Paquetes';
$result = $conn->query($sql);

if (!$result) {
    echo '<div class="alert alert-danger">Error en la consulta de paquetes: ' . $conn->error . '</div>';
    exit;
}

$paquetes = [];
while ($row = $result->fetch_assoc()) {
    $paquetes[] = [
        'id_paquete' => $row['id_paquete'],
        'nombre' => $row['nombre'],
        'precio' => $row['precio']
    ];
}
?>

<!DOCTYPE html>
<html lang="es">
<!-- Head -->
<?php include '../templates/head.php'; ?>

<body>
  <!-- Header -->
  <?php include '../templates/header.php'; ?>

  <section class="mini-header">
    <h2>Formulario de Pago</h2>
  </section>

  <section class="payment-form container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header bg-info text-white text-center">
            <h3>Pagar por el Paquete</h3>
          </div>
          <div class="card-body">
            <form action="../../includes/procesar_pago.php" method="POST">
                <div class="form-group mb-3">
                    <label for="nombre">Nombre Completo:</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="telefono">Teléfono:</label>
                    <input type="tel" id="telefono" name="telefono" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="correo">Correo Electrónico:</label>
                    <input type="email" id="correo" name="correo" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="cedula">Cédula:</label>
                    <input type="text" id="cedula" name="cedula" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="id_paquete">Paquete Seleccionado:</label>
                    <select id="id_paquete" name="id_paquete" class="form-control" required>
                    <option value="" disabled selected>Selecciona un paquete</option>
                    <?php foreach ($paquetes as $paquete): ?>
                        <option value="<?php echo $paquete['id_paquete']; ?>">
                        <?php echo htmlspecialchars($paquete['nombre'], ENT_QUOTES) . ' - ' . htmlspecialchars($paquete['precio'], ENT_QUOTES) . ' USD'; ?>
                        </option>
                    <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group mb-4">
                    <label for="duracion_mes">Duración del Plan:</label>
                    <select id="duracion_mes" name="duracion_mes" class="form-control" required>
                    <option value="1">1 Mes</option>
                    <option value="3">3 Meses</option>
                    <option value="12">12 Meses</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Pagar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <?php include '../templates/footer.php'; ?>
</body>
</html>
