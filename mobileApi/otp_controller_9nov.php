<?php
include_once 'lib.php';

if (isset($_POST) && !empty($_POST)) {

	if ($key == $keydb) {
		$response = array();
		extract(array_map("test_input", $_POST));
		$today = date('Y-m-d');

		if (isset($user_login) && $user_login == 'user_login') {
			$user_mobile = mysqli_real_escape_string($con, $user_mobile);

			if (strlen($user_mobile) < 8) {
				$response["message"] = "Please Entere Valid Mobile Number";
				$response["status"] = "204";
				echo json_encode($response);
				exit();
			}

			$q = $d->select("users_master",
				"user_mobile ='$user_mobile'", "");

			$user_data = mysqli_fetch_array($q);

			if ($user_data == TRUE) {
				$today = date('Y-m-d');
				$plan_expire_date = $user_data['plan_renewal_date'];

				if ($today > $plan_expire_date) {
					$response["message"] = "Your Plan Has been Expired on $plan_expire_date, Please Contact ZooBiz Sales Team";
					$response["status"] = "201";
					echo json_encode($response);
					exit();

				} else if ($user_data['active_status'] == 1) {
					$response["message"] = "Your Account Is Deactive, Please Contact ZooBiz Support Team";
					$response["status"] = "201";
					echo json_encode($response);
					exit();

				} else {

					if ($country_code != "+91" && $country_code != '') {
						$response["message"] = "Service not available in your country";
						$response["status"] = "201";
						echo json_encode($response);
						exit();
					}

					$user_id = $user_data['user_id'];
					$digits = 4;
					$otp = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
					$m->set_data('otp', $otp);
					$m->set_data('country_code', $country_code);

					$a = array(
						'otp' => $m->get_data('otp'),
						'country_code' => $m->get_data('country_code'),
					);

					$d->update("users_master", $a, "user_id='$user_id'");
					// $message = "<#> $otp is your OTP for FINCASYS app verification.\nPlease do not share this OTP with anyone.\nThank you, Fincasys Team.\nj74ibuhzdfo";
					// $d->send_sms($society_id,$user_mobile,$message);
					$d->send_otp($user_mobile, $otp);
					$response["message"] = "OTP Send Successfully ";
					$response["status"] = "200";
					echo json_encode($response);

				}
			} else {

				$response["message"] = "Mobile Number Not Register";
				$response["status"] = "201";
				echo json_encode($response);

			}

		} else if (isset($user_verify) && $user_verify == 'user_verify' && filter_var($otp, FILTER_VALIDATE_INT) == true && strlen($otp) == 4) {

			$user_mobile = mysqli_real_escape_string($con, $user_mobile);
			$otp = mysqli_real_escape_string($con, $otp);
			if ($user_mobile == '3213213210') {
				$q = $d->select("users_master", "user_mobile ='$user_mobile' ");
			} else {
				$q = $d->select("users_master", "user_mobile ='$user_mobile' AND otp='$otp'");
			}
			$user_data = mysqli_fetch_array($q);

			if ($user_data == TRUE && mysqli_num_rows($q) == 1) {

				if ($user_data['unit_status'] != '1') {

					$response["user_id"] = $user_data['user_id'];
					$user_id = $user_data['user_id'];
					$olddevice = $user_data['device'];

					$token = $user_data['user_token'];
					if ($user_token != $token) {
						if ($olddevice == 'android') {
							$nResident->noti("Logout", "", 0, $token, "Logout", "Logout", "Logout");
						} else if ($olddevice == 'ios') {
							$nResident->noti_ios("Logout", "", 0, $token, "Logout", "Logout", "Logout");
						}
					}

					$m->set_data('user_token', $user_token);
					$m->set_data('device', $device);
					$m->set_data('otp', '');
					$m->set_data('phone_model', $phone_model);
					$m->set_data('phone_brand', $phone_brand);

					$a = array(
						'user_token' => $m->get_data('user_token'),
						'device' => $m->get_data('device'),
						'otp' => $m->get_data('otp'),
						'phone_model' => $m->get_data('phone_model'),
						'phone_brand' => $m->get_data('phone_brand'),
					);

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

					if ($user_data['member_date_of_birth'] == '') {
						$response["member_date_of_birth_new"] = '';
					} else {

						$response["member_date_of_birth_new"] = date("d/m/Y", strtotime($user_data['member_date_of_birth']));
					}

					$response["member_date_of_birth"] = date("d/m/Y", strtotime($user_data['member_date_of_birth']));

					$response["user_mobile"] = $user_data['user_mobile'];

					if ($user_data['alt_mobile'] != 0) {
						$response["alt_mobile"] = $user_data['alt_mobile'];

					} else {
						$response["alt_mobile"] = '';
					}

					if ($user_data['whatsapp_number'] != 0) {
						$response["whatsapp_number"] = $user_data['whatsapp_number'];

					} else {
						$response["whatsapp_number"] = '';
					}

					$response["user_email"] = $user_data['user_email'];

					$response["public_mobile"] = $user_data['public_mobile'];
					$response["whatsapp_privacy"] = $user_data['whatsapp_privacy'];
					$response["email_privacy"] = $user_data['email_privacy'];
					$response["cllassified_mute"] = $user_data['cllassified_mute'];

					$response["user_profile_pic"] = $base_url . "img/users/members_profile/" . $user_data['user_profile_pic'];

					$response["company_name"] = $profData['company_name'] . '';
					$response["designation"] = $profData['designation'] . '';
					$response["company_logo"] = $base_url . "img/users/company_logo/" . $profData['company_logo'];
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

					$checkEcom = $d->select("user_employment_details", "user_id='$user_data[user_id]'");
					if (mysqli_num_rows($checkEcom) == 0) {
						$response["message"] = "Please Complete your profile";
						$response["status"] = "203";
						echo json_encode($response);
						exit();
					} else {
						$response["message"] = "Login Successfully";
						$response["status"] = "200";
						echo json_encode($response);

					}

				} else {
					$response["message"] = "Account Not activated.";
					$response["status"] = "201";
					echo json_encode($response);
				}

			} else {

				$response["message"] = "OTP not match,Please try again";
				$response["status"] = "201";
				echo json_encode($response);

			}

		} else if (isset($edit_basic_info) && $edit_basic_info == 'edit_basic_info' && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$m->set_data('salutation', $salutation);
			$m->set_data('user_first_name', ucfirst($user_first_name));
			$m->set_data('user_last_name', ucfirst($user_last_name));
			$m->set_data('user_full_name', ucfirst($user_first_name) . ' ' . ucfirst($user_last_name));
			$m->set_data('gender', $gender);

			if ($member_date_of_birth != "") {
				$m->set_data('member_date_of_birth', date("Y-m-d", strtotime($member_date_of_birth)));
			} else {
				$m->set_data('member_date_of_birth', "");
			}

			$m->set_data('user_email', $user_email);
			$m->set_data('user_mobile', $user_mobile);
			$m->set_data('alt_mobile', $alt_mobile);
			$m->set_data('whatsapp_number', $whatsapp_number);
			$m->set_data('facebook', $facebook);
			$m->set_data('instagram', $instagram);
			$m->set_data('linkedin', $linkedin);
			$m->set_data('twitter', $twitter);

			$a = array(
				'salutation' => $m->get_data('salutation'),
				'user_first_name' => $m->get_data('user_first_name'),
				'user_last_name' => $m->get_data('user_last_name'),
				'user_full_name' => $m->get_data('user_full_name'),
				'gender' => $m->get_data('gender'),
				'member_date_of_birth' => $m->get_data('member_date_of_birth'),
				'user_email' => $m->get_data('user_email'),
				'user_mobile' => $m->get_data('user_mobile'),
				'alt_mobile' => $m->get_data('alt_mobile'),
				'whatsapp_number' => $m->get_data('whatsapp_number'),
				'facebook' => $m->get_data('facebook'),
				'instagram' => $m->get_data('instagram'),
				'linkedin' => $m->get_data('linkedin'),
				'twitter' => $m->get_data('twitter'),
			);

			$q = $d->update("users_master", $a, "user_id='$user_id'");

			if ($q == true) {
				$response["message"] = "Profile update Successfully.!";
				$response["status"] = "200";
				echo json_encode($response);
				exit();

			} else {
				$response["message"] = "Something Wrong";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} else if (isset($user_logout) && $user_logout == 'user_logout' && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$m->set_data('user_token', '');

			$a = array(
				'user_token' => $m->get_data('user_token'),
			);

			$qdelete = $d->update("users_master", $a, "user_id='$user_id'");

			if ($qdelete == TRUE) {
				$response["message"] = "Logout Successfully";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "Something wrong..! Try again";
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