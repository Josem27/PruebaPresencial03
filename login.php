<?php
session_start();

// Verificar si el usuario ya está autenticado
if(isset($_SESSION['username'])) {
    if ($_SESSION['username'] === 'Admin') {
        header("Location: admin.php");
    } elseif ($_SESSION['username'] === 'Usuario') {
        header("Location: user.php");
    }
    exit();
}

$error_message = '';

// Verificar si se recibió una solicitud para cerrar sesión
if(isset($_GET['logout'])) {
    session_unset();
    session_destroy();

    // Eliminar cookies relacionadas con la sesión
    setcookie("recordar_user", "", time() - 3600); 
    setcookie("keep_session", "", time() - 3600); 

    header("Location: login.php");
    exit();
}

// Verificar si hay datos guardados para rellenar el formulario
$remembered_username = isset($_COOKIE['recordar_user']) ? $_COOKIE['recordar_user'] : '';
$remembered_password = isset($_COOKIE['recordar_pass']) ? $_COOKIE['recordar_pass'] : '';
$remember_checked = $remembered_username ? 'checked' : '';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conexion.php';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conexion->query($sql);

    if ($result->rowCount() > 0) {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $_SESSION['username'] = $row['username'];

        // Si el checkbox "Recordarme" está marcado, guardar el nombre de usuario y la contraseña en cookies
        if(isset($_POST['remember'])) {
            setcookie("recordar_user", $username, time() + (86400 * 30), "/");
            setcookie("recordar_pass", $password, time() + (86400 * 30), "/");
        } else {
            // Si el checkbox "Recordarme" no está marcado, eliminar las cookies
            setcookie("recordar_user", "", time() - 3600, "/");
            setcookie("recordar_pass", "", time() - 3600, "/");
        }

        // Si el checkbox "Mantener sesión abierta" está marcado, establecer la cookie
        if(isset($_POST['keep_session'])) {
            setcookie("keep_session", $_SESSION['username'], time() + (86400 * 30), "/");
        }

        // Redirigir según el nombre de usuario
        if ($username === 'Admin') {
            header("Location: admin.php");
        } elseif ($username === 'Usuario') {
            header("Location: user.php");
        } else {
            // Usuario desconocido, redirigir a una página por defecto (Esto esta simulado, ya que solo usamos dos perfiles, pero es para control de errores)
            header("Location: index.php");
        }
        exit();
    } else {
        $error_message = "Credenciales incorrectas. Inténtalo de nuevo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Iniciar Sesión</h2>
                    </div>
                    <div class="card-body">
                        <?php if($error_message !== '') { ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error_message; ?>
                            </div>
                        <?php } ?>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="form-group">
                                <label for="username">Nombre de usuario:</label>
                                <input type="text" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars($remembered_username); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña:</label>
                                <input type="password" id="password" name="password" class="form-control" value="<?php echo htmlspecialchars($remembered_password); ?>" required>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember" value="1" <?php echo $remember_checked; ?>>
                                <label class="form-check-label" for="remember">Recordarme</label>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="keep_session" name="keep_session">
                                <label class="form-check-label" for="keep_session">Mantener sesión abierta</label>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>