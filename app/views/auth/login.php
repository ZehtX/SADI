<?php
session_start();
if(isset($_SESSION['email'])){
    header("location: ../Dashboard/index.php");
    exit;
}
require_once "../Clases/Usuario.php";
require_once "../Clases/Inputs.php";

$errors = array();
$messages = array();

// Login
if(($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['login'])){
    // 
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $errors[] = "Por Favor Llene los Campos";
    } else{
        $user = new Usuario($_POST['email'],$_POST['password']);
        $userExist = $user->searchUser();
        
        if ($userExist) { //Validar la Existencia

            if ($user->validation($userExist['Clave'])) { //Validar Contraseña
                $_SESSION['ID'] = 1;
                $_SESSION['email'] = $user->getEmail();

                header("location: ../Dashboard/index.php");
                exit;
            }else {
                $errors[] = "Contraseña Incorrecta";
            }
        }else{
            $errors[] = "Usuario no encotrado";
        }
        
    }
}

// Registro
if(($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['register'])){
    
    if (empty($_POST['email-reg']) || empty($_POST['password-reg'])) {
        $errors[] = "Por Favor Llene los Campos";
    }else{
        $user = new Usuario($_POST['email-reg'],$_POST['password-reg']);

        $userExist = $user->searchUser();
        if ($userExist) {
            $errors[] = "Usuario no Disponible";
        } else{
            if($user->register(password_hash($_POST['password-reg'], PASSWORD_DEFAULT))){
                $messages[] = "Registro exitoso";
            }else{
                $errors[] = "Error inesperado. Intente de nuevo";
            }
            }
        }
    }


?>
<!-- Code of End -->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="./assets/icon/favicon-16x16.png" type="image/x-icon">

    <link rel="stylesheet" href="./assets/css/Style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;1,300&display=swap"
        rel="stylesheet">

    <!-- HTML Meta Tags -->
    <title>SADI | Sistema de Administración Inteligente</title>
    <meta name="description" content="Optimiza tu inventario y factura de manera ágil y eficiente.">

    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="https://zehtx.github.io/Login-Project/">
    <meta property="og:type" content="website">
    <meta property="og:title" content="SADI | Sistema de Administración Inteligente">
    <meta property="og:description" content="Optimiza tu inventario y factura de manera ágil y eficiente.">
    <meta property="og:image" content="https://zehtx.github.io/Login-Project/assets/img/Sadi.png">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="zehtx.github.io">
    <meta property="twitter:url" content="https://zehtx.github.io/Login-Project/">
    <meta name="twitter:title" content="SADI | Sistema de Administración Inteligente">
    <meta name="twitter:description" content="Optimiza tu inventario y factura de manera ágil y eficiente.">
    <meta name="twitter:image" content="https://zehtx.github.io/Login-Project/assets/img/Sadi.png">

    <!-- Meta Tags Generated via https://www.opengraph.xyz -->
</head>

<body>
<div style="color: white;">
        <?php
        if(isset($messages)){
            greyMsg($messages);
        }
            if(isset($errors)){
                greyMsg($errors);
            }
        ?>
    </div>

    <!-- Contenedor de Inicio de Sesion -->
    <div class="container-form login">
        <div class="information">
            <!-- Mensaje + Boton de Sing In -->
            <div class="info-childs">
                <h2>¡¡Bienvenido De Nuevo!!</h2>
                <p>
                    Si no posees una cuenta registrate aqui
                </p>
                <input type="button" value="Registrarse" id="sign-up">
            </div>
        </div>
        <!-- Fin Mensaje + Boton de Sing In -->
        <!-- Formulario -->
        <div class="form-information">
            <div class="form-information-childs">
                <h2>Inicia Sesión</h2>
                <p>Inicia Sesión con tu Email</p>
                <form class="form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                    <label for="new-user-email">
                        <i class='bx bx-envelope' id="git"></i>
                        <input type="email" id="new-user-email" placeholder="Email" name="email">
                    </label>
                    <label for="new-user-password">
                        <i class='bx bx-lock-alt' id="linkedin"></i>
                        <input type="password" id="new-user-password" placeholder="Contraseña" name="password">
                    </label>
                    <input type="submit" value="Iniciar Sesión" name="login">
                </form>
            </div>
        </div>
        <!-- Fin Formulario -->
    </div>

    <!-- Fin de Formulario de Inicio de Sesion -->

    <!-- Contenedor de Registro -->
    <div class="container-form register hide">
        <!-- Mensaje + Boton de Login -->
        <div class="information">
            <div class="info-childs">
                <h2>Bienvenido</h2>
                <p>
                    Para ingresar al panel de administración crea una cuenta o inicia sesión
                </p>
                <input type="button" value="Iniciar Sesión" id="sign-in">
            </div>
        </div>
        <!-- Fin Mensaje + Boton de Login -->
        <!-- Formulario -->
        <div class="form-information">
            <div class="form-information-childs">
                <h2>Crea Una Cuenta</h2>
                <p>Usa tu Email para registrarte</p>
                <form class="form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                    <label for="new-user-email">
                        <i class='bx bx-envelope'></i>
                        <input type="email" id="new-user-email" placeholder="Email" name="email-reg">
                    </label>
                    <label for="new-user-password">
                        <i class='bx bx-lock-alt'></i>
                        <input type="password" id="new-user-password" placeholder="Contraseña" name="password-reg">
                    </label>
                    <input type="submit" value="Registrarse" name="register">
                </form>
            </div>
            <!-- Fin Formulario -->
        </div>
    </div>
    <!-- Fin de Contenedor de Registro -->

    <script src="./assets/js/script.js"></script>
</body>

</html>