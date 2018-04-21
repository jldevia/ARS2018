<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html" charset="utf-8">
    <title>TP1 - Ejercicio 1</title>
    <link rel="stylesheet" href="estilos.css">
  </head>
  <body>
  <?php
    $alfabeto = array('A','B','C', 'D',
                      'E', 'F', 'G', 'H',
                      'I', 'J', 'K', 'L', 'M', 'N', 'Ñ', 'O', 'P', 'Q', 'R',
                      'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

    //Funcion de cifrado (ó descifrado). Algoritmo de "Cesar"
    function cifrar($action, $key, $message){
      global $alfabeto;
      $msg_orig = mb_convert_encoding(strtoupper($message), "UTF-8");
      $msg_cifrado = "";
      $cod_chr = 0;

      for ($i=0; $i < mb_strlen($msg_orig); $i++) {
          if ($msg_orig[$i] == " " ) {
            $msg_cifrado .= " ";
          }else{
            if ($action == "actCifrar"){
              //echo(array_search($msg_orig[$i], $alfabeto));
              $cod_chr = (array_search(mb_substr($msg_orig, $i, 1), $alfabeto) + $key) % 27;
            }else{
              //echo(array_search($msg_orig[$i], $alfabeto));
              $cod_chr = (array_search(mb_substr($msg_orig, $i, 1), $alfabeto) - $key) % 27;
            }
            $msg_cifrado .= $alfabeto[$cod_chr];
          }
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
          if (!ctype_digit($clave)) {
            $err_msg .= "La clave del cifrado debe ser un número entero mayor que 0 <br>";
          }
      }

      if ($_POST["message"] == ""){
        $err_msg .= "Indique el mensaje a cifrar <br>";
      }else{
          $mensaje = $_POST["message"];
          if (preg_match("/^[a-zñ\s]*$/i", $mensaje) == 0) {
            $err_msg .= "El mensaje debe contener solo letras [A-Z ó a-z]";
          }
      }

      if ($err_msg == "") {
        $resultado = cifrar($accion, $clave, $mensaje);
      }
    }
   ?>

    <div id="registration-form">
    	<div class="fieldset">
        <legend>Cifrador del "César"</legend>
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
