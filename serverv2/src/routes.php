<?php
// Routes
$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', 'http://localhost:4200/')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

$app->post('/registerDetails', function($request, $response){
	$data = json_decode($request->getBody());
	$handler = new IOhandler;
	$username = $data->name;
	$email = $data->email;
	$file = $data->file;
	$fields = array('username', 'email', 'thefile');
	$values = array($username, $email, $file);
	$sth = $handler->insert('details', $fields , $values);
	return $this->response->withJson($sth)->withStatus(200);
});


$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function($req, $res) {
    $handler = $this->notFoundHandler; // handle using the default Slim page not found handler
    return $handler($req, $res);
});

