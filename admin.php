<?php
session_start();

if(!isset($_SESSION['username']) || $_SESSION['username'] !== 'Admin') {
    header("Location: login.php");
    exit();
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
        <!-- Formulario para seleccionar género y enviar -->
        <form action="entrar.php" method="post">
            <h3>Selecciona tu género:</h3>
            <input type="radio" id="masculino" name="genero" value="masculino">
            <label for="masculino">Masculino</label><br>
            <input type="radio" id="femenino" name="genero" value="femenino">
            <label for="femenino">Femenino</label><br>
            <button type="submit" class="btn btn-primary">Entrar</button>
        </form>
        <!-- Botón para cerrar sesión -->
        <form action="logout.php" method="post">
            <button type="submit" class="btn btn-danger">Cerrar sesión</button>
        </form>
    </div>
</body>
</html>
