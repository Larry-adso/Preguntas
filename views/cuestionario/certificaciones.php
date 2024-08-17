<?php
session_start();

if (!isset($_SESSION['correo'])) {
  echo '
    <script>
        alert("Por favor inicie sesión e intente nuevamente");
        window.location = "../../index.php";
    </script>
    ';
  session_destroy();
  die();
}

include "../../conexion/conexion.php";

// Obtener id_clasificacion de la URL
$id_clasificacion = isset($_GET['id_clasificacion']) ? (int)$_GET['id_clasificacion'] : null;

// Consultar las clasificaciones
$consulta = $conexion->prepare("SELECT * FROM clasificacion");
$consulta->execute();
$clasificaciones = $consulta->fetchAll(PDO::FETCH_ASSOC);

// Consultar las preguntas solo si id_clasificacion está disponible y es válido
$preguntas = [];
if ($id_clasificacion !== null && is_numeric($id_clasificacion)) {
  $pregunta = $conexion->prepare("SELECT * FROM cuestionario WHERE id_clasificacion = :id_clasificacion");
  $pregunta->bindParam(':id_clasificacion', $id_clasificacion, PDO::PARAM_INT);
  $pregunta->execute();
  $preguntas = $pregunta->fetchAll(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../../css/styles.css">
  <script src="../../js/script.js" defer></script>
</head>

<body class="u-body u-xl-mode" data-lang="es">

  <header class="u-header" id="sec-5f08">
    <div class="u-container-header">
      <a href="../php/excel/subir.php" class="u-logo">
        <img src="../../img/logo.png" class="logo">
      </a>
      <a style="text-decoration: none;" href="../../php/login_register/cerrar.php" class="logout-btn">Cerrar Sesión</a>
    </div>
  </header>
<?php 
include "nav.php";
?>
<br>
<?php include 'searh.php'; ?>
  <section class="u-section-1">
    <div class="u-container">
      <div class="image-container">
        <img class="u-image" src="../../img/img.png" alt="Business Meeting">

        <div class="u-title-overlay">
          <h2> <strong>HOSTDIME EN ANDICOM 2024</strong> </h2>
        </div>

      </div>
      
      <?php if (!empty($preguntas)) : ?>
        <?php foreach ($preguntas as $pregunta) : ?>
          <div class="cuestionario-item">
            <button id="toggleBtn<?php echo htmlspecialchars($pregunta['id']); ?>" class="u-accordion-btn">
              <?php echo htmlspecialchars($pregunta['pregunta']); ?>
              <span class="plus-icon">+</span>
            </button>
            <div id="accordionContent<?php echo htmlspecialchars($pregunta['id']); ?>" class="u-accordion-content">
              <p><?php echo htmlspecialchars($pregunta['respuesta']); ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else : ?>
        <p>No hay preguntas disponibles para esta clasificación.</p>
      <?php endif; ?>

    </div>
  </section>

</body>

</html>
