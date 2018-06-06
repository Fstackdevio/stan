<?php

$app->get('/getStudents', function() {
    $db = new dbHandler();
    $response = array();
    $resp = $db->getAllRecords("SELECT * FROM users");
    
    $response["status"] = "success";
    $response["students"] = array();
    
    while($student = $resp->fetch_assoc()) {
        $tmp = array();
        $tmp["_id"] = $student["_id"];     
        $tmp["username"] = $student["username"];
        $tmp["firstname"] = $student["firstname"];
        $tmp["lastname"] = $student["lastname"];
        $tmp["othername"] = $student["othername"];
        $tmp["fullName"] = $student["fullName"];        
        $tmp["level"] = $student["level"];
        $tmp["department"] = $student["department"];
        $tmp["reg_number"] = $student["reg_number"];
        /*$tmp["matric"] = $user["matric"];
        $tmp["email"] = $user["email"];
        $tmp["phone"] = $user["phone"];
        $tmp["created_by"] =  $user["created_by"];
        $tmp["ip_address"] = $user["ip_address"];
        $tmp["date_created"] = $user["date_created"];
        $tmp["date_modified"] = $user["date_modified"];*/
        array_push($response["students"], $tmp);
    }
    echoResponse(200, $response);
});

/// add Student Api
$app->post('/addStudent', function() use ($app) {
    $response = array();
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('username', 'firstname','lastname','othername','level','reg_number','department','fullname'),$r);
    require_once 'passwordHash.php';
    $db = new DbHandler();
    $username = $r->username;
    $firstname = $r->firstname;
    $lastname = $r->lastname;
    $othername = $r->othername;
    $fullname = $r->fullname;
    $level = $r->level;
    $reg_number = $r->reg_number;
    $department = $r->department;
    /*$lastname = $r->lastname;
    $firstname = $r->firstname;
    $department = $r->department;
    $college = $r->college;
    $matric = $r->matric;
    $role = $r->role;*/
    /*$created_by = $r->created_by;*/

    $isUserExists = $db->getOneRecord("select 1 from users where reg_number='$reg_number'");
    if(!$isUserExists){
            /*$r->password = passwordHash::hash($password);*/
            $r->active = true;
            $table_name = "users";
            $column_names = array('username', 'firstname', 'lastname', 'othername','level','reg_number','department','fullname');
            $result = $db->insertIntoTable($r, $column_names, $table_name);
            if ($result != NULL) {
            $response["status"] = "success";
            $response["message"] = "Student registration successfull";
            echoResponse(200, $response);
        } else {
            $response["status"] = "error";
            $response["message"] = "Failed to register student. Please try again";
            echoResponse(201, $response);
        }
    }else{
        $response["status"] = "error";
        $response["message"] = "Sorry that registration number aleready exists!";
        echoResponse(201, $response);
    }
});
$app->put('/editStudent/:id', function($id) use($app){
    $response = array();
    $r = json_decode($app->request->getBody());
    $condition = array('_id'=>$id);
    verifyRequiredParams(array('firstname', 'lastname', 'othername', 'username', 'department', 'level','reg_number'),$r);
    $db = new DbHandler();
    $firstname = $r->firstname;
    $lastname = $r->lastname;
    $othername = $r->othername;
    $username = $r->username;
    $department = $r->department;
    $level = $r->level;
    $reg_number = $r->reg_number;
    /*$room =$r->room;
    $reg_no = $r->reg_no;
    $matric = $r->matric;
    $email = $r->email;
    $phone = $r->phone;*/

    $table_name = "users";
    $coloum_name = array('firstname', 'lastname', 'othername', 'username', 'department', 'level', 'reg_number');
    $result = $db->updateTable($r,$table_name,$condition);
    if($result != null){
        $response["status"] = "success";
        $response["message"] = "Student Updated successfully";
        echoResponse(200, $response);
    }
    else{
        $response["status"] = "error";
        $response["message"] = "Update Failed";
        echoResponse(201, $response);
    }
});

$app->delete('/deleteStd/:id', function($id) use($app){
    $response = array();
    $r = json_decode($app->request->getBody());
    $condition = array('_id'=>$id);

    $db = new dbHandler();
    $table_name = "users";
    $result = $db->deleteTable($table_name, $condition);
    if($result != null){
        $response["status"] = "success";
        $response["message"] = "Delete Successfull";
        echoResponse(200, $response);
    }
    else{
        $response["status"] = "error";
        $response["message"] = "Delete Unsuccessfull";
        echoResponse(201, $response);
    }
});
?>