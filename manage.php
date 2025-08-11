<?php
// Repository: php-rest-api-users
// New Feature: Update user details via PUT request

case 'PUT':
    $input = json_decode(file_get_contents('php://input'), true);
    $id = $_GET['id'] ?? null;

    if (!$id || !isset($input['name']) || !isset($input['email'])) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid input"]);
        break;
    }

    foreach ($users as &$user) {
        if ($user['id'] == $id) {
            $user['name'] = $input['name'];
            $user['email'] = $input['email'];
            echo json_encode(["message" => "User updated"]);
            return;
        }
    }

    http_response_code(404);
    echo json_encode(["error" => "User not found"]);
    break;
?>
