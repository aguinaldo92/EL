<?php 

$app->get('/session', function() {
    $db = new DbHelper();
    $session = $db->getSession();
    $response["ID"] = $session['ID'];
    $response["email"] = $session['email'];
    $response["nickname"] = $session['nickname'];
    echoResponse(200, $response);
});

$app->post('/login', function() use ($app) {
    require_once 'passwordHash.php';
    $db = new DbHelper();
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('email', 'password'),$r->user);
    $response = array();
    
    $password = $r->user->password;
    $email = $r->user->email;
    $columns = "ID,nickname,password,email,created";
    $table = "user";
    $limit = "1";
    $where = array("email" => "$email");
    $orwhere = array("nickname" => "$email");
    $result = $db->select($table, $columns, $where,$orwhere,$limit);
    $user = $result['data'][0];
            
    //$user = $db->getOneRecord("select ID,nickname,password,email,created from user where nickname='$email' or email='$email'");
    if ($user != NULL) {
        if(passwordHash::check_password($user['password'],$password)){
        $response['status'] = "success";
        $response['message'] = 'Logged in successfully.';
        $response['nickname'] = $user['nickname'];
        $response['ID'] = $user['ID'];
        $response['email'] = $user['email'];
        $response['createdAt'] = $user['created'];
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['ID'] = $user['ID'];
        $_SESSION['email'] = $email;
        $_SESSION['nickname'] = $user['nickname'];
        } else {
            $response['status'] = "error";
            $response['message'] = 'Login failed. Incorrect credentials';
        }
    }else {
            $response['status'] = "error";
            $response['message'] = 'No such user is registered';
        }
    echoResponse(200, $response);
});
$app->post('/signUp', function() use ($app) {
    $response = array();
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('email', 'nickname', 'password'),$r->user);
    require_once 'passwordHash.php';
    $db = new DbHelper();
   
    $nickname = $r->user->nickname;
    $email = $r->user->email;
    $password = $r->user->password;
    
    $columns = 'ID,nickname,password,email,created';
    $table = 'user';
    $where = "";
    $orwhere = "";
    
    $isUserExists = $db->select($table, $columns, $where,$orwhere,'1');
    if(!$isUserExists){
        $r->user->password = passwordHash::hash($password);
        $table_name = "user";
        $column_names = array('nickname', 'email', 'password');
        $result = $db->insertIntoTable($r->user, $column_names, $table_name);
        if ($result != NULL) {
            $response["status"] = "success";
            $response["message"] = "User account created successfully";
            $response["ID"] = $result;
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['ID'] = $response["ID"];
           
            $_SESSION['nickname'] = $nickname;
            $_SESSION['email'] = $email;
            echoResponse(200, $response);
        } else {
            $response["status"] = "error";
            $response["message"] = "Failed to create user. Please try again";
            echoResponse(201, $response);
        }            
    }else{
        $response["status"] = "error";
        $response["message"] = "An user with the provided phone or email exists!";
        echoResponse(201, $response);
    }
});
$app->get('/logout', function() {
    $db = new DbHelper();
    $session = $db->destroySession();
    $response["status"] = "info";
    $response["message"] = "Logged out successfully";
    echoResponse(200, $response);
});
?>