<?php
include_once 'lib.php';

/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/

if (isset($_POST) && !empty($_POST)) {

	if ($key == $keydb) {

		$response = array();
		extract(array_map("test_input", $_POST));

		if ($_POST['getGeoMembers'] == "getGeoMembers" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {
 
			if ($city_name != "") {
				// find city id
				$qc = $d->selectRow("city_id,city_name", "cities", "city_name LIKE '%$city_name%'");
				$cityData = mysqli_fetch_array($qc);
				$city_id = $cityData['city_id'];
				$city_name = $cityData['city_name'];
				$meq = $d->select("users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master", "
  business_categories.category_status = 0 and  
business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0  AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND business_adress_master.city_id='$city_id' and users_master.is_developer_account=0 ", "");
			} else {
				$meq = $d->select("users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master", "
  business_categories.category_status = 0 and  
business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0  AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id and users_master.is_developer_account=0 ", "");
			}

			if (mysqli_num_rows($meq) > 0) {

				$response["NearByMember"] = array();

				while ($data_app = mysqli_fetch_array($meq)) {

					if (!preg_match('/^(\-?\d+(\.\d+)?),\s*(\-?\d+(\.\d+)?)$/', $data_app['add_latitude'])) {

						$NearByMember = array();
						$NearByMember["user_id"] = $data_app["user_id"];
						$NearByMember["city_name"] = $cityData["city_name"] . '';
						$NearByMember["business_category_id"] = $data_app["business_category_id"];
						$NearByMember["business_sub_category_id"] = $data_app["business_sub_category_id"];
						$NearByMember["user_full_name"] = $data_app["user_full_name"];
						$NearByMember["add_latitude"] = $data_app["add_latitude"];
						$NearByMember["add_longitude"] = $data_app["add_longitude"];
						$NearByMember["adress"] = $data_app["adress"];
						$NearByMember["zoobiz_id"] = $data_app['zoobiz_id'];
						$NearByMember["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_app['user_profile_pic'];

						//23oct
						if($data_app['menu_icon'] !="" && 0){
							$NearByMember["menu_icon"] = $base_url . "img/category/icon/" . $data_app['menu_icon'];
						} else {
							$NearByMember["menu_icon"] = "";
						}
						//23oct

						
						$NearByMember["bussiness_category_name"] = html_entity_decode($data_app["category_name"]);
						$NearByMember["sub_category_name"] = html_entity_decode($data_app["sub_category_name"]) . '';
						$NearByMember["company_name"] = html_entity_decode($data_app["company_name"]) . '';
						if ($data_app["public_mobile"] == 0) {
							$NearByMember["user_mobile"] = "" . substr($data_app['user_mobile'], 0, 3) . '****' . substr($data_app['user_mobile'], -3);
						} else {
							$NearByMember["user_mobile"] = $data_app["user_mobile"];
						}
						// $NearByMember["user_mobile"]=html_entity_decode($data_app["user_mobile"]).'';
						$NearByMember["user_email"] = html_entity_decode($data_app["user_email"]) . '';

						/**************************** Distance Calculation ******************************/
						$service_provider_latitude = $data_app['add_latitude'];
						$service_provider_logitude = $data_app['add_longitude'];

						$radiusInMeeter = $d->haversineGreatCircleDistance($user_latitude, $user_longitude, $service_provider_latitude, $service_provider_logitude);

						$totalKm = number_format($radiusInMeeter / 1000, 2, '.', '');

						// $distancedetails = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=$user_latitude,$user_longitude&destinations=$service_provider_latitude,$service_provider_logitude&key=AIzaSyAUPcYOnCeZLyHFqI-ssbvwg-f12q8B85A");
						// $test = json_decode($distancedetails);
						// $destination = explode(',', $test->destination_addresses[0]);
						// $local_service_provider["distance"]=$destination[1].','.$destination[2].' - '.number_format($test->rows[0]->elements[0]->distance->value/1000,2).' km';
						// $totalKm= number_format($test->rows[0]->elements[0]->distance->value/1000,2).' km';
						$NearByMember["distance_in_km"] = $totalKm . ' KM';
						/**************************** Distance Calculation ******************************/

						array_push($response["NearByMember"], $NearByMember);
					}
				}

				$response["message"] = "Get Member Found";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "No Near By Member Found.";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} else if ($_POST['getGeoMembersNew'] == "getGeoMembersNew" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			if ($city_id != "") {
				// find city id
				// /AND business_adress_master.city_id='$city_id'
				$meq = $d->select("users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master", "
  business_categories.category_status = 0 and  
business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0  AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  and users_master.is_developer_account=0  ", "");
			} else {
				$meq = $d->select("users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master", "
  business_categories.category_status = 0 and  
business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0  AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  and users_master.is_developer_account=0  ", "");
			}

			if (mysqli_num_rows($meq) > 0) {

				$response["NearByMember"] = array();

				while ($data_app = mysqli_fetch_array($meq)) {

					if (!preg_match('/^(\-?\d+(\.\d+)?),\s*(\-?\d+(\.\d+)?)$/', $data_app['add_latitude']) ) {

						$NearByMember = array();
						$NearByMember["user_id"] = $data_app["user_id"];
						$NearByMember["city_name"] = $cityData["city_name"] . '';
						$NearByMember["business_category_id"] = $data_app["business_category_id"];
						$NearByMember["business_sub_category_id"] = $data_app["business_sub_category_id"];
						$NearByMember["user_full_name"] = $data_app["user_full_name"];
						$NearByMember["add_latitude"] = $data_app["add_latitude"];
						$NearByMember["add_longitude"] = $data_app["add_longitude"];

						//27oct
						$data_user_id = $data_app["user_id"];
						$address = $d->select("business_adress_master,area_master,cities,states,countries", " business_adress_master.country_id =countries.country_id AND business_adress_master.state_id =states.state_id AND business_adress_master.city_id =cities.city_id AND business_adress_master.area_id =area_master.area_id AND business_adress_master.user_id = '$data_user_id'    ", "");
						if (mysqli_num_rows($address) > 0) {
							$address_data = mysqli_fetch_array($address);
							$NearByMember["adress"] = $address_data["adress"]."\n Area: ".$address_data["area_name"]."\n City:  ".$address_data["city_name"]." - ".$address_data["pincode"]."\n State: ".$address_data["state_name"]."\n Country: ".$address_data["country_name"];
						} else {
							$NearByMember["adress"] = $data_app["adress"];
						}
 
						//27oct
						
						$NearByMember["zoobiz_id"] = $data_app['zoobiz_id'];
						 
						$NearByMember["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_app['user_profile_pic'];
						$NearByMember["bussiness_category_name"] = html_entity_decode($data_app["category_name"]);

						//23oct
						if($data_app['menu_icon'] !="" && 0 ){
							$NearByMember["menu_icon"] = $base_url . "img/category/icon/" . $data_app['menu_icon'];
						} else {
							$NearByMember["menu_icon"] = "";
						}
						//23oct
						
						$NearByMember["sub_category_name"] = html_entity_decode($data_app["sub_category_name"]) . '';
						$NearByMember["company_name"] = html_entity_decode($data_app["company_name"]) . '';
						if ($data_app["public_mobile"] == 0) {
							$NearByMember["user_mobile"] = "" . substr($data_app['user_mobile'], 0, 3) . '****' . substr($data_app['user_mobile'], -3);
						} else {
							$NearByMember["user_mobile"] = $data_app["user_mobile"];
						}
						// $NearByMember["user_mobile"]=html_entity_decode($data_app["user_mobile"]).'';
						$NearByMember["user_email"] = html_entity_decode($data_app["user_email"]) . '';

						/**************************** Distance Calculation ******************************/
						$service_provider_latitude = $data_app['add_latitude'];
						$service_provider_logitude = $data_app['add_longitude'];

						$radiusInMeeter = $d->haversineGreatCircleDistance($user_latitude, $user_longitude, $service_provider_latitude, $service_provider_logitude);

						$totalKm = number_format($radiusInMeeter / 1000, 2, '.', '');

						// $distancedetails = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=$user_latitude,$user_longitude&destinations=$service_provider_latitude,$service_provider_logitude&key=AIzaSyAUPcYOnCeZLyHFqI-ssbvwg-f12q8B85A");
						// $test = json_decode($distancedetails);
						// $destination = explode(',', $test->destination_addresses[0]);
						// $local_service_provider["distance"]=$destination[1].','.$destination[2].' - '.number_format($test->rows[0]->elements[0]->distance->value/1000,2).' km';
						// $totalKm= number_format($test->rows[0]->elements[0]->distance->value/1000,2).' km';
						$NearByMember["distance_in_km"] = $totalKm . ' KM';
						/**************************** Distance Calculation ******************************/

						array_push($response["NearByMember"], $NearByMember);
					}
				}

				$response["message"] = "Get Member Found";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "No Near By Member Found.";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} else if ($_POST['getGeoMembersFilter'] == "getGeoMembersFilter" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$queryAry = array();
			if ($city_id != 0) {
				$cityIdAry = explode(",", $city_id);
				$ids = join("','", $cityIdAry);
				$query = "business_adress_master.city_id IN ('$ids')";
				array_push($queryAry, $query);
			}
			if ($business_category_id == 0) {
				$query = "user_employment_details.business_category_id!='0'";
				array_push($queryAry, $query);
			}
			if ($business_category_id != 0) {
				$atchQuery = "user_employment_details.business_category_id='$business_category_id'";
				array_push($queryAry, $atchQuery);
			}
			if ($business_sub_category_id != 0) {
				$atchQuery1 = "user_employment_details.business_sub_category_id='$business_sub_category_id'";
				array_push($queryAry, $atchQuery1);
			}

			if ($user_full_name != '') {
				$atchQueryName = "users_master.user_full_name LIKE '%$user_full_name%'";
				array_push($queryAry, $atchQueryName);
			}

			if ($zoobiz_id != '') {
				$atchQuery2 = "users_master.zoobiz_id LIKE '%$zoobiz_id%'";
				array_push($queryAry, $atchQuery2);
			}

			if ($user_email != '') {
				$atchQuery3 = "users_master.user_email LIKE '%$user_email%'";
				array_push($queryAry, $atchQuery3);
			}
			if ($user_mobile != '') {
				$atchQuery4 = "users_master.user_mobile LIKE '%$user_mobile%'";
				array_push($queryAry, $atchQuery4);
			}
			if ($search_keyword != '') {
				$atchQuery5 = "user_employment_details.search_keyword LIKE '%$search_keyword%'";
				array_push($queryAry, $atchQuery5);
			}
			$appendQuery = implode(" AND ", $queryAry);

			$meq = $d->select("users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master", "
  business_categories.category_status = 0 and  
business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0  AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id and users_master.is_developer_account=0  AND  $appendQuery  ", "");

			if (mysqli_num_rows($meq) > 0) {

				$response["NearByMember"] = array();

				while ($data_app = mysqli_fetch_array($meq)) {

					if (!preg_match('/^(\-?\d+(\.\d+)?),\s*(\-?\d+(\.\d+)?)$/', $data_app['add_latitude'])) {

						$NearByMember = array();
						$NearByMember["user_id"] = $data_app["user_id"];
						$NearByMember["city_name"] = $cityData["city_name"] . '';
						$NearByMember["business_category_id"] = $data_app["business_category_id"];
						$NearByMember["business_sub_category_id"] = $data_app["business_sub_category_id"];
						$NearByMember["user_full_name"] = $data_app["user_full_name"];
						$NearByMember["add_latitude"] = $data_app["add_latitude"];
						$NearByMember["add_longitude"] = $data_app["add_longitude"];

						//27oct
						$data_user_id = $data_app["user_id"];
						$address = $d->select("business_adress_master,area_master,cities,states,countries", " business_adress_master.country_id =countries.country_id AND business_adress_master.state_id =states.state_id AND business_adress_master.city_id =cities.city_id AND business_adress_master.area_id =area_master.area_id AND business_adress_master.user_id = '$data_user_id'    ", "");
						if (mysqli_num_rows($address) > 0) {
							$address_data = mysqli_fetch_array($address);
							$NearByMember["adress"] = $address_data["adress"]."\n Area: ".$address_data["area_name"]."\n City:  ".$address_data["city_name"]." - ".$address_data["pincode"]."\n State: ".$address_data["state_name"]."\n Country: ".$address_data["country_name"];
						} else {
							$NearByMember["adress"] = $data_app["adress"];
						}
 
						//27oct

						 
						$NearByMember["zoobiz_id"] = $data_app['zoobiz_id'];
						$NearByMember["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_app['user_profile_pic'];

						//23oct
						if($data_app['menu_icon'] !="" && 0){
							$NearByMember["menu_icon"] = $base_url . "img/category/icon/" . $data_app['menu_icon'];
						} else {
							$NearByMember["menu_icon"] = "";
						}
						//23oct
						$NearByMember["bussiness_category_name"] = html_entity_decode($data_app["category_name"]);
						$NearByMember["sub_category_name"] = html_entity_decode($data_app["sub_category_name"]) . '';
						$NearByMember["company_name"] = html_entity_decode($data_app["company_name"]) . '';
						// $NearByMember["user_mobile"]=html_entity_decode($data_app["user_mobile"]).'';
						if ($data_app["public_mobile"] == 0) {
							$NearByMember["user_mobile"] = "" . substr($data_app['user_mobile'], 0, 3) . '****' . substr($data_app['user_mobile'], -3);
						} else {
							$NearByMember["user_mobile"] = $data_app["user_mobile"];
						}
						$NearByMember["user_email"] = html_entity_decode($data_app["user_email"]) . '';

						/**************************** Distance Calculation ******************************/
						$service_provider_latitude = $data_app['add_latitude'];
						$service_provider_logitude = $data_app['add_longitude'];

						$radiusInMeeter = $d->haversineGreatCircleDistance($user_latitude, $user_longitude, $service_provider_latitude, $service_provider_logitude);

						$totalKm = number_format($radiusInMeeter / 1000, 2, '.', '');
						// $distancedetails = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=$user_latitude,$user_longitude&destinations=$service_provider_latitude,$service_provider_logitude&key=AIzaSyAUPcYOnCeZLyHFqI-ssbvwg-f12q8B85A");
						// $test = json_decode($distancedetails);
						// $destination = explode(',', $test->destination_addresses[0]);
						// $local_service_provider["distance"]=$destination[1].','.$destination[2].' - '.number_format($test->rows[0]->elements[0]->distance->value/1000,2).' km';
						// $totalKm= number_format($test->rows[0]->elements[0]->distance->value/1000,2).' km';
						$NearByMember["distance_in_km"] = $totalKm . ' KM';
						/**************************** Distance Calculation ******************************/

						array_push($response["NearByMember"], $NearByMember);
					}
				}

				$response["message"] = "Get Member Found";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "No Near By Member Found.";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} else if ($_POST['getGeoMembersByKm'] == "getGeoMembersByKm" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			if ($city_name != "") {
				// find city id
				$qc = $d->selectRow("city_id,city_name", "cities", "city_name LIKE '%$city_name%'");
				$cityData = mysqli_fetch_array($qc);
				$city_id = $cityData['city_id'];
				$city_name = $cityData['city_name'];
				$meq = $d->select("users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master", "
  business_categories.category_status = 0 and  
business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0  AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND business_adress_master.city_id='$city_id' and users_master.is_developer_account=0  ", "");
			} else {
				$meq = $d->select("users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master", "
  business_categories.category_status = 0 and  
business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0  AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id and users_master.is_developer_account=0  ", "");
			}

			if (mysqli_num_rows($meq) > 0) {

				$response["NearByMember"] = array();

				while ($data_app = mysqli_fetch_array($meq)) {

					if (!preg_match('/^(\-?\d+(\.\d+)?),\s*(\-?\d+(\.\d+)?)$/', $data_app['add_latitude'])) {

						$NearByMember = array();
						$NearByMember["user_id"] = $data_app["user_id"];
						$NearByMember["city_name"] = $cityData["city_name"] . '';
						$NearByMember["business_category_id"] = $data_app["business_category_id"];
						$NearByMember["business_sub_category_id"] = $data_app["business_sub_category_id"];
						$NearByMember["user_full_name"] = $data_app["user_full_name"];
						$NearByMember["add_latitude"] = $data_app["add_latitude"];
						$NearByMember["add_longitude"] = $data_app["add_longitude"];
						$NearByMember["adress"] = $data_app["adress"];
						$NearByMember["zoobiz_id"] = $data_app['zoobiz_id'];
						$NearByMember["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_app['user_profile_pic'];
						//23oct
						if($data_app['menu_icon'] !="" && 0){
							$NearByMember["menu_icon"] = $base_url . "img/category/icon/" . $data_app['menu_icon'];
						} else {
							$NearByMember["menu_icon"] = "";
						}
						//23oct

						$NearByMember["bussiness_category_name"] = html_entity_decode($data_app["category_name"]);
						$NearByMember["sub_category_name"] = html_entity_decode($data_app["sub_category_name"]) . '';
						$NearByMember["company_name"] = html_entity_decode($data_app["company_name"]) . '';
						if ($data_app["public_mobile"] == 0) {
							$NearByMember["user_mobile"] = "" . substr($data_app['user_mobile'], 0, 3) . '****' . substr($data_app['user_mobile'], -3);
						} else {
							$NearByMember["user_mobile"] = $data_app["user_mobile"];
						}
						// $NearByMember["user_mobile"]=html_entity_decode($data_app["user_mobile"]).'';
						$NearByMember["user_email"] = html_entity_decode($data_app["user_email"]) . '';

						/**************************** Distance Calculation ******************************/
						$service_provider_latitude = $data_app['add_latitude'];
						$service_provider_logitude = $data_app['add_longitude'];
 
//old AIzaSyAUPcYOnCeZLyHFqI-ssbvwg-f12q8B85A
  //new AIzaSyCAqhdXVLwvt1byUEkzGPsLKLhutT70yFY  
						$distancedetails = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=$user_latitude,$user_longitude&destinations=$service_provider_latitude,$service_provider_logitude&key=AIzaSyCAqhdXVLwvt1byUEkzGPsLKLhutT70yFY");
						$test = json_decode($distancedetails);
						$destination = explode(',', $test->destination_addresses[0]);
						$local_service_provider["distance"] = $destination[1] . ',' . $destination[2] . ' - ' . number_format($test->rows[0]->elements[0]->distance->value / 1000, 2) . ' km';
						$totalKm = number_format($test->rows[0]->elements[0]->distance->value / 1000, 2) . ' km';
						$NearByMember["distance_in_km"] = $totalKm;
						/**************************** Distance Calculation ******************************/
						if ($totalKm <= $kmarea) {
							array_push($response["NearByMember"], $NearByMember);
						}
					}
				}

				$response["message"] = "Get Member Found";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "No Near By Member Found.";
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