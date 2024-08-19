<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Preguntas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/dashboard.css" rel="stylesheet">
    <!-- Iconos de FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="../../img/logo.png" alt=""></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../excel/subir.php"><i class="fas fa-file-upload"></i> Subir Archivos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../views/registro.php"><i class="fas fa-user-plus"></i> Crear Usuarios</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="user.php"><i class="fas fa-users"></i> Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="confirmarEliminacion()"><i class="fas fa-trash-alt"></i> Borrar Todas las Preguntas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../login_register/cerrar.php" ><i class="fas fa-sign-out-alt"></i> Cerrar sesion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">

        <!-- Gráficas -->
        <div class="mt-5">
            <h2>Gráficas de manejo de Información</h2>
            <canvas id="clasificacionGrafica"></canvas>
        </div>

        <!-- Tabla de Datos (inicialmente oculta) -->
        <div class="table-responsive mt-4" id="tablaPreguntas" style="display: none;">
            <h3 class="text-center" id="tituloTabla"></h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Clasificación</th>
                        <th>Pregunta</th>
                        <th>Respuesta</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tablaContenido">
                    <!-- Contenido generado dinámicamente -->
                </tbody>
            </table>
        </div>

        <!-- Alertas -->
        <div id="alertPlaceholder"></div>

    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Datos para la gráfica
        var ctx = document.getElementById('clasificacionGrafica').getContext('2d');
        var clasificacionGrafica = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    <?php
                    require '../../conexion/conexion.php';
                    $stmt = $conexion->prepare("SELECT clasificacion.clasificacion, COUNT(*) as total 
                                                FROM cuestionario 
                                                JOIN clasificacion ON cuestionario.id_clasificacion = clasificacion.id 
                                                GROUP BY clasificacion.clasificacion");
                    $stmt->execute();
                    $labels = [];
                    $data = [];
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $labels[] = "'" . $row['clasificacion'] . "'";
                        $data[] = $row['total'];
                    }
                    echo implode(", ", $labels);
                    ?>
                ],
                datasets: [{
                    label: 'Cantidad de Preguntas',
                    data: [<?php echo implode(", ", $data); ?>],
                    backgroundColor: [
                        'rgba(0, 209, 178, 0.2)', // Verde
                        'rgba(243, 119, 32, 0.2)', // Naranja
                        'rgba(115, 129, 133, 0.2)', // Gris
                        'rgba(75, 192, 192, 0.2)'
                    ],
                    borderColor: [
                        'rgba(0, 209, 178, 1)',
                        'rgba(243, 119, 32, 1)',
                        'rgba(115, 129, 133, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.raw;
                            }
                        }
                    }
                },
                onClick: function(evt, item) {
                    if (item.length > 0) {
                        var index = item[0].index;
                        var label = clasificacionGrafica.data.labels[index];
                        mostrarPreguntas(label);
                    }
                }
            },
            plugins: [{
                afterDatasetsDraw: function(chart) {
                    var ctx = chart.ctx;

                    chart.data.datasets.forEach(function(dataset, i) {
                        var meta = chart.getDatasetMeta(i);
                        if (!meta.hidden) {
                            meta.data.forEach(function(element, index) {
                                // Dibujar el texto
                                ctx.fillStyle = 'rgb(0, 0, 0)';

                                var fontSize = 16;
                                var fontStyle = 'normal';
                                var fontFamily = 'Helvetica Neue';
                                ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);

                                // Texto que se va a mostrar
                                var dataString = dataset.data[index].toString();

                                // Posición del texto
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'middle';

                                var padding = 5;
                                var position = element.tooltipPosition();
                                ctx.fillText(dataString, position.x, position.y - (fontSize / 2) - padding);
                            });
                        }
                    });
                }
            }]
        });

        // Función para mostrar preguntas asociadas a una clasificación
        function mostrarPreguntas(clasificacion) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'obtener_preguntas.php?clasificacion=' + clasificacion, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('tablaPreguntas').style.display = 'block';
                    document.getElementById('tituloTabla').textContent = 'Preguntas para la clasificación: ' + clasificacion;
                    document.getElementById('tablaContenido').innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }

        // Función para confirmar eliminación de todas las preguntas
        function confirmarEliminacion() {
            // Mostrar alerta personalizada en lugar del diálogo de confirmación estándar
            if (confirm("¿Estás seguro de que deseas eliminar todas las preguntas? Esta acción no se puede deshacer.")) {
                let dobleConfirmacion = confirm("Esta es tu última oportunidad. ¡Todas las preguntas serán eliminadas permanentemente! (*NO SE PUEDEN RECUPERAR*)");
                if (dobleConfirmacion) {
                    mostrarAlerta('success', '¡Las preguntas han sido eliminadas correctamente!', 'fa-check-circle');
                    setTimeout(function() {
                        window.location.href = "delete_all.php";
                    }, 3000); // Espera 3 segundos antes de redirigir
                } else {
                    mostrarAlerta('warning', '¡La eliminación ha sido cancelada!', 'fa-exclamation-circle');
                }
            } else {
                mostrarAlerta('info', '¡No se realizó ninguna acción!', 'fa-info-circle');
            }
        }

        // Función para mostrar alertas estilizadas
        function mostrarAlerta(tipo, mensaje, icono) {
            const alertPlaceholder = document.getElementById('alertPlaceholder');
            const wrapper = document.createElement('div');
            wrapper.innerHTML = [
                `<div class="alert alert-${tipo} d-flex align-items-center" role="alert">`,
                `   <i class="fas ${icono} me-2"></i>`,
                `   <div>${mensaje}</div>`,
                '</div>'
            ].join('');

            alertPlaceholder.append(wrapper);

            setTimeout(() => {
                wrapper.remove();
            }, 5000); // Oculta la alerta después de 5 segundos
        }
    </script>

<?php  
  include "../../includes/footer.php";
  ?>
</body>
</html>
