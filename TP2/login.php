<!DOCTYPE html>
<html lang="es" >

<head>
  <meta charset="UTF-8">
  <title>TP2-Arquitectura de Redes y Servicios</title>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

  <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
  <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>

  <link rel="stylesheet" href="css/style.css">

</head>

<body>
  
<div class="pen-title">
  <h1>TP 2 - Ejercicio 5</h1><span><h2>Uso de funciones hash para almacenar contraseñas</h2></span>
</div>
<!-- Form Module-->
<div class="module form-module">
  <div class="toggle"><i class="fa fa-times fa-pencil"></i>
    <div class="tooltip">Registro</div>
  </div>
  <div class="form">
    <h2>Login de tu cuenta</h2>
    <form action="home.php" method="post">
      <input type="text" name="user_name" placeholder="Usuario"/>
      <input type="password" name="password" placeholder="Contraseña"/>
      <input type="hidden" name="form" value="login" hid>
      <button>Login</button>
    </form>
  </div>
  <div class="form">
    <h2>Crear cuenta</h2>
    <form action="home.php" method="post">
      <input type="text" name="user_name" placeholder="Usuario"/>
      <input type="password" name="password" placeholder="Contraseña"/>
      <input type="text" name="nombres" placeholder="Nombres"/>
      <input type="text" name="apellidos" placeholder="Apellidos">
      <input type="email" name="email" placeholder="E-Mail"/>
      <input type="tel" name="telefono" placeholder="Nº Telefono"/>
      <input type="hidden" name="form" value="registro">
      <button>Registro</button>
    </form>
  </div>
</div>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

<script  src="js/index.js"></script>

</body>

</html>
