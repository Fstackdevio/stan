<?php //all functions here handle the admin auth and vars are preceeded by admin_ or links by adminLink e.g adminLogin
    $app->get('/adminSession', function($request, $response){
    $db = new DbHandler();
    $session = $db->getAdminSession();
    $response = array();
    $response["_id"] = $session['admin_id'];
    $response["username"] = $session['admin_username'];
    $response["fullName"] = $session['admin_fullName'];
    $response["active"] = $session['admin_active'];
    //$response["active"] = $session['active'];
    $response["access"] = $session['admin_access'];
    $response["course"] = $session['admin_course'];
    // echoResponse(200, $session);
    return $this->response->withJson($session)->withStatus(200);
    });

    $app->post('/adminLogin', function($request, $response){
    require_once 'passwordHash.php';
    $r = json_decode($request->getBody());
    verifyRequiredParams(array('username', 'password'),$r);
    $response = array();
    $db = new DbHandler();
    $password = $r->password;
    $username = $r->username;
    $user = $db->getOneRecord("select _id,fullName,username,password,active,access,course from admins where username='$username'");
    if ($user != NULL) {
        if(passwordHash::check_password($user['password'],$password)){
          if($user['active'] == 1){
            $response['status'] = "success";
            $response['message'] = 'Login was successful';
            $response['_id'] = $user['_id'];
            $response['username'] = $user['username'];
            $response['fullName'] = $user['fullName'];
            $response['active'] = $user['active'];
            $response['access'] = $user['access'];
            $response['course'] = $user['course'];
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['admin_id'] = $user['_id'];
            $_SESSION['admin_username'] = $user['username'];
            $_SESSION['admin_fullName'] = $user['fullName'];
            $_SESSION['admin_active'] = $user['active'];
            $_SESSION['admin_access'] = $user['access'];
            $_SESSION['admin_course'] = $user['course'];

            // echoResponse(200, $response);
            return $this->response->withJson($response)->withStatus(200);
          }else{
            $response['status'] = "error";
            $response['message'] = 'Login failed. That account is not active';
            // echoResponse(201, $response);
            return $this->response->withJson($response)->withStatus(201);
          }
            }
         else {
            $response['status'] = "error";
            $response['message'] = 'Login failed. Incorrect credentials';
            // echoResponse(201, $response);
            return $this->response->withJson($response)->withStatus(201);
        }
    }else {
            $response['status'] = "error";
            $response['message'] = 'User does not exist';
            // echoResponse(201, $response);
            return $this->response->withJson($response)->withStatus(201);
        }

});
    $app->get('/adminLogout', function($request, $response){
    $db = new DbHandler();
    $response = array();
    $session = $db->destroyAdminSession();
    $response["status"] = "info";
    $response["message"] = "Logged out successfully";
    // echoResponse(200, $response);
    return $this->response->withJson($response)->withStatus(200);
});
?>