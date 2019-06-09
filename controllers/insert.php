<?php 
 /*
 Project phonebook
 */
date_default_timezone_set("Asia/Bangkok");
require '../vendor/autoload.php';

$storage = new Flatbase\Storage\Filesystem('../models');
$flatbase = new Flatbase\Flatbase($storage);

//Get Parameter
$id = uniqid();
$name = $_POST['name'];
$tel = $_POST['tel'];

//POST Data
$postData = ['id'=> $id ,'name' => $name, 'tel' => $tel ];

if( $_FILES['fileUpload']['size'] > 0 ){

    // Simple validation (max file size 2MB and only two allowed mime types)
    $validator = new FileUpload\Validator\Simple('1M', ['image/jpg', 'image/png', 'image/jpeg']); 

    // Simple path resolver, where uploads will be put
    $pathresolver = new FileUpload\PathResolver\Simple(__DIR__."/../uploads");

    // The machine's filesystem
    $filesystem = new FileUpload\FileSystem\Simple();

    // FileUploader itself
    $temp_name = explode('.',$_FILES['fileUpload']['name']);
    $new_name =  date('YmdHis').'.'.end($temp_name);
    $_FILES['fileUpload']['name'] = $new_name;
    $fileupload = new FileUpload\FileUpload($_FILES['fileUpload'], $_SERVER);


    // Adding it all together. Note that you can use multiple validators or none at all
    $fileupload->setPathResolver($pathresolver);
    $fileupload->setFileSystem($filesystem);
    $fileupload->addValidator($validator);

    // Doing the deed
    list($files, $headers) = $fileupload->processAll();

    $postData['profileImg'] =  $new_name;

    // echo json_encode(['files' => $files]);

}


$flatbase->insert()->in('phonebook')
    ->set($postData)
    ->execute();


header('Location: ../index.php');