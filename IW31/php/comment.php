<?php
$user_id = $_POST['user_id'];
$article_id = $_POST['article_id'];
$com = $_POST['com'];
$date = date("Y/m/t");

$link = mysqli_connect('localhost', 'root', '', 'haveatry');
  
// 接続状況をチェックします
if (mysqli_connect_errno()) {
    die("データベースに接続できません:" . mysqli_connect_error() . "\n");
}
// userテーブルの全てのデータを取得する
$sql = "SELECT name FROM users WHERE id = '".$user_id."';";
if ($result = mysqli_query($link, $sql)) {
    foreach ($result as $row) {
        $name = $row['name'];
    }
}



//コメントをデータベースに
$db = new PDO("mysql:host=localhost;dbname=haveatry;charset=utf8","root","");
 
$sql2 = $db->prepare( "INSERT INTO comment(comment,article_id,name,date)VALUES('" .$com. "'  ,  '" .$article_id. "' ,  '" .$name. "' , '" .$date. "') ");
$sql2->execute();
$all = $sql2->fetchAll();

header("Location:../article.php?article_id=$article_id");

