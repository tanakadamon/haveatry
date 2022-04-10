<?php

$fname = $_POST['src'];
$img = $_POST['img'];
$title = $_POST['title'];
$user_id = $_POST['user_id'];


try{

$db = new PDO("mysql:host=localhost;dbname=haveatry;charset=utf8","root","");



    //動画をDBに格納．
    $sql = $db->prepare( "INSERT INTO movie(fname, img, title, user_id)VALUES('" .$fname. "'  ,  '" .$img. "' ,  '" .$title. "' , '" .$user_id. "'); ");
    $sql->execute();


    // var_dump($sql);

}

catch(PDOException $e){
    echo("<p>500 Inertnal Server Error</p>");
exit($e->getMessage());
}







 
header( "Location: ../worklist.php" ) ;
 
$sql = null; // オブジェクトの開放

