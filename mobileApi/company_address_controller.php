<?php
include_once 'lib.php';

/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/

if (isset($_POST) && !empty($_POST)) {

	if ($key == $keydb) {

		$response = array();
		extract(array_map("test_input", $_POST));

		if ($_POST['get_company_address'] == "get_company_address" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$qA2 = $d->select("area_master,business_adress_master,cities,states,countries", "business_adress_master.user_id='$user_id'
                AND
                business_adress_master.country_id = countries.country_id
                AND
                business_adress_master.state_id = states.state_id
                AND
                business_adress_master.city_id = cities.city_id
                AND
                business_adress_master.area_id = area_master.area_id", "ORDER BY business_adress_master.adress_type ASC");

			if (mysqli_num_rows($qA2) > 0) {

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
					$company_address["area_name"] = $data_app["area_name"] . " [" . $data_app["pincode"] . "]";
					$company_address["adress"] = $data_app["adress"];
					array_push($response["company_address"], $company_address);

				}

				$response["message"] = "Get company address info success.";
				$response["status"] = "200";
				echo json_encode($response);
			} else {

				$response["message"] = "No company address info found";
				$response["status"] = "201";
				echo json_encode($response);
			}
		} else if ($_POST['get_countries'] == "get_countries") {

			$qA2 = $d->select("countries", "flag=1", "");

			if (mysqli_num_rows($qA2) > 0) {

				$response["countries"] = array();

				while ($data_app = mysqli_fetch_array($qA2)) {

					$countries = array();
					$countries["country_id"] = $data_app["country_id"];
					$countries["country_name"] = "" . $data_app["country_name"];
					array_push($response["countries"], $countries);

				}

				$response["message"] = "Get countries info success.";
				$response["status"] = "200";
				echo json_encode($response);
			} else {

				$response["message"] = "No countries info found";
				$response["status"] = "201";
				echo json_encode($response);
			}
		} else if ($_POST['get_states'] == "get_states" && filter_var($country_id, FILTER_VALIDATE_INT) == true) {

			$qA2 = $d->select("states", "country_id='$country_id' AND state_flag=1", "");

			if (mysqli_num_rows($qA2) > 0) {

				$response["states"] = array();

				while ($data_app = mysqli_fetch_array($qA2)) {

					$states = array();
					$states["state_id"] = $data_app["state_id"];
					$states["state_name"] = "" . $data_app["state_name"];
					array_push($response["states"], $states);

				}

				$response["message"] = "Get states info success.";
				$response["status"] = "200";
				echo json_encode($response);
			} else {

				$response["message"] = "No states info found";
				$response["status"] = "201";
				echo json_encode($response);
			}
		} else if ($_POST['get_cities'] == "get_cities" && filter_var($country_id, FILTER_VALIDATE_INT) == true
			&& filter_var($state_id, FILTER_VALIDATE_INT) == true) {

			$qA2 = $d->select("cities", "country_id='$country_id' AND state_id='$state_id' AND city_flag=1", "");

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
		} else if ($_POST['get_area'] == "get_area" && filter_var($country_id, FILTER_VALIDATE_INT) == true
			&& filter_var($state_id, FILTER_VALIDATE_INT) == true
			&& filter_var($city_id, FILTER_VALIDATE_INT) == true) {
			$qA2 = $d->select("area_master", "country_id='$country_id' AND state_id='$state_id' AND
            city_id='$city_id'", "");
			if (mysqli_num_rows($qA2) > 0) {
				$response["area"] = array();
				while ($data_app2 = mysqli_fetch_array($qA2)) {
					$area = array();
					$area["area_id"] = $data_app2["area_id"];
					$area["area_name"] = $data_app2["area_name"];
					$area["pincode"] = $data_app2["pincode"];
					array_push($response["area"], $area);
				}
				$response["message"] = "Get area info success.";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "No area info found";
				$response["status"] = "201";
				echo json_encode($response);
			}
		} else if ($_POST['add_company_address'] == "add_company_address" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$m->set_data('user_id', $user_id);
			$m->set_data('adress', $adress);
			$m->set_data('area_id', $area_id);
			$m->set_data('city_id', $city_id);
			$m->set_data('state_id', $state_id);
			$m->set_data('country_id', $country_id);
			$m->set_data('pincode', $pincode);
			$m->set_data('latitude', $latitude);
			$m->set_data('longitude', $longitude);
			$m->set_data('adress_type', $adress_type);

			$a = array(
				'user_id' => $m->get_data('user_id'),
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

			if ($adress_id == 0) {
				if ($adress_type == 0) {
					$a11 = array(
						'adress_type' => 1,
					);
					$d->update("business_adress_master", $a11, "user_id='$user_id'");
				} else if ($adress_type == 1) {
					$totalAddress = $d->count_data_direct("adress_id", "business_adress_master", "user_id='$user_id' AND adress_type=0 ");
					if ($totalAddress < 1) {
						$response["message"] = "Need at least 1 primary address";
						$response["status"] = "201";
						echo json_encode($response);
						exit();
					}

				}

				$d->insert("business_adress_master", $a, "");
				$response["message"] = "Add Successfully !";
			} else {
				if ($adress_type == 0) {
					$a11 = array(
						'adress_type' => 1,
					);
					$d->update("business_adress_master", $a11, "user_id='$user_id' AND adress_id!='$adress_id'");
				} else if ($adress_type == 1) {
					$totalAddress = $d->count_data_direct("adress_id", "business_adress_master", "user_id='$user_id' AND adress_type=0 AND adress_id!='$adress_id'");
					if ($totalAddress < 1) {
						$response["message"] = "Need at least 1 primary address";
						$response["status"] = "201";
						echo json_encode($response);
						exit();
					}

				}

				$d->update("business_adress_master", $a, "adress_id='$adress_id'");
				$response["message"] = "Update Successfully !";
			}

			if ($d == true) {

				$response["status"] = "200";
				echo json_encode($response);

			} else {
				$response["message"] = "Something Wrong";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} else if ($_POST['delete_address'] == "delete_address" && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($adress_id, FILTER_VALIDATE_INT) == true) {
			$totalAddress = $d->count_data_direct("adress_id", "business_adress_master", "user_id='$user_id' AND adress_type=0 AND adress_id!='$adress_id'");
			if ($totalAddress < 1) {
				$response["message"] = "Need at least 1 primary address";
				$response["status"] = "201";
				echo json_encode($response);
				exit();
			}

			$q = $d->delete("business_adress_master", "adress_id='$adress_id' AND user_id='$user_id'");

			if ($q == true) {
				$response["message"] = "Deleted Successfully !";
				$response["status"] = "200";
				echo json_encode($response);

			} else {
				$response["message"] = "Something Wrong";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} else {

			$response["message"] = "Wrong tag";
			$response["status"] = "201";
			echo json_encode($response);
		}
	} else {
		$response["message"] = "wrong api key.";
		$response["status"] = "201";
		echo json_encode($response);
	}
}
