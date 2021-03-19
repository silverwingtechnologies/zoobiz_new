<?php
include_once 'lib.php';

/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/

if (isset($_POST) && !empty($_POST)) {

if ($key == $keydb) {

$response = array();
extract(array_map("test_input", $_POST));

if ($_POST['getCategory'] == "getCategory") {
 
	$app_data = $d->select("business_categories", " 
 category_status='0'", "ORDER BY category_name ASC");

	if (mysqli_num_rows($app_data) > 0) {

		$response["category"] = array();

		while ($data = mysqli_fetch_array($app_data)) {

			$category = array();
			$category["business_category_id"] = $data["business_category_id"];
			$category["category_name"] = html_entity_decode($data["category_name"]);

			if ($data["category_images"] != '') {
				$category["category_icon"] = $base_url . "img/category/" . $data["category_images"];
			} else {
				$category["category_icon"] = "";
			}

			array_push($response["category"], $category);
		}

		$response["message"] = "get Success.";
		$response["status"] = "200";
		echo json_encode($response);
	} else {
		$response["message"] = "No Category Found.";
		$response["status"] = "201";
		echo json_encode($response);
	}

} else if ($_POST['getCategory'] == "getCategoryMember") {

	$app_data = $d->select("business_categories", "  
 category_status='0'", "ORDER BY category_name ASC");

	if (mysqli_num_rows($app_data) > 0) {

		$response["category"] = array();

		while ($data = mysqli_fetch_array($app_data)) {

			$meq = $d->select("users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master", "  business_categories.category_status = 0 and  
business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0 AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND users_master.office_member=0 AND users_master.office_member=0  AND user_employment_details.business_category_id='$data[business_category_id]'", "");

			$catId = $data["business_category_id"];

			$qq1 = $d->select("category_follow_master", "category_id = '$catId' AND user_id='$user_id'");

			$dataFollow = mysqli_fetch_array($qq1);

			$category = array();
			$category["business_category_id"] = $data["business_category_id"];
			$category["category_name"] = html_entity_decode($data["category_name"]);

			if (mysqli_num_rows($qq1) > 0) {
				$category["is_follow"] = true;
				$category["category_follow_id"] = $dataFollow["category_follow_id"];
			} else {
				$category["is_follow"] = false;
				$category["category_follow_id"] = "";
			}

			if ($data["category_images"] != '') {
				$category["category_icon"] = $base_url . "img/category/" . $data["category_images"];
			} else {
				$category["category_icon"] = "";
			}

			if (mysqli_num_rows($meq) > 0) {
				array_push($response["category"], $category);
			}
		}

		$response["message"] = "get Success.";
		$response["status"] = "200";
		echo json_encode($response);
	} else {
		$response["message"] = "No Category Found.";
		$response["status"] = "201";
		echo json_encode($response);
	}

} else if ($_POST['getSubCategory'] == "getSubCategory" && filter_var($business_category_id, FILTER_VALIDATE_INT) == true) {

	$response["sub_category"] = array();
	$response["slider"] = array();

	$app_data = $d->select("business_categories,business_sub_categories", "   business_categories.category_status = 0 and  
 business_sub_categories.business_category_id=business_categories.business_category_id AND business_sub_categories.business_category_id='$business_category_id' AND business_sub_categories.sub_category_status='0'", "ORDER BY business_sub_categories.sub_category_name ASC");

	$qnotification = $d->select("slider_master", "business_category_id != 0 AND business_category_id = '$business_category_id' and status=0", "order by RAND()");

	if (mysqli_num_rows($app_data) > 0) {

		$sub_category = array();

		$sub_category["business_sub_category_id"] = "0";
		$sub_category["business_category_id"] = $business_category_id;
		$sub_category["category_name"] = "All";
		$sub_category["sub_category_name"] = "All";
		$sub_category["sub_category_icon"] = $base_url . "img/sub_category/all.png";

		$meq = $d->select("users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master", "  business_categories.category_status = 0 and  
business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0 AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND users_master.office_member=0  AND user_employment_details.business_category_id='$business_category_id'", "");
		if (mysqli_num_rows($meq) > 0) {
			array_push($response["sub_category"], $sub_category);

			$temp1 = true;
		}
	}

	if (mysqli_num_rows($app_data) > 0) {

		while ($data = mysqli_fetch_array($app_data)) {

			$meqSub = $d->select("users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master", "  business_categories.category_status = 0 and  
business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0 AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND users_master.office_member=0  AND user_employment_details.business_category_id='$business_category_id' AND user_employment_details.business_sub_category_id='$data[business_sub_category_id]'", "");

			$sub_category = array();
			$sub_category["business_sub_category_id"] = $data["business_sub_category_id"];
			$sub_category["business_category_id"] = $data["business_category_id"];
			$sub_category["category_name"] = html_entity_decode($data["category_name"]);
			$sub_category["sub_category_name"] = html_entity_decode($data["sub_category_name"]);
			if ($data["sub_category_images"] != '') {
				$sub_category["sub_category_icon"] = $base_url . "img/sub_category/" . $data["sub_category_images"];
			} else {
				$sub_category["sub_category_images"] = "";
			}

			if (mysqli_num_rows($meqSub) > 0) {
				array_push($response["sub_category"], $sub_category);
			}
		}
		$temp = true;

	}

	if (mysqli_num_rows($qnotification) > 0) {

		while ($data_notification = mysqli_fetch_array($qnotification)) {

			// print_r($data_notification);

			$slider = array();

			$slider["app_slider_id"] = $data_notification['slider_id'];
			$slider["slider_image_name"] = $base_url . "img/sliders/" . $data_notification['slider_image'];
			$slider["slider_description"] = $data_notification['slider_description'];
			$slider["slider_url"] = $data_notification['slider_url'] . '';
			if ($data_notification['slider_mobile'] != 0) {
				$slider["slider_mobile"] = $data_notification['slider_mobile'] . '';
			} else {
				$slider["slider_mobile"] = '';
			}
			$slider["slider_video_url"] = $data_notification['slider_video_url'] . '';
			$slider["user_id"] = $data_notification['user_id'] . '';

			array_push($response["slider"], $slider);
		}

	}

	if ($temp == true || $temp1 == true) {
		$response["message"] = "get Success.";
		$response["status"] = "200";
		echo json_encode($response);
	} else {
		$response["message"] = "No Sub Category Found.";
		$response["status"] = "201";
		echo json_encode($response);
	}

} else if ($_POST['getSubCategory'] == "getSubCategoryNew" && filter_var($business_category_id, FILTER_VALIDATE_INT) == true) {

	$response["sub_category"] = array();

	$app_data = $d->select("business_categories,business_sub_categories", "  business_categories.category_status = 0 and  
business_sub_categories.business_category_id=business_categories.business_category_id AND business_sub_categories.business_category_id='$business_category_id' AND business_sub_categories.sub_category_status='0'", "ORDER BY business_sub_categories.sub_category_name ASC");

	if (mysqli_num_rows($app_data) > 0) {

		while ($data = mysqli_fetch_array($app_data)) {

			$sub_category = array();
			$sub_category["business_sub_category_id"] = $data["business_sub_category_id"];
			$sub_category["business_category_id"] = $data["business_category_id"];
			$sub_category["category_name"] = html_entity_decode($data["category_name"]);
			$sub_category["sub_category_name"] = html_entity_decode($data["sub_category_name"]);
			if ($data["sub_category_images"] != '') {
				$sub_category["sub_category_icon"] = $base_url . "img/category/" . $data["sub_category_images"];
			} else {
				$sub_category["sub_category_images"] = "";
			}

			array_push($response["sub_category"], $sub_category);
		}
		$temp = true;

	}

	if ($temp == true || $temp1 == true) {
		$response["message"] = "get Success.";
		$response["status"] = "200";
		echo json_encode($response);
	} else {
		$response["message"] = "No Sub Category Found.";
		$response["status"] = "201";
		echo json_encode($response);
	}

} else if ($_POST['getMembers'] == "getMembers" && filter_var($city_id, FILTER_VALIDATE_INT) == true && filter_var($state_id, FILTER_VALIDATE_INT) == true) {

	// if ($business_category_id==0 ) {
	//     $app_data=$d->select("cities","city_flag=1","ORDER BY city_name ASC");
	// }else {

	$app_data = $d->select("cities", "city_flag=1", "ORDER BY city_name ASC");
	// }

	if (mysqli_num_rows($app_data) > 0) {

		$response["city"] = array();

		while ($data = mysqli_fetch_array($app_data)) {

			$city = array();
			$city["city_id"] = $data["city_id"];
			$city["city_name"] = html_entity_decode($data["city_name"]);
			if ($data["city_id"] == $city_id) {
				$city["primary_city"] = true;
			} else {
				$city["category_icon"] = false;
			}

			$city["area"] = array();
			$qs = $d->select("area_master", "city_id='$data[city_id]' ", "ORDER BY area_name ASC");

			while ($subData = mysqli_fetch_array($qs)) {
				$area = array();
				$area["area_id"] = $subData["area_id"];
				$area["area_name"] = html_entity_decode($subData["area_name"]);
				if ($subData["pincode"] != 0) {
					$area["area_name_with_pincode"] = html_entity_decode($subData["area_name"]) . ' [' . $subData["pincode"] . ']';
				} else {
					$area["area_name_with_pincode"] = html_entity_decode($subData["area_name"]);

				}
				$area["pincode"] = $subData["pincode"];
				$area["latitude"] = $subData["latitude"];
				$area["longitude"] = $subData["longitude"];

				$area["member"] = array();
				if ($business_sub_category_id == 0) {
					$meq = $d->select("users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master", "  business_categories.category_status = 0 and  
 business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0 AND business_adress_master.area_id='$subData[area_id]'  AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND users_master.office_member=0  AND user_employment_details.business_category_id='$business_category_id' ", "");
					# code...
				} else {
					$meq = $d->select("users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master", "  business_categories.category_status = 0 and  
business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0 AND business_adress_master.area_id='$subData[area_id]'  AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND users_master.office_member=0  AND user_employment_details.business_category_id='$business_category_id' AND user_employment_details.business_sub_category_id='$business_sub_category_id'", "");

				}

				$totalUsers = mysqli_num_rows($meq);

				while ($data_app = mysqli_fetch_array($meq)) {

					$qche = $d->select("follow_master", "follow_by='$user_id' AND follow_to='$data_app[user_id]'");
					if (mysqli_num_rows($qche) > 0) {
						$follow_status = true;
					} else {
						$follow_status = false;
					}

					$member = array();
					$member["user_id"] = $data_app["user_id"];
					$member["business_category_id"] = $data_app["business_category_id"];
					$member["business_sub_category_id"] = $data_app["business_sub_category_id"];
					$member["user_full_name"] = $data_app["user_full_name"];
					$member["zoobiz_id"] = $data_app["zoobiz_id"];
					$member["public_mobile"] = $data_app["public_mobile"];
					$member["user_mobile"] = $data_app["user_mobile"];
					$member["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_app['user_profile_pic'];
					$member["bussiness_category_name"] = html_entity_decode($data_app["category_name"]);
					$member["sub_category_name"] = html_entity_decode($data_app["sub_category_name"]) . '';
					$member["company_name"] = html_entity_decode($data_app["company_name"]) . '';
					$member["follow_status"] = $follow_status;

					array_push($area["member"], $member);
				}
				if ($totalUsers > 0) {
					array_push($city["area"], $area);
				}
			}

			array_push($response["city"], $city);
		}

		$response["message"] = "get Success.";
		$response["status"] = "200";
		echo json_encode($response);
	} else {
		$response["message"] = "No Category Found.";
		$response["status"] = "201";
		echo json_encode($response);
	}

} else if ($_POST['getMembersFilter'] == "getMembersFilter" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

	if ($city_id == 0 || $city_id == '') {
		$app_data = $d->select("cities", "state_id='$state_id' AND city_flag=1", "ORDER BY city_name ASC");
	} else {
		$cityIdAry = explode(",", $city_id);
		$ids = join("','", $cityIdAry);
		$app_data = $d->select("cities", "state_id='$state_id' AND city_flag=1 AND city_id IN ('$ids')", "ORDER BY city_name ASC");
	}

	if (mysqli_num_rows($app_data) > 0) {

		$response["city"] = array();

		while ($data = mysqli_fetch_array($app_data)) {

			$city = array();
			$city["city_id"] = $data["city_id"];
			$city["ids"] = $ids;
			$city["city_name"] = html_entity_decode($data["city_name"]);
			if ($data["city_id"] == $city_id) {
				$city["primary_city"] = true;
			} else {
				$city["category_icon"] = false;
			}

			$city["area"] = array();
			$qs = $d->select("area_master", "city_id='$data[city_id]' ", "ORDER BY area_name ASC");

			while ($subData = mysqli_fetch_array($qs)) {
				$area = array();
				$area["area_id"] = $subData["area_id"];

				if ($subData["pincode"] != 0) {
					$area["area_name_with_pincode"] = html_entity_decode($subData["area_name"]) . ' [' . $subData["pincode"] . ']';
				} else {
					$area["area_name_with_pincode"] = html_entity_decode($subData["area_name"]);

				}

				$area["pincode"] = $subData["pincode"];
				$area["latitude"] = $subData["latitude"];
				$area["longitude"] = $subData["longitude"];

				$area["member"] = array();

				$queryAry = array();
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
				if ($zoobiz_id != '') {
					$atchQuery2 = "users_master.zoobiz_id LIKE '%$zoobiz_id%'";
					array_push($queryAry, $atchQuery2);
				}

				if ($user_full_name != '') {
					$atchQueryName = "users_master.user_full_name LIKE '%$user_full_name%'";
					array_push($queryAry, $atchQueryName);
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
business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0 AND business_adress_master.area_id='$subData[area_id]'  AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND users_master.office_member=0 AND user_employment_details.user_id=users_master.user_id   AND  $appendQuery", "");

				$totalUsers = mysqli_num_rows($meq);

				while ($data_app = mysqli_fetch_array($meq)) {

					$qche = $d->select("follow_master", "follow_by='$user_id' AND follow_to='$data_app[user_id]'");
					if (mysqli_num_rows($qche) > 0) {
						$follow_status = true;
					} else {
						$follow_status = false;
					}

					$member = array();
					$member["user_id"] = $data_app["user_id"];
					$member["business_category_id"] = $data_app["business_category_id"];
					$member["business_sub_category_id"] = $data_app["business_sub_category_id"];
					$member["user_full_name"] = $data_app["user_full_name"];
					$member["zoobiz_id"] = $data_app["zoobiz_id"];
					$member["user_mobile"] = $data_app["user_mobile"];
					$member["public_mobile"] = $data_app["public_mobile"];
					$member["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_app['user_profile_pic'];
					$member["bussiness_category_name"] = html_entity_decode($data_app["category_name"]);
					$member["sub_category_name"] = html_entity_decode($data_app["sub_category_name"]) . '';
					$member["company_name"] = html_entity_decode($data_app["company_name"]) . '';
					$member["follow_status"] = $follow_status;

					array_push($area["member"], $member);
				}
				if ($totalUsers > 0) {
					array_push($city["area"], $area);
				}
			}

			array_push($response["city"], $city);
		}

		$response["message"] = "get Success.";
		$response["status"] = "200";
		echo json_encode($response);
	} else {
		$response["message"] = "No Category Found.";
		$response["status"] = "201";
		echo json_encode($response);
	}

} else if ($_POST['getMembersFilterMap'] == "getMembersFilterMap" && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($kmarea, FILTER_VALIDATE_INT) == true) {

	if ($city_name != "") {
		$qc = $d->selectRow("city_id,city_name", "cities", "city_name LIKE '%$city_name%'");
		$cityData = mysqli_fetch_array($qc);
		$city_id = $cityData['city_id'];
		$city_name = $cityData['city_name'];

		$app_data = $d->select("cities", "city_id='$city_id' ", "ORDER BY city_name ASC");
	} else {
		$response["message"] = "No Data Found.";
		$response["status"] = "201";
		echo json_encode($response);
		exit();
	}

	if (mysqli_num_rows($app_data) > 0) {

		$response["city"] = array();

		while ($data = mysqli_fetch_array($app_data)) {

			$city = array();
			$city["city_id"] = $data["city_id"];
			$city["ids"] = $ids . '';
			$city["city_name"] = html_entity_decode($data["city_name"]);
			if ($data["city_id"] == $city_id) {
				$city["primary_city"] = true;
			} else {
				$city["category_icon"] = false;
			}

			$city["area"] = array();
			$qs = $d->select("area_master", "city_id='$data[city_id]' ", "ORDER BY area_name ASC");

			while ($subData = mysqli_fetch_array($qs)) {
				$area = array();
				$area["area_id"] = $subData["area_id"];

				if ($subData["pincode"] != 0) {
					$area["area_name_with_pincode"] = html_entity_decode($subData["area_name"]) . ' [' . $subData["pincode"] . ']';
				} else {
					$area["area_name_with_pincode"] = html_entity_decode($subData["area_name"]);

				}

				$area["pincode"] = $subData["pincode"];
				$area["latitude"] = $subData["latitude"];
				$area["longitude"] = $subData["longitude"];

				$area["member"] = array();

				$queryAry = array();
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
business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0 AND business_adress_master.area_id='$subData[area_id]'  AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND users_master.office_member=0   AND  $appendQuery", "");

				$totalUsers = mysqli_num_rows($meq);

				while ($data_app = mysqli_fetch_array($meq)) {

					$qche = $d->select("follow_master", "follow_by='$user_id' AND follow_to='$data_app[user_id]'");
					if (mysqli_num_rows($qche) > 0) {
						$follow_status = true;
					} else {
						$follow_status = false;
					}

					$member = array();
					$member["user_id"] = $data_app["user_id"];
					$member["business_category_id"] = $data_app["business_category_id"];
					$member["business_sub_category_id"] = $data_app["business_sub_category_id"];
					$member["user_full_name"] = $data_app["user_full_name"];
					$member["zoobiz_id"] = $data_app["zoobiz_id"];
					$member["user_mobile"] = $data_app["user_mobile"];
					$member["public_mobile"] = $data_app["public_mobile"];
					$member["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_app['user_profile_pic'];
					$member["bussiness_category_name"] = html_entity_decode($data_app["category_name"]);
					$member["sub_category_name"] = html_entity_decode($data_app["sub_category_name"]) . '';
					$member["company_name"] = html_entity_decode($data_app["company_name"]) . '';
					$member["follow_status"] = $follow_status;

					/**************************** Distance Calculation ******************************/
					$service_provider_latitude = $data_app['add_latitude'];
					$service_provider_logitude = $data_app['add_longitude'];

					$radiusInMeeter = $d->haversineGreatCircleDistance($user_latitude, $user_longitude, $service_provider_latitude, $service_provider_logitude);

					$totalKm = number_format($radiusInMeeter / 1000, 2, '.', '');
					// $distancedetails = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=$user_latitude,$user_longitude&destinations=$service_provider_latitude,$service_provider_logitude&key=AIzaSyAUPcYOnCeZLyHFqI-ssbvwg-f12q8B85A");
					// $test = json_decode($distancedetails);
					// $destination = explode(',', $test->destination_addresses[0]);
					// $local_service_provider["distance"]=$destination[1].','.$destination[2].' - '.number_format($test->rows[0]->elements[0]->distance->value/1000,2).' km';
					// $totalKm= number_format($test->rows[0]->elements[0]->distance->value/1000,2);
					// $member["distance_in_km"]=$totalKm.' km';
					/**************************** Distance Calculation ******************************/
					if ($totalKm <= $kmarea) {
						array_push($area["member"], $member);
					}
				}
				if ($totalUsers > 0 && $totalKm <= $kmarea) {
					array_push($city["area"], $area);
				}
			}

			array_push($response["city"], $city);
		}

		$response["message"] = "Members Found in $kmarea KM";
		$response["status"] = "200";
		echo json_encode($response);
	} else {
		$response["message"] = "No Category Found.";
		$response["status"] = "201";
		echo json_encode($response);
	}

} else if ($_POST['getMembersAll'] == "getMembersAll" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

	$response["member"] = array();

	$meq = $d->select("users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master,cities,area_master", "
  business_categories.category_status = 0 and
area_master.area_id=business_adress_master.area_id AND cities.city_id=business_adress_master.city_id AND business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0 AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND users_master.office_member=0 AND    business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  ", "");

	$totalUsers = mysqli_num_rows($meq);
	if (mysqli_num_rows($meq) > 0) {
		while ($data_app = mysqli_fetch_array($meq)) {

			$qche = $d->select("follow_master", "follow_by='$user_id' AND follow_to='$data_app[user_id]'");
			if (mysqli_num_rows($qche) > 0) {
				$follow_status = true;
			} else {
				$follow_status = false;
			}

			$member = array();
			$member["user_id"] = $data_app["user_id"];
			$member["zoobiz_id"] = $data_app["zoobiz_id"];
			$member["business_category_id"] = $data_app["business_category_id"];
			$member["business_sub_category_id"] = $data_app["business_sub_category_id"];
			$member["user_full_name"] = $data_app["user_full_name"];
			$member["zoobiz_id"] = $data_app["zoobiz_id"];
			$member["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_app['user_profile_pic'];
			$member["bussiness_category_name"] = html_entity_decode($data_app["category_name"]);
			$member["sub_category_name"] = html_entity_decode($data_app["sub_category_name"]) . '';
			$member["company_name"] = html_entity_decode($data_app["company_name"]) . '';
			$member["designation"] = html_entity_decode($data_app["designation"]) . '';
			$member["city_name"] = html_entity_decode($data_app["city_name"]) . '';
			$member["area_name"] = html_entity_decode($data_app["area_name"]) . '';
			$member["public_mobile"] = $data_app["public_mobile"];
			$member["user_mobile"] = $data_app["user_mobile"];
			$member["follow_status"] = $follow_status;

			array_push($response["member"], $member);
		}

		$response["message"] = "Member Found.";
		$response["status"] = "200";
		echo json_encode($response);
	} else {
		$response["message"] = "No Member Found.";
		$response["status"] = "201";
		echo json_encode($response);
	}

} else if ($_POST['getSubCategoryRegister'] == "getSubCategoryRegister") {

	$response["sub_category"] = array();

	$app_data = $d->select("business_categories,business_sub_categories", "
  business_categories.category_status = 0 and
business_sub_categories.business_category_id=business_categories.business_category_id AND business_sub_categories.sub_category_status='0'", "ORDER BY business_sub_categories.sub_category_name ASC");

	if (mysqli_num_rows($app_data) > 0) {

		while ($data = mysqli_fetch_array($app_data)) {

			$sub_category = array();
			$sub_category["business_sub_category_id"] = $data["business_sub_category_id"];
			$sub_category["business_category_id"] = $data["business_category_id"];
			$sub_category["category_name"] = html_entity_decode($data["sub_category_name"] . ' - ' . $data["category_name"]);
			array_push($response["sub_category"], $sub_category);
		}
		$response["message"] = "get Success.";
		$response["status"] = "200";
		echo json_encode($response);

	} else {
		$response["message"] = "No Category Found.";
		$response["status"] = "201";
		echo json_encode($response);
	}

} else if ($_POST['getPackage'] == "getPackage") {

	$response["package"] = array();

	$app_data = $d->select("package_master", "", "");

	if (mysqli_num_rows($app_data) > 0) {

		while ($data = mysqli_fetch_array($app_data)) {

			// find gst_amount
			$gst_amount = $data["package_amount"] * 18 / 100;

			$package = array();
			$package["package_id"] = $data["package_id"];

			if($data['gst_slab_id'] !="0"){
              $gst_slab_id = $data['gst_slab_id'];
                   $gst_master=$d->select("gst_master","slab_id = '$gst_slab_id'","");
                   $gst_master_data=mysqli_fetch_array($gst_master);
                   $slab_percentage=  " +".str_replace(".00","",$gst_master_data['slab_percentage']) .'% GST' ;

                   //4nov 2020
                   $gst_amount= (($data["package_amount"]*$gst_master_data['slab_percentage']) /100);
                   //4nov 2020
            } else {
                    $slab_percentage= "" ;
                    //4nov 2020
                    $gst_amount= 0 ;
            }

             




			$package["package_name"] = $data["package_name"] . ' (₹ ' . $data["package_amount"] . ' + '.$slab_percentage.')';
			$package["package_description"] = $data["packaage_description"];
			$package["package_amount"] = $data["package_amount"];
			$package["package_with_amount"] = number_format($data["package_amount"] + $gst_amount, 2, '.', '');
			$package["gst_amount"] = number_format($gst_amount, 2, '.', '');
			$package["no_of_month"] = $data["no_of_month"];
			$package["time_slab"] = $data["time_slab"];
			array_push($response["package"], $package);
		}
		$response["message"] = "Get Success.";
		$response["status"] = "200";
		echo json_encode($response);

	} else {
		$response["message"] = "No Package Found.";
		$response["status"] = "201";
		echo json_encode($response);
	}

} else if ($_POST['followCategory'] == "followCategory") {

	$last_auto_id = $d->last_auto_id("category_follow_master");
	$res = mysqli_fetch_array($last_auto_id);
	$category_follow_id = $res['Auto_increment'];

	$m->set_data('category_id', $category_id);
	$m->set_data('user_id', $user_id);
	$m->set_data('created_at', date("Y-m-d H:i:s"));

	$a = array(
		'category_id' => $m->get_data('category_id'),
		'user_id' => $m->get_data('user_id'),
		'created_at' => $m->get_data('created_at'),
	);

	$q = $d->insert("category_follow_master", $a);

	if ($q > 0) {
		$response["message"] = "Followed " . html_entity_decode($category_name) . ".";
		$response["status"] = "200";
		$response["category_follow_id"] = $category_follow_id;
		echo json_encode($response);
	} else {
		$response["message"] = "Something Went Wrong";
		$response["status"] = "201";
		echo json_encode($response);
	}
} else if ($_POST['unFollowCategory'] == "unFollowCategory") {

	$q = $d->delete("category_follow_master", "category_follow_id = '$category_follow_id'");

	if ($q == TRUE) {
		$response["message"] = "Unfollowed " . html_entity_decode($category_name) . ".";
		$response["status"] = "200";
		echo json_encode($response);
	} else {
		$response["message"] = "Something Went Wrong";
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