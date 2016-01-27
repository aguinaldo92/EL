<?php

$app->get('/teachers', function() { 
    $db = new DbHelper();
    $columns = "ID,first_name,last_name,nickname,email,password,address,birthdate,gender,educational_qualification,image,is_a_student,is_a_teacher,is_active,created";
    $table = "user";    
    $where = array(
        "is_a_teacher" => "1"
        );
    $orwhere = array();
    $limit = 9999;
    $result = $db->select($table, $columns, $where,$orwhere,$limit);
    echoResponse(200, $result);
});

