<?php
include_once 'lib.php';

if (isset($_POST) && !empty($_POST)) {

	if ($key == $keydb) {
		$response = array();
		extract(array_map("test_input", $_POST));
		$today = date('Y-m-d');
		if (isset($getNewUserTimelinePost) && $getNewUserTimelinePost == 'getNewUserTimelinePost' && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			 

			$qq = $d->select("user_employment_details,business_categories,business_sub_categories,users_master", "users_master.user_id='$user_id'  AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  ", "");
			$userData = mysqli_fetch_array($qq);
 
				 

				$response["user_id"] = $userData["user_id"];
				$response["user_full_name"] = $userData["user_full_name"];
				$response["user_first_name"] = $userData['user_first_name'];
				$response["user_last_name"] = $userData['user_last_name'];
				$response["gender"] = $userData['gender'];

				//12nov
                $userData['member_date_of_birth'] = str_replace("/", "-",$userData['member_date_of_birth']);
                //12nov

                
				$response["member_date_of_birth"] = $userData['member_date_of_birth'];
				if ($userData["public_mobile"] == 0) {
					$response["user_mobile"] = "" . substr($userData['user_mobile'], 0, 3) . '****' . substr($userData['user_mobile'], -3);
				} else {
					if ($userData["user_mobile"] != 0) {
						$response["user_mobile"] = $userData["user_mobile"];
					} else {
						$response["user_mobile"] = "";
					}
				}
				 
				$response["zoobiz_id"] = $userData["zoobiz_id"];
				  
				 
				$response["public_mobile"] = $userData["public_mobile"];
				$response["whatsapp_privacy"] = $userData["whatsapp_privacy"];
				$response["email_privacy"] = $userData["email_privacy"];
				$response["facebook"] = $userData["facebook"];
				$response["instagram"] = $userData["instagram"];
				$response["linkedin"] = $userData["linkedin"];
				$response["twitter"] = $userData["twitter"];
				$response["user_profile_pic"] = $base_url . "img/users/members_profile/" . $userData['user_profile_pic'];
				$response["follow_status"] = $follow_status;
				$response["block_status"] = $block_status;
				$response["business_description"] = html_entity_decode($userData["business_description"]);
				$response["bussiness_category_name"] = html_entity_decode($userData["category_name"]);
				$response["sub_category_name"] = html_entity_decode($userData["sub_category_name"]) . '';
				$response["company_name"] = html_entity_decode($userData["company_name"]) . '';
				$response["designation"] = html_entity_decode($userData["designation"]) . '';
				 

				if ($userData['company_logo'] != '') {
					$response["company_logo"] = $base_url . "img/users/company_logo/" . $userData['company_logo'];
				} else {
					$response["company_logo"] = "";
				}
				$response["company_logo_name"] = $userData['company_logo'];
				if ($userData['company_broucher'] != '') {
					$response["company_broucher"] = $base_url . "img/users/company_broucher/" . $userData['company_broucher'];
				} else {
					$response["company_broucher"] = "";
				}
				$response["company_broucher_name"] = $userData['company_broucher'];
				if ($userData['company_profile'] != '') {
					$response["company_profile"] = $base_url . "img/users/comapany_profile/" . $userData['company_profile'];
				} else {
					$response["company_profile"] = "";
				}
				$response["compny_profile_name"] = $userData['company_profile'];
				$response["products_servicess"] = html_entity_decode($userData['products_servicess']);
				$response["billing_address"] = html_entity_decode($userData['billing_address']);
				$response["gst_number"] = html_entity_decode($userData['gst_number']);
				$response["billing_pincode"] = html_entity_decode($userData['billing_pincode']);
				$response["bank_name"] = html_entity_decode($userData['bank_name']);
				$response["ifsc_code"] = html_entity_decode($userData['ifsc_code']);
				$response["billing_contact_person"] = html_entity_decode($userData['billing_contact_person']);
				$response["billing_contact_person_name"] = html_entity_decode($userData['billing_contact_person_name']);

				$qA2 = $d->select("area_master,business_adress_master,cities,states,countries", "business_adress_master.user_id='$user_id'
                AND
                business_adress_master.country_id = countries.country_id
                AND
                business_adress_master.state_id = states.state_id
                AND
                business_adress_master.city_id = cities.city_id
                AND
                business_adress_master.area_id = area_master.area_id", "ORDER BY business_adress_master.adress_type ASC");

				$response["company_address"] = array();

				while ($data_app = mysqli_fetch_array($qA2)) {
					$company_address = array();
					$company_address["adress_id"] = $data_app["adress_id"];
					$company_address["city_name"] = "" . $data_app["city_name"];
					$company_address["state_name"] = $data_app["state_name"];
					$company_address["country_name"] = $data_app["country_name"];
					$company_address["pincode"] = $data_app["pincode"];
					$company_address["latitude"] = $data_app["add_latitude"];
					$company_address["longitude"] = $data_app["add_longitude"];
					$company_address["adress_type"] = $data_app["adress_type"];
					$company_address["country_id"] = $data_app["country_id"];
					$company_address["state_id"] = $data_app["state_id"];
					$company_address["city_id"] = $data_app["city_id"];
					$company_address["area_id"] = $data_app["area_id"];
					$company_address["area_name"] = $data_app["area_name"];
					$company_address["adress"] = $data_app["adress"];
					array_push($response["company_address"], $company_address);

				}
 
				$response["message"] = "Member Details Found";
				$response["status"] = "200";
				echo json_encode($response);

			}     else {
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