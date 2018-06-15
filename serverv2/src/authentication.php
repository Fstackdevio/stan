<?php //all functions here handle the student authentication apis
$app->get('/session', function($request, $response){
    $db = new DbHandler();
    $session = $db->getStuSession();
    $response = array();
    $response["_id"] = $session['_id'];
    $response["username"] = $session['username'];
    $response["fullName"] = $session['fullName'];
    $response["level"] = $session['level'];
    //$response["active"] = $session['active'];
    $response["department"] = $session['department'];
    $response["reg_number"] = $session['reg_number'];
    // echoResponse(200, $session);
    return $this->response->withJson($session)->withStatus(200);
});

$app->post('/login', function($request, $response){
    require_once 'passwordHash.php';
    $r = json_decode($request->getBody());
    verifyRequiredParams(array('username', 'password'),$r);
    $response = array();
    $db = new DbHandler();
    $password = $r->password;
    $username = $r->username;
    $user = $db->getOneRecord("select _id,fullName, username, level, active,reg_number,department from users where username='$username'");
    if ($user != NULL) {
        /*if(passwordHash::check_password($user['password'],$password)){*/
          if($user['active'] == 1){
            $response['status'] = "success";
            $response['message'] = 'Login was successful';
            $response['_id'] = $user['_id'];
            $response['username'] = $user['username'];
            $response['fullName'] = $user['fullName'];
            $response['level'] = $user['level'];
            $response['reg_number'] = $user['reg_number'];
            $response['department'] = $user['department'];
            $response['active'] = $user['active'];
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['_id'] = $user['_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['fullName'] = $user['fullName'];
            $_SESSION['level'] = $user['level'];
            $_SESSION['reg_number'] = $user['reg_number'];
            $_SESSION['department'] = $user['department'];
            $_SESSION['active'] = $user['active'];

            // echoResponse(200, $response);
            return $this->response->withJson($response)->withStatus(200);
          }else{
            $response['status'] = "error";
            $response['message'] = 'Login failed. Your are not verified for this course';
            // echoResponse(201, $response);
            return $this->response->withJson($response)->withStatus(201);
          }
            //}
         /*else {
            $response['status'] = "error";
            $response['message'] = 'Login failed. Incorrect credentials';
            echoResponse(201, $response);
        }*/
    }else {
            $response['status'] = "error";
            $response['message'] = 'No such user is registered';
            // echoResponse(201, $response);
            return $this->response->withJson($response)->withStatus(201);
        }

});

$app->post('/forgotPass', function($request, $response){
    require_once 'passwordHash.php';
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('email'),$r);
    $response = array();
    $db = new DbHandler();
    $email = $r->email;
    $user = $db->getOneRecord("select _id, username, email from admin where email='$email' or username='$email'");
    if ($user != NULL && sendResetMail($user['username'],$user['email'])) {
        $response['status'] = "success";
        $response['message'] = 'Password Reset Code has been sent to your email';
    }else {
            $response['status'] = "error";
            $response['message'] = 'Email address does not exist';
        }
    // echoResponse(200, $response);
    return $this->response->withJson($response)->withStatus(200);
});

//CREATE ACCOUNT NOT COMPLETED YET
// $app->post('/createAcct', function() use ($app) {
//     $response = array();
//     $r = json_decode($app->request->getBody());





$app->get('/logout', function($request, $response){
    $db = new DbHandler();
    $session = $db->destroyStuSession();
    $response = array();
    $response["status"] = "success";
    $response["message"] = "Logged out successfully";
    // echoResponse(200, $response);
    return $this->response->withJson($response)->withStatus(200);
});


$app->get('/clearExam', function($request, $response){
    $db = new DbHandler();
    $isCleared = $db->clearExamSession();
    $response = array();
    if($isCleared){
        $response["status"] = "success";
        $response["message"] = "Exam Data cleared successfully";
    } else {
        $response["status"] = "error";
        $response["message"] = "An error occurrred";
    }
    // echoResponse(200, $response);
    return $this->response->withJson($response)->withStatus(200);
});
?>
