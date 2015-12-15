<?php 
$app->get('/session', function() {
    $db = new DbHandler();
    $session = $db->getSession();
    $response["ID"] = $session['ID'];
    $response["email"] = $session['email'];
    $response["nickname"] = $session['nickname'];
    echoResponse(200, $session);
});

$app->post('/login', function() use ($app) {
    require_once 'passwordHash.php';
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('email', 'password'),$r->user);
    $response = array();
    $db = new DbHandler();
    $password = $r->user->password;
    $email = $r->user->email;
    $user = $db->getOneRecord("select ID,nickname,password,email,created from user where nickname='$email' or email='$email'");
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
    $db = new DbHandler();
   
    $nickname = $r->user->nickname;
    $email = $r->user->email;
    $password = $r->user->password;
    
    
    $isUserExists = $db->getOneRecord("select 1 from user where nickname='$nickname' or email='$email'");
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
    $db = new DbHandler();
    $session = $db->destroySession();
    $response["status"] = "info";
    $response["message"] = "Logged out successfully";
    echoResponse(200, $response);
});
?>