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
    <title>Edición objetos lista</title>
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
<?php

require("conectar.php");
if (isset($_POST['enviar'])) {
    $update = "UPDATE items SET name='" . $_POST['nombre']. "', link='" . $_POST['link']. "', description='" . $_POST['descripcion'] . "'" . "WHERE id=" . $_SESSION["id_item"];
    $conn->query($update); 
    header("Location:wishlist.php");
    
    // Cerrar conexión de base de datos
    $conn->close();

} else {
    $select = "SELECT * FROM items WHERE id=" . $_GET["id"];
    $result = $conn->query($select);

    if($result->num_rows == 1) {
        // Formulario de edición
        $objeto = $result->fetch_assoc();
        $_SESSION["id_item"]=$objeto["id"];
        ?>
        <form method="post" action="wishlist_edit.php">
                <div class="contenedor">
                    <h1>Formulario de edicion de objetos</h1>
                        <div class="a">
                            <label>Nombre</label>
                            <input type="text" name="nombre" value="<?php echo $objeto["name"]; ?>"required />
                        </div>
                        <div class="a">
                            <label>Link</label>
                            <input type="text/html" name="link" value="<?php echo $objeto["link"]; ?>"/>
                        </div>
                        <div class="a">
                            <label>Descripcion</label>
                            <textarea name="descripcion" style="width:300px; height:200px;" value="<?php echo $objeto["description"]; ?>">Descripcion del objeto.</textarea>
                        </div>
                        <div class="a">
                            <button type="submit" name="enviar" value="enviar">ENVIAR</button>
                        </div>       
                </div>
                </form>
    <?php } else {
        echo "hay algo mal";
    }
}

?>
<div class="footer">
<p>Bienvenido Usuario : <?php echo $_SESSION['name']?> Fecha actual:<?php echo date("d-m-y")?> </p>
  <a class="f" href="wishlist.php">VOLVER</a>
</div>
</body>
</html>