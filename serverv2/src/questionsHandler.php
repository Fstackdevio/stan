<?php
$app->post('/addQuestions', function($request, $response, $args){
    $response = array();
    $r = json_decode($request->getBody());
    $db = new DbHandler();
    // $data = $request->getParsedBody();

    // $course_id = $r->course;
    $course_id = 1;
    $explanation = "";
    $picked = "";
    $name = "test";

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
        $temp['qid'] = $data['A'];
        $temp['question'] = $data['B'];
        $temp['option_a'] = $data['C'];
        $temp['option_b'] = $data['D'];
        $temp['option_c'] = $data['E'];
        $temp['option_d'] = $data['F'];
        $temp['correct_option'] = $data['G'];

        array_push($questions,$temp);
    }


    $sql = "INSERT INTO `questions` (`qid`, `course_id`,`question`,`name`,  `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `explanation`, `picked`) VALUES ";
    $sql2 = "INSERT INTO `options` (`qid`, `name`, `course_id`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`) VALUES ";
    $valuesArr = array();
    $optionArr = array();
    foreach($questions as $row){
        $course_id = $course_id++;
        $qid = $db->clean_input( $row['qid'] );
        $question = $db->clean_input( $row['question'] );
        $option_a = $db->clean_input( $row['option_a'] );
        $option_b = $db->clean_input( $row['option_b'] );
        $option_c = $db->clean_input( $row['option_c'] );
        $option_d = $db->clean_input( $row['option_d'] );
        $correct_option = $db->clean_input( $row['correct_option'] );
        $valuesArr[] = "('$qid', '$course_id', '$question', '$name', '$option_a', '$option_b', '$option_c', '$option_d', '$correct_option', '$explanation', '$picked')";
        $optionArr[] = "('$qid', '$course_id', '$name', '$option_a', '$option_b', '$option_c', '$option_d', '$correct_option')";
    }

    $sql .= implode(',', $valuesArr);
    $sql2 .= implode(',', $optionArr);
    $result = $db->insertloop($sql);
    $result2 = $db->insertloop($sql2);
    if ($result && $result2 == true) {
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
    // return $result2;
});

$app->post('/getQuestions', function($request, $response){
    $db = new DbHandler();
    $response = array();
    $r = json_decode($request->getBody());
    verifyRequiredParams(array('limit'),$r);
    // $limit = $r->limit;
    // $qid = $r->qid;
    // $cid = $r->cid;
    $resp = $db->getAllrecords("SELECT * from questions ORDER BY RAND()");
    $response["status"] = "success";
    $response["questions"] = array();
    $test = array();
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
        array_push($test, $options);
    }
    return $this->response->withJson($response)->withStatus(200);
});

$app->get('/testgetq', function($request, $response){
    $db = new DbHandler();
    $response = array();
    $r = json_decode($request->getBody());
    verifyRequiredParams(array('limit'),$r);
    $resp = $db->getAllrecords("SELECT * from questions ORDER BY RAND()");
    $response["status"] = "success";
    $response["questions"] = $resp;
    return $this->response->withJson($response);
});
?>