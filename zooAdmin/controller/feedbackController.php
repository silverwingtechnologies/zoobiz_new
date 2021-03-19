<?php 
 include '../common/objectController.php';

if(isset($_POST) && !empty($_POST) ) {
 if(isset($replyFeedback) ){
   $query=$d->select("feedback_master","feedback_id='$feedback_id'   ","LIMIT 1");
   $query_data = mysqli_fetch_assoc($query);
   $to = $query_data['email'];
   $user_name =  $query_data['name'];
   $feedback_society_id =  $query_data['society_id'];
   $subject =$query_data['feedback_msg'];
   $reply= $reply;
   include '../mail/feedbackReply.php';
   include '../mail.php';
   $_SESSION['msg']="Inquiry Reply Sent Successfully to '$to'";
   $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
   header("Location: ../feedback");
 }
 if(isset($deleteFeedback)) {

   $adm_data=$d->selectRow("subject","feedback_master"," feedback_id='$feedback_id'");
        $data_q=mysqli_fetch_array($adm_data);


  $q=$d->delete("feedback_master","feedback_id='$feedback_id'    ");
  if($q==TRUE) {


    $_SESSION['msg']=$data_q['subject']." Inquiry Deleted";
    $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
    header("Location: ../feedback");
  } else {
    $_SESSION['msg1']="Something Wrong";
    header("Location: ../feedback");
  }
}
}
?>