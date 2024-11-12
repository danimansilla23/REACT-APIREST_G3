
<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
class Api{
    private $connect='';
    function __construct()
    {
        $this->connect = new PDO("mysql:host=localhost;dbname=diariodb","root","");
    }

    function list(){
        try {
            $query="select * from noticias";
            $sql = $this->connect->prepare($query);
            $ok= $sql->execute();
            if($ok){
                $data=null;
                while($row = $sql->fetch(PDO::FETCH_ASSOC))
                {
                    $data[] = $row;
                }
                $datasuccess=[
                    'status'=>200,
                    'data'=>$data
                ];
                return $datasuccess;
            }
            else{
                $datasuccess=[
                    'status'=>500,
                    'message'=>'error al ejecutar la consulta'
                ];
                return $datasuccess;
            }
        } catch (Exception $e) {
            $datasuccess[]=[
                'status'=>500,
                'menssage'=>'algo malo paso'
            ];
            return  $datasuccess;
        }
    }
    function insert() {
        try {
            // Usar $_GET para obtener los parámetros
            if (!isset($_GET['titulo'], $_GET['copete'], $_GET['cuerpo'], $_GET['imagen'], $_GET['fecha'], $_GET['categoria'])) {
                return json_encode([
                    'status' => 400,
                    'message' => 'Faltan datos requeridos.'
                ]);
            }
    
            $query = "INSERT INTO noticias (titulo, copete, cuerpo, imagen, fecha, categoria) VALUES (:pTitulo, :pCopete, :pCuerpo, :pImagen, :pFecha, :pCategoria)";
            
            $sql = $this->connect->prepare($query);
            
            // Usar $_GET en vez de $data
            $sql->bindParam(':pTitulo', $_GET['titulo'], PDO::PARAM_STR);
            $sql->bindParam(':pCopete', $_GET['copete'], PDO::PARAM_STR);
            $sql->bindParam(':pCuerpo', $_GET['cuerpo'], PDO::PARAM_STR);
            $sql->bindParam(':pImagen', $_GET['imagen'], PDO::PARAM_STR);
            $sql->bindParam(':pFecha', $_GET['fecha'], PDO::PARAM_STR);
            $sql->bindParam(':pCategoria', $_GET['categoria'], PDO::PARAM_STR);
            
            $ok = $sql->execute();
            
            if ($ok) {
                return json_encode([
                    'status' => 200,
                    'message' => 'Noticia insertada correctamente.',
                    'id' => $this->connect->lastInsertId() // Devolver el ID de la noticia insertada
                ]);
            } else {
                return json_encode([
                    'status' => 500,
                    'message' => 'Error al ejecutar la consulta'
                ]);
            }
        } catch (Exception $e) {
            return json_encode([
                'status' => 500,
                'menssage' => 'Algo malo pasó: ' . $e->getMessage()
            ]);
        }
    }
    
    function delete() {
        try {
            // Comprobar si se ha proporcionado el id_noticia en $_GET
            if (!isset($_GET['id_noticia'])) {
                return json_encode([
                    'status' => 400,
                    'message' => 'Falta el ID de la noticia a eliminar.'
                ]);
            }
    
            $query = "DELETE FROM noticias WHERE id_noticia = :pIdNoticia";
            
            $sql = $this->connect->prepare($query);
            
            // Enlazar el parámetro id_noticia desde $_GET
            $sql->bindParam(':pIdNoticia', $_GET['id_noticia'], PDO::PARAM_INT);
            
            $ok = $sql->execute();
            
            if ($ok) {
                return json_encode([
                    'status' => 200,
                    'message' => 'Noticia eliminada correctamente.'
                ]);
            } else {
                return json_encode([
                    'status' => 500,
                    'message' => 'Error al ejecutar la consulta de eliminación'
                ]);
            }
        } catch (Exception $e) {
            return json_encode([
                'status' => 500,
                'message' => 'Algo malo pasó: ' . $e->getMessage()
            ]);
        }
    }
    
    function update() {
        try {
            // Verificar que todos los datos requeridos están presentes
            if (!isset($_GET['id_noticia'], $_GET['titulo'], $_GET['copete'], $_GET['cuerpo'], $_GET['imagen'], $_GET['fecha'], $_GET['categoria'])) {
                return json_encode([
                    'status' => 400,
                    'message' => 'Faltan datos requeridos.'
                ]);
            }
    
            // Crear consulta de actualización
            $query = "UPDATE noticias SET titulo = :pTitulo, copete = :pCopete, cuerpo = :pCuerpo, imagen = :pImagen, fecha = :pFecha, categoria = :pCategoria WHERE id_noticia = :pId";
            
            $sql = $this->connect->prepare($query);
    
            // Asociar parámetros con los datos recibidos
            $sql->bindParam(':pId', $_GET['id_noticia'], PDO::PARAM_INT);
            $sql->bindParam(':pTitulo', $_GET['titulo'], PDO::PARAM_STR);
            $sql->bindParam(':pCopete', $_GET['copete'], PDO::PARAM_STR);
            $sql->bindParam(':pCuerpo', $_GET['cuerpo'], PDO::PARAM_STR);
            $sql->bindParam(':pImagen', $_GET['imagen'], PDO::PARAM_STR);
            $sql->bindParam(':pFecha', $_GET['fecha'], PDO::PARAM_STR);
            $sql->bindParam(':pCategoria', $_GET['categoria'], PDO::PARAM_STR);
            
            $ok = $sql->execute();
            
            if ($ok) {
                return json_encode([
                    'status' => 200,
                    'message' => 'Noticia actualizada correctamente.'
                ]);
            } else {
                return json_encode([
                    'status' => 500,
                    'message' => 'Error al ejecutar la actualización'
                ]);
            }
        } catch (Exception $e) {
            return json_encode([
                'status' => 500,
                'message' => 'Algo malo pasó: ' . $e->getMessage()
            ]);
        }
    }
    
}
?>

