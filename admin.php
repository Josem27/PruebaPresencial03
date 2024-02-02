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
            <h2 class="text-center">Bienvenido, <?php echo $_SESSION['username']; ?></h2>
            <form method="post">
                <h3 class="text-center">Selecciona tu género:</h3>
                <div class="form-check">
                    <input type="radio" id="masculino" name="genero" value="masculino" <?php if($genero === 'masculino') echo 'checked'; ?>>
                    <label class="form-check-label" for="masculino">Masculino</label>
                </div>
                <div class="form-check">
                    <input type="radio" id="femenino" name="genero" value="femenino" <?php if($genero === 'femenino') echo 'checked'; ?>>
                    <label class="form-check-label" for="femenino">Femenino</label>
                </div>
                <button type="submit" class="btn btn-primary btn-block mt-3">Entrar</button>
            </form>
            <form action="logout.php" method="post">
                <div class="btn-group">
                    <button type="submit" class="btn btn-danger">Cerrar sesión</button>
                </div>
            </form>
        </div>
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
