<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Headers, Authorization, X-Requested-With');

require_once 'Database.php';

$instance = Database::getInstance();

$conn = $instance->getConnection();

$data = json_decode(file_get_contents('php://input'), true);

$id = $data['id'];

$task = $data['task'];

$category_id = $data['category_id'];

$completed = $data['completed'];

$sql = "UPDATE  todo_items SET task = :task, category_id = :category_id, completed= :completed WHERE id = :id";

$statement = $conn->prepare($sql);

$statement->bindParam(':id', $id);

$statement->bindParam(':task', $task);

$statement->bindParam(':category_id', $category_id);

$statement->bindParam(':completed', $completed);

try{
    if($statement->execute()){

        echo json_encode(['msg' => 'Data updated Successfully!', 'status' => true]);

    }else {

        echo json_encode(['msg' => 'No data', 'status' => false]);
    }

}catch (Exception $e){
    print_r($e);
    exit();
}
?>

