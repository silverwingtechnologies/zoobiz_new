<?php 

  
             $partner_login_id= $_SESSION['partner_login_id'];
        	 $a = array( 
        	 	  'logout_time' =>date("Y-m-d H:i:s")
        	 );
             $d->update("partner_login_master",$a,"partner_login_id='$partner_login_id'  ");


             $a = array( 
        	 	  'logout_time' =>date("Y-m-d H:i:s")
        	 );
             $d->update("partner_session_log",$a,"partner_login_id='$partner_login_id'  ");
             
          
session_destroy();
/*header("location:welcome");*/
 echo ("<script LANGUAGE='JavaScript'>
    window.location.href='index';
    </script>");
exit;
 ?>