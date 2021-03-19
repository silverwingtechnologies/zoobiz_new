<?php
include_once 'lib.php';
if (isset($_POST) && !empty($_POST)) {
	if ($key == $keydb) {
		$response = array();
		extract(array_map("test_input", $_POST));
		$today = date('Y-m-d');
		if (isset($user_id) && isset($interestedCategoryData) && $interestedCategoryData == 'interestedCategoryData'   ) {

			$user_employment_details = $d->select("business_sub_categories,user_employment_details"," business_sub_categories.business_sub_category_id =user_employment_details.business_sub_category_id and    user_employment_details.user_id = $user_id     ","");


			$user_employment_details_data = mysqli_fetch_array($user_employment_details);


			/*$related_sub_category_id_arr = array('0');
			 while ($user_employment_details_data=mysqli_fetch_array($user_employment_details)) {
			 	$related_sub_category_id_arr[] = $user_employment_details_data['related_sub_category_id'];
              }
              $related_sub_category_id_arr = implode(",", $related_sub_category_id_arr);*/


			$business_sub_category_id =$user_employment_details_data['business_sub_category_id'];
			$business_sub_ctagory_relation_master = $d->select("business_sub_categories,business_sub_ctagory_relation_master,user_employment_details,users_master ","
				users_master.user_id = user_employment_details.user_id and
				user_employment_details.business_sub_category_id = business_sub_ctagory_relation_master.related_sub_category_id and
				business_sub_ctagory_relation_master.business_sub_category_id = business_sub_categories.business_sub_category_id  and
				business_sub_ctagory_relation_master.business_sub_category_id = '$business_sub_category_id'  and users_master.user_id!=$user_id   and user_employment_details.user_id!=$user_id     ","");
 
			if(mysqli_num_rows($business_sub_ctagory_relation_master)  > 0    ){
				$response["interestedUserDetails"] = array();
				while ($business_sub_ctagory_relation_master_data = mysqli_fetch_array($business_sub_ctagory_relation_master)) {
					$uid = $business_sub_ctagory_relation_master_data["user_id"];


					 $users_master_qry=$d->select("users_master","user_id=$uid");
					 $users_master_data=mysqli_fetch_array($users_master_qry);

					$userDetails = array();
					$userDetails["user_id"] = $users_master_data["user_id"];
					$userDetails["user_full_name"] = $users_master_data["user_full_name"];

					$userDetails["user_mobile"] = $users_master_data["user_mobile"];
					$userDetails["user_email"] = $users_master_data["user_email"];
					$userDetails["company_name"] = $business_sub_ctagory_relation_master_data["company_name"];
					$userDetails["company_contact_number"] = $business_sub_ctagory_relation_master_data["company_contact_number"];

					if($business_sub_ctagory_relation_master_data["gst_number"] !=''){
						$userDetails["gst_number"] = $business_sub_ctagory_relation_master_data["gst_number"];	
					} else {
						$userDetails["gst_number"] = '';
					}
					
					$userDetails["sub_category_name"] = $business_sub_ctagory_relation_master_data["sub_category_name"];
					if($users_master_data['user_profile_pic'] !=""){
						$userDetails["user_profile_pic"] =$base_url . "img/users/members_profile/" . $users_master_data['user_profile_pic'];
					}else {
						$userDetails["user_profile_pic"] ="";
					}
					

					if($business_sub_ctagory_relation_master_data['company_logo']!=''){
						$userDetails["company_logo"] =$base_url . "img/users/company_logo/" . $business_sub_ctagory_relation_master_data['company_logo'];
					} else {
						$userDetails["company_logo"] ="";
					}
					


					array_push($response["interestedUserDetails"], $userDetails);
				}
				$response["message"]="success.";
				$response["status"]="200";
				echo json_encode($response);

			} else {
				$response["message"] = "No Data Found.";
				$response["status"] = "201";
				echo json_encode($response);
			}
		}   else {
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