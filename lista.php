<?php 
session_start(); 
require_once "autoloader.php";
            
$datos = new Modelo(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<table class="greenTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>título</th>
            <th>Vencimiento</th>
            <th colspan="2">Actions</th>
        </tr>
    </thead>
        <?php echo $datos->showOrderAction(); ?>
    <tfoot>
        <tr>
            <td colspan="5">
                &nbsp;
            </td>
        </tr>
    </tfoot>
    <tbody>
        <?php
            $orden = $datos->getCurrentOrder();
            $tabla = $datos->showAllTasks($orden);
            echo $tabla;
        ?>
    </tbody>
</table>
<a href="nueva.php">Añadir registro</a><br>
<?php 

echo $datos->showNavigation();

?>
</body>
</html>
