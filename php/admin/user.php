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

// Verifica si se envió una solicitud para eliminar un usuario
if (isset($_POST['eliminar'])) {
    $id = $_POST['id'];

    // Consulta para eliminar el usuario
    $sql = "DELETE FROM usuarios WHERE id = :id";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Usuario eliminado con éxito.";
    } else {
        echo "Error al eliminar el usuario.";
    }
}

// Consulta para obtener los usuarios con sus roles
$sql = "SELECT usuarios.id, usuarios.correo, usuarios.nombre, roles.roll 
        FROM usuarios 
        INNER JOIN roles ON usuarios.id_rol = roles.id";

$stmt = $conexion->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios y Roles</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
<a name="" id="" class="btn btn-danger" href="dasboard.php" role="button">Volver</a>
        <br>

    <div class="container mt-5">
        <h1>Lista de Usuarios y Roles</h1>
       
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Correo</th>
                    <th>Nombre</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['roll']); ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($usuario['id']); ?>">
                                <button type="submit" name="eliminar" class="btn btn-danger btn-sm">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h5>Enviar correo a Hilda de los asesores que estaran en Andicom</h5>
        <a style="text-align: center;" class="btn btn-success" href="../excel/documento.php" role="button">Enviar</a>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>