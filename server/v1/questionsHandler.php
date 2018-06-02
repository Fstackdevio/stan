<?php
$app->get('/getQuestions', function() {
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

$app->post('/addExam', function() use ($app){
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('name', 'duration'),$r);
    $response = array();
    $db = new DbHandler();
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

$app->post('/addQuestion', function() use ($app){
    $r = json_decode($app->request->getBody());
    //verifyRequiredParams(array('courseid'),$r);
    $response = array();
    
    // $course_id = $r->courseid;
    $course_id = '1';

    $files = $app->request->getUploadedFiles();
    if (empty($files['questions'])) {
        throw new Exception('Expected a file');
    }
 
    $newfile = $files['questions']->getClientFilename();
    
    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
    $reader->setReadDataOnly(TRUE);
    $spreadsheet = $reader->load($newfile);

    $worksheet = $spreadsheet->getActiveSheet();
    // Get the highest row and column numbers referenced in the worksheet
    $highestRow = $worksheet->getHighestRow(); // e.g. 10
    $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'

    $range = $highestColumn.$highestRow;

    $dataArray = $spreadsheet->getActiveSheet()
    ->rangeToArray(
        'A2:'.$range,     // The worksheet range that we want to retrieve
        NULL,        // Value that should be returned for empty cells
        TRUE,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
        TRUE,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
        TRUE         // Should the array be indexed by cell row and cell column
    );

    $questions = array();
    foreach ($dataArray as $data) {
        $temp = array();
        $temp['question'] = $data['A'];
        $temp['option_a'] = $data['B'];
        $temp['option_b'] = $data['C'];
        $temp['option_c'] = $data['D'];
        $temp['option_d'] = $data['E'];
        $temp['correct_option'] = $data['F'];

        array_push($questions,$temp);
    }

    $sql = "INSERT INTO `questions` (`course_id`,`question`,`option_a`,`option_b`,`option_c`,`option_d`,`correct_option`) VALUES ";
    $valuesArr = array();
    foreach($questions as $row){
        $question = mysqli_real_escape_string($conn, $row['question'] );
        $option_a = mysqli_real_escape_string($conn, $row['option_a'] );
        $option_b = mysqli_real_escape_string($conn, $row['option_b'] );
        $option_c = mysqli_real_escape_string($conn, $row['option_c'] );
        $option_d = mysqli_real_escape_string($conn, $row['option_d'] );
        $correct_option = mysqli_real_escape_string($conn, $row['correct_option'] );
        $valuesArr[] = "('$course_id','$question', '$option_a','$option_b','$option_c','$option_d','$correct_option')";
    }

    $sql .= implode(',', $valuesArr);
    $conn = $db->getconnpermission();
    if(mysqli_query($conn, $sql)){
		$response['status'] = 200;
		$response['message'] = 'success';
    }else{
		$response['status'] = 201;
		$response['message'] = 'error';
    }
    return json_encode($response);
});

?>