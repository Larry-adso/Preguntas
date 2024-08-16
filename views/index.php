<?php
session_start();

if (!isset($_SESSION['correo'])) {
  echo '
    <script>
        alert("Por favor inicie sesión e intente nuevamente");
        window.location = "../index.php";
    </script>
    ';
  session_destroy();
  die();
}

include "../conexion/conexion.php";

$consulta = $conexion->prepare("SELECT * FROM cuestionario");
$consulta->execute();
$cuestionario = $consulta->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
  <script src="script.js" defer></script>
</head>

<body class="u-body u-xl-mode" data-lang="es">

  <header class="u-header" id="sec-5f08">
    <div class="u-container-header">
      <a href="#" class="u-logo">
        <img src="../img/logo.png" class="logo">
      </a>
      <button class="logout-btn">Cerrar Sesión</button>
    </div>
  </header>

  <section class="u-section-1">
    <div class="u-container">
      <div class="image-container">
        <img class="u-image" src="images/img.png" alt="Business Meeting">
        
          <div class="u-title-overlay">
            <h2> <strong>Esto e sun titulo</strong> </h2>
          </div>
        
      </div>
      <?php foreach ($cuestionario as $cuestionarios) : ?>
        <div class="cuestionario-item">
          <button id="toggleBtn<?php echo $cuestionarios['id']; ?>" class="u-accordion-btn">
            <?php echo $cuestionarios['pregunta']; ?>
            <span class="plus-icon">+</span>
          </button>
          <div id="accordionContent<?php echo $cuestionarios['id']; ?>" class="u-accordion-content">
            <p><?php echo $cuestionarios['respuesta']; ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

</body>

</html>
