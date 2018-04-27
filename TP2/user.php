<?php 
    
    //Registro de usuario
    function log_up($user_name, $password, $nombres, $apellidos, $email, $num_telefono){
        if (empty($user_name) || empty($password) )  {
            return FALSE;
        }
        
        $file_db = fopen("users_db.txt", "a+");

        if ($file_db){
            fwrite($file_db, $user_name."|");
            fwrite($file_db, password_hash($password, PASSWORD_BCRYPT)."|");
            fwrite($file_db, $nombres."|");
            fwrite($file_db, $apellidos."|");
            fwrite($file_db, $email."|");
            fwrite($file_db, $num_telefono."\n");

            fclose($file_db);

            return TRUE;
        }    
        else{
            return FALSE;    
        }
    }

    //Autentificación de usuario
    function log_in($user_name, $password){
        if (empty($user_name) || empty($password) )  {
            return false;
        }

        $file_db = fopen("users_db.txt", "r");

        if ( $file_db ) {
            while (($buffer = fgets($file_db)) !== false ) {
                $linea = explode("|", $buffer);

                if ($linea[0] == $user_name) {
                    fclose($file_db);
                    if (password_verify($password, $linea[1])) {
                        return true;
                    }else{
                        return false;
                    }
                }
            }
            fclose($file_db);
        }
        return false;
    }    

?>