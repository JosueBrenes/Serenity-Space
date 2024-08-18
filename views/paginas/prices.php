<?php
include '../../database/database.php';

if (!$conn) {
    echo "No se pudo conectar a la base de datos.";
    exit;
}

$sql = 'SELECT id_paquete, nombre, precio FROM Paquetes';
$result_paquetes = $conn->query($sql);

if (!$result_paquetes) {
    echo '<div class="alert alert-danger">Error en la consulta: ' . $conn->error . '</div>';
    exit;
}

$paquetes = [];
while ($row = $result_paquetes->fetch_assoc()) {
    $id_paquete = $row['id_paquete'];
    $paquetes[$id_paquete] = [
        'nombre' => $row['nombre'],
        'precio' => $row['precio'],
        'detalles' => []
    ];

    $sql_detalles = 'SELECT detalle FROM Detalles_Paquete WHERE id_paquete = ' . intval($id_paquete);
    $result_detalles = $conn->query($sql_detalles);

    if ($result_detalles) {
        while ($detalle_row = $result_detalles->fetch_assoc()) {
            $paquetes[$id_paquete]['detalles'][] = $detalle_row['detalle'];
        }
    } else {
        echo '<div class="alert alert-danger">Error en la consulta de detalles: ' . $conn->error . '</div>';
    }
}

$conn->close();

function getPaqueteColor($nombre_paquete) {
    $colors = [
        'Paquete Inicial' => '#19A4BF',
        'Paquete Profesional' => '#14292D',
        'Paquete Premium' => '#D3ADA7'
    ];
    return $colors[$nombre_paquete] ?? '#19A4BF'; 
}
?>

<!DOCTYPE html>
<html lang="es">
  <!-- Head -->
  <?php include '../templates/head.php'; ?>

  <body>
    <!-- Header -->
    <?php include '../templates/header.php'; ?>

    <!-- Mini Header -->
    <section class="mini-header">
      <h2>Precios</h2>
    </section>

    <!-- Contenido principal -->
    <section class="pricing-table">
      <?php foreach ($paquetes as $paquete): ?>
        <div class="pricing-table-item">
          <div class="pricing-table-item-header" style="background-color: <?php echo getPaqueteColor($paquete['nombre']); ?>;">
            <h3 style="color: white;"><?php echo htmlspecialchars($paquete['nombre'], ENT_QUOTES); ?></h3>
          </div>
          <div class="pricing-table-item-price">
            <p><span class="price-big"><?php echo htmlspecialchars($paquete['precio'], ENT_QUOTES); ?></span><span class="price-small">.00</span></p>
          </div>
          <ul class="benefits-list">
            <?php foreach ($paquete['detalles'] as $detalle): ?>
              <li><?php echo htmlspecialchars($detalle, ENT_QUOTES); ?></li>
            <?php endforeach; ?>
          </ul>
          <div class="pricing-table-item-footer">
            <a href="pago.php?id_paquete=<?php echo $id_paquete; ?>" class="btn-contratar" style="color: white;">Contratar</a>
          </div>
        </div>
      <?php endforeach; ?>
    </section>

    <!-- Footer -->
    <?php include '../templates/footer.php'; ?>
  </body>
</html>
