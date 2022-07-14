<?php
//Iniciamos la sesion
session_start();
//Chequeamos si el usuario esta logeado
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: wishlist.php");
    exit;
}
//Incluimos el archivo de congiruracion para conectarnos a la base de datos
include('conectar.php');

$nombre = $password = "";
$error = "";

if (isset($_POST['entrar'])) {  
        // Preparamos la sentencia
        if($stmt =  $conn->prepare("SELECT * FROM users WHERE name = ? AND password = ?")){

            $stmt->bind_param("ss", $nombre,$password);
            
            // Asignamos los parámetros
            $nombre = trim($_POST["nombre"]);
            $password= trim($_POST["contraseña"]);
            
            // Ejecutamos la sentencia
            if( $stmt->execute()){

                $stmt->store_result();
                
                // Comprobamos que el usuario y contraseña existen
                 if($stmt->num_rows == 1){                 

                    $_SESSION["loggedin"] = true;
                    $_SESSION["name"] = $nombre;
                    $_SESSION["password"] = $password;                             
                                    
                    // Redireccionamos al usuario hacia su wishlist
                    header("location: wishlist.php");
                } else{
                    $error= 'El email o password es incorrecto,vuelva a intenarlo<br/>';
                }
            }
        $stmt->close();             
        }
$conn->close();
}
 
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="diseño.css">
    <title>Registro</title>
</head>
<body>
    <form method="post" name="inicio">
    <div class="contenedor">
        <h1>Formulario de inicio de sesion</h1>
            <div class="a">
                <label>Nombre</label>
                <input type="text" name="nombre" pattern="[a-zA-Z0-9]+" required />
            </div>
            <div class="a">
                <label>Contraseña</label>
                <input type="password" name="contraseña" required />
                <div class="a">
                <span style="color: red; font-size: 20px;"><?php echo $error; ?></span>
                </div>
            </div>
            <div class="a">
                <button id="entrar" type="submit" name="entrar" value="entrar">ENTRAR</button>
            </div>
            
            <a id="crear" type="button" name="registrarse" value="registrarse" href='registro.php'>Registrarse</a>
            
        
    </div>
    </form>
</body>
</html>