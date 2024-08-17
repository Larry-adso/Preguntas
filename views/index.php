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

// Definir variables para id_clasificacion
$hostdime_id = 1;
$datacenter_id = 2;
$nebula_id = 3;
$certificaciones_id = 4;
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/styles.css">
  <script src="../js/script.js" defer></script>
</head>

<body class="u-body u-xl-mode" data-lang="es">

  <header class="u-header" id="sec-5f08">
    <div class="u-container-header">
      <a href="../php/excel/subir.php" class="u-logo">
        <img src="../img/logo.png" class="logo">
      </a>
      <a style="text-decoration: none;" href="../php/login_register/cerrar.php" class="logout-btn">Cerrar Sesión</a>
    </div>
  </header>

  <section class="u-section-1">
    <div class="u-container">
      <div class="image-container">
        <img class="u-image" src="../img/img.png" alt="Business Meeting">

        <div class="u-title-overlay">
          <h2> <strong>HOSTDIME EN ANDICOM 2024</strong> </h2>
        </div>

      </div>

      <div class="cuestionario-item">
        <a style="text-decoration: none;" href="cuestionario/hostdime.php?id_clasificacion=<?php echo $hostdime_id; ?>">
          <button id="toggleBtn" class="u-accordion-btn">
            HOSTDIME
            <span class="plus-icon">+</span>
          </button>
        </a>
      </div>

      <div class="cuestionario-item">
        <a style="text-decoration: none;" href="cuestionario/datacenter.php?id_clasificacion=<?php echo $datacenter_id; ?>">
          <button id="toggleBtn" class="u-accordion-btn">
          DATACENTER
            <span class="plus-icon">+</span>
          </button>
        </a>
      </div>

      <div class="cuestionario-item">
        <a style="text-decoration: none;" href="cuestionario/nebula.php?id_clasificacion=<?php echo $nebula_id; ?>">
          <button id="toggleBtn" class="u-accordion-btn">
          NEBULA
            <span class="plus-icon">+</span>
          </button>
        </a>
      </div>

      <div class="cuestionario-item">
        <a style="text-decoration: none;" href="cuestionario/certificaciones.php?id_clasificacion=<?php echo $certificaciones_id; ?>">
          <button id="toggleBtn" class="u-accordion-btn">
          CERTIFICACIONES
            <span class="plus-icon">+</span>
          </button>
        </a>
      </div>

    </div>
  </section>

</body>

</html>
