<?php
require("conectar.php");

$nombre = $password = $correo = "";
$username_err = $password_err = $correo_err = "";

if (isset($_POST['entrar'])) {
    if(empty(trim($_POST["nombre"]))){
        $username_err = "Por favor ingrese un nombre de usuario.";
    } else{
        // Preparamos la sentencia 
        if($stmt = $conn->prepare("SELECT id FROM users WHERE name = ?")){
            
            $stmt->bind_param("s", $nombre);
            
            // Asignacion a los parametros
            $nombre = trim($_POST["nombre"]);
            
            // Ejecutamos la sentencia
            if($stmt->execute()){

                $stmt->store_result();

                if($stmt->num_rows == 1){
                    $username_err = "Este usuario ya fue tomado.";
                } else{
                    $nombre = trim($_POST["nombre"]);
                }
            } else{
                echo "Al parecer algo salió mal.";
            }
        }
         
        // Cerramos sentencia
        $stmt->close();
    }
    
    // Validacion de la contraseña
    if(empty(trim($_POST["contraseña"]))){
        $password_err = "Por favor ingresa una contraseña.";     
    } elseif(strlen(trim($_POST["contraseña"])) < 6){
        $password_err = "La contraseña al menos debe tener 6 caracteres.";
    } else{
        $password = trim($_POST["contraseña"]);
    }
    
    // Validacion del correo
    if(empty(trim($_POST["email"]))){
        $correo_err="Confirma tu email.";     
    } else{
        $correo = trim($_POST["email"]);
    }
    
    // Comprobamos kos errores antes de insertar en la base de datos
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Preparamos la sentencia
        if($stmt = $conn->prepare("INSERT INTO users (name, password,email) VALUES (?, ?, ?)")){
        
            $stmt->bind_param("sss", $nombre, $password, $correo);
            
            // Asignacion a los parametros
            $correo=$_POST["email"];
            $nombre = $_POST["nombre"];
            $password = $_POST["contraseña"];
            
            // Si se ejecuta la sentencia  
            if($stmt->execute()){
                // Redirecciona a la pagina de login
                header("location: login.php");
            } else{
                echo "Algo salió mal, por favor inténtalo de nuevo.";
            }
        }
         
        // Cerramos sentencia
        $stmt->close();
    }
    
    // Cerramos conexion
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
<form method="post" >
    <div class="contenedor">
        <h1>Formulario de registro</h1>
        <div class="a">
            <label>Nombre</label>
            <input type="text" name="nombre" pattern="[a-zA-Z0-9]+" required />
            <div class="a">
            <span style="color: red; font-size: 20px"><?php echo $username_err; ?></span>
            </div>
        </div>
        <div class="a">
            <label>Email</label>
            <input type="email" name="email" required />
            <div class="a">
            <span style="color: red; font-size: 20px"><?php echo $correo_err; ?></span>
            </div>
        </div>
        <div class="a">
            <label>Contraseña</label>
            <input type="password" name="contraseña" required />
            <div class="a">
            <span style="color: red; font-size: 20px;"><?php echo $password_err; ?></span>
            </div>
        </div>
        <div class="a">
            <button id="registro" type="submit" name="entrar" value="entrar">Registrarse</button>
            </div>
        <a href="salir.php">SALIR</a>
    </div>
</form>
</body>
</html> 