<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once 'Database.php';

$instance = Database::getInstance();

$conn = $instance->getConnection();

$sql = "SELECT * FROM todo_items";

$statement = $conn->prepare($sql);

$statement->execute();

$data = $statement->fetchAll(PDO::FETCH_ASSOC);

if($data){

    echo json_encode($data);

}else {

    echo json_encode(['msg' => 'No data found', 'status' => false]);
}

?>