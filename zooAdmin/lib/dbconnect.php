<?php
class dbconnect
{
    function connect()
    {
       // $connection=mysqli_connect("localhost","zoobiz_silver","3y!~Sb(s1i-C","zoobiz_2020");
     $connection=mysqli_connect("localhost","root","","zoobiz_2020");
    	//$connection=mysqli_connect("localhost","root","","silver_zoobiz");
    	// $connection=mysqli_connect("localhost","Sil_Zoobiz","pA7yW7&Z&R","Silver_Zoobiz");

    	  
		return $connection;
    }
}
?>