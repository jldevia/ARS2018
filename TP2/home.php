<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TP2-Arquitectura de Redes y Servicios</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

    <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
    <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
   
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php 
        include 'user.php';
        $msg = "";
        $msg_error ="";

        if ( $_SERVER["REQUEST_METHOD"] == "POST" ){
            $user = $_POST["user_name"];
            $password = $_POST["password"];
            
            if (empty($user) || empty($password)) {
                $msg_error = "Debe especificar usuario/contraseña.";
            }else{
                if ($_POST["form"] == "login"){
                
                    if(log_in($user, $password)){
                        $msg = "Bienvenido a este gran sitio!!!";
                    }else{
                        $msg_error = "Usuario ó contraseña incorrectas";
                    }
                }else{
                    if ( log_up($user, $password, $_POST["nombres"], $_POST["apellidos"],
                                $_POST["email"], $_POST["telefono"])  ){
                        $msg = "El registro se efectuo exitosamente!!!";            
                    }else{
                        $msg_error = "Se produjo un error al registrar la cuenta.";
                    }
                }
            }
        }
    ?>
    
    <div class="pen-title">
        <h1>TP 2 - Ejercicio 5</h1><span><h2>Uso de funciones hash para almacenar contraseñas</h2></span>
    </div>
    <div class="form-module">
        <h2>Home</h2>
        <form action="login.php" method="post">
            <span style="font-size: 18px; font-weight: bold; color: MediumSeaGreen"><?php echo($msg); ?></span>
            <span style="font-size: 18px; font-weight: bold; color: Tomato"><?php echo($msg_error); ?></span>
            <button>Salir</button>
        </form>
    </div>
    
</body>
</html>