<?php 

$app->post('/initResult', function() use ($app){
    //method to initialize the result row for each exam session...
});

/*function validateUser($id){
    if(empty($id) or (strlen($id) < 1)){
        return;
    } else {
        // validate the user...
    }
};*/

$app->post('/setResult', function($request, $response){
    $r = json_decode($request->getBody());
    verifyRequiredParams(array('userId', 'courseId', 'qnA'),$r);
    $response = array();
    require_once 'scoreHasher.php';

    $db = new DbHandler();
    
    $uid = $r->userId;
    $cid = $r->courseId;
    $qnA = $r->qnA;

    $stuSess = $db->getStuSession();
    $examSess = $db->getExamSession();
    

    if((isset($stuSess['_id'])) && ($stuSess['active'] == 1)){

        if(isset($examSess['examData'])){

            $stuId = $stuSess['_id'];
            $stuActive = $stuSess['active'];
            $uActualData = $db->getOneRecord("SELECT _id, active, username FROM users WHERE _id='$stuId' and active='$stuActive'");
            $eActualData = $db->getOneRecord("SELECT _id FROM exams WHERE _id='$cid' and disabled='0'");

            if(($uActualData['_id'] == $uid) && ($uActualData['active'] == 1) && ($cid == $eActualData['_id'])){
                //to extractttttt
                $qActual = $db->getAllRecords("SELECT qid, correct_option FROM questions WHERE course_id = '$cid'");
                $bodyKount = 0;
                
                for($i = 0; $i < count($qActual); $i++){
                    foreach($qnA as $qRow){
                        if($qRow['qid'] == $qActual['qid']){
                            if($qRow['picked'] == $qActual['correct_option']){
                                $bodyKount += 10; //we're using the 10 point system incase someone tries to send dummy data later on...
                            }
                        }
                    }
                }

                //now we have the actual student score 10x;
                $orig = $bodyKount / 10;

                //chceck for active scores...
                $isActiveExist = $db->getOneRecord("SELECT _id, valid from outcomes WHERE std_id = '$stuId' and course_id = '$cid'");

                if($isActiveExist['valid'] == 1){
                    $updateValidator = $db->updateTable( 'outcomes', array('valid'), "_id='$cid'");
                    if($updateValidator != null){
                       $newResult = $db->insertIntoTable(array($stuId, $orig, 1, $cid), array('std_id', 'score', 'valid', 'course_id'), $table_name);
                       if($newResult != null){
                        $response["status"] = "success";
                        $response["message"] = "Examination Successfull";
                        $statCode = 200;
                        return $this->response->withJson($response)->withStatus($statCode);
                       }
                    } else{
                        $response['status'] = "error";
                        $response['message'] = "Something went wrong...";
                        $statCode = 201;
                        return $this->response->withJson($response)->withStatus($statCode);
                    }
                }else{
                    $response['status'] = "error";
                    $response['message'] = "error getting isactive records";
                    $statCode = 201;
                    return $this->response->withJson($response)->withStatus($statCode);
                }
            }else{
                $response['status'] = "error";
                $response['message'] = "error getting some records";
                $statCode = 201;
                return $this->response->withJson($response)->withStatus($statCode);
            }
        } else {
            $response['status'] = "error";
            $response['message'] = "Something went wrong...";
            $statCode = 201;
            return $this->response->withJson($response)->withStatus($statCode);
        }
    } else{
        $response['status'] = "error";
        $response['message'] = "Invalid Session";
        $statCode = 201;
        return $this->response->withJson($response)->withStatus($statCode);
        
    }
});

$app->get('getResult', function(){
    //method to get result (you can pass a param of how many (int) or all)
});

$app->put('updateResult', function(){
    //method to update the result of a student (while storing as a new row...)
});

?>