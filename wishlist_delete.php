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
        <link rel="stylesheet" href="diseñowish.css">
        <title>Borrar objeto</title>
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
    <h1>Borrar objeto</h1>

    <?php
        require("conectar.php");
        // Recorre y muestra todos los objetos
        $delete = "DELETE FROM items WHERE id=". $_GET['id'];
        $result = $conn->query($delete);
        echo"Objeto borrado de la lista satisfactoriamente";
        $conn->close();
    ?>

    <a href="wishlist.php">Volver</a>
<div class="footer">
<p>Bienvenido Usuario : <?php echo $_SESSION['name']?> Fecha actual:<?php echo date("d-m-y")?> </p>
  <a class="f" href="wishlist.php">VOLVER</a>
</div>
    </body>
</html>