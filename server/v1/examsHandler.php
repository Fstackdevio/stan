<?php
$app->get('/getExams', function() {
    $db = new DbHandler();
    $response = array();
    $resp = $db->getAllRecords("SELECT * FROM exams WHERE 1");

    $response["status"] = "success";
    $response["exams"] = array();

    while ($exams = $resp->fetch_assoc()) {
        $tmp = array();
        $tmp["_id"] = $exams["_id"];
        $tmp["name"] = $exams["name"];
        $tmp["pwd"] = $exams["pwd"];
        $tmp["duration"] = $exams["duration"];
        $tmp["instructions"] = $exams["instructions"];
        $tmp["disabled"] = $exams["disabled"];
        $tmp["unit"] = $exams["unit"];
        $tmp["instructor"] =$exams["instructor"];
       /* $tmp["date_created"] = $exam["date_created"];
        $tmp["date_modified"] = $exam["date_modified"];*/
        array_push($response["exams"], $tmp);
    }
    echoResponse(200, $response);
});

$app->post('/setExam', function() use ($app){
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('name', 'duration'),$r);
    $response = array();

    //store the given item in the session
    if(!isset($_SESSION['examData'])){
        session_start();
        foreach ($r as $key => $value) {
            $_SESSION['examData'][$key] = $value;
        }
    }

    //crosscheck to be sure it's not empty
    if(isset($_SESSION['examData']['name'])){
        $response['status'] = 'success';
        $response['message'] = "Successfully stored exam data.";
        // $response['info'] = $_SESSION['examData'];
    } else {
        $response['status'] = 'error';
        $response['message'] = "An unknown error occurred.";
    }

    echoResponse(200, $response);
});

//api to add exam to the database
$app->post('/addExam', function() use ($app) {
    $response = array();
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('name', 'pwd', 'duration', 'instructions', 'unit', 'instructor'),$r);
    $db = new DbHandler();
    $name = $r->name;
    $pwd = $r->pwd;
    $duration = $r->duration;
    $instructions = $r->instructions;
    $disabled = $r->disabled;
    $unit = $r->unit;
    $instructor =$r->instructor;
    
    $isExamExist = $db->getOneRecord("SELECT 1 from exams WHERE name='$name'");
    if(!$isExamExist){
        $table_name = "exams";
        $coloum_names = array('name',  'pwd', 'duration', 'instructions', 'disabled', 'unit', 'instructor');
        $result = $db->InsertIntoTable($r, $coloum_names, $table_name);
        if($result != null){
            $response["status"] = "success";
            $response["message"] = "Exam Successfully Added";
            echoResponse(200, $response);
        }
        else {
            $response["status"] = "error";
            $respnse["message"] = "Error while adding exam please try again";
            echoResponse(201, $response);
        }}
        else{
            $response["status"] = "error";
            $response["message"] = "Exam Already Exists";
            echoResponse(201, $response);        
        }
    });

// This specific function is to Edit the exam

$app->put('/editExam/:id', function($id) use ($app) {
    $response = array();
    $r = json_decode($app->request->getBody());
    $condition = array('_id'=>$id);
    verifyRequiredParams(array('name', 'instructions', 'unit', 'duration', 'pwd', 'disabled', 'instructor'),$r);
    $db = new DbHandler();
    $name = $r->name;
    $instructions = $r->instructions;
    $unit = $r->unit;
    $duration = $r->duration;
    $pwd = $r->pwd; 
    $disabled = $r->disabled;
    $instructor = $r->instructor;
    //$ip_address = $r->ip_address;
    
    $table_name ="exams";
    $coloum_names = array('name', 'instructions', 'unit', 'duration', 'pwd', 'disabled', 'instructor');
    $result = $db->UpdateTable($r,$table_name,$condition);
    if($result != null) {
        $response["status"] = "Success";
        $response["message"] = "Exam Updated Successfully";
        echoResponse(200, $response);
    }
    else{
        $response["status"] = "Error";
        $response["message"] = "Exam Update Failed";
        echoResponse(201, $response);
    }
});

$app->delete('/deleteExam/:id', function($id) use($app) {
    $response = array();
    $r = json_decode($app->request->getBody());
    $condition = array('_id'=>$id);
    
    $db = new DbHandler();
    $table_name = "exams";
    $result = $db->deleteTable($table_name, $condition);
    if ($result != null) {
        $response["status"] = "success";
        $response["message"] = "Delete Successful";
        echoResponse(200, $response);
    }
    else {
        $response["status"] = "error";
        $response["message"] = "Error Occured";
        echoResponse(201, $response);
    }
}); 
?>