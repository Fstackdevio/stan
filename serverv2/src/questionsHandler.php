<?php
$app->get('/', function ($request, $response, $args) {
    $response->write("Welcome to Slim!");
    return $response;
});

$app->post('/addQuestions', function ($request, $response, $args) {
    $response = array();
    $r = json_decode($request->getBody());
    // $data = $request->getParsedBody();

    $course_id = $r->course;

    $files = $request->getUploadedFiles();
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

    // $table_name = "users";
    // $column_names = array(`course_id`,`question`,`option_a`,`option_b`,`option_c`,`option_d`,`correct_option`);
    // $result = $db->insertIntoTable($r, $column_names, $table_name);

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
    if($conn->query($sql)){
		$response['status'] = 200;
		$response['message'] = 'success';
    }else{
		$response['status'] = 201;
		$response['message'] = 'error';
    }
    return json_encode($response);
    // $questions = json_encode($questions);

    // return $questions;

});

?>