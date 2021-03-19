<?php
session_start();
error_reporting(0);
?>  
<link rel="stylesheet" href="../css/bootstrap.min.css">  

 <script src="../js/jquery-3.4.1.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<center>
  <div class="container-fluid">
 	<div class="col-xs-12">
 		<div class="alert alert-success">
		    <strong>Success!</strong> <?php  echo $_SESSION['msgTemp']; ?>
		</div>
 	</div>
 	 
 	

 </div>
</center>