<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Headers, Authorization, X-Requested-With');

require_once 'Database.php';

$instance = Database::getInstance();

$conn = $instance->getConnection();

$data = json_decode(file_get_contents('php://input'), true);

$id = $_GET['id'];

$sql = "DELETE FROM todo_items WHERE id = :id";

$statement = $conn->prepare($sql);

$statement->bindParam(':id', $id);

$statement->execute();

$affectedRows = $statement->rowCount();

if ($affectedRows > 0) {
    echo 'ID ' . $id . ' was deleted successfully.';
} else {
    echo 'ID ' . $id . ' not found or already deleted.';
}

?>