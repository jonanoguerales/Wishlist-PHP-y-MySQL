<?php
// Solo se permite el ingreso con el inicio de sesion.
session_start();
// Si el usuario no se ha logueado se le regresa al inicio.
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit; }
?>


<html>
<head>
    <link rel="stylesheet" href="diseño.css">
    <meta charset="utf-8">
<title>wishlist</title>
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

<body >
<form method="post" name="inicio">
    <div class="contenedor">
        <h1>Wishlist de usuario</h1>
        <ol>
<?php
require("conectar.php");
    $resultado = $conn->query("SELECT id FROM users WHERE name='".$_SESSION['name']."'");
    if ($resultado->num_rows > 0) {
    // Recorremos cada fila
        while($row = $resultado->fetch_assoc()) {
            $_SESSION['id']=$row["id"];
        }
    }
        $resultado->close();
?>
<?php
    $resultado = $conn->query("SELECT name,id,link FROM items WHERE user_id='".$_SESSION['id']."'");
    if ($resultado->num_rows > 0) {
        // Recorremos cada fila
        while($row = $resultado->fetch_assoc()) {?>
            <div class="a">
            <li><a href="<?php echo $row["link"]?>">
            <?php echo $row["name"]?>&nbsp;
                <button style="background: rgb(9, 43, 107)"><a href="wishlist_edit.php?id=<?php echo $row["id"]; ?>">Añadir</a></button>&nbsp;
                <button style="background: rgb(83, 2, 9)"><a href="wishlist_delete.php?id=<?php echo $row["id"]; ?>">Borrar</a></button><br>
            </li>
            </div>
            <?php 
        }
    }
    $resultado->close(); 
?>
        <div class="a">
        <button><a href="wishlist_crear.php">CREAR</a></button>
        </div>
        </ol>
    </div>
    </form>
<div class="footer">
  <p>Bienvenido Usuario : <?php echo $_SESSION['name']?> Fecha actual:<?php echo date("d-m-y")?> </p>
  <a class="f" href="salir.php">SALIR</a>
</div>
</body>
</html>
