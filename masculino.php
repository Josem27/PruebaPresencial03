<?php
session_start();

if(!isset($_SESSION['username']) || $_SESSION['username'] !== 'Admin') {
    header("Location: login.php");
    exit();
}

// Contador de visitas
$counter_file = "contadores/masculino_counter.txt";
$counter = (file_exists($counter_file)) ? intval(file_get_contents($counter_file)) : 0;
$counter++;
file_put_contents($counter_file, $counter);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Información para hombre</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos adicionales -->
    <style>
        .container {
            margin-top: 50px;
        }
        .center-box {
            margin: 0 auto;
            width: 50%;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn-group {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="center-box">
            <h2 class="text-center">Información para hombre</h2>
            <p class="text-center">#Visitas: <?php echo $counter; ?></p>
            <div class="btn-group">
                <form action="admin.php" method="post">
                    <button type="submit" class="btn btn-primary">Cambiar de sexo</button>
                </form>
                <form action="logout.php" method="post">
                    <button type="submit" class="btn btn-danger">Cerrar sesión</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
