<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="estilos.css">
    <title>TP1 - Ejercicio 3</title>
</head>
<body>
    <?php
      $alfabeto = array('A','B','C', 'D','E', 'F', 'G', 'H','I', 'J', 'K', 'L', 'M', 'N', 'Ñ', 'O', 'P', 'Q', 'R',
                        'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

      //Funcion de cifrado (ó descifrado). Algoritmo de "Vigenerè"
      function cifrar ($action, $key, $message) {
        global $alfabeto;

        $key_orig = mb_convert_encoding(strtoupper($key), "UTF-8");
        $msg_orig = mb_convert_encoding(strtoupper($message), "UTF-8");
        $msg_cifrado = "";
        $cod_chr = 0;
        $j = 0;

        for ($i=0; $i < mb_strlen($msg_orig); $i++) { 
          
          if ($action == "actCifrar"){
            $cod_chr = (array_search(mb_substr($msg_orig, $i, 1), $alfabeto) 
                          + array_search(mb_substr($key_orig, $j, 1), $alfabeto)) % 27;
          }else{
            $cod_chr = array_search(mb_substr($msg_orig, $i, 1), $alfabeto) - 
                          array_search(mb_substr($key_orig, $j, 1), $alfabeto);

            $cod_chr = ($cod_chr < 0)? $cod_chr + 27 : $cod_chr;
                          
          }
          $msg_cifrado .= $alfabeto[$cod_chr];
          
          $j = ($j+1) % mb_strlen($key_orig);  ;
        }
        return $msg_cifrado;
      } 
      
      $accion = $clave = $mensaje = $resultado= $err_msg = "";

      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $accion = $_POST["action"];
        if ($_POST["key"] == ""){
          $err_msg .= "Debe indicar la clave para el cifrado <br>";
      }else{
          $clave = $_POST["key"];
          if (preg_match("/^[a-zñÑ]*$/i",$clave) == 0) {
            $err_msg .= "La clave del cifrado debe contener solo letras [A-Z ó a-z], sin espacios en blanco <br>";
          }
      }

      if ($_POST["message"] == ""){
        $err_msg .= "Indique el mensaje a cifrar <br>";
      }else{
        $mensaje = $_POST["message"];
        if (preg_match("/^[a-zñ]*$/i", $mensaje) == 0) {
          $err_msg .= "El mensaje debe contener solo letras [A-Z ó a-z], sin espacios en blanco";
        }
      }

      if ($err_msg == "") {
        $resultado = cifrar($accion, $clave, $mensaje);
      }
    }

    ?>
    <div id="registration-form">
    	<div class="fieldset">
        <legend>Cifrador de "Vigenerè"</legend>
    	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" data-validate="parsley">
    		<div class="row">
    			<label for="action">Acción</label>
    			<select name="action">
             <option value="actCifrar">Cifrar</option>
             <option value="actDescifrar">Descifrar</option>
          </select>
    		</div>
    		<div class="row">
    			<label for="key">Clave</label>
    			<input type="text" placeholder="clave"  name='key' value="<?php echo($clave);?>">
    		</div>
    		<div class="row">
    			<label for="message">Mensaje</label>
          <input type="text" name="message" placeholder="mensaje ...." value="<?php echo($mensaje);?>">
    		</div>
        <div class="row">
          <label for="resultado">Resultado</label>
          <input type="text" name="resultado" placeholder="resultado ...." value="<?php echo($resultado);?>">
        </div>
    		<input type="submit" value="Ejecutar">
    	</form>
        <div class="error">
          <?php echo($err_msg)?>
        </div>
    	</div>
    </div>

    <script type="text/javascript">

      function placeholderIsSupported() {
        test = document.createElement('input');
        return ('placeholder' in test);
      }

      $(document).ready(function(){
        placeholderSupport = placeholderIsSupported() ? 'placeholder' : 'no-placeholder';
        $('html').addClass(placeholderSupport);
      });
    </script>
</body>
</html>