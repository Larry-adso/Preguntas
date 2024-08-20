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
require '../../conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $id_clasificacion = $_POST['id_clasificacion'];
    $pregunta = $_POST['pregunta'];
    $respuesta = $_POST['respuesta'];

    $stmt = $conexion->prepare("UPDATE cuestionario SET id_clasificacion = ?, pregunta = ?, respuesta = ? WHERE id = ?");
    $stmt->execute([$id_clasificacion, $pregunta, $respuesta, $id]);

    header('Location: dasboard.php');
}

$id = $_GET['id'];
$stmt = $conexion->prepare("SELECT * FROM cuestionario WHERE id = ?");
$stmt->execute([$id]);
$cuestionario = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pregunta</title>
    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
    <style>
        .form-control-auto-width {
            display: inline-block;
            width: auto;
            min-width: 100%; /* Esto asegura que el campo no sea más pequeño que el contenedor */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Editar Pregunta</h1>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $cuestionario['id']; ?>">
            <div class="mb-3">
                <label for="id_clasificacion" class="form-label">Clasificación</label>
                <select id="id_clasificacion" name="id_clasificacion" class="form-control">
                    <?php
                    $stmt = $conexion->prepare("SELECT * FROM clasificacion");
                    $stmt->execute();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $selected = $row['id'] == $cuestionario['id_clasificacion'] ? 'selected' : '';
                        echo "<option value='" . $row['id'] . "' $selected>" . $row['clasificacion'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="pregunta" class="form-label">Pregunta</label>
                <input type="text" class="form-control form-control-auto-width" id="pregunta" name="pregunta" value="<?php echo $cuestionario['pregunta']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="respuesta" class="form-label">Respuesta</label>
                <textarea type="text" class="form-control form-control-auto-width" id="respuesta" name="respuesta"  required><?php echo $cuestionario['respuesta']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a
                name=""
                id=""
                class="btn btn-secondary"
                href="dasboard.php"
                role="button"
                >SALIR</a
            >
            
        </form>
    </div>
    <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
</body>
</html>