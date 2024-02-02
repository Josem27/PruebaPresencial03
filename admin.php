<?php
session_start();

if(!isset($_SESSION['username']) || $_SESSION['username'] !== 'Admin') {
    header("Location: login.php");
    exit();
}

// Verificar si hay una cookie para el género y establecer el valor predeterminado
$genero_cookie = isset($_COOKIE['genero']) ? $_COOKIE['genero'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['genero'])) {
    $genero = $_POST['genero'];
    setcookie('genero', $genero, time() + (86400 * 30), "/"); // Cookie válida por 30 días
} else {
    $genero = $genero_cookie;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administrador</title>
</head>
<body>
    <div class="container">
        <h2>Bienvenido, <?php echo $_SESSION['username']; ?>!</h2>
        <form method="post">
            <h3>Selecciona tu género:</h3>
            <input type="radio" id="masculino" name="genero" value="masculino" <?php if($genero === 'masculino') echo 'checked'; ?>>
            <label for="masculino">Masculino</label><br>
            <input type="radio" id="femenino" name="genero" value="femenino" <?php if($genero === 'femenino') echo 'checked'; ?>>
            <label for="femenino">Femenino</label><br>
            <button type="submit" class="btn btn-primary">Entrar</button>
        </form>
        <form action="logout.php" method="post">
            <button type="submit" class="btn btn-danger">Cerrar sesión</button>
        </form>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['genero'])) {
        // Redirigir según el género seleccionado
        if ($genero === 'masculino') {
            header("Location: Masculino.php");
            exit();
        } elseif ($genero === 'femenino') {
            header("Location: Femenino.php");
            exit();
        }
    }
    ?>
</body>
</html>