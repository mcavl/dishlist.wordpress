<?php
    // Domain
    include_once $_SERVER["DOCUMENT_ROOT"] . "/api/core/domain/ErrorMessage.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/api/core/domain/User/User.php";

    // Service
    include_once $_SERVER["DOCUMENT_ROOT"] . "/api/core/service/SUser.php";

    // Headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    // Check HTTP Method
    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        // User
        $user = json_decode(file_get_contents("php://input"));

        // Check values
        if(!empty($user->id) && !empty($user->name) && !empty($user->phone)){
            
            // Create new user user
            $sUsers = new SUser();
            $result = $sUsers->Update($user);

            // Check if user was updated
            if($result){
                // set response code - 200 Created
                http_response_code(200);
            
                // User in json format
                echo json_encode($user);

                // Stop execution
                return;
            }
        }

        // Set response code - 404 Not found
        http_response_code(404);

        // Erro Message in json format
        echo json_encode(new ErrorMessage(404, "User does not exist."));
        
        // Stop execution
        return;
    }

    // Set response code - 403 Forbidden
    http_response_code(403);
?>