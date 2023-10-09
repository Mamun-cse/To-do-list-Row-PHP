<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once 'Database.php';

$instance = Database::getInstance();

$conn = $instance->getConnection();

$data = json_decode(file_get_contents('php://input'), true);

$id = $_GET['id'];

$sql = "SELECT * FROM todo_items WHERE id = :id";

$statement = $conn->prepare($sql);

$statement->bindParam(':id', $id);

$statement->execute();

$data = $statement->fetch(PDO::FETCH_ASSOC);

if($data){

    echo json_encode($data);

}else {
    echo 'Id '.$id. ' not found';
}
?>
