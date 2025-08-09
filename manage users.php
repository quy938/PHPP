<?php
// Repository: php-rest-api-users
// Description: A RESTful API for managing users with CRUD operations.

header("Content-Type: application/json");

// Simulated database
$users = [];

/**
 * Handle HTTP methods for user management.
 */
$requestMethod = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($requestMethod) {
    case 'GET':
        echo json_encode($users);
        break;

    case 'POST':
        if (!isset($input['name']) || !isset($input['email'])) {
            http_response_code(400);
            echo json_encode(["error" => "Invalid input"]);
            break;
        }
        $newUser = [
            "id" => count($users) + 1,
            "name" => $input['name'],
            "email" => $input['email']
        ];
        $users[] = $newUser;
        echo json_encode($newUser);
        break;

    case 'DELETE':
        $id = $_GET['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(["error" => "ID is required"]);
            break;
        }
        $users = array_filter($users, function ($user) use ($id) {
            return $user['id'] != $id;
        });
        echo json_encode(["message" => "User deleted"]);
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Method not allowed"]);
}
?>
