<?php
session_start();

if(!isset($_SESSION['username']) || $_SESSION['username'] !== 'Admin') {
    header("Location: login.php");
    exit();
}

// Contador de visitas basado en una cookie
$counter_cookie_name = 'femenino_contador';
$counter = isset($_COOKIE[$counter_cookie_name]) ? intval($_COOKIE[$counter_cookie_name]) : 0;
$counter++;
setcookie($counter_cookie_name, $counter, time() + (86400 * 365), "/"); // Cookie válida por 1 año
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Información para mujer</title>
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
            <h2 class="text-center">Información para mujer</h2>
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
