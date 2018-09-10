<?php
include "./firbaseNotification.php";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    extract($_POST);
//    print_r($_POST);
//    exit;
    
    $token_ids = json_decode($token_ids);
    $other_data = json_decode($other_data,true);
    
    foreach ($token_ids as $token_id){
        $notify = new firbaseNotification;
        $data = array(
                'title' => $title,
                'message' =>  $message,
                'registrationIds' => [$token_id],// ["cnOG7jarObE:APA91bH01j5Qc7PGVN9DAnY0bzzogoLV_diSxMrb9kg14OY1YkcJWPJZedcPLDcfU1N2zJROOIsVuszhPNvHDq36AT2yanyxYH5RLKHAtGHY6XWQu5RHM_TuX6IN25eIOibCi8EsAsRG"],
                'data' => $other_data
                );
        $notify->android($data);
    }
}

?>