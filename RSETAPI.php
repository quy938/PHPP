<?php
header("Content-Type: application/json");

$users = [
    ["id" => 1, "name" => "John", "age" => 30],
    ["id" => 2, "name" => "Jane", "age" => 25]
];

$requestMethod = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($requestMethod) {
    case 'GET':
        echo json_encode($users);
        break;

    case 'POST':
        if (!isset($input['name']) || !isset($input['age'])) {
            http_response_code(400);
            echo json_encode(["error" => "Invalid input"]);
            break;
        }
        $newUser = [
            "id" => count($users) + 1,
            "name" => $input['name'],
            "age" => $input['age']
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
