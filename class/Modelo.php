<?php

class Modelo extends Connection {

    public function __construct()
    {
        parent::__construct();
    }

    function import(){
        $gestor = fopen('tareas.csv', "r");
        $conn= $this->getConn();
        while (($element = fgetcsv($gestor)) !== false) {
            $query = "INSERT INTO `tareas`(`titulo`, `descripcion`, `fecha_creacion`, `fecha_vencimiento`) VALUES ('$element[1]','$element[2]','$element[3]','$element[4]')";
            $result = mysqli_query($conn, $query);
        }
        fclose($gestor);
    }

    function delete(){
        $conn= $this->getConn();
        $query = "DELETE FROM `tareas`";
        $result = mysqli_query($conn, $query);
    }

    function init(){
        $this->delete();
        $this->import();
    }

    function getAllTasks(){
        $data=[];
        $conn= $this->getConn();
        $orden = $this->getCurrentOrder();
        $page = $this->getCurrentPage();
        $orden=isset($orden) ? ($orden) : 1;
        $pagina=isset($pagina) ? ($pagina) : 1;


        if ($orden == 1) {
            $query = "SELECT `id`, `titulo`, `descripcion`, `fecha_creacion`, `fecha_vencimiento` FROM `tareas` ORDER BY titulo";
        } elseif ($orden == 2) {
            $query = "SELECT `id`, `titulo`, `descripcion`, `fecha_creacion`, `fecha_vencimiento` FROM `tareas` ORDER BY fecha_vencimiento";
        } else{
        $query = "SELECT `id`, `titulo`, `descripcion`, `fecha_creacion`, `fecha_vencimiento` FROM `tareas`";
        }

        $registros = "SELECT Count(*) FROM tareas";

        $totalRegisters = mysqli_query($conn, $registros);
        $total=[];

        array_push($total, $totalRegisters->fetch_array(MYSQLI_ASSOC));

        $regxPag=10;
        $pages=ceil($total[0]['Count(*)']/$regxPag);
        $inicio=($pagina-1) * $regxPag;
        $fin=$inicio+$regxPag-1;

        $query .= " LIMIT 10";

        $result = mysqli_query($conn, $query);

        for ($i=0; $i < 10; $i++) {
            $result->data_seek($i);
            array_push($data, $result->fetch_array(MYSQLI_ASSOC));
        }
        return $data;
    }

    function showAllTasks(){
        $data = $this->getAllTasks();
        $output = "";
    
        foreach ($data as $info) {
            
            $output .= "<tr>"; 
            $id = $info['id'];
            $titulo = $info['titulo'];
            $vencimiento = $info['fecha_vencimiento'];

            $output .= "<td> $id </td>"; 
	
            $output .= "<td> <a href='detalle.php?id=$id'> $titulo </a> </td>"; 
            $output .= "<td> $vencimiento </td>";
            $output .= "<td> <a href='modificar.php?id=$id'>  Editar  </a> </td>";
            $output .= "<td> <a href='borrar.php?id=$id'>  Eliminar  </a> </td>";  

            $output .= "</tr>"; 

            }
        return $output;
    }

    function addTarea($array) {
        $conn= $this->getConn();

        $titulo = $array['title'];
        $descripcion = $array['description'];
        $f_crea = date('Y-m-d');
        $f_venc = $array['dueDate']; 
        $query = "INSERT INTO `tareas`(`titulo`, `descripcion`, `fecha_vencimiento` , `fecha_creacion`) VALUES ('$titulo', '$descripcion', '$f_venc', '$f_crea')";
        mysqli_query($conn, $query);
    }

    function updateTarea($array, $id) {
        $conn= $this->getConn();

        $titulo = $array['title'];
        $descripcion = $array['description'];
        $f_venc = $array['dueDate'];
        $query = "UPDATE `tareas` SET `titulo`='$titulo',`descripcion`='$descripcion',`fecha_vencimiento`='$f_venc' WHERE `id` = $id";
        mysqli_query($conn, $query);
    }
    
    function showOrderAction() {
        $pagina = $this->getCurrentPage();
        
        $pagina=isset($pagina) ? ($pagina) : 1;

        $output = "<tr> <td> <a href='lista.php?orden=3&pagina=$pagina'>  No ordenar  </a> </td> <td> <a href='lista.php?orden=1&pagina=$pagina'>  Ordenar  </a> </td> <td> <a href='lista.php?orden=2&pagina=$pagina'>  Ordenar  </a> </td> <td>  </td> <td>  </td> </tr>";
        return $output;
    }
    
    function getCurrentOrder() {
        $orden=$_GET['orden'];
        return $orden;
    }

    function getCurrentPage() {
        $pagina=$_GET['pagina'];
        return $pagina;
    }

    function getRegisters() {
        $conn= $this->getConn();
        
        $query = "SELECT `id`, `titulo`, `descripcion`, `fecha_creacion`, `fecha_vencimiento` FROM `tareas`";
        $result = mysqli_query($conn, $query);
        $totalRegisters = $result->num_rows;
        return $totalRegisters;
    }

    function showNavigation(){
        $limite = 10;
        $tamano = $this->getRegisters();
        $pages = ceil($tamano/$limite);
        
        $pagina = $this->getCurrentPage();
        $pagina=isset($pagina) ? ($pagina) : 1;
        $orden = $_GET['orden'];
        for ($i=1; $i <= $pages; $i++) {
            if ($pagina == $i) {
                echo '<strong>' . " $i " . '</strong>';
            } else{
                echo '<a href="lista.php?orden=' . 3 . '&pagina=' . $i . ' ">' . " $i " . '</a>';
            }
        }
    }
}
?>