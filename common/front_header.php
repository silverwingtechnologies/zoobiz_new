<?php
session_start();
include_once 'zooAdmin/lib/dao.php';
include 'zooAdmin/lib/model.php';
$d = new dao();
$m = new model();
$con=$d->dbCon();

require('razorpay_config.php');
require('razorpay-php/Razorpay.php');
$base_url=$m->base_url();
if(isset($_GET['f'])){
    $title= ucwords($_GET['f']);  
} else{
    $title ="";
}
 
  if($title=="Register"){
    $title ="Register in ZooBiz";
  }

  if($title=="" || $title== ucwords("index") || $title==ucwords("index.php")  ){
    $title ="Grow Your Business Through  Networking";
  }


 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ZooBiz | <?php echo $title;?></title>
    <link href="img/fav.png" rel="icon">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="css/tooltipster.min.css">
    <link rel="stylesheet" href="css/cubeportfolio.min.css">
    <link rel="stylesheet" href="css/navigation.css">
    <link rel="stylesheet" href="css/settings.css">
    <link rel="stylesheet" href="css/style2.css">


    <link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
    <!-- <link rel="stylesheet" href="assets/plugins/material-datepicker/css/bootstrap-material-datetimepicker.min.css"> -->
 
      <link href="assets/plugins/select2/css/select2.min.css" rel="stylesheet"/>
  <!--inputtags-->
  <link href="assets/plugins/inputtags/css/bootstrap-tagsinput.css" rel="stylesheet" />
  <!--multi select-->
  <link href="assets/plugins/jquery-multi-select/multi-select.css" rel="stylesheet" type="text/css">

    <link href="assets/plugins/select2/css/select2.min.css" rel="stylesheet"/>

<link href="css/sweetalert2.min.css" rel="stylesheet">
<link href="zooAdmin/assets/css/app-style12.css" rel="stylesheet"/>

    <style type="text/css">

    </style>

</head>



<body data-spy="scroll" data-target=".navbar-nav" data-offset="75" class="offset-nav">
    <!--PreLoader-->
    <div class="loader">
        <div class="loader-inner">
            <div class="cssload-loader"></div>
        </div>
    </div>
    <!--PreLoader Ends-->
    <!-- header -->