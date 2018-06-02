<?php
//Gets all the admins in the database
$app->get('/viewAdmin',  function($request, $response){
    $db = new DbHandler();
    $response = array();
    $resp = $db->getAllRecords("SELECT * FROM admins WHERE 1");

    $response["status"] = "success";
    $response["admins"] = array();

    while ($admin = $resp->fetch_assoc()) {
            $tmp = array();
            $tmp["_id"] = $admin["_id"];
            $tmp["firstname"] = $admin["firstname"];
            $tmp["lastname"] = $admin["lastname"];
            $tmp["email"] = $admin["email"];
            $tmp["matric"] = $admin["matric"];
            $tmp["department"] = $admin["department"];
            $tmp["college"] = $admin["college"];
            $tmp["level"] = $admin["level"];
            $tmp["role"] = $admin["role"];
            $tmp["date_created"] = $admin["date_created"];
            $tmp["date_modified"] = $admin["date_modified"];
            $tmp["created_by"] = $admin["created_by"];
            $tmp["active"] = $admin["active"];
            array_push($response["admins"], $tmp);
        }
    // echoResponse(200, $response);
    return $this->response->withJson($response)->withStatus(200);
});

$app->post('/addAdmin',  function($request, $response){
    $response = array();
    $r = json_decode($request->getBody());
    verifyRequiredParams(array('username', 'password', 'email', 'lastname',  'firstname', 'department', 'college', 'matric', 'role', 'level'),$r);
    require_once 'passwordHash.php';
    $db = new DbHandler();
    $username = $r->username;
    $password = $r->password;
    $email = $r->email;
    $lastname = $r->lastname;
    $firstname = $r->firstname;
    $department = $r->department;
    $college = $r->college;
    $matric = $r->matric;
    $role = $r->role;
    $level = $r->level;
    $created_by = $r->created_by;

    $isUserExists = $db->getOneRecord("select 1 from admins where username='$username' or email='$email' or matric='$matric'");
    if(!$isUserExists){
            $r->password = passwordHash::hash($password);
            $table_name = "admin";
            $column_names = array('username', 'password', 'email', 'lastname', 'firstname', 'department', 'college', 'matric', 'role', 'level', 'created_by');
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
//METHODS IN REST: GET, POST, PUT
$app->put('/editAdmin/{id}',  function($request, $response, $id){
    $response = array();
    $r = json_decode($request->getBody());
    $id = $id['id'];
    $condition = array('_id'=>$id);
    verifyRequiredParams(array('username', 'password', 'email', 'lastname',  'firstname', 'department', 'college', 'matric', 'role', 'level'),$r);
    require_once 'passwordHash.php';
    $db = new DbHandler();
    $username = $r->username;
    $password = $r->password;
    $email = $r->email;
    $lastname = $r->lastname;
    $firstname = $r->firstname;
    $department = $r->department;
    $college = $r->college;
    $matric = $r->matric;
    $role = $r->role;
    $level = $r->level;

            $r->password = passwordHash::hash($password);
            $table_name = "admins";
            $column_names = array('username', 'password', 'email', 'lastname', 'firstname', 'department', 'college', 'matric', 'role', 'level');
            $result = $db->updateTable($r,$table_name,$condition);
            if ($result != NULL) {
            $response["status"] = "success";
            $response["message"] = "Update was success";
            // echoResponse(200, $response);
            return $this->response->withJson($response)->withStatus(200);
        } else {
            $response["status"] = "error";
            $response["message"] = "Failed to edit admin. Please try again";
            // echoResponse(201, $response);
            return $this->response->withJson($response)->withStatus(201);
        }
});

$app->delete('/deleteAdmin/{id}',  function($request, $response, $id){
    $response = array();
    $r = json_decode($request->getBody());
    $id = $id['id'];
    $condition = array('_id'=>$id);
    $db = new DbHandler();
            $table_name = "admins";
            $result = $db->deleteTable($table_name,$condition);
            if ($result != NULL) {
            $response["status"] = "success";
            $response["message"] = "Delete was success";
            // echoResponse(200, $response);
            return $this->response->withJson($response)->withStatus(200);
        } else {
            $response["status"] = "error";
            $response["message"] = "Failed to delete admin. Please try again";
            // echoResponse(201, $response);
            return $this->response->withJson($response)->withStatus(201);
        }
});

 ?>
