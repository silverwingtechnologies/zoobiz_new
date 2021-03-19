<?php
include_once 'lib.php';

if (isset($_POST) && !empty($_POST)) {

	if ($key == $keydb) {

		$response = array();
		extract(array_map("test_input", $_POST));

		if ($_POST['getFrames'] == "getFrames") {

			$qnotification = $d->select("frame_master", "status = '0'");
			$response["frames"] = array();

			if (mysqli_num_rows($qnotification) > 0) {

				while ($data = mysqli_fetch_array($qnotification)) {

					// print_r($data);
					$frames = array();

					$frames["frame_id"] = $data['frame_id'];
					$frames["frame_name"] = $data['frame_name'];
					$frames["layout_name"] = $data['layout_name'];
					$frames["frame_image"] = $base_url . "img/frames/" . $data['frame_image'];
					$frames["status"] = $data['status'];

					array_push($response["frames"], $frames);
				}

				$response["message"] = "Get frames success.";
				$response["status"] = "200";
				echo json_encode($response);
			}
		} else if ($_POST['getFrameImages'] == "getFrameImages") {

			$qnotification = $d->select("utility_banner_master", "frame_id = '$frame_id'");
			$response["images"] = array();

			if (mysqli_num_rows($qnotification) > 0) {

				while ($data = mysqli_fetch_array($qnotification)) {

					// print_r($data);
					$images = array();

					$images["banner_id"] = $data['banner_id'];
					$images["frame_id"] = $data['frame_id'];
					$images["banner_image"] = $base_url . "img/utilityBanner/" . $data['banner_image'];
					$images["active_status"] = $data['active_status'];
					$images["created_date"] = $data['created_date'];

					array_push($response["images"], $images);
				}

				$response["message"] = "Get frame images success.";
				$response["status"] = "200";
				echo json_encode($response);
			}
		} else if ($_POST['getFramesAndImages'] == "getFramesAndImages") {

			$qnotification = $d->select("frame_master", "status = '0'");
			$response["frames"] = array();

			if (mysqli_num_rows($qnotification) > 0) {

				while ($data = mysqli_fetch_array($qnotification)) {

					// print_r($data);
					$frames = array();

					$frames["frame_id"] = $data['frame_id'];
					$frames["frame_name"] = $data['frame_name'];
					$frames["layout_name"] = $data['layout_name'];
					$frames["frame_image"] = $base_url . "img/frames/" . $data['frame_image'];
					$frames["status"] = $data['status'];

					$qnotification1 = $d->select("utility_banner_master", "frame_id = '$data[frame_id]'");
					$frames["images"] = array();

					if (mysqli_num_rows($qnotification1) > 0) {

						while ($data1 = mysqli_fetch_array($qnotification1)) {

							$images = array();

							$images["banner_id"] = $data1['banner_id'];
							$images["frame_id"] = $data1['frame_id'];
							$images["banner_image"] = $base_url . "img/utilityBanner/" . $data1['banner_image'];
							$images["active_status"] = $data1['active_status'];
							$images["created_date"] = $data1['created_date'];

							array_push($frames["images"], $images);
						}
					}

					array_push($response["frames"], $frames);
				}

				$response["message"] = "Get frames success.";
				$response["status"] = "200";
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
}?>