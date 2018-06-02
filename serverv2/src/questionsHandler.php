<?php
$app->post('/addQuestions', function($request, $response, $args){
    $response = array();
    $r = json_decode($request->getBody());
    $db = new DbHandler();
    // $data = $request->getParsedBody();

    // $course_id = $r->course;
    $course_id = 1;

    $files = $request->getUploadedFiles();
    $directory = $this->get('upload_directory');
    if (empty($files['questions'])) {
        throw new Exception('Expected a file');
    }
    $file = $files['questions'];

    if ($file->getError() === UPLOAD_ERR_OK) {
        $fileName = $file->getClientFilename();
        $file->moveTo("$directory\\$fileName");
        // $response['status'] = "success";
        // $response['message'] = $files;
        // $response['filename'] = $fileName;
        // $response['filedir'] = $file;
        // $response['filesee'] = "$directory\\$fileName";
    }else{
        $response["status"] = "erroe";
        $response["message"] = "error uploading file";
        return $this->response->withJson($response)->withStatus(200);
    }

    $fileloc = $directory . '\\'. $fileName;

    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
    $reader->setReadDataOnly(TRUE);
    $spreadsheet = $reader->load($fileloc);
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
        $course_id = $course_id++;
        $question = $db->clean_input( $row['question'] );
        $option_a = $db->clean_input( $row['option_a'] );
        $option_b = $db->clean_input( $row['option_b'] );
        $option_c = $db->clean_input( $row['option_c'] );
        $option_d = $db->clean_input( $row['option_d'] );
        $correct_option = $db->clean_input( $row['correct_option'] );
        $valuesArr[] = "('$course_id', '$question', '$option_a', '$option_b', '$option_c', '$option_d', '$correct_option')";
    }

    $sql .= implode(',', $valuesArr);
    $result = $db->insertloop($sql);
    if ($result == true) {
        $response["status"] = "success";
        $response["message"] = "questions uploaded";
        // echoResponse(200, $response);
        return $this->response->withJson($response)->withStatus(200);
    } else {
        $response["status"] = "main error";
        $response["message"] = "main error uploading question";
        // echoResponse(201, $response);
        return $this->response->withJson($response)->withStatus(201);
    }
    // return $result;
});

$app->post('/getQuestions', function($request, $response){
    $db = new DbHandler();
    $response = array();
    $r = json_decode($request->getBody());
    verifyRequiredParams(array('limit'),$r);
    $limit = $r->limit;
    $resp = $db->getAllrecords("SELECT * from questions ORDER BY RAND()");
    $response["status"] = "success";
    $response["questions"] = array();
    while($questions = $resp->fetch_assoc()) {
        $tmp = array();
        $options = array();
        $options['option_a'] = $questions['option_a']; 
        $options['option_b'] = $questions['option_b']; 
        $options['option_c'] = $questions['option_c']; 
        $options['option_d'] = $questions['option_d']; 
        $tmp["id"] = $questions["id"];
        $tmp["question"] = $questions["question"];
        $tmp["answer"] = $questions["correct_option"];
        $tmp["options"] = $options;
        $tmp["explanation"] = $questions["explanation"];
        $tmp["isAnswered"] = $questions["isAnswered"];
        $tmp["picked"] = $questions["picked"];
        
        array_push($response["questions"], $tmp);
        array_push($options, $options);
    }
    return $this->response->withJson($response)->withStatus(200);
});

?>