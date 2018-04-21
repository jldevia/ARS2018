<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="estilos.css">
    <title>TP1 - Ejercicio 2</title>
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
                        $cod_chr = (array_search(mb_substr($msg_orig, $i, 1), $alfabeto) - $key);

                        $cod_chr = ($cod_chr < 0)? $cod_chr + 27 : $cod_chr;
                    }
                    $msg_cifrado .= $alfabeto[$cod_chr];
                }
            }
  
            return $msg_cifrado;
        }

        //Calcula el peso del mensaje descifrado en base a la cantidad de palabras que encuentra
        //en el diccionario.
        function calcular_peso($diccionario, $mensaje){
            $peso = 0;
            
            $palabras = explode(" ", $mensaje);

            foreach ($palabras as $key => $value) {
                $existe = in_array(strtolower($value)."\n", $diccionario);
                if ($existe == TRUE){
                  $peso++;
                }
            }
            return $peso;
        }

        //Función de comparación utilizada para ordenar el array de ranking de palabras.    
        function cmp($a, $b){
            $result = 0;
            
            if ($a["peso"] < $b["peso"]){
                $result = -1;
            } elseif ($a["peso"] > $b["peso"]){
                $result = 1;
            }

            return $result;
        }

        $mensaje = $resultado= $err_msg = "";
        define("MAX_DESPLZ", 27);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if ($_POST["message"] == ""){
              $err_msg .= "Indique el mensaje a descifrar <br>";
            }else{
                $mensaje = $_POST["message"];
                if (preg_match("/^[a-zñ\s]*$/i",$mensaje) == 0) {
                  $err_msg .= "El mensaje debe contener solo letras [A-Z ó a-z]";
                }
            }

            $diccionario = file('diccionario.txt');
            $ranking = array();
      
            if ($err_msg == "") {
              for ($i=0; $i < MAX_DESPLZ; $i++) { 
                  $msg_descifrado = cifrar("actDescifrar", $i, $mensaje);
                  $peso = calcular_peso($diccionario, $msg_descifrado);
                  array_push($ranking, array("key" => $i, "palabra" => $msg_descifrado, "peso" => $peso));
              }

              usort($ranking, "cmp");

              for ($i= count($ranking)-1; $i >= 0; $i--) { 
                  $resultado.= "[clave = ".$ranking[$i]["key"]."]: ";
                  $resultado.= $ranking[$i]["palabra"]."\n";
              }

            }
            
        }
    ?>
    <div id="registration-form">
    	<div class="fieldset">
        <legend>Descifrador x "Fuerza Bruta" - Cesar</legend>
    		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" data-validate="parsley">
                <div class="row">
                    <label for="message">Mensaje cifrado</label>
                    <input type="text" name="message" placeholder="mensaje ...." value="<?php echo($mensaje);?>">
    			</div>
                <div class="row">
                    <label for="result">Resultado</label>
                    <textarea name="result" cols="42" rows="10" style="resize: none; display: block"
                       ><?php echo($resultado);?></textarea>
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