<?php
// Solo se permite el ingreso con el inicio de sesion.
session_start();
// Si el usuario no se ha logueado se le regresa al inicio.
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit; }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="diseño.css">
    <link rel="stylesheet" href="diseñowish.css">
    <title>Edición animales</title>
    <style>
    .footer {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        background-color: cyan;
        color: black;
        text-align: center;
    }
    </style>
</head>
<body>
<h1>Edición animales</h1>
<?php
require("conectar.php");
if(isset($_POST["enviar"])){
    $stmt = $conn->prepare("INSERT INTO items(name,link,description, user_id) VALUES (?, ?,?,?)");
    $stmt->bind_param("sssi", $nombre,$link,$descripcion,$id);
    //Asigna los parámetros y los sustituye
    $nombre = $_POST['nombre'];
    $link = $_POST['link'];
    $descripcion = $_POST['descripcion'];
    $id = $_SESSION["id"];
    //Ejecuta la sentencia
    $stmt->execute();
    header('Location:wishlist.php');
    // Cerrar conexión de base de datos
    $conn->close();
}

?>
<form method="post" action="wishlist_crear.php">
<div class="contenedor">
    <h1>Formulario de creacion de objeto</h1>
    <div class="a">
        <label>Nombre</label>
        <input type="text" name="nombre" required />
    </div>
    <div class="a">
        <label>Link</label>
        <input type="text/html" name="link" />
    </div>
        <div class="a">
        <label>Descripcion</label>
        <textarea name="descripcion" style="width:200px; height: 200px;">Descripcion del objeto.</textarea>
    </div>
    <div class="a">
        <button type="submit" name="enviar" value="enviar">ENVIAR</button>
    </div>       
</div>
</form>
<div class="footer">
<p>Bienvenido Usuario : <?php echo $_SESSION['name']?> Fecha actual:<?php echo date("d-m-y")?> </p>
  <a class="f" href="wishlist.php">VOLVER</a>
</div>
</body>
</html>