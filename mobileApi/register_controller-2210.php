<?php
include_once 'lib.php';

if (isset($_POST) && !empty($_POST)) {

	if ($key == $keydb) {
		$response = array();
		extract(array_map("test_input", $_POST));
		$today = date('Y-m-d');

		if (isset($user_register_temp) && $user_register_temp == 'user_register_temp' && filter_var($userMobile, FILTER_VALIDATE_INT) == true) {
			$userMobile = mysqli_real_escape_string($con, $userMobile);

			if (strlen($userMobile) < 8) {
				$response["message"] = "Please Entere Valid Mobile Number";
				$response["status"] = "201";
				echo json_encode($response);
				exit();
			}

			$q11 = $d->select("users_master", "user_mobile='$userMobile'");
			$data = mysqli_fetch_array($q11);
			if ($data > 0) {
				$response["message"] = "Mobile Number Already Register !";
				$response["status"] = "201";
				echo json_encode($response);
				exit();
			}

			$company_master_qry = $d->select("  company_master", " city_id ='$city_id' ", "");
			if (mysqli_num_rows($company_master_qry) > 0) {
				$company_master_data = mysqli_fetch_array($company_master_qry);
				$company_id = $company_master_data['company_id'];
			} else {
				$company_id = 1;
			}

			$m->set_data('company_id', $company_id);

			$user_first_name = ucfirst($user_first_name);
			$user_last_name = ucfirst($user_last_name);
			$gst_number = strtoupper($gst_number);
			$m->set_data('salutation', ucfirst($salutation));
			$m->set_data('user_first_name', ucfirst($user_first_name));
			$m->set_data('user_last_name', ucfirst($user_last_name));
			$m->set_data('user_full_name', ucfirst($user_first_name) . ' ' . ucfirst($user_last_name));
			$m->set_data('user_mobile', $userMobile);
			$m->set_data('city_id', $city_id);
			$m->set_data('user_email', $user_email);
			$m->set_data('gender', $gender);
			$m->set_data('plan_id', $plan_id);

			$m->set_data('register_date', date("Y-m-d H:i:s"));
			//7oct2020
 
			  $m->set_data('refer_by',$refer_type);
			  
			  if(isset($refer_friend_name) && trim($refer_friend_name)!=''){
			    $m->set_data('refere_by_name',$refer_friend_name);
			  } else{
			    $m->set_data('refere_by_name','');
			  }
			 
			  if(isset($refer_friend_no) && trim($refer_friend_no)!=''){
			     $m->set_data('refere_by_phone_number',$refer_friend_no);
			  }else{
			    $m->set_data('refere_by_phone_number','');
			  }
			  
			  if(isset($refer_remark) && trim($refer_remark)!=''){
			    $m->set_data('remark',$refer_remark);
			  } else {
			    $m->set_data('remark','');
			  }
			//7oct2020
			$a = array(
				'salutation' => $m->get_data('salutation'),
				'user_first_name' => $m->get_data('user_first_name'),
				'user_last_name' => $m->get_data('user_last_name'),
				'user_full_name' => $m->get_data('user_full_name'),
				'user_mobile' => $m->get_data('user_mobile'),
				'user_email' => $m->get_data('user_email'),
				'city_id' => $m->get_data('city_id'),
				'gender' => $m->get_data('gender'),
				'user_email' => $m->get_data('user_email'),
				'register_date' => $m->get_data('register_date'),
				'plan_id' => $m->get_data('plan_id'),
				'company_id' => $m->get_data('company_id'),
				'refer_by' => $m->get_data('refer_by'),
		      	'refere_by_name' => $m->get_data('refere_by_name'),
		      	'refere_by_phone_number' => $m->get_data('refere_by_phone_number'),
		      	'remark' => $m->get_data('remark')

			);

			$q = $d->select("users_master_temp", "user_mobile='$userMobile'");
			$data = mysqli_fetch_array($q);
			if ($data > 0) {
				$q = $d->update("users_master_temp", $a, "user_mobile = '$userMobile'");
			} else {
				$q = $d->insert("users_master_temp", $a);
			}

			if ($q > 0) {

				if (isset($city_id)) {

					$company_master_qry = $d->select("company_master", " city_id ='$city_id' ", "");

					if (mysqli_num_rows($company_master_qry) > 0) {
						$company_master_data = mysqli_fetch_array($company_master_qry);
						$company_id = $company_master_data['company_id'];
					} else {
						$company_id = 1;
					}

					$payment_getway_master_qry = $d->select("payment_getway_master", " company_id ='$company_id' ", "");

					if (mysqli_num_rows($payment_getway_master_qry) > 0) {
						$payment_getway_master_data = mysqli_fetch_array($payment_getway_master_qry);
						$currency_id = $payment_getway_master_data['currency_id'];
						$currency_master_qry = $d->select("currency_master", " currency_id ='$currency_id' ", "");
						$currency_master_data = mysqli_fetch_array($currency_master_qry);
						$keyId = $payment_getway_master_data['merchant_id'];
						$keySecret = $payment_getway_master_data['merchant_key'];
						$displayCurrency = $currency_master_data['currency_code'];
					} else {
						$keyId = 'rzp_live_5y1DZZJ3OBJO75';
						$keySecret = 'Eeyz7w1TTXBtCx0TiO4wZeCf';
						$displayCurrency = 'INR';
					}
				} else {
					$keyId = 'rzp_live_5y1DZZJ3OBJO75';
					$keySecret = 'Eeyz7w1TTXBtCx0TiO4wZeCf';
					$displayCurrency = 'INR';
				}

				$response["keyId"] = $keyId;
				$response["keySecret"] = $keySecret;
				$response["displayCurrency"] = $displayCurrency;
				$response["message"] = "Registration Successfully";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "Something Went Wrong";
				$response["status"] = "201";
				echo json_encode($response);

			}

		} else if ($_POST['get_cities'] == "get_cities") {

			$qA2 = $d->select("cities", "city_flag=1", "");

			if (mysqli_num_rows($qA2) > 0) {

				$response["cities"] = array();

				while ($data_app2 = mysqli_fetch_array($qA2)) {

					$cities = array();
					$cities["city_id"] = $data_app2["city_id"];
					$cities["city_name"] = $data_app2["city_name"];
					array_push($response["cities"], $cities);

				}

				$response["message"] = "Get cities info success.";
				$response["status"] = "200";
				echo json_encode($response);
			} else {

				$response["message"] = "No cities info found";
				$response["status"] = "201";
				echo json_encode($response);
			}
		} else if (isset($user_register) && $user_register == 'user_register' && filter_var($userMobile, FILTER_VALIDATE_INT) == true) {
			$con->autocommit(FALSE);

			$q = $d->select("package_master", "package_id='$plan_id'", "");
			$row1 = mysqli_fetch_array($q);
			$package_name = $row1['package_name'];
			$no_month = $row1['no_of_month'];
			$package_amount = $row1['package_amount'];

			 
//plan_with_gst_amount anount with gst will come as a parameter
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




			$lid = $d->select("zoobizlastid", "", "");
			$laisZooBizId = mysqli_fetch_array($lid);
			$lastZooId = $laisZooBizId['zoobiz_last_id'] + 1;

			$plan_renewal_date = date('Y-m-d', strtotime(' +' . $no_month . ' months'));

			$last_auto_id = $d->last_auto_id("users_master");
			$res = mysqli_fetch_array($last_auto_id);
			$user_id = $res['Auto_increment'];
			$zoobiz_id = "ZB2020" . $lastZooId;

			$q = $d->select("users_master_temp", "user_mobile='$userMobile'");
			$dataTemp = mysqli_fetch_array($q);

			// $catArray = explode(":", $business_sub_category_id);

			$m->set_data('zoobiz_id', ucfirst($zoobiz_id));
			$m->set_data('salutation', ucfirst($salutation));
			$m->set_data('user_first_name', ucfirst($user_first_name));
			$m->set_data('user_last_name', ucfirst($user_last_name));
			$m->set_data('user_full_name', ucfirst($user_first_name) . ' ' . ucfirst($user_last_name));
			// $m->set_data('member_date_of_birth',$member_date_of_birth);
			$m->set_data('whatsapp_number', $whatsapp_number);
			$m->set_data('user_mobile', $userMobile);
			$m->set_data('user_email', $user_email);
			$m->set_data('company_id', $dataTemp['company_id']);
			$m->set_data('city_id', $dataTemp['city_id']);
			$m->set_data('gender', $gender);
			$m->set_data('user_email', $user_email);
			// $m->set_data('user_profile_pic',$user_profile_pic);
			$m->set_data('plan_renewal_date', $plan_renewal_date);
			$m->set_data('plan_id', $plan_id);

			$m->set_data('register_date', date("Y-m-d H:i:s"));
			//7oct2020
 
			  $m->set_data('refer_by',$refer_type);
			  
			  if(isset($refer_friend_name) && trim($refer_friend_name)!=''){
			    $m->set_data('refere_by_name',$refer_friend_name);
			  } else{
			    $m->set_data('refere_by_name','');
			  }
			 
			  if(isset($refer_friend_no) && trim($refer_friend_no)!=''){
			     $m->set_data('refere_by_phone_number',$refer_friend_no);
			  }else{
			    $m->set_data('refere_by_phone_number','');
			  }
			  
			  if(isset($refer_remark) && trim($refer_remark)!=''){
			    $m->set_data('remark',$refer_remark);
			  } else {
			    $m->set_data('remark','');
			  }
			//7oct2020
			$a = array(
				'zoobiz_id' => $m->get_data('zoobiz_id'),
				'salutation' => $m->get_data('salutation'),
				'user_first_name' => $m->get_data('user_first_name'),
				'user_last_name' => $m->get_data('user_last_name'),
				'user_full_name' => $m->get_data('user_full_name'),
				'company_id' => $m->get_data('company_id'),
				'city_id' => $m->get_data('city_id'),
				// 'member_date_of_birth'=> $m->get_data('member_date_of_birth'),
				'user_mobile' => $m->get_data('user_mobile'),
				'whatsapp_number' => $m->get_data('whatsapp_number'),
				'user_email' => $m->get_data('user_email'),
				'gender' => $m->get_data('gender'),
				'user_email' => $m->get_data('user_email'),
				// 'user_profile_pic'=> $m->get_data('user_profile_pic'),
				'register_date' => $m->get_data('register_date'),
				'plan_id' => $m->get_data('plan_id'),
				'plan_renewal_date' => $m->get_data('plan_renewal_date'),
				'refer_by' => $m->get_data('refer_by'),
		      	'refere_by_name' => $m->get_data('refere_by_name'),
		      	'refere_by_phone_number' => $m->get_data('refere_by_phone_number'),
		      	'remark' => $m->get_data('remark')
			);

			$m->set_data('razorpay_order_id', $razorpay_order_id);
			$m->set_data('razorpay_payment_id', $razorpay_payment_id);
			$m->set_data('razorpay_signature', $razorpay_signature);

			$paymentAry = array(
				'user_id' => $user_id,
				'package_id' => $m->get_data('plan_id'),
				'package_name' => $package_name,
				'user_mobile' => $m->get_data('user_mobile'),
				'payment_mode' => "Razorpay App",
				'transection_amount' => $package_amount,
				'transection_date' => date("Y-m-d H:i:s"),
				'payment_status' => "SUCCESS",
				'payment_firstname' => $m->get_data('user_first_name'),
				'payment_lastname' => $m->get_data('user_last_name'),
				'payment_phone' => $m->get_data('user_mobile'),
				'payment_email' => $m->get_data('user_email'),
				// 'payment_address' => $m->get_data('adress'),
				'razorpay_payment_id' => $m->get_data('razorpay_payment_id'),
				'razorpay_order_id' => $m->get_data('razorpay_order_id'),
				'razorpay_signature' => $m->get_data('razorpay_signature'),
			);

			$a11 = array(
				'zoobiz_last_id' => $lastZooId,
			);

			$q = $d->insert("users_master", $a);
			// $q1=$d->insert("user_employment_details",$compAry);
			// $q2=$d->insert("business_adress_master",$adrAry);
			$q3 = $d->insert("transection_master", $paymentAry);
			$q4 = $d->update("zoobizlastid", $a11, "id='1'");

			if ($q and $q3 and $q4) {
				$d->delete("users_master_temp", "user_mobile='$user_mobile'");
				$con->commit();

				$response["message"] = "Registration Successfully, Please Login & Complete Your Profile !";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				mysqli_query("ROLLBACK");
				$response["message"] = "Something Wrong";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} else if (isset($complete_profile) && $complete_profile == 'complete_profile' && filter_var($user_id, FILTER_VALIDATE_INT) == true) {
			$con->autocommit(FALSE);

			//add in original table

			$extension = array("jpeg", "jpg", "png", "gif", "JPG", "jpeg", "JPEG", "PNG");
			$uploadedFile = $_FILES['user_profile_pic']['tmp_name'];
			$ext = pathinfo($_FILES['user_profile_pic']['name'], PATHINFO_EXTENSION);

			if (file_exists($uploadedFile)) {
				if (in_array($ext, $extension)) {
					$sourceProperties = getimagesize($uploadedFile);
					$newFileName = rand() . $user_id;
					$dirPath = "../img/users/members_profile/";
					$imageType = $sourceProperties[2];
					$imageHeight = $sourceProperties[1];
					$imageWidth = $sourceProperties[0];

					if ($imageWidth > 800) {
						$newWidthPercentage = 800 * 100 / $imageWidth; //for maximum 400 widht
						$newImageWidth = $imageWidth * $newWidthPercentage / 100;
						$newImageHeight = $imageHeight * $newWidthPercentage / 100;
					} else {
						$newImageWidth = $imageWidth;
						$newImageHeight = $imageHeight;
					}

					switch ($imageType) {

					case IMAGETYPE_PNG:
						$imageSrc = imagecreatefrompng($uploadedFile);
						$tmp = imageResize($imageSrc, $sourceProperties[0], $sourceProperties[1], $newImageWidth, $newImageHeight);
						imagepng($tmp, $dirPath . $newFileName . "_profile." . $ext);
						break;

					case IMAGETYPE_JPEG:
						$imageSrc = imagecreatefromjpeg($uploadedFile);
						$tmp = imageResize($imageSrc, $sourceProperties[0], $sourceProperties[1], $newImageWidth, $newImageHeight);
						imagejpeg($tmp, $dirPath . $newFileName . "_profile." . $ext);
						break;

					case IMAGETYPE_GIF:
						$imageSrc = imagecreatefromgif($uploadedFile);
						$tmp = imageResize($imageSrc, $sourceProperties[0], $sourceProperties[1], $newImageWidth, $newImageHeight);
						imagegif($tmp, $dirPath . $newFileName . "_profile." . $ext);
						break;

					default:
						// $_SESSION['msg1']="Invalid Profile Photo";
						// header("Location: ../register");
						// exit;
						break;
					}
					$user_profile_pic = $newFileName . "_profile." . $ext;

				} else {
					// $_SESSION['msg1']="Invalid Profile Photo";
					// header("location:../register");
					// exit();
				}
			} else {
				$user_profile_pic = "";
			}

			// $catArray = explode(":", $business_sub_category_id);
			$m->set_data('salutation', ucfirst($salutation));
			$m->set_data('user_first_name', ucfirst($user_first_name));
			$m->set_data('user_last_name', ucfirst($user_last_name));
			$m->set_data('user_full_name', ucfirst($user_first_name) . ' ' . ucfirst($user_last_name));
			if ($member_date_of_birth != "") {
				$m->set_data('member_date_of_birth', date("Y-m-d", strtotime($member_date_of_birth)));
			} else {
				$m->set_data('member_date_of_birth', "");
			}
			$m->set_data('whatsapp_number', $whatsapp_number);
			// $m->set_data('user_mobile',$userMobile);
			$m->set_data('user_email', $user_email);
			$m->set_data('gender', $gender);
			$m->set_data('user_profile_pic', $user_profile_pic);

			$m->set_data('company_name', $company_name);
			$m->set_data('company_contact_number', $company_contact_number);
			$m->set_data('business_category_id', $business_category_id);
			$m->set_data('business_sub_category_id', $business_sub_category_id);
			$m->set_data('designation', $designation);
			$m->set_data('company_website', $company_website);
			$m->set_data('gst_number', strtoupper($gst_number));

			$m->set_data('adress', $adress);
			$m->set_data('area_id', $area_id);
			$m->set_data('city_id', $city_id);
			$m->set_data('state_id', $state_id);
			$m->set_data('country_id', $country_id);
			$m->set_data('pincode', $pincode);
			$m->set_data('latitude', $latitude);
			$m->set_data('longitude', $longitude);
			$m->set_data('adress_type', $adress_type);
			$m->set_data('register_date', date("Y-m-d H:i:s"));

			$a = array(
				'salutation' => $m->get_data('salutation'),
				'user_first_name' => $m->get_data('user_first_name'),
				'user_last_name' => $m->get_data('user_last_name'),
				'user_full_name' => $m->get_data('user_full_name'),
				'member_date_of_birth' => $m->get_data('member_date_of_birth'),
				'whatsapp_number' => $m->get_data('whatsapp_number'),
				'user_email' => $m->get_data('user_email'),
				'gender' => $m->get_data('gender'),
				'user_profile_pic' => $m->get_data('user_profile_pic'),
			);

			$compAry = array(
				'user_id' => $user_id,
				'company_name' => $m->get_data('company_name'),
				'company_contact_number' => $m->get_data('company_contact_number'),
				'business_category_id' => $m->get_data('business_category_id'),
				'business_sub_category_id' => $m->get_data('business_sub_category_id'),
				'designation' => $m->get_data('designation'),
				'company_website' => $m->get_data('company_website'),
				'gst_number' => $m->get_data('gst_number'),

			);

			$adrAry = array(
				'user_id' => $user_id,
				'adress' => $m->get_data('adress'),
				'area_id' => $m->get_data('area_id'),
				'city_id' => $m->get_data('city_id'),
				'state_id' => $m->get_data('state_id'),
				'country_id' => $m->get_data('country_id'),
				'pincode' => $m->get_data('pincode'),
				'add_latitude' => $m->get_data('latitude'),
				'add_longitude' => $m->get_data('longitude'),
				'adress_type' => $m->get_data('adress_type'),
			);

			$q = $d->update("users_master", $a, "user_id='$user_id'");
			$q1 = $d->insert("user_employment_details", $compAry);
			$q2 = $d->insert("business_adress_master", $adrAry);

			if ($q and $q1 and $q2) {
				$con->commit();

				$androidLink = 'https://play.google.com/store/apps/details?id=com.silverwing.zoobiz';
				$iosLink = '#';

				$getData = $d->select("custom_settings_master", " status = 0 and send_fcm=1 and flag = 0 ", "");
				if (mysqli_num_rows($getData) > 0) {
					$custom_settings_master_data = mysqli_fetch_array($getData);
					$business_categories_qry = $d->select("business_categories", " business_category_id ='$business_category_id' ", "");
					$business_categories_data = mysqli_fetch_array($business_categories_qry);

					$title = "New Member Registered."; //" in ". $business_categories_data['category_name'] ." Category" ;
					$description = $custom_settings_master_data['fcm_content'];
					$description = str_replace("USER_NAME", ucfirst($user_first_name) . ' ' . ucfirst($user_last_name), $description);
					$description = str_replace("CAT_NAME", $business_categories_data['category_name'], $description);

					//$description= $custom_settings_master_data['fcm_content'];

					// $d->insertAllUserNotification($title,$description,"circulars",'','');

					$where = "";
		            if($custom_settings_master_data['share_within_city'] ==1 ){
		              $where = " and  city_id ='$city_id'";
		            }

            
					$user_employment_details_qry = $d->select("users_master", " active_status=0 $where ", "");
					$user_ids_array = array('0');
					while ($user_employment_details_data = mysqli_fetch_array($user_employment_details_qry)) {
						$user_ids_array[] = $user_employment_details_data['user_id'];
					}
					$user_ids_array = implode(",", $user_ids_array);

					$fcmArray = $d->get_android_fcm("users_master", "user_token!='' AND  device='android' and user_id in ($user_ids_array) AND user_id != $user_id");

					$fcmArrayIos = $d->get_android_fcm("users_master ", " user_token!='' AND  device='ios' and user_id in ($user_ids_array)   AND user_id != $user_id ");
					$nResident->noti("mainCategory", "", 0, $fcmArray, $title, $description, 'mainCategory');
					$nResident->noti_ios("mainCategory", "", 0, $fcmArrayIos, $title, $description, 'mainCategory');
				}


				$notiAry = array(
					'admin_id' => 0,
					'notification_tittle' => "New Member Registered.",
					'notification_description' => ucfirst($user_first_name) . ' ' . ucfirst($user_last_name) . " registered in ZooBiz from " . $company_name_user,
					'notifiaction_date' => date('Y-m-d H:i'),
					'notification_action' => '',
					'admin_click_action ' => 'adminNotification',
				);
				$d->insert("admin_notification", $notiAry);

				$company_master_qry = $d->select("  company_master", " city_id ='$city_id' ", "");

				if (mysqli_num_rows($company_master_qry) > 0) {
					$company_master_data = mysqli_fetch_array($company_master_qry);
					$company_id = $company_master_data['company_id'];
					$company_name_c = $company_master_data['company_name'];
				} else {
					$company_id = 1;
					$company_name_c = "Zoobiz India Pvt. Ltd.";
				}

				$zoobiz_admin_master = $d->select("zoobiz_admin_master", "send_notification = '1'    ");
				while ($zoobiz_admin_master_data = mysqli_fetch_array($zoobiz_admin_master)) {
					$adminname = $zoobiz_admin_master_data['admin_name'];
					$msg2 = "New Member Registration in $company_name_c \nName: " . ucfirst($user_first_name) . ' ' . ucfirst($user_last_name) . " \nCompany Name: $company_name \nThanks Team ZooBiz";

					$d->send_sms($zoobiz_admin_master_data['admin_mobile'], $msg2);

				}

				$getDataq = $d->select("custom_settings_master", " status = 0 and send_fcm=1 and   flag = 1 ", "");

				if (mysqli_num_rows($getDataq) > 0) {
					$custom_settings_master_data = mysqli_fetch_array($getDataq);

					$user_full_name = ucfirst($user_first_name) . ' ' . ucfirst($user_last_name);
					$description = $custom_settings_master_data['fcm_content'];
					$description = str_replace("USER_FULL_NAME", $user_full_name, $description);
					$description = str_replace("ANDROID_LINK", $androidLink, $description);
					$description = str_replace("IOS_LINK", $iosLink, $description);

					$d->send_sms($user_mobile, addslashes($description));

				}

				$q = $d->select("users_master", "user_id ='$user_id' ");
				$user_data = mysqli_fetch_array($q);

				$tq11 = $d->select("users_master,timeline_master", "users_master.user_id=timeline_master.user_id AND  timeline_master.user_id='$user_id'", "");
				$total_post = mysqli_num_rows($tq11);

				$tq22 = $d->select("users_master,follow_master,user_employment_details,business_categories,business_sub_categories", "business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND follow_master.follow_to=users_master.user_id AND follow_master.follow_by='$user_id'", "ORDER BY users_master.user_full_name ASC");

				$tq33 = $d->select("users_master,follow_master,user_employment_details,business_categories,business_sub_categories", "business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND follow_master.follow_by=users_master.user_id AND follow_master.follow_to='$user_id'", "ORDER BY users_master.user_full_name ASC");
				$following = mysqli_num_rows($tq22);
				$followers = mysqli_num_rows($tq33);

				$d->update("users_master", $a, "user_mobile='$user_mobile' AND user_mobile!='' AND user_mobile!='0'");

				$q11 = $d->select("user_employment_details", "user_id ='$user_data[user_id]'");
				$profData = mysqli_fetch_array($q11);

				$qA2 = $d->select("business_adress_master,cities,states,countries,area_master", "business_adress_master.user_id='$user_data[user_id]'
		                AND
		                business_adress_master.country_id = countries.country_id
		                AND
		                business_adress_master.state_id = states.state_id
		                AND
		                business_adress_master.city_id = cities.city_id
		                AND
		                business_adress_master.area_id = area_master.area_id AND business_adress_master.adress_type=0", "");
				$addData = mysqli_fetch_array($qA2);

				$response["user_id"] = $user_data['user_id'];
				$response["zoobiz_id"] = $user_data['zoobiz_id'];

				$response["plan_renewal_date"] = date("d M Y", strtotime($user_data['plan_renewal_date']));

				$response["facebook"] = $user_data['facebook'];
				$response["instagram"] = $user_data['instagram'];
				$response["linkedin"] = $user_data['linkedin'];
				$response["twitter"] = $user_data['twitter'];

				$response["salutation"] = $user_data['salutation'];
				$response["user_full_name"] = $user_data['user_full_name'];
				$response["user_first_name"] = $user_data['user_first_name'];
				$response["user_last_name"] = $user_data['user_last_name'];
				$response["gender"] = $user_data['gender'];
				if ($user_data['member_date_of_birth'] != "") {
					# code...
					$response["member_date_of_birth"] = date("d/m/Y", strtotime($user_data['member_date_of_birth']));
				} else {
					$response["member_date_of_birth"] = "";

				}

				$response["user_mobile"] = $user_data['user_mobile'];
				$response["alt_mobile"] = $user_data['alt_mobile'];
				$response["user_email"] = $user_data['user_email'];
				$response["whatsapp_number"] = $user_data['whatsapp_number'];

				$response["public_mobile"] = $user_data['public_mobile'];
				$response["whatsapp_privacy"] = $user_data['whatsapp_privacy'];
				$response["cllassified_mute"] = $user_data['cllassified_mute'];

				$response["user_profile_pic"] = $base_url . "img/users/members_profile/" . $user_data['user_profile_pic'];

				$response["company_name"] = $profData['company_name'] . '';
				$response["designation"] = $profData['designation'] . '';

				$response["address"] = $addData['adress'] . '';
				$response["country_id"] = $addData['country_id'] . '';
				$response["state_id"] = $addData['state_id'] . '';
				$response["city_id"] = $addData['city_id'] . '';
				$response["area_id"] = $addData['area_id'] . '';
				$response["country_name"] = $addData['country_name'] . '';
				$response["state_name"] = $addData['state_name'] . '';
				$response["city_name"] = $addData['city_name'] . '';
				$response["area_name"] = $addData['area_name'] . '';
				$response["latitude"] = $addData['add_latitude'] . '';
				$response["longitude"] = $addData['add_longitude'] . '';

				$response["plan_renewal_date"] = date("d M Y", strtotime($user_data['plan_renewal_date']));
				$response["total_post"] = $total_post . '';
				$response["followers"] = $followers . '';
				$response["following"] = $following . '';

				$response["message"] = "Your Profile Updated Successfully!";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				mysqli_query("ROLLBACK");
				$response["message"] = "Something Wrong";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} else {
			$response["message"] = "wrong tag.";
			$response["status"] = "201";
			echo json_encode($response);

		}

	} else {

		$response["message"] = "wrong api key.";
		$response["status"] = "201";
		echo json_encode($response);

	}

}

?>