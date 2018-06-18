<?php
$app->get('/quest', function($request, $response, $args){
    $response = array();
    $directory = $this->get('upload_directory'); 
    $response['loc'] = $directory;
    return $this->response->withJson($response)->withStatus(200);
});

$app->post('/addQuestions', function($request, $response){
    $response = array();
    $r = json_decode($request->getBody());
    verifyRequiredParams(array('filename','username','course_id','explanation'),$r);
    $db = new DbHandler();
    // $data = $request->getParsedBody();

    // $course_id = $r->course;
    $fileName = $r->filename;
    $name = $r->username;
    $course_id = $r->course_id;
    $explanation = $r->explanation;
    $picked = "";
    
    $directory = $this->get('upload_directory');    

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

$app->post('/testopt', function($request, $response){
    $db = new DbHandler();
    $response = array();
    $r = json_decode($request->getBody());
    verifyRequiredParams(array('limit'),$r);
    $cid = $r->course_id;
    $qid = $r->qid;
    $respopt = $db->getAllrecords("SELECT * FROM options WHERE course_id = $cid  and qid = $qid ORDER BY RAND()");
    $response["status"] = "success";
    $response["options"] = array();
    $test = array();
    while($options = $respopt->fetch_assoc()) {
        $tmpopt = array();
        $tmpopt["name"] = $options["name"];
        $tmpopt["id"] = $options["qid"] . '.' . $options['id'];
        array_push($response["options"], $tmpopt);
    }
    return $this->response->withJson($response)->withStatus(200);
});


$app->post('/setgetquestions', function($request, $response){
    $db = new DbHandler();
    $response = array();
    $r = json_decode($request->getBody());
    verifyRequiredParams(array('course_id', 'limit'),$r);
    $cid = $r->course_id;
    $limit = $r->limit;
    $respopt = $db->getAlleasy("SELECT qid FROM questions WHERE course_id = $cid ORDER BY RAND() limit $limit");
    $response["status"] = "success";    $test = array();
    $response['message'] = $respopt;
    return $this->response->withJson($response)->withStatus(200);
});

$app->post('/getQuestions', function($request, $response){
    $db = new DbHandler();
    $response = array();
    $r = json_decode($request->getBody());
    verifyRequiredParams(array('limit'),$r);
    $cid = $r->course_id;
    // $qid = $r->qid;
    $limit = $r->limit;
    $setquestions = $r->questionsselected;
    for($i = 0; $i < count($setquestions); $i++){
        foreach($setquestions as $qRow){ 
            $qid = $qRow->qid;
            $resp = $db->getAllrecords("SELECT * FROM questions WHERE course_id = $cid and qid = $qid limit $limit");
            $respopt = $db->getAllrecords("SELECT * FROM options WHERE course_id = $cid  and qid = $qid limit $limit");
            $response["status"] = "success";
            $response["questions"] = array();
            $optio = array();
            while($options = $respopt->fetch_assoc()) {
                $tmpopt = array();
                $tmpopt["name"] = $options["name"];
                $tmpopt["id"] = $options["qid"] . '.' . $options['id'];
                array_push($optio, $tmpopt);
            }
            while($questions = $resp->fetch_assoc()) {
                $tmp = array();
                $tmp["id"] = $questions["id"];
                $tmp["question"] = $questions["question"];
                $tmp["answer"] = $questions["correct_option"];
                $tmp["options"] = $optio;
                $tmp["explanation"] = $questions["explanation"];
                $tmp["isAnswered"] = $questions["isAnswered"];
                $tmp["picked"] = $questions["picked"];
                array_push($response["questions"], $tmp);
            }
        }
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