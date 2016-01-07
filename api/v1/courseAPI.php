<?php

$app->get('/courses', function() { 
    $db = new DbHelper();
    $columns = "ID,title,description,price,start_date,end_date,max_number_of_students,ID_subject";
    $table = "course";    
    $where = array();
    $orwhere = array();
    $result = $db->select($table, $columns, $where,$orwhere,$limit);
    echoResponse(200, $result);
});

