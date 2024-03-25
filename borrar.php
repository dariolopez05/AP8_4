<?php

require_once "autoloader.php";

session_start();
$datos = new Modelo();
$conn= $datos->getConn();
$id=$_GET['id'];
$query = "DELETE FROM `tareas` WHERE `id` = $id ";
$result = mysqli_query($conn, $query);
header("location: lista.php");

?>