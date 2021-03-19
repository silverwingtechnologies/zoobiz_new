<?php  
 
//include '../zooAdmin/common/objectController.php'; 
include 'frontObjectController.php'; 

 


// print_r($_POST);
if(isset($_POST) && !empty($_POST) )//it can be $_GET doesn't matter
{
	if (isset($feedback)) {
		
	 $m->set_data('name', $userName);
      $m->set_data('email', $userEmail);
      $m->set_data('mobile', $mobile);
      $m->set_data('feedback_msg', $userMessage);
      
      $m->set_data('feedback_date_time', date('Y-m-d H:i:s'));


      $adrAry = array(
          'name' => $m->get_data('name'),
          'email' => $m->get_data('email'),
          'mobile'=> $m->get_data('mobile'),
          'feedback_msg' => $m->get_data('feedback_msg'),
          'feedback_date_time' => $m->get_data('feedback_date_time'),
         
      );

        $q=$d->insert("feedback_master",$adrAry);

        echo "Thank you for your feedback";

   }


   if (isset($subs)) {
   		
   	  $m->set_data('name', $subName);
      $m->set_data('email', $subEmail);
      $m->set_data('subMobile', $subMobile);
      $m->set_data('created_date', date('Y-m-d H:i:s'));


      $adrAry = array(
          'name' => $m->get_data('name'),
          'mobile' => $m->get_data('subMobile'),
          'email' => $m->get_data('email'),
          'created_date' => $m->get_data('created_date'),
         
      );

     $qqq=$d->select("subscribe_master","mobile='$subMobile' OR email='$subEmail'");
     if (mysqli_num_rows($qqq)>0) {
        $q=$d->update("subscribe_master",$adrAry,"mobile='$subMobile' OR email='$subEmail'");
     } else {
        $q=$d->insert("subscribe_master",$adrAry);

     }

        echo "Thank you for your subscribe";


   }
}

?>