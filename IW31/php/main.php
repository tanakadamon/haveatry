<?php

$db = new PDO("mysql:host=localhost;dbname=haveatry;charset=utf8","root","");
$title = $_POST['title'];

function uploadImage($tmpName, $dir, $maxWidth, $maxHeight){
 
$text = $_POST['content'];
$title = $_POST['title'];
$type = $_POST['type'];
$date = date("Y/m/t");
$user_id = $_POST['user_id'];



$db = new PDO("mysql:host=localhost;dbname=haveatry;charset=utf8","root","");
 
$sql = $db->prepare( "INSERT INTO article(name,text,type,title,imgname,date,fav)VALUES('" .$user_id. "'  ,  '" .$text. "' ,  '" .$type. "' , '" .$title. "' , ' ' , '" .$date. "' , 0) ");
$sql->execute();
$all = $sql->fetchAll();

$sql = null; // オブジェクトの開放

$db2 = mysqli_connect('localhost', 'root', '', 'haveatry');
$sql2 = "SELECT * FROM article WHERE title = '".$title."';";


if ($data = mysqli_query($db2, $sql2)) {

    foreach ($data as $row) {
        $article_id = $row['id'];
    }
}
else{

}

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($tmpName);
 
    if($mime == 'image/jpeg' || $mime == 'image/pjpeg'){
        $ext = '.jpg';
        $image1 = imagecreatefromjpeg($tmpName);
    } elseif($mime == 'image/png' || $mime == 'image/x-png'){
        $ext = '.png';
        $image1 = imagecreatefrompng($tmpName);
    } elseif($mime == 'image/gif'){
        $ext = '.gif';
        $image1 = imagecreatefromgif($tmpName);
    } else {
        return false;
    }
     
    list($width1, $height1) = getimagesize($tmpName);
 
    if($width1 <= $maxWidth && $height1 <= $maxHeight){
        $scale = 1.0;
    } else {
        $scale = min($maxWidth / $width1, $maxHeight / $height1);
    }
 
    $width2 = $width1 * $scale;
    $height2 = $height1 * $scale;
 
    $image2 = imagecreatetruecolor($width2, $height2);
 
    if($ext == '.gif'){
        $transparent1 = imagecolortransparent($image1);
        if($transparent1 >= 0){
            $index = imagecolorsforindex($image1, $transparent1);
            $transparent2 = imagecolorallocate($image2, $index['red'], $index['green'], $index['blue']);
            imagefill($image2, 0, 0, $transparent2);
            imagecolortransparent($image2, $transparent2);
        }
    } elseif($ext == '.png'){
        imagealphablending($image2, false);
        $transparent = imagecolorallocatealpha($image2, 0, 0, 0, 127);
        imagefill($image2, 0, 0, $transparent);
        imagesavealpha($image2, true);
    }
 
    imagecopyresampled($image2, $image1, 0, 0, 0, 0, $width2, $height2, $width1, $height1);
 
    if(!file_exists($dir)){
        mkdir($dir, 0777, true);
    }
 
    $filename = $article_id.'image'.$ext;

    $saveTo = rtrim($dir, '/\\') . '/' . $filename;
 
    if($ext == '.jpg'){
        $quality = 80;
        imagejpeg($image2, $saveTo, $quality);
    } else if($ext == '.png'){
        imagepng($image2, $saveTo);
    } else if($ext == '.gif'){
        imagegif($image2, $saveTo);
    }
 
    imagedestroy($image1);
    imagedestroy($image2);

    $sql3 = $db->prepare( "UPDATE article SET imgname =  '".$filename."' WHERE title = '".$title."' ");
    $sql3->execute();
    $all3 = $sql3->fetchAll();
    return $saveTo;
}
 
if($_SERVER["REQUEST_METHOD"] === 'POST'
    && !empty($_FILES['image']['tmp_name']))
{

 
    $maxWidth = 300;    // 最大幅
    $maxHeight = 169;   // 最大高さ
 
    // 一時ファイルの場所
    $tmpName = $_FILES['image']['tmp_name'];
 
    // 保存先のディレクトリ
    $dir = __DIR__ . '/upload/';
    $path = uploadImage($tmpName, $dir, $maxWidth, $maxHeight);

} 
$sql2 = null; // オブジェクトの開放
header("Location: ../index.php");


