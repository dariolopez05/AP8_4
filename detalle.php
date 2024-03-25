<?php
require_once "autoloader.php";

session_start();
$datos = new Modelo();
$tabla = $datos->showAllTasks(3);
$conn= $datos->getConn();
$id=$_GET['id'];
$query = "SELECT `id`, `titulo`, `descripcion`, `fecha_creacion`, `fecha_vencimiento` FROM `tareas` WHERE `id` = $id ";
$result = mysqli_query($conn, $query);
$data = $result->fetch_array(MYSQLI_ASSOC);

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
            <th><?php echo $data['titulo']; ?></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td>La tarea <?php echo $data['id']; ?> vence el <?php echo $data['fecha_vencimiento']; ?></td>
        </tr>
    </tfoot>
    <tbody>
        <tr>
            <td>fecha de creación: <?php echo $data['fecha_creacion']; ?></td>
        </tr>
        <tr>
            <td>descripción: <?php echo $data['descripcion']; ?></td>
        </tr>
    </tbody>
</table>
<a href="lista.php">Volver</a>
</body>
</html>
