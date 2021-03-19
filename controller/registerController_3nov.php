<?php  
 
//include '../zooAdmin/common/objectController.php'; 
include 'frontObjectController.php'; 
 
require('../razorpay_config.php');
require('../razorpay-php/Razorpay.php');
include '../zooAdmin/fcm_file/user_fcm.php';

$nResident = new firebase_resident();
//ECHO "TEST";EXIT;

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

$androidLink ='https://play.google.com/store/apps/details?id=com.silverwing.zoobiz';
$iosLink='#';
// print_r($_POST);
 //echo "<pre>"; print_r($_POST);exit;
if(isset($_POST) && !empty($_POST) )//it can be $_GET doesn't matter
{


//  echo "<pre>";print_r($_POST);exit;
// add main menu
$whatsapp_number ='';
   if(isset($_POST['checkUserMobile'])){
    $q=$d->select("users_master","user_mobile='$userMobile'");
    $data=mysqli_fetch_array($q);
    if ($data>0) {
       echo 1;
       exit();
    } else {
      echo 0;
      exit();
    }

  }
  

  if(isset($_POST['checkUserMobileFormSubmit'])){
    $q=$d->select("users_master","user_mobile='$userMobile'");
    $data=mysqli_fetch_array($q);
    if ($data>0) {
       echo 1;
       exit();
    } else {
      echo 0;
      $user_first_name = ucfirst($user_first_name);
      $user_last_name = ucfirst($user_last_name);
      $gst_number = '';//strtoupper($gst_number);
      $m->set_data('salutation',ucfirst($salutation));
      
      
      $m->set_data('user_first_name',ucfirst($user_first_name));
      $m->set_data('user_first_name',ucfirst($user_first_name));
      $m->set_data('user_last_name',ucfirst($user_last_name));
      $m->set_data('user_full_name',ucfirst($user_first_name).' '.ucfirst($user_last_name));
      $m->set_data('user_mobile',$userMobile);
      $m->set_data('user_email',$user_email);
      $m->set_data('gender',$gender);
      $m->set_data('plan_id',$plan_id);
      $m->set_data('register_date', date("Y-m-d H:i:s"));
     
     $company_master_qry=$d->select("  company_master"," city_id ='$city_id' ","");
      if (mysqli_num_rows($company_master_qry) > 0 ) {
        $company_master_data=mysqli_fetch_array($company_master_qry);
         $company_id = $company_master_data['company_id'];
       } else {
         $company_id = 1;
       }
      
    $m->set_data('company_id',$company_id);
    $m->set_data('city_id',$city_id);
    $m->set_data('whatsapp_number','');
//7oct2020
 
  $m->set_data('refer_by',$refer_by);
  
  if(isset($refere_by_name) && trim($refere_by_name)!=''){
    $m->set_data('refere_by_name',$refere_by_name);
  } else{
    $m->set_data('refere_by_name','');
  }
 
  if(isset($refere_by_phone_number) && trim($refere_by_phone_number)!=''){
     $m->set_data('refere_by_phone_number',$refere_by_phone_number);
  }else{
    $m->set_data('refere_by_phone_number','');
  }
  
  if(isset($remark) && trim($remark)!=''){
    $m->set_data('remark',$remark);
  } else {
    $m->set_data('remark','');
  }
//7oct2020

      $a =array(
        'salutation'=> $m->get_data('salutation'),
        'company_id'=> $m->get_data('company_id'),
        'refer_by' => $m->get_data('refer_by'),
      'refere_by_name' => $m->get_data('refere_by_name'),
      'refere_by_phone_number' => $m->get_data('refere_by_phone_number'),
      'remark' => $m->get_data('remark'),

        'city_id'=> $m->get_data('city_id'),
        'user_first_name'=> $m->get_data('user_first_name'),
        'user_last_name'=> $m->get_data('user_last_name'),
        'user_full_name'=> $m->get_data('user_full_name'),
        'user_mobile'=> $m->get_data('user_mobile'),
        'whatsapp_number'=> $m->get_data('whatsapp_number'),
        'user_email'=> $m->get_data('user_email'),
        'gender'=> $m->get_data('gender'),
        'register_date'=> $m->get_data('register_date'),
        'plan_id'=> $m->get_data('plan_id'),

      );
        
      $q=$d->select("users_master_temp","user_mobile='$userMobile'");
      $data=mysqli_fetch_array($q);
      if ($data>0) {
         $q=$d->update("users_master_temp",$a,"user_mobile = '$userMobile'");
      } 
      else {
         $q=$d->insert("users_master_temp",$a);
      }

      exit();
    }

  }
  
   
  // print_r($_POST);


  //5oct2020
  if(isset($_POST['cpn_success']) && $_POST['cpn_success'] ==1){
    $_SESSION['cpn_success'] ="<p>Your Registration with coupon was successful</p>";

       $con -> autocommit(FALSE);


    $q=$d->select("users_master_temp","user_mobile='$user_mobile'");
    $data=mysqli_fetch_array($q);
    if ($data>0) {
      $q=$d->delete("users_master_temp","user_mobile='$user_mobile'");
          
    } 

     $q=$d->select("users_master","user_mobile='$user_mobile'");
    $data=mysqli_fetch_array($q);
    if ($data>0) {
         $_SESSION['msg1']="Mobile number alerady registered in Zoobiz Account";
            header("location:../register");
       exit();
    } 


 
     $user_first_name = ucfirst($user_first_name);
     $user_last_name = ucfirst($user_last_name);
     $gst_number = '';//strtoupper($gst_number);

      $_SESSION['salutation']= $salutation;
      $_SESSION['user_first_name']= $user_first_name;
      $_SESSION['user_last_name']= $user_last_name; 
      $_SESSION['user_email']= $user_email;
      $_SESSION['user_mobile']= $user_mobile;
      $_SESSION['gender']= $gender;
      $_SESSION['plan_id']= $plan_id;
      $_SESSION['city_id']= $city_id;
if(!isset($plan_id)){
       
       $plan_id = $plan_id_temp;
    }
$q=$d->select("package_master","package_id='$plan_id'","");
    $row1=mysqli_fetch_array($q);
    $package_name= $row1['package_name'];
    $no_month=$row1['no_of_month'];
    $package_amount=$row1['package_amount'];

//9oct2020
     if($row1['gst_slab_id'] !="0"){
      $gst_slab_id = $row1['gst_slab_id'];
           $gst_master=$d->select("gst_master","slab_id = '$gst_slab_id'","");
           $gst_master_data=mysqli_fetch_array($gst_master);
           $gst_amount= (($row1["package_amount"]*$gst_master_data['slab_percentage']) /100);
    } else {
            $gst_amount= 0 ;
    }
     $package_amount=number_format($row1["package_amount"]+$gst_amount,2,'.','');
      //9oct2020


    $lid=$d->select("zoobizlastid","","");
    $laisZooBizId=mysqli_fetch_array($lid);
    $lastZooId= $laisZooBizId['zoobiz_last_id']+1;

    $plan_renewal_date=date('Y-m-d', strtotime(' +'.$no_month.' months'));
//NEW
     if($row1["time_slab"] == 1){
       $plan_renewal_date=date('Y-m-d', strtotime(' +'.$no_month.' days'));
     } else {
       $plan_renewal_date=date('Y-m-d', strtotime(' +'.$no_month.' months'));
     }
     //NEW



    $last_auto_id=$d->last_auto_id("users_master");
    $res=mysqli_fetch_array($last_auto_id);
    $user_id=$res['Auto_increment'];
    $zoobiz_id="ZB2020".$lastZooId;

   // $catArray = explode(":", $business_sub_category_id);

    $m->set_data('zoobiz_id',ucfirst($zoobiz_id));
    $m->set_data('salutation',ucfirst($salutation));


$company_master_qry=$d->select("  company_master"," city_id ='$city_id' ","");
      
     

       if (mysqli_num_rows($company_master_qry) > 0 ) {
        $company_master_data=mysqli_fetch_array($company_master_qry);
         $company_id = $company_master_data['company_id'];
         $company_name =$company_master_data['company_name'];
       } else {
         $company_id = 1;
         $company_name ="Zoobiz India Pvt. Ltd.";
       }
      $coupon_master=$d->select("  coupon_master"," coupon_code ='$coupon_code' and coupon_status = 0  ","");
      if (mysqli_num_rows($coupon_master) > 0 ) {
        $coupon_master_data=mysqli_fetch_array($coupon_master);
         $coupon_id = $coupon_master_data['coupon_id'];
       } else {
         $coupon_id = 0 ;
       }

       $m->set_data('coupon_id',$coupon_id);


    $m->set_data('company_id',$company_id);
    $m->set_data('city_id',$city_id);
    $m->set_data('user_first_name',ucfirst($user_first_name));
    $m->set_data('user_last_name',ucfirst($user_last_name));
    $m->set_data('user_full_name',ucfirst($user_first_name).' '.ucfirst($user_last_name));
    $m->set_data('user_mobile',$user_mobile);
    $m->set_data('user_email',$user_email);
    $m->set_data('gender',$gender);
    $m->set_data('plan_renewal_date',$plan_renewal_date);
    if(!isset($plan_id)){
       $m->set_data('plan_id',$plan_id_temp);
    } else{
       $m->set_data('plan_id',$plan_id);
    }
   

    $m->set_data('register_date', date("Y-m-d H:i:s"));
   //7oct2020
 
  $m->set_data('refer_by',$refer_by);
  
  if(isset($refere_by_name) && trim($refere_by_name)!=''){
    $m->set_data('refere_by_name',$refere_by_name);
  } else{
    $m->set_data('refere_by_name','');
  }
 
  if(isset($refere_by_phone_number) && trim($refere_by_phone_number)!=''){
     $m->set_data('refere_by_phone_number',$refere_by_phone_number);
  }else{
    $m->set_data('refere_by_phone_number','');
  }
  
  if(isset($remark) && trim($remark)!=''){
    $m->set_data('remark',$remark);
  } else {
    $m->set_data('remark','');
  }
//7oct2020
 
    $a =array(
      'zoobiz_id'=> $m->get_data('zoobiz_id'),
      'salutation'=> $m->get_data('salutation'),
      'company_id'=> $m->get_data('company_id'),

       'refer_by' => $m->get_data('refer_by'),
      'refere_by_name' => $m->get_data('refere_by_name'),
      'refere_by_phone_number' => $m->get_data('refere_by_phone_number'),
      'remark' => $m->get_data('remark'),


      'city_id'=> $m->get_data('city_id'),
      'user_first_name'=> $m->get_data('user_first_name'),
      'user_last_name'=> $m->get_data('user_last_name'),
      'user_full_name'=> $m->get_data('user_full_name'),
      'user_mobile'=> $m->get_data('user_mobile'),
      'user_email'=> $m->get_data('user_email'),
      'gender'=> $m->get_data('gender'),
      'register_date'=> $m->get_data('register_date'),
      'plan_id'=> $m->get_data('plan_id'),
      'plan_renewal_date'=> $m->get_data('plan_renewal_date'),
    );
  
   
  
      $m->set_data('razorpay_order_id', '');
    $m->set_data('razorpay_payment_id', '');
    $m->set_data('razorpay_signature', '');


       $paymentAry = array(
          'user_id' => $user_id, 
          'package_id' => $m->get_data('plan_id'),
          'company_id'=> $m->get_data('company_id'),
          'package_name' => $package_name,
          'coupon_id' => $m->get_data('coupon_id'),
          'user_mobile' => $m->get_data('user_mobile'),
          'payment_mode' => "Coupon ",
          'transection_amount' => $package_amount,
          'transection_date' => date("Y-m-d H:i:s"),
          'payment_status' => "SUCCESS",
          'payment_firstname' => $m->get_data('user_first_name'),
          'payment_lastname' => $m->get_data('user_last_name'),
          'payment_phone' => $m->get_data('user_mobile'),
          'payment_email' => $m->get_data('user_email'),
          'payment_address' => $m->get_data('adress'),
           'razorpay_payment_id' => $m->get_data('razorpay_payment_id'),
          'razorpay_order_id' => $m->get_data('razorpay_order_id'),
          'razorpay_signature' => $m->get_data('razorpay_signature'),
      );

       $a11 =array(
        'zoobiz_last_id'=> $lastZooId,
      );

    $q=$d->insert("users_master",$a);
    $q3=$d->insert("transection_master",$paymentAry);
    $q4= $d->update("zoobizlastid",$a11,"id='1'");
     
    
      
     
   if($q and $q3 and $q4) {
      $d->delete("users_master_temp","user_mobile='$user_mobile'");
      $con -> commit();
      unset($_SESSION['salutation']);
      unset($_SESSION['user_first_name']);
      unset($_SESSION['user_last_name']);
      unset($_SESSION['user_email']);
      unset($_SESSION['user_mobile']);
      unset($_SESSION['gender']);
      unset($_SESSION['plan_id']);
       unset($_SESSION['city_id']);
  

      $_SESSION['show_success']="yes";
      $_SESSION['msg']="Registration Successfully !";

        /*$last_auto_id=$d->last_auto_id("users_master");
          $res=mysqli_fetch_array($last_auto_id);
          $new_user_id=$res['Auto_increment'];*/



      $user_full_name = ucfirst($user_first_name).' '.ucfirst($user_last_name);
        $getData = $d->select("custom_settings_master"," status = 0 and send_fcm=1 and   flag = 1 ","");
         if( mysqli_num_rows($getData) > 0){ 
           $custom_settings_master_data = mysqli_fetch_array($getData);
           $description = $custom_settings_master_data['fcm_content'];
           $description =  str_replace("USER_FULL_NAME",$user_full_name,$description);
           $description =  str_replace("ANDROID_LINK",$androidLink,$description);
           $description =  str_replace("IOS_LINK",$iosLink,$description);

          /* $link =$base_url.'zooAdmin/viewMember?id'.$new_user_id;
             $description .=" \n Link: $link";*/
           $d->send_sms($user_mobile,$description);

         }
      
      //20OCT2020
          $getData = $d->select("custom_settings_master"," status = 0 and send_fcm=1 and flag = 0 ","");
         if( mysqli_num_rows($getData) > 0 && 0 ){ 
          $custom_settings_master_data = mysqli_fetch_array($getData);
          
 
           $title= "New Member Registered."; 
           $description = $custom_settings_master_data['fcm_content'];
 

           $description =  str_replace("USER_NAME",$user_full_name,$description);
           
 

          
            $where = "";
            if($custom_settings_master_data['share_within_city'] ==1 ){
              $where = " and  city_id ='$city_id'";
            }
            
            // $d->insertAllUserNotification($title,$user_full_name ." registered in ZooBiz from ".$company_name,"custom_notification",'',"active_status=0 $where");


            $user_employment_details_qry = $d->select("users_master"," active_status=0 $where  ","");

            $user_ids_array = array('0');
             while ($user_employment_details_data=mysqli_fetch_array($user_employment_details_qry)) {
              $user_ids_array[] =$user_employment_details_data['user_id'];
             }

            
             $user_ids_array = implode(",", $user_ids_array);

            
         $fcmArray=$d->get_android_fcm("users_master","user_token!='' AND  device='android' and user_id in ($user_ids_array)  ");
         
        $fcmArrayIos=$d->get_android_fcm("users_master "," user_token!='' AND  device='ios' and user_id in ($user_ids_array)    ");

        //23OCT2020
        $last_auto_id=$d->last_auto_id("users_master");
          $res=mysqli_fetch_array($last_auto_id);
          $new_user_id=$res['Auto_increment'];

          $new_user_id = ($new_user_id-1);
        //23OCT2020

          $fcm_data_array = array(
            'img' =>$base_url.'img/logo.png',
            'title' =>$title,
            'desc' => $description,
            'time' =>date("d M Y h:i A")
          );
         $nResident->noti("custom_notification","",0,$fcmArray,$title,$description,$fcm_data_array);
         $nResident->noti_ios("custom_notification","",0,$fcmArrayIos,$title,$description,$fcm_data_array);
       }
         //20OCT2020
       
     //send user a welcome mail start
       $to = $user_email;
      $subject ="Welcome To Zoobiz";
      
      include('../mail/welcomeUserMail.php');
      include '../mail_front.php';
      //send user a welcome mail end
 



       /* $notiAry = array(
                      'admin_id'=>0,
                      'notification_tittle'=>"New Member Registered.",
                      'notification_description'=>$user_full_name ." registered in ZooBiz from ".$company_name,
                      'notifiaction_date'=>date('Y-m-d H:i'),
                      'notification_action'=>'',
                      'admin_click_action '=>'adminNotification'
                    );
                    $d->insert("admin_notification",$notiAry);*/

        $zoobiz_admin_master=$d->select("zoobiz_admin_master","send_notification = '1'    ");
        while($zoobiz_admin_master_data = mysqli_fetch_array($zoobiz_admin_master)) {
           $adminname=$zoobiz_admin_master_data['admin_name'];
           //$link =$base_url.'zooAdmin/viewMember?id='.$new_user_id;

           $msg2= "New Member Registration in $company_name \n Name: $user_full_name \n Company Name: $company_name   \nThanks Team ZooBiz";
           
                      $d->send_sms($zoobiz_admin_master_data['admin_mobile'],$msg2);
                    
         }
       


      header("location:../success");
    } else {
      mysqli_query("ROLLBACK");
      $_SESSION['msg1']="Something Wrong";
      header("location:../register");
    }

   } else 
    //5oct2020
   if(isset($_POST['razorpay_signature'])){
     $con -> autocommit(FALSE);


    $q=$d->select("users_master_temp","user_mobile='$user_mobile'");
    $data=mysqli_fetch_array($q);
    if ($data>0) {
      $q=$d->delete("users_master_temp","user_mobile='$user_mobile'");
          
    } 

     $q=$d->select("users_master","user_mobile='$user_mobile'");
    $data=mysqli_fetch_array($q);
    if ($data>0) {
         $_SESSION['msg1']="Mobile number alerady registered in Zoobiz Account";
            header("location:../register");
       exit();
    } 


 
     $user_first_name = ucfirst($user_first_name);
     $user_last_name = ucfirst($user_last_name);
     $gst_number = '';//strtoupper($gst_number);

      $_SESSION['salutation']= $salutation;
      $_SESSION['user_first_name']= $user_first_name;
      $_SESSION['user_last_name']= $user_last_name; 
      $_SESSION['user_email']= $user_email;
      $_SESSION['user_mobile']= $user_mobile;
      $_SESSION['gender']= $gender;
      $_SESSION['plan_id']= $plan_id;
  $_SESSION['city_id']= $city_id;
    
  
//razor pay start

$success = true;

$error = "Payment Failed";

if (empty($_POST['razorpay_payment_id']) === false)
{
    $api = new Api($keyId, $keySecret);

    try
    {
        // Please note that the razorpay order ID must
        // come from a trusted source (session here, but
        // could be database or something else)
        $attributes = array(
            'razorpay_order_id' => $_SESSION['razorpay_order_id'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
        );

        $api->utility->verifyPaymentSignature($attributes);
    }
    catch(SignatureVerificationError $e)
    {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();

         $_SESSION['msg1']=$error;
            header("location:../register");
         exit();
    }
}

if ($success === true   )
{
    $_SESSION['payment_id'] = "<p>Your payment was successful</p>
             <p>Payment ID: {$_POST['razorpay_payment_id']}</p>";
      
     //add in original table
             

      
    $q=$d->select("package_master","package_id='$plan_id'","");
    $row1=mysqli_fetch_array($q);
    $package_name= $row1['package_name'];
    $no_month=$row1['no_of_month'];
    $package_amount=$row1['package_amount'];

//9oct2020
     if($row1['gst_slab_id'] !="0"){
      $gst_slab_id = $row1['gst_slab_id'];
           $gst_master=$d->select("gst_master","slab_id = '$gst_slab_id'","");
           $gst_master_data=mysqli_fetch_array($gst_master);
           $gst_amount= (($row1["package_amount"]*$gst_master_data['slab_percentage']) /100);
    } else {
            $gst_amount= 0 ;
    }
     $package_amount=number_format($row1["package_amount"]+$gst_amount,2,'.','');
      //9oct2020
     

    $lid=$d->select("zoobizlastid","","");
    $laisZooBizId=mysqli_fetch_array($lid);
    $lastZooId= $laisZooBizId['zoobiz_last_id']+1;

    $plan_renewal_date=date('Y-m-d', strtotime(' +'.$no_month.' months'));

    $last_auto_id=$d->last_auto_id("users_master");
    $res=mysqli_fetch_array($last_auto_id);
    $user_id=$res['Auto_increment'];
    $zoobiz_id="ZB2020".$lastZooId;

   // $catArray = explode(":", $business_sub_category_id);

    $m->set_data('zoobiz_id',ucfirst($zoobiz_id));
    $m->set_data('salutation',ucfirst($salutation));


$company_master_qry=$d->select("  company_master"," city_id ='$city_id' ","");
      
     

       if (mysqli_num_rows($company_master_qry) > 0 ) {
        $company_master_data=mysqli_fetch_array($company_master_qry);
         $company_id = $company_master_data['company_id'];
         $company_name =$company_master_data['company_name'];
       } else {
         $company_id = 1;
         $company_name ="Zoobiz India Pvt. Ltd.";
       }
      
    $m->set_data('company_id',$company_id);
    $m->set_data('city_id',$city_id);
    $m->set_data('user_first_name',ucfirst($user_first_name));
    $m->set_data('user_last_name',ucfirst($user_last_name));
    $m->set_data('user_full_name',ucfirst($user_first_name).' '.ucfirst($user_last_name));
    $m->set_data('user_mobile',$user_mobile);
    $m->set_data('user_email',$user_email);
    $m->set_data('gender',$gender);
    $m->set_data('plan_renewal_date',$plan_renewal_date);
    $m->set_data('plan_id',$plan_id);

    $m->set_data('register_date', date("Y-m-d H:i:s"));
    //7oct2020
 
  $m->set_data('refer_by',$refer_by);
  
  if(isset($refere_by_name) && trim($refere_by_name)!=''){
    $m->set_data('refere_by_name',$refere_by_name);
  } else{
    $m->set_data('refere_by_name','');
  }
 
  if(isset($refere_by_phone_number) && trim($refere_by_phone_number)!=''){
     $m->set_data('refere_by_phone_number',$refere_by_phone_number);
  }else{
    $m->set_data('refere_by_phone_number','');
  }
  
  if(isset($remark) && trim($remark)!=''){
    $m->set_data('remark',$remark);
  } else {
    $m->set_data('remark','');
  }
//7oct2020
 
    $a =array(
      'zoobiz_id'=> $m->get_data('zoobiz_id'),
      'salutation'=> $m->get_data('salutation'),
      'company_id'=> $m->get_data('company_id'),

      'refer_by' => $m->get_data('refer_by'),
      'refere_by_name' => $m->get_data('refere_by_name'),
      'refere_by_phone_number' => $m->get_data('refere_by_phone_number'),
      'remark' => $m->get_data('remark'),

      
      'city_id'=> $m->get_data('city_id'),
      'user_first_name'=> $m->get_data('user_first_name'),
      'user_last_name'=> $m->get_data('user_last_name'),
      'user_full_name'=> $m->get_data('user_full_name'),
      'user_mobile'=> $m->get_data('user_mobile'),
      'user_email'=> $m->get_data('user_email'),
      'gender'=> $m->get_data('gender'),
      'register_date'=> $m->get_data('register_date'),
      'plan_id'=> $m->get_data('plan_id'),
      'plan_renewal_date'=> $m->get_data('plan_renewal_date'),
    );
  
   
  
      $m->set_data('razorpay_order_id', $_SESSION['razorpay_order_id']);
    $m->set_data('razorpay_payment_id', $razorpay_payment_id);
    $m->set_data('razorpay_signature', $razorpay_signature);


       $paymentAry = array(
          'user_id' => $user_id, 
          'package_id' => $m->get_data('plan_id'),
          'company_id'=> $m->get_data('company_id'),
          'package_name' => $package_name,
          'user_mobile' => $m->get_data('user_mobile'),
          'payment_mode' => "Razorpay Web",
          'transection_amount' => $package_amount,
          'transection_date' => date("Y-m-d H:i:s"),
          'payment_status' => "SUCCESS",
          'payment_firstname' => $m->get_data('user_first_name'),
          'payment_lastname' => $m->get_data('user_last_name'),
          'payment_phone' => $m->get_data('user_mobile'),
          'payment_email' => $m->get_data('user_email'),
          'payment_address' => $m->get_data('adress'),
           'razorpay_payment_id' => $m->get_data('razorpay_payment_id'),
          'razorpay_order_id' => $m->get_data('razorpay_order_id'),
          'razorpay_signature' => $m->get_data('razorpay_signature'),
      );

       $a11 =array(
        'zoobiz_last_id'=> $lastZooId,
      );

    $q=$d->insert("users_master",$a);
    $q3=$d->insert("transection_master",$paymentAry);
    $q4= $d->update("zoobizlastid",$a11,"id='1'");
     
    
      
     
   if($q and $q3 and $q4) {
      $d->delete("users_master_temp","user_mobile='$user_mobile'");
      $con -> commit();
      unset($_SESSION['salutation']);
      unset($_SESSION['user_first_name']);
      unset($_SESSION['user_last_name']);
      unset($_SESSION['user_email']);
      unset($_SESSION['user_mobile']);
      unset($_SESSION['gender']);
      unset($_SESSION['plan_id']);
       unset($_SESSION['city_id']);
  

      $_SESSION['show_success']="yes";
      $_SESSION['msg']="Registration Successfully !";

      

      


      //25sept2020
      $user_full_name = ucfirst($user_first_name).' '.ucfirst($user_last_name);
        $getData = $d->select("custom_settings_master"," status = 0 and send_fcm=1 and   flag = 1 ","");
         if( mysqli_num_rows($getData) > 0){ 
           $custom_settings_master_data = mysqli_fetch_array($getData);
           $description = $custom_settings_master_data['fcm_content'];
           $description =  str_replace("USER_FULL_NAME",$user_full_name,$description);
           $description =  str_replace("ANDROID_LINK",$androidLink,$description);
           $description =  str_replace("IOS_LINK",$iosLink,$description);

            /*$msg= "Dear $user_full_name\nWelcome to ZooBiz ! We're excited to provide you our ZooBiz services, and hopefully you're excited too. Let come & enjoy the world of Digital.\n Download the ZooBiz Admin App by clicking following link :\n\n (If Android User) $androidLink \n\n(If IOS User) $iosLink \n\nThanks Team ZooBiz";*/
           $d->send_sms($user_mobile,addslashes($description));

         }
      //25sept2020

         //20OCT2020
          $getData = $d->select("custom_settings_master"," status = 0 and send_fcm=1 and flag = 0 ","");
         if( mysqli_num_rows($getData) > 0 && 0 ){ 
          $custom_settings_master_data2 = mysqli_fetch_array($getData);
          $business_categories_qry = $d->select("business_categories"," business_category_id != 0 and   business_category_id ='$business_category_id' ","");
          $business_categories_data=mysqli_fetch_array($business_categories_qry);
 
           $title= "New Member Registered.";//" in ". $business_categories_data['category_name'] ." Category" ;
           $description = $custom_settings_master_data2['fcm_content'];
 

           $description =  str_replace("USER_NAME",$user_full_name,$description);
           $description =  str_replace("CAT_NAME",$business_categories_data['category_name'],$description);
 

          
            $where = "";
            if($custom_settings_master_data2['share_within_city'] ==1 ){
              $where = " and  city_id ='$city_id'";
            }
             $d->insertAllUserNotification($title,$user_full_name ." registered in ZooBiz from ".$company_name,"custom_notification",'',"active_status=0 $where");
            $user_employment_details_qry = $d->select("users_master"," active_status=0 $where  ","");

            $user_ids_array = array('0');
             while ($user_employment_details_data=mysqli_fetch_array($user_employment_details_qry)) {
              $user_ids_array[] =$user_employment_details_data['user_id'];
             }

             
             $user_ids_array = implode(",", $user_ids_array);

            
         $fcmArray=$d->get_android_fcm("users_master","user_token!='' AND  device='android' and user_id in ($user_ids_array)  ");
         
        $fcmArrayIos=$d->get_android_fcm("users_master "," user_token!='' AND  device='ios' and user_id in ($user_ids_array)    ");

        //23OCT2020
        $last_auto_id=$d->last_auto_id("users_master");
          $res=mysqli_fetch_array($last_auto_id);
          $new_user_id=$res['Auto_increment'];

          $new_user_id = ($new_user_id-1);
        //23OCT2020
          $fcm_data_array = array(
            'img' =>$base_url.'img/logo.png',
            'title' =>$title,
            'desc' => $description,
            'time' =>date("d M Y h:i A")
          );
          
         $nResident->noti("custom_notification","",0,$fcmArray,$title,$description,$fcm_data_array);
         $nResident->noti_ios("custom_notification","",0,$fcmArrayIos,$title,$description,$fcm_data_array);
       }
         //20OCT2020
       
     //send user a welcome mail start
       $to = $user_email;
      $subject ="Welcome To Zoobiz";
      
      include('../mail/welcomeUserMail.php');
      include '../mail_front.php';
      //send user a welcome mail end

        //22sept2020
       /* $notiAry = array(
                      'admin_id'=>0,
                      'notification_tittle'=>"New Member Registered.",
                      'notification_description'=>$user_full_name ." registered in ZooBiz from ".$company_name,
                      'notifiaction_date'=>date('Y-m-d H:i'),
                      'notification_action'=>'',
                      'admin_click_action '=>'adminNotification'
                    );

                    $d->insert("admin_notification",$notiAry);*/

        $zoobiz_admin_master=$d->select("zoobiz_admin_master","send_notification = '1'    ");
        while($zoobiz_admin_master_data = mysqli_fetch_array($zoobiz_admin_master)) {
           $adminname=$zoobiz_admin_master_data['admin_name'];
           $msg2= "New Member Registration in $company_name \n Name: $user_full_name \n Company Name: $company_name \nThanks Team ZooBiz";
           
                      $d->send_sms($zoobiz_admin_master_data['admin_mobile'],$msg2);
                    
         }
       //22sept2020


      header("location:../success");
    } else {
      mysqli_query("ROLLBACK");
      $_SESSION['msg1']="Something Wrong";
      header("location:../register");
    }


    }
else
{

   $_SESSION['msg1']="Error: Payment Failed, Please Try Again ";
      header("location:../register");

    
}



  }

   
 
}
else{
  $_SESSION['msg1']="Something Wrong";
  header('location:../register.php');
}
?>