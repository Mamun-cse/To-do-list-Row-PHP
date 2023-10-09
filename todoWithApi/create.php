<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Headers, Authorization, X-Requested-With');

require_once 'Database.php';

$instance = Database::getInstance();

$conn = $instance->getConnection();

$data = json_decode(file_get_contents('php://input'), true);

$task = $data['task'];

$category_id = $data['category_id'];

$sql = "INSERT INTO todo_items (task, category_id) VALUES (:task, :category_id)";

$statement = $conn->prepare($sql);

$statement->bindParam(':task', $task);

$statement->bindParam(':category_id', $category_id);

try{
    if($statement->execute()){

    echo json_encode(['msg' => 'Data Inserted Successfully!', 'status' => true]);

}else {

        echo json_encode(['msg' => 'No data', 'status' => false]);
    }
}catch (Exception $e){
    print_r($e);
    exit();
}


?>