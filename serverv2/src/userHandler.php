<?php

$app->get('/viewUser', function($request, $response){
    $db = new dbHandler();
    $response = array();
    $resp = $db->getAllRecords("SELECT * FROM users");
    
    $response["status"] = "success";
    $response["users"] = array();
    
    while($user = $resp->fetch_assoc()) {
        $tmp = array();
        $tmp["_id"] = $user["id"];
        $tmp["firstname"] = $user["firstname"];
        $tmp["lastname"] = $user["lastname"];
        $tmp["othername"] = $user["othername"];
        $tmp["college"] = $user["college"];
        $tmp["department"] = $user["department"];
        $tmp["level"] = $user["level"];
        $tmp["hall"] = $user["hall"];
        $tmp["room"] = $user["room"];
        $tmp["reg_no"] = $user["reg_no"];
        $tmp["matric"] = $user["matric"];
        $tmp["email"] = $user["email"];
        $tmp["phone"] = $user["phone"];
        $tmp["created_by"] =  $user["created_by"];
        $tmp["ip_address"] = $user["ip_address"];
        $tmp["date_created"] = $user["date_created"];
        $tmp["date_modified"] = $user["date_modified"];
        array_push($response["users"], $tmp);
    }
    // echoResponse(200, $response);
    return $this->response->withJson($response)->withStatus(200);
});
$app->post('/newStudent', function() use ($app) {
    $response = array();
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('username', 'password','level'),$r);
    require_once 'passwordHash.php';
    $db = new DbHandler();
    $username = $r->username;
    $password = $r->password;
    $fullName = $r->firstName . "." . $r->lastName;
    /*$lastname = $r->lastname;
    $firstname = $r->firstname;
    $department = $r->department;
    $college = $r->college;
    $matric = $r->matric;
    $role = $r->role;*/
    $level = $r->level;
    /*$created_by = $r->created_by;*/

    $isUserExists = $db->getOneRecord("select 1 from users where username='$username'");
    if(!$isUserExists){
            $r->password = passwordHash::hash($password);
            $table_name = "users";
            $column_names = array('username', 'password', 'fullName', 'level');
            $result = $db->insertIntoTable($r, $column_names, $table_name);
            if ($result != NULL) {
            $response["status"] = "success";
            $response["message"] = "Admin account created";
            // echoResponse(200, $response);
            return $this->response->withJson($response)->withStatus(200);
        } else {
            $response["status"] = "error";
            $response["message"] = "Failed to create admin. Please try again";
            // echoResponse(201, $response);
            return $this->response->withJson($response)->withStatus(201);
        }
    }else{
        $response["status"] = "error";
        $response["message"] = "Admin account exists!";
        // echoResponse(201, $response);
        return $this->response->withJson($response)->withStatus(201);
    }
});
/*$app->post('/addUser', function() use ($app) {
    $response = array();
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('firstname', 'lastname', 'othername', 'college', 'department', 'level', 'hall', 'room', 'reg_no', 'matric', 'email', 'phone', 'created_by'),$r);
    $db = new DbHandler();
    $firstname = $r->firstname;
    $lastname = $r->lastname;
    $othername = $r->othername;
    $college = $r->college;
    $department = $r->department;
    $level = $r->level;
    $hall = $r->hall;
    $room = $r->room;
    $reg_no = $r->reg_no;
    $matric = $r->matric;
    $email = $r->email;
    $phone = $r->phone;
    $created_by = $r->created_by;

    $isUserExists = $db->getoneRecord("SELECT 1 from users where firstname='$firstname' or reg_no='$reg_no' or matric='$matric' or email='$email'");
    if(!$isUserExists){
        $table_name = "users";
        $coloum_name = array('firstname', 'lastname', 'othername', 'college', 'department', 'level', 'hall', 'room', 'reg_no', 'matric', 'email', 'phone', 'created_by');
        $result = $db->insertIntoTable($r, $coloum_name, $table_name);
        if($result != null){
            $response["status"] = "success";
            $response["message"] = "User Added";
            echoResponse(200, $response);
        }
        else{
            $response["status"] = "error";
            $response["message"] = "Error Trying To Add User";
            echoResponse(201, $response);
        }}
        else {
            $response["status"] = "error";
            $response["message"] = "User Already Exist";
            echoResponse(201, $response);
        }
});*/

$app->put('/editUser/{id}', function($request, $response, $id){
    $response = array();
    $r = json_decode($app->request->getBody());
    $id = $id['id'];
    $condition = array('_id'=>$id);
    verifyRequiredParams(array('firstname', 'lastname', 'othername', 'college', 'department', 'level', 'hall', 'room', 'reg_no', 'matric', 'email', 'phone'),$r);
    $db = new DbHandler();
    $firstname = $r->firstname;
    $lastname = $r->lastname;
    $othername = $r->othername;
    $college = $r->college;
    $department = $r->department;
    $level = $r->level;
    $hall = $r->hall;
    $room =$r->room;
    $reg_no = $r->reg_no;
    $matric = $r->matric;
    $email = $r->email;
    $phone = $r->phone;

    $table_name = "users";
    $coloum_name = array('firstname', 'lastname', 'othername', 'college', 'department', 'level', 'hall', 'room', 'reg_no', 'matric', 'email', 'phone');
    $result = $db->updateTable($r, $coloum_name, $table_name);
    if($result != null){
        $response["status"] = "success";
        $response["message"] = "Update successfull";
        // echoResponse(200, $response);
        return $this->response->withJson($response)->withStatus(200);
    }
    else{
        $response["status"] = "error";
        $response["message"] = "Update Failed";
        // echoResponse(201, $response);
        return $this->response->withJson($response)->withStatus(201);
    }
});

$app->delete('/deleteUser/{id}', function($request, $response, $id){
    $response = array();
    $r = json_decode($request->getBody());
    $id = $id['id'];
    $condition = array('_id'=>$id);

    $db = new dbHandler();
    $table_name = "users";
    $result = $db->deleteTable($table_name, $condition);
    if($result != null){
        $response["status"] = "success";
        $response["message"] = "Delete Successfull";
        // echoResponse(200, $response);
        return $this->response->withJson($response)->withStatus(200);
    }
    else{
        $response["status"] = "error";
        $response["message"] = "Delete Unsuccessfull";
        // echoResponse(201, $response);
        return $this->response->withJson($response)->withStatus(201);
    }
});
?>