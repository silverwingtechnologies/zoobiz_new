<?php include('Crypto.php');
include 'frontObjectController.php'; 
include '../zooAdmin/fcm_file/user_fcm.php';
$nResident = new firebase_resident(); 
	 
	//$workingKey='CF33EDAC825B5B39BAFB5CD2C955F90B';


$tracking_id  = $_POST['orderNo'];
$user_data_qry = $d->select("users_master_temp", "tracking_id='$tracking_id'");
$user_data = mysqli_fetch_array($user_data_qry);
$city_id = $user_data ['city_id'];


 $company_master_qry=$d->select("company_master"," city_id ='$city_id' and is_master = 0  ","");
 if (mysqli_num_rows($company_master_qry) > 0 ) {
    $company_master_data=mysqli_fetch_array($company_master_qry);
    $company_id = $company_master_data['company_id'];
} else {
    $company_id = 1;
}


$payment_getway_master_qry=$d->select("payment_getway_master,currency_master"," payment_getway_master.company_id ='$company_id' AND payment_getway_master.currency_id=currency_master.currency_id and payment_getway_master.ccav_working_key !=''  ","");
 if (mysqli_num_rows($payment_getway_master_qry) > 0 ) {
    $payment_getway_master_data=mysqli_fetch_array($payment_getway_master_qry);

    $workingKey=$payment_getway_master_data['ccav_working_key'];//Shared by CCAVENUES
    $access_code=$payment_getway_master_data['ccav_access_code'];
    $_POST['merchant_id']=$payment_getway_master_data['ccav_merchant_id'];

    
 } else {
    $workingKey='CF33EDAC825B5B39BAFB5CD2C955F90B';//Shared by CCAVENUES
    $access_code='AVGK04IC24AQ98KGQA';//Shared by CCAVENUES
    $_POST['merchant_id'] = '345038';
     
 }


  // $workingKey= $_SESSION['working_key'];		//Working Key should be provided here.
	$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
 

	$rcvdString=decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
 


	$order_status="";
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);
	echo "<center>";
$arr_data = array();
	for($i = 0; $i < $dataSize; $i++) 
	{
		$information=explode('=',$decryptValues[$i]);
		$arr_data[$information[0]]  = $information[1];
		if($i==3)	$order_status=$information[1];
	}
	 

if(empty($arr_data) || $arr_data['order_status'] !="Success"){
   

 $tracking_id =   $_POST['tracking_id']; 
   $q_tmp = $d->select("users_master_temp", "tracking_id='$tracking_id'");
    $data_tmp = mysqli_fetch_array($q_tmp);
   if ($data_tmp > 0)
   {
       $d->delete("users_master_temp", "user_mobile='$user_mobile'");
        $tran_user_id = $data_tmp['user_id'];
       $d->delete("transection_master", "user_id='$tran_user_id'");
   }


/*echo "<pre>";
   print_r($_SESSION);
 print_r($_POST);
 print_r($arr_data);
 print_r($information);
 exit;*/

   $_SESSION['msg1']="Something Wrong, Please try again";
   header("location:../register");
}

	if($arr_data['order_status']=="Success")
	{
		echo "<br>Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon.";

		//main code start

 
     	$con -> autocommit(FALSE);
     	$tracking_id = $arr_data['order_id'] ;
     	$q_temp=$d->select("users_master_temp","tracking_id='$tracking_id'");
     	if(mysqli_num_rows($q_temp) > 0  ){
          $data_temp=mysqli_fetch_array($q_temp);
			extract($data_temp);
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


     		//$q=$d->delete("users_master_temp","tracking_id='$tracking_id'");

     	} 
     	 
 
         
         	$_SESSION['payment_id'] = "<p>Your payment was successful</p>
         	<p>Order ID: {$arr_data[order_id]}</p><p>Tracking ID: {$arr_data[tracking_id]}</p>";
         	$q=$d->select("package_master","package_id='$plan_id'","");
         	$row1=mysqli_fetch_array($q);
         	$package_name= $row1['package_name'];
         	$no_month=$row1['no_of_month'];
         	$package_amount=$row1['package_amount'];
         	$package_amount_new = $row1["package_amount"];
         	$coupon_amount = 0 ;
         	$coupon_id = 0 ;
         	 

         	if($row1['gst_slab_id'] !="0"){
         		$gst_slab_id = $row1['gst_slab_id'];
         		$gst_master=$d->select("gst_master","slab_id = '$gst_slab_id'","");
         		$gst_master_data=mysqli_fetch_array($gst_master);
         		$gst_amount= (($package_amount_new*$gst_master_data['slab_percentage']) /100);
         	} else {
         		$gst_amount= 0 ;
         	}
            $package_amount_new = $arr_data['mer_amount'];
         	$package_amount= number_format($package_amount_new,2,'.',''); //number_format($package_amount_new+$gst_amount,2,'.','');
         	$lid=$d->select("zoobizlastid","","");
         	$laisZooBizId=mysqli_fetch_array($lid);
         	$lastZooId= $laisZooBizId['zoobiz_last_id']+1;
         	$plan_renewal_date=date('Y-m-d', strtotime(' +'.$no_month.' months'));
         	$zoobiz_id="ZB2020".$lastZooId;
         	$m->set_data('zoobiz_id',ucfirst($zoobiz_id));
         	$m->set_data('salutation',ucfirst($salutation));
         	$company_master_qry=$d->select("  company_master"," city_id ='$city_id' and is_master = 0  ","");
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
         	$m->set_data('refer_by',$refer_by);
         	$m->set_data('referred_by_user_id','0');
         	$m->set_data('refere_by_name','');
         	$m->set_data('refere_by_phone_number','');

         	if($refer_by==2){
         		$ref_u_qry=$d->selectRow("*","users_master"," user_id ='$referred_by_user_id'","");
         		$ref_u_data=mysqli_fetch_array($ref_u_qry);
         		$m->set_data('referred_by_user_id',$referred_by_user_id);
         		$m->set_data('refere_by_name',$ref_u_data['user_full_name']);
         		$m->set_data('refere_by_phone_number',$ref_u_data['user_mobile']);
         	}
         	if(isset($remark) && trim($remark)!=''){
         		$m->set_data('remark',$remark);
         	} else {
         		$m->set_data('remark','');
         	}

       


         	$m->set_data('razorpay_order_id', $arr_data[order_id]);
         	$m->set_data('razorpay_payment_id', $arr_data[tracking_id]);
         	$m->set_data('razorpay_signature', $arr_data[status_code]);


               $q_user=$d->select("users_master","tracking_id='$tracking_id'");
      if(mysqli_num_rows($q_user) > 0  ){
          $data_user=mysqli_fetch_array($q_user);
          $user_id = $data_user['user_id'];
         } else {
            $a =array(
               'zoobiz_id'=> $m->get_data('zoobiz_id'),
               'salutation'=> $m->get_data('salutation'),
               'company_id'=> $m->get_data('company_id'),
               'refer_by' => $m->get_data('refer_by'),
               'referred_by_user_id' => $m->get_data('referred_by_user_id'),
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
            $q=$d->insert("users_master",$a);
            $user_id = $con->insert_id;
         }
         	
         	 


         	$payment_mode = $arr_data[payment_mode];
         	if($package_amount > 0 ){ 
         		$paymentAry = array(
         			'user_id' => $user_id, 
         			'package_id' => $m->get_data('plan_id'),
         			'company_id'=> $m->get_data('company_id'),
         			'package_name' => $package_name,
         			'user_mobile' => $m->get_data('user_mobile'),
         			'payment_mode' => $payment_mode,
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
         		$q3=$d->insert("transection_master",$paymentAry);
         	}
         	$a11 =array(
         		'zoobiz_last_id'=> $lastZooId,
         	);


         	$q4= $d->update("zoobizlastid",$a11,"id='1'");
         	if($q and $q3 and $q4) {

                $a15 =array(
                'user_id'=> $user_id,
                 );
                $q5= $d->update("transection_master",$a15,"user_mobile='$$user_mobile'");


         		$d->delete("users_master_temp","tracking_id='$tracking_id'");
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
         		$user_full_name = ucfirst($user_first_name).' '.ucfirst($user_last_name);
         		$getData = $d->select("custom_settings_master"," status = 0 and send_fcm=1 and   flag = 1 ","");
         		if( mysqli_num_rows($getData) > 0){ 
         			$custom_settings_master_data = mysqli_fetch_array($getData);
         			$description = $custom_settings_master_data['fcm_content'];
         			$description =  str_replace("USER_FULL_NAME",$user_full_name,$description);
         			$description =  str_replace("ANDROID_LINK",$androidLink,$description);
         			$description =  str_replace("IOS_LINK",$iosLink,$description);
         			$d->sms_to_member_on_registration($user_mobile,$user_full_name,$androidLink,$iosLink);
         		}
         		$ref_by_data ="Other ";
         		if($refer_by==2){
         			$refere_by_phone_number = $refere_by_phone_number;
         			$ref_users_master = $d->selectRow("user_mobile,user_token,device,user_full_name","users_master", "user_mobile = '$refere_by_phone_number' or user_id = '$refer_friend_id'");

         			if (mysqli_num_rows($ref_users_master) > 0) {
         				$ref_users_master_data = mysqli_fetch_array($ref_users_master);

         				$ref_by_data = ucfirst($ref_users_master_data['user_full_name']);
         			} else {
         				$ref_by_data = ucfirst($refere_by_name);
         			}
         		}
         		if($refer_by==1){ 
         			$ref_by_data ="Social Media";
         		} else if($refer_by==3){ 
         			$ref_by_data ="Other ";
         			if($remark !=''){
         				$ref_by_data .=" -".$remark;
         			}
         		}  

         		$cities = $d->selectRow("city_name","cities", "city_id = '$city_id'    ");
         		$cities_data = mysqli_fetch_array($cities);


         //send user a welcome mail start
         		$to = $user_email;
         		$subject ="Welcome To Zoobiz";
         		$user_full_name = ucfirst($user_first_name).' '.ucfirst($user_last_name);
         		include('../mail/welcomeUserMail.php');
         		include '../mail_front.php';
          //send user a welcome mail end

         		header("location:../success");
         	} else {
         		mysqli_query("ROLLBACK");
         		$_SESSION['msg1']=$arr_data['order_status']. " Something Wrong . . ";
         		header("location:../register");
         	}
          

     
		//main code end
		
	}
	else if($order_status==="Aborted")
	{
		//echo "<br>Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail";
		$_SESSION['msg1']=$arr_data['order_status']. " Something Wrong . . .";
        header("location:../register");
	}
	else if($order_status==="Failure")
	{
		//echo "<br>Thank you for shopping with us.However,the transaction has been declined.";
		$_SESSION['msg1']=$arr_data['order_status']." Something Wrong . . . .";
        header("location:../register");
	}
	else
	{
		//echo "<br>Security Error. Illegal access detected";
		$_SESSION['msg1']=$arr_data['order_status']." Something Wrong . ";
        header("location:../register");
	
	}

	/*echo "<br><br>";

	echo "<table cellspacing=4 cellpadding=4>";
	for($i = 0; $i < $dataSize; $i++) 
	{
		$information=explode('=',$decryptValues[$i]);
	    	echo '<tr><td>'.$information[0].'</td><td>'.$information[1].'</td></tr>';
	}

	echo "</table><br>";
	echo "</center>";*/
?>
