<?php 
 /*
 Project phonebook
 @Author NottDev 07/06/19
 */

require '../vendor/autoload.php';

$storage = new Flatbase\Storage\Filesystem('../models');
$flatbase = new Flatbase\Flatbase($storage);

//Get Query String
$id = $_GET['id'];
$flatbase->delete()->in('phonebook')->where('id', '==', $id)->execute();

header('Location: ../index.php');