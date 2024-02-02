<?php
session_start();

if(!isset($_SESSION['username']) || $_SESSION['username'] !== 'Admin') {
    header("Location: login.php");
    exit();
}

// Contador de visitas
$counter_file = "femenino_counter.txt";
$counter = (file_exists($counter_file)) ? intval(file_get_contents($counter_file)) : 0;
$counter++;
file_put_contents($counter_file, $counter);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Información para Mujer</title>
</head>
<body>
    <div class="container">
        <h2>Información para Mujer</h2>
        <p>#Visitas: <?php echo $counter; ?></p>
        <form action="admin.php" method="post">
            <button type="submit" class="btn btn-primary">Cambiar de sexo</button>
        </form>
        <!-- Botón para cerrar sesión -->
        <form action="logout.php" method="post">
            <button type="submit" class="btn btn-danger">Cerrar sesión</button>
        </form>
    </div>
</body>
</html>
