<?php
include_once 'lib.php';

if (isset($_POST) && !empty($_POST)) {
// ini_set('display_errors', '1');
	// ini_set('display_startup_errors', '1');
	// error_reporting(E_ALL);
// //C:\xampp\htdocs\zoobiz\mobileApi\timeline_controller.php


	if ($key == $keydb) {
		$response = array();
		extract(array_map("test_input", $_POST));

		if ($_POST['getFeed'] == "getFeed" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$totalFeed = $d->count_data_direct("timeline_id", "timeline_master", "active_status = 0 ");

			$qnotification = $d->select("timeline_master", "active_status = 0 ", "ORDER BY timeline_id DESC LIMIT $limit_feed,10");

		    $totalSocietyFeedLimit = $d->count_data_direct("timeline_id", "timeline_master", "active_status = 0");
 
			if (mysqli_num_rows($qnotification) > 0) {

				$response["feed"] = array();
				while ($data_notification = mysqli_fetch_array($qnotification)) {

					$qch22 = $d->select("user_block_master", "user_id='$user_id' AND block_by='$data_notification[user_id]' ");

					//new
					$user_found =1;
					if ($data_notification['user_id'] != 0) {
						$time_line_user = $data_notification['user_id'];
						$user_found = $user_counter = $d->count_data_direct("user_id","user_employment_details,users_master", " users_master.user_id=user_employment_details.user_id and  users_master.user_id='$time_line_user'  ");
					}
					if($user_found){ 
					//new

					if ($data_notification['user_id'] != 0) {
						$qu = $d->select("users_master,user_employment_details", "users_master.user_id=user_employment_details.user_id AND users_master.user_id='$data_notification[user_id]' ");
						$userData = mysqli_fetch_array($qu);
						$userProfile = $base_url . "img/users/members_profile/" . $userData['user_profile_pic'];
						$user_full_name = $userData['user_full_name'];
						$company_name = html_entity_decode($userData['company_name']);
					} else {
						$userProfile = $base_url . "img/fav.png";
						$user_full_name = "ZooBiz";
						$company_name = "Admin";
					}

					$feed = array();
					$feed["timeline_id"] = $data_notification['timeline_id'];
					$feed["timeline_text"] = html_entity_decode($data_notification['timeline_text'] . ' ' . $block_status);
					$feed["user_name"] = $user_full_name;
					$feed["company_name"] = $company_name;
					$feed["user_id"] = $data_notification['user_id'];
					$feed["user_profile_pic"] = $userProfile;
					$timeline_id = $data_notification['timeline_id'];

					$fi = $d->select("timeline_photos_master", "timeline_id='$timeline_id' AND user_id='$data_notification[user_id]'");

					$feed["timeline_photos"] = array();

					while ($feeData = mysqli_fetch_array($fi)) {
						$timeline_photos = array();
						$timeline_photos["photo_name"] = $base_url . "img/timeline/" . $feeData['photo_name'];
						$timeline_photos["feed_height"] = $feeData['feed_img_height'];
						$timeline_photos["feed_width"] = $feeData['feed_img_width'];
						array_push($feed["timeline_photos"], $timeline_photos);

					}

					$feed["feed_type"] = $data_notification['feed_type'];
				/*	$feed["modify_date"] = time_elapsed_string($data_notification['created_date']);*/


if(strtotime($data_notification['created_date']) < strtotime('-30 days')) {
				     $feed["modify_date"] = date("j M Y", strtotime($data_notification['created_date']));
				 } else {
				 	$feed["modify_date"] = time_elapsed_string($data_notification['created_date']);
				 }


					$qlike = $d->select("timeline_like_master,users_master", "timeline_like_master.timeline_id='$timeline_id' AND timeline_like_master.user_id=users_master.user_id AND timeline_like_master.active_status=0");
					$totalLikes = mysqli_num_rows($qlike);
					$feed["totalLikes"] = "$totalLikes";

					if (mysqli_num_rows($qlike) > 0) {
						$feed["like"] = array();
						$feed["like_status"] = "0";

						while ($data_like = mysqli_fetch_array($qlike)) {

							$like = array();

							$like["like_id"] = $data_like['like_id'];
							$like["timeline_id"] = $data_like['timeline_id'];
							$like["user_id"] = $data_like['user_id'];

							if ($user_id == $data_like['user_id']) {

								$feed["like_status"] = "1";

							} else {
								if ($feed["like_status"] == "1") {

								} else {

									$feed["like_status"] = "0";
								}
							}
							$like["user_name"] = $data_like['user_full_name'];
							$like["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_like['user_profile_pic'];
							$like["modify_date"] = $data_like['modify_date'];

							array_push($feed["like"], $like);
						}
					} else {

						$feed["like_status"] = "0";
					}

					$qcomment = $d->select("timeline_comments,users_master", "timeline_comments.timeline_id='$timeline_id' AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id=0", "ORDER BY timeline_comments.comments_id DESC");

					if (mysqli_num_rows($qcomment) > 0) {
						$feed["comment"] = array();

						while ($data_comment = mysqli_fetch_array($qcomment)) {

							$comment = array();

							$comment["comments_id"] = $data_comment['comments_id'];
							$comment["timeline_id"] = $data_comment['timeline_id'];
							$comment["msg"] = html_entity_decode($data_comment['msg']);
							$comment["user_name"] = $data_comment['user_full_name'];
							$comment["user_id"] = $data_comment['user_id'];
							$comment["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_comment['user_profile_pic'];
							if ($user_id == $data_comment['user_id']) {
								$feed["comment_status"] = "1";
							} else {
								$feed["comment_status"] = "0";
							}
							//$comment["modify_date"] = time_elapsed_string($data_comment['modify_date']);

				 if(strtotime($data_comment['modify_date']) < strtotime('-30 days')) {
				    $comment["modify_date"] = date("j M Y", strtotime($data_notification['created_date']));
				 } else {
				 	$comment["modify_date"] = time_elapsed_string($data_comment['modify_date']);
				 }



							$comment["sub_comment"] = array();
							$q4 = $d->select("timeline_comments,users_master", "timeline_comments.timeline_id='$timeline_id' AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id='$data_comment[comments_id]'", "ORDER BY timeline_comments.comments_id DESC");
							while ($subCommentData = mysqli_fetch_array($q4)) {
								$sub_comment = array();
								$sub_comment["comments_id"] = $subCommentData['comments_id'];
								$sub_comment["timeline_id"] = $subCommentData['timeline_id'];
								$sub_comment["msg"] = html_entity_decode($subCommentData['msg']);
								$sub_comment["user_name"] = $subCommentData['user_full_name'];
								$sub_comment["user_id"] = $subCommentData['user_id'];
								$sub_comment["user_profile_pic"] = $base_url . "img/users/members_profile/" . $subCommentData['user_profile_pic'];
								//$sub_comment["modify_date"] = time_elapsed_string($subCommentData['modify_date']);

								if(strtotime($subCommentData['modify_date']) < strtotime('-30 days')) {
				    $sub_comment["modify_date"] = date("j M Y", strtotime($subCommentData['modify_date']));
				 } else {
				 	$sub_comment["modify_date"]= time_elapsed_string($subCommentData['modify_date']);
				 }



								array_push($comment["sub_comment"], $sub_comment);
							}
							array_push($feed["comment"], $comment);
						}
					} else {
						$feed["comment_status"] = "0";
					}

					if (mysqli_num_rows($qch22) == 0) {
						array_push($response["feed"], $feed);
					}
				}
			}
				// print_r($response["feed"]);

				$q2222 = $d->select("user_notification", "user_id='$user_id' AND  notification_type=1 AND read_status=0");

				$response["unread_notification"] = mysqli_num_rows($q2222);
				$response["pos1"] = $pos1 + 0;
				$response["totalSocietyFeedLimit"] = '' . $totalSocietyFeedLimit + count($mainFeed);
				$response["message"] = "Get Feeds success.";
				$response["totalFeed"] = $totalFeed;
				$response["status"] = "200";
				echo json_encode($response);

			} else {
				$response["message"] = "No Data Found";
				$response["status"] = "201";
				echo json_encode($response);
			}
		} else if ($_POST['addFeed'] == "addFeed" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$temDate2 = date("Y_m_dhis");
			$modify_date = date("Y-m-d H:i:s");
			$last_auto_id = $d->last_auto_id("timeline_master");
			$res = mysqli_fetch_array($last_auto_id);
			$timeline_id = $res['Auto_increment'];

			if ($feed_type == "1") {

				$total = count($_FILES['photo']['tmp_name']);

				$m->set_data('feed_type', 1);
				$m->set_data('timeline_text', $timeline_text);
				$m->set_data('user_id', $user_id);
				$m->set_data('user_name', $user_name);
				$m->set_data('created_date', $modify_date);

				$a1 = array(
					'feed_type' => $m->get_data('feed_type'),
					'timeline_text' => $m->get_data('timeline_text'),
					'user_id' => $m->get_data('user_id'),
					// 'user_name'=>$m->get_data('user_name'),
					'created_date' => $m->get_data('created_date'),
				);

				$d->insert("timeline_master", $a1);

				if ($d == TRUE) {

					for ($i = 0; $i < $total; $i++) {
						$uploadedFile = $_FILES['photo']['tmp_name'][$i];
						if ($uploadedFile != "") {

							$sourceProperties = getimagesize($uploadedFile);
							$newFileName = rand() . $user_id;
							$dirPath = "../img/timeline/";
							$ext = pathinfo($_FILES['photo']['name'][$i], PATHINFO_EXTENSION);
							$imageType = $sourceProperties[2];
							$imageHeight = $sourceProperties[1];
							$imageWidth = $sourceProperties[0];

							if ($imageWidth > 1800) {
								$newWidthPercentage = 1800 * 100 / $imageWidth; //for maximum 1200 widht
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
								imagepng($tmp, $dirPath . $newFileName . "_feed." . $ext);
								break;

							case IMAGETYPE_JPEG:
								$imageSrc = imagecreatefromjpeg($uploadedFile);
								$tmp = imageResize($imageSrc, $sourceProperties[0], $sourceProperties[1], $newImageWidth, $newImageHeight);
								imagejpeg($tmp, $dirPath . $newFileName . "_feed." . $ext);
								break;

							case IMAGETYPE_GIF:
								$imageSrc = imagecreatefromgif($uploadedFile);
								$tmp = imageResize($imageSrc, $sourceProperties[0], $sourceProperties[1], $newImageWidth, $newImageHeight);
								imagegif($tmp, $dirPath . $newFileName . "_feed." . $ext);
								break;

							default:
								$response["message"] = "Invalid Image type.";
								$response["status"] = "201";
								echo json_encode($response);
								exit;
								break;
							}
							$feed_img = $newFileName . "_feed." . $ext;

							$a1 = array(
								'timeline_id' => $timeline_id,
								'user_id' => $user_id,
								'photo_name' => $feed_img,
								'feed_img_height' => $newImageHeight,
								'feed_img_width' => $newImageWidth,
							);

							$d->insert("timeline_photos_master", $a1);

						} else {
							$response["message"] = "faild.";
							$response["status"] = "201";
							echo json_encode($response);
							exit();

						}
					}
					$title = "$user_name Add New Post In Timeline";
					if ($timeline_text == '') {
						//23nov $user_name added
						$description = "$user_name Post a new photo";
					} else {
						$description = $timeline_text;
					}

					$d->insertFollowNotification($title, $description, $timeline_id, $user_id, 1, "timeline");

					$fcmArray = $d->get_android_fcm("users_master,follow_master", "users_master.user_id=follow_master.follow_by AND follow_master.follow_to='$user_id' AND users_master.user_token!='' AND  users_master.device='android' ");

					$fcmArrayIos = $d->get_android_fcm("users_master,follow_master", "users_master.user_id=follow_master.follow_by AND follow_master.follow_to='$user_id' AND users_master.user_token!='' AND  users_master.device='ios' ");

					$getCatId = $d->select("user_employment_details", "user_id = '$user_id'");
					$getCatData = mysqli_fetch_array($getCatId);

					$fcmArrayAndroidFollow = $d->get_android_fcm("users_master,category_follow_master", " users_master.user_id=category_follow_master.user_id AND category_follow_master.category_id='$getCatData[business_category_id]' AND users_master.user_token!='' AND  users_master.device='android' and users_master.user_id != '$user_id' ");

					$fcmArrayIosFollow = $d->get_android_fcm("users_master,category_follow_master", "users_master.user_id=category_follow_master.user_id AND category_follow_master.category_id='$getCatData[business_category_id]' AND users_master.user_token!='' AND  users_master.device='ios'  and users_master.user_id != '$user_id' ");

					$fcmArray = array_merge($fcmArrayAndroidFollow, $fcmArray);
					$fcmArrayIos = array_merge($fcmArrayIosFollow, $fcmArrayIos);

					//23oct2020
					$last_auto_id=$d->last_auto_id("timeline_master");
          $res=mysqli_fetch_array($last_auto_id);
          $new_feed_id=$res['Auto_increment'];

          $new_feed_id = ($new_feed_id-1);
//23oct2020


					$nResident->noti("timeline", "", 0, $fcmArray, $title, $description, $new_feed_id);
					$nResident->noti_ios("timeline", "", 0, $fcmArrayIos, $title, $description, $new_feed_id);

					$response["message"] = "Posted successfully";
					$response["status"] = "200";
					echo json_encode($response);
					exit();

				} else {

					$response["message"] = "Something Wrong";
					$response["status"] = "201";
					echo json_encode($response);

				}

			} else {
				if ($timeline_text == '') {
					$response["message"] = "Please write something";
					$response["status"] = "201";
					echo json_encode($response);
					exit();
				}

				$m->set_data('feed_type', 0);
				$m->set_data('timeline_text', $timeline_text);
				$m->set_data('user_id', $user_id);
				$m->set_data('user_name', $user_name);
				$m->set_data('created_date', $modify_date);

				$a1 = array(
					'feed_type' => $m->get_data('feed_type'),
					'timeline_text' => $m->get_data('timeline_text'),
					'user_id' => $m->get_data('user_id'),
					'created_date' => $m->get_data('created_date'),
				);

				$d->insert("timeline_master", $a1);

				if ($d == TRUE) {
					$title = "$user_name Add New Post In Timeline";
					$description = $timeline_text;

					$d->insertFollowNotification($title, $description, $timeline_id, $user_id, 1, "timeline");

					$fcmArray = $d->get_android_fcm("users_master,follow_master", "users_master.user_id=follow_master.follow_by AND follow_master.follow_to='$user_id' AND users_master.user_token!='' AND  users_master.device='android' and users_master.user_id != '$user_id' ");

					$fcmArrayIos = $d->get_android_fcm("users_master,follow_master", "users_master.user_id=follow_master.follow_by AND follow_master.follow_to='$user_id' AND users_master.user_token!='' AND  users_master.device='ios' and users_master.user_id != '$user_id' ");

					$getCatId = $d->select("user_employment_details", "user_id = '$user_id'");
					$getCatData = mysqli_fetch_array($getCatId);

					$fcmArrayAndroidFollow = $d->get_android_fcm("users_master,category_follow_master", "users_master.user_id=category_follow_master.user_id AND category_follow_master.category_id='$getCatData[business_category_id]' AND users_master.user_token!='' AND  users_master.device='android' and users_master.user_id != '$user_id' ");

					$fcmArrayIosFollow = $d->get_android_fcm("users_master,category_follow_master", "users_master.user_id=category_follow_master.user_id AND category_follow_master.category_id='$getCatData[business_category_id]' AND users_master.user_token!='' AND  users_master.device='ios' and users_master.user_id != '$user_id' ");

					$fcmArray = array_merge($fcmArrayAndroidFollow, $fcmArray);
					$fcmArrayIos = array_merge($fcmArrayIosFollow, $fcmArrayIos);

					//23oct2020
					$last_auto_id=$d->last_auto_id("timeline_master");
          $res=mysqli_fetch_array($last_auto_id);
          $new_feed_id=$res['Auto_increment'];

          $new_feed_id = ($new_feed_id-1);
//23oct2020

					$nResident->noti("timeline", "", 0, $fcmArray, $title, $description, $new_feed_id );
					$nResident->noti_ios("timeline", "", 0, $fcmArrayIos, $title, $description, $new_feed_id );

					$response["message"] = "Posted successfully";
					$response["status"] = "200";
					echo json_encode($response);

				} else {

					$response["message"] = "Something Wrong";
					$response["status"] = "201";
					echo json_encode($response);

				}

			}
		} else if ($_POST['likeFeed'] == "likeFeed" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$m->set_data('timeline_id', $timeline_id);
			$m->set_data('user_id', $user_id);
			$m->set_data('user_name', $user_name);
			$m->set_data('block_name', $block_name);
			$m->set_data('modify_date', date("Y-m-d H:i:s"));

			$a1 = array(
				'timeline_id' => $m->get_data('timeline_id'),
				'user_id' => $m->get_data('user_id'),
				'modify_date' => $m->get_data('modify_date'),
			);
			if ($like_status == 0) {

				$qcheck = $d->select("timeline_like_master", "user_id='$user_id' AND timeline_id='$timeline_id'");
				if (mysqli_num_rows($qcheck) > 0) {
					$a1 = array(
						'active_status' => 0,
					);

					$d->update("timeline_like_master", $a1, "user_id='$user_id' AND timeline_id='$timeline_id'");
				} else {

					$d->delete("timeline_like_master", "user_id='$user_id' AND timeline_id='$timeline_id'");
					$d->insert("timeline_like_master", $a1);

					$quc = $d->select("users_master,timeline_master", "timeline_master.user_id=users_master.user_id AND timeline_master.timeline_id='$timeline_id' AND users_master.user_id!='$user_id'");
					$userData = mysqli_fetch_array($quc);
					$sos_user_token = $userData['user_token'];
					$device = $userData['device'];
					$feed_user_id = $userData['user_id'];
					if ($feed_user_id != $user_id && $feed_user_id != '0' AND $feed_user_id != '') {
						# code...

						$title = "$user_name ";
						$msg = "Liked your post";

						$notiAry = array(
							'user_id' => $feed_user_id,
							'notification_title' => 'timeline',
							'notification_desc' => "$user_name liked your post",
							'notification_date' => date('Y-m-d H:i'),
							'notification_action' => 'timeline',
							'notification_logo' => 'timeline.png',
							'notification_type' => '1',
							'other_user_id' => $user_id,
							'timeline_id' => $timeline_id,
						);
						$d->insert("user_notification", $notiAry);

						if ($device == 'android') {
							$nResident->noti("timeline", "", $society_id, $sos_user_token, $title, $msg, $timeline_id);
						} else if ($device == 'ios') {
							$nResident->noti_ios("timeline", "", $society_id, $sos_user_token, $title, $msg, $timeline_id);
						}
					}
				}

			} else {
				$a1 = array(
					'active_status' => 1,
				);

				$d->update("timeline_like_master", $a1, "user_id='$user_id' AND timeline_id='$timeline_id'");

				// $d->delete("timeline_like_master","user_id='$user_id' AND timeline_id='$timeline_id'");
			}

			if ($d == TRUE) {

				$response["message"] = "Liked";
				$response["status"] = "200";
				echo json_encode($response);

			} else {

				$response["message"] = "Somehitng wrong";
				$response["status"] = "201";
				echo json_encode($response);

			}
		} else if ($_POST['commentFeed'] == "commentFeed" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			if ($msg == '') {
				$response["message"] = "Please enter your comment message.";
				$response["status"] = "201";
				echo json_encode($response);
				exit();
			}

			$m->set_data('parent_comments_id', $parent_comments_id);
			$m->set_data('timeline_id', $timeline_id);
			$m->set_data('msg', $msg);
			$m->set_data('user_id', $user_id);
			$m->set_data('user_name', $user_name);

			$a1 = array(
				'parent_comments_id' => $m->get_data('parent_comments_id'),
				'timeline_id' => $m->get_data('timeline_id'),
				'msg' => $m->get_data('msg'),
				'user_id' => $m->get_data('user_id'),
				'user_name' => $m->get_data('user_name'),
				'modify_date' => date("Y-m-d H:i:s"),
			);

			$d->insert("timeline_comments", $a1);

			if ($d == TRUE) {
				if ($parent_comments_id != 0) {
					$quc = $d->select("users_master,timeline_comments", "timeline_comments.user_id=users_master.user_id AND timeline_comments.timeline_id='$timeline_id' AND timeline_comments.user_id!='$user_id'");
				} else {
					$quc = $d->select("users_master,timeline_master", "timeline_master.user_id=users_master.user_id AND timeline_master.timeline_id='$timeline_id' AND users_master.user_id!='$user_id'");
				}
				$userData = mysqli_fetch_array($quc);
				$sos_user_token = $userData['user_token'];
				$device = $userData['device'];
				$feed_user_id = $userData['user_id'];

				if ($parent_comments_id != '0' && $parent_comments_id != '') {
					$title = "$user_name replied on your comment";
				} else {
					$title = "$user_name commented on your post";

				}
				if ($feed_user_id != '' && $feed_user_id != 0 && $feed_user_id != $user_id) {

					if ($device == 'android') {
						$nResident->noti("timeline", "", $society_id, $sos_user_token, $title, $msg, $timeline_id);
					} else if ($device == 'ios') {
						$nResident->noti_ios("timeline", "", $society_id, $sos_user_token, $title, $msg, $timeline_id);
					}

					$notiAry = array(
						'user_id' => $feed_user_id,
						'notification_title' => 'timeline',
						'notification_desc' => "$title $msg",
						'notification_date' => date('Y-m-d H:i'),
						'notification_action' => 'timeline',
						'notification_logo' => 'timeline.png',
						'notification_type' => '1',
						'other_user_id' => $user_id,
						'timeline_id' => $timeline_id,
					);
					$d->insert("user_notification", $notiAry);
				}

				$qcomment = $d->select("timeline_comments,users_master", "timeline_comments.timeline_id='$timeline_id' AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id=0", "ORDER BY timeline_comments.comments_id DESC");

				if (mysqli_num_rows($qcomment) > 0) {
					$response["comment"] = array();

					while ($data_comment = mysqli_fetch_array($qcomment)) {

						$comment = array();

						$comment["comments_id"] = $data_comment['comments_id'];
						$comment["timeline_id"] = $data_comment['timeline_id'];
						$comment["msg"] = $data_comment['msg'];
						$comment["user_name"] = $data_comment['user_name'];
						$comment["user_id"] = $data_comment['user_id'];
						//$comment["modify_date"] = time_elapsed_string($data_comment['modify_date']);

						if(strtotime($data_comment['modify_date']) < strtotime('-30 days')) {
				   $comment["modify_date"] = date("j M Y", strtotime($data_comment['modify_date']));
				 } else {
				 	$comment["modify_date"]= time_elapsed_string($data_comment['modify_date']);
				 }


						$comment["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_comment['user_profile_pic'];

						$comment["sub_comment"] = array();
						$q4 = $d->select("timeline_comments,users_master", "timeline_comments.timeline_id='$timeline_id' AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id='$data_comment[comments_id]'", "ORDER BY timeline_comments.comments_id DESC");
						while ($subCommentData = mysqli_fetch_array($q4)) {
							$sub_comment = array();
							$sub_comment["comments_id"] = $subCommentData['comments_id'];
							$sub_comment["timeline_id"] = $subCommentData['timeline_id'];
							$sub_comment["msg"] = html_entity_decode($subCommentData['msg']);
							$sub_comment["user_name"] = $subCommentData['user_name'];
							$sub_comment["user_id"] = $subCommentData['user_id'];
							$sub_comment["user_profile_pic"] = $base_url . "img/users/members_profile/" . $subCommentData['user_profile_pic'];
							//$sub_comment["modify_date"] = time_elapsed_string($subCommentData['modify_date']);

							if(strtotime($subCommentData['modify_date']) < strtotime('-30 days')) {
				   $sub_comment["modify_date"] = date("j M Y", strtotime($subCommentData['modify_date']));
				 } else {
				 	$sub_comment["modify_date"]= time_elapsed_string($subCommentData['modify_date']);
				 }


							array_push($comment["sub_comment"], $sub_comment);
						}

						array_push($response["comment"], $comment);
					}
				}

				$response["message"] = "Comment Added $title";
				$response["status"] = "200";
				echo json_encode($response);

			} else {

				$response["message"] = "faild.";
				$response["status"] = "201";
				echo json_encode($response);

			}

		} else if ($_POST['getComments'] == "getComments" && filter_var($timeline_id, FILTER_VALIDATE_INT) == true) {

			$qcomment = $d->select("timeline_comments,users_master", "timeline_comments.timeline_id='$timeline_id' AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id=0", "ORDER BY timeline_comments.comments_id DESC");

			if (mysqli_num_rows($qcomment) > 0) {
				$response["comment"] = array();

				while ($data_comment = mysqli_fetch_array($qcomment)) {

					$comment = array();

					$comment["comments_id"] = $data_comment['comments_id'];
					$comment["timeline_id"] = $data_comment['timeline_id'];
					$comment["msg"] = $data_comment['msg'];
					$comment["user_name"] = $data_comment['user_full_name'];
					$comment["user_id"] = $data_comment['user_id'];
					//$comment["modify_date"] = time_elapsed_string($data_comment['modify_date']);

					if(strtotime($data_comment['modify_date']) < strtotime('-30 days')) {
				   $comment["modify_date"] = date("j M Y", strtotime($data_comment['modify_date']));
				 } else {
				 	$comment["modify_date"]= time_elapsed_string($data_comment['modify_date']);
				 }


					$comment["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_comment['user_profile_pic'];

					$comment["sub_comment"] = array();
					$q4 = $d->select("timeline_comments,users_master", "timeline_comments.timeline_id='$timeline_id' AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id='$data_comment[comments_id]'", "ORDER BY timeline_comments.comments_id DESC");
					while ($subCommentData = mysqli_fetch_array($q4)) {
						$sub_comment = array();
						$sub_comment["comments_id"] = $subCommentData['comments_id'];
						$sub_comment["timeline_id"] = $subCommentData['timeline_id'];
						$sub_comment["msg"] = html_entity_decode($subCommentData['msg']);
						$sub_comment["user_name"] = $subCommentData['user_name'];
						$sub_comment["user_id"] = $subCommentData['user_id'];
						$sub_comment["user_profile_pic"] = $base_url . "img/users/members_profile/" . $subCommentData['user_profile_pic'];
						//$sub_comment["modify_date"] = time_elapsed_string($subCommentData['modify_date']);

						if(strtotime($subCommentData['modify_date']) < strtotime('-30 days')) {
				   $sub_comment["modify_date"] = date("j M Y", strtotime($subCommentData['modify_date']));
				 } else {
				 	$sub_comment["modify_date"]= time_elapsed_string($subCommentData['modify_date']);
				 }


						array_push($comment["sub_comment"], $sub_comment);
					}
					array_push($response["comment"], $comment);
				}
				$response["message"] = "success.";
				$response["status"] = "200";
				echo json_encode($response);

			} else {
				$response["message"] = "faild.";
				$response["status"] = "201";
				echo json_encode($response);
			}
		} else if ($_POST['deleteFeed'] == "deleteFeed" && filter_var($timeline_id, FILTER_VALIDATE_INT) == true && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$q = $d->delete("timeline_master", "timeline_id='$timeline_id' AND timeline_id!=0 AND user_id='$user_id'");

			if ($q == true) {
				$q = $d->delete("timeline_comments", "timeline_id='$timeline_id'");
				$q = $d->delete("timeline_like_master", "timeline_id='$timeline_id'");
				$q = $d->delete("user_notification", "timeline_id='$timeline_id'");
				$q = $d->delete("timeline_photos_master", "timeline_id='$timeline_id'");
				$response["message"] = "Deleted Successfully";
				$response["status"] = "200";
				echo json_encode($response);

			} else {
				$response["message"] = "Sumething Wrong";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} else if ($_POST['deleteComment'] == "deleteComment" && filter_var($comments_id, FILTER_VALIDATE_INT) == true && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$q = $d->delete("timeline_comments", "comments_id='$comments_id' AND user_id='$user_id'");

			if ($q == true) {
				$q = $d->delete("timeline_comments", "parent_comments_id='$comments_id' AND user_id='$user_id'");
				$response["message"] = "Comment Deleted";
				$response["status"] = "200";
				echo json_encode($response);

			} else {
				$response["message"] = "Something Wrong";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} else if ($_POST['getMyFeed'] == "getMyFeed") {

			$qnotification = $d->select("timeline_master,users_master,user_employment_details", "user_employment_details.user_id=users_master.user_id AND timeline_master.active_status = 0 AND timeline_master.user_id='$user_id' AND users_master.user_id='$user_id'", "ORDER BY timeline_id DESC LIMIT 500");

			$tq11 = $d->selectRow("timeline_id", "timeline_master", "user_id='$user_id'");
			$total_post = mysqli_num_rows($tq11);

			$tq22 = $d->select("users_master,follow_master,user_employment_details,business_categories,business_sub_categories", "business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND follow_master.follow_by=users_master.user_id AND follow_master.follow_to='$user_id'", "ORDER BY users_master.user_full_name ASC");
			// $tq22=$d->selectRow("follow_id","follow_master","follow_by!='$data_app[user_id]'");
			$followers = mysqli_num_rows($tq22);

			$tq33 = $d->select("users_master,follow_master,user_employment_details,business_categories,business_sub_categories", "business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND follow_master.follow_to=users_master.user_id AND follow_master.follow_by='$user_id'", "ORDER BY users_master.user_full_name ASC");
			// $tq33=$d->selectRow("follow_id","follow_master","follow_by='$data_app[user_id]'");
			$following = mysqli_num_rows($tq33);

			$qche = $d->select("follow_master", "follow_by='$my_id' AND follow_to='$user_id'");
			if (mysqli_num_rows($qche) > 0) {
				$follow_status = true;
			} else {
				$follow_status = false;
			}

			if (mysqli_num_rows($qnotification) > 0) {

				$response["feed"] = array();

				while ($data_notification = mysqli_fetch_array($qnotification)) {

					$feed = array();
					$feed["timeline_id"] = $data_notification['timeline_id'];
					$feed["timeline_text"] = $data_notification['timeline_text'];
					$feed["user_name"] = $data_notification['user_full_name'];
					$feed["company_name"] = html_entity_decode($data_notification['company_name']);
					$feed["user_id"] = $data_notification['user_id'];
					$feed["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_notification['user_profile_pic'];
					$timeline_id = $data_notification['timeline_id'];
					$feed["feed_type"] = $data_notification['feed_type'];
					//$feed["modify_date"] = time_elapsed_string($data_notification['created_date']);

					if(strtotime($data_notification['created_date']) < strtotime('-30 days')) {
				   $feed["modify_date"] = date("j M Y", strtotime($data_notification['created_date']));
				 } else {
				 	$feed["modify_date"]= time_elapsed_string($data_notification['created_date']);
				 }


					$fi = $d->select("timeline_photos_master", "timeline_id='$timeline_id' AND user_id='$data_notification[user_id]'");

					$feed["timeline_photos"] = array();

					while ($feeData = mysqli_fetch_array($fi)) {
						$timeline_photos = array();
						$timeline_photos["photo_name"] = $base_url . "img/timeline/" . $feeData['photo_name'];
						$timeline_photos["feed_height"] = $feeData['feed_img_height'];
						$timeline_photos["feed_width"] = $feeData['feed_img_width'];
						array_push($feed["timeline_photos"], $timeline_photos);

					}

					$qlike = $d->select("timeline_like_master,users_master", "timeline_like_master.timeline_id='$timeline_id' AND timeline_like_master.user_id=users_master.user_id AND timeline_like_master.active_status=0");
					$totalLikes = mysqli_num_rows($qlike);
					$feed["totalLikes"] = "$totalLikes";

					$clike = $d->count_data_direct("like_id", "timeline_like_master", "timeline_id='$timeline_id' AND user_id = '$my_id' AND active_status=0");

					if (mysqli_num_rows($qlike) > 0) {
						$feed["like"] = array();

						while ($data_like = mysqli_fetch_array($qlike)) {

							$like = array();

							$like["like_id"] = $data_like['like_id'];
							$like["timeline_id"] = $data_like['timeline_id'];
							$like["user_id"] = $data_like['user_id'];
							$like["user_name"] = $data_like['user_full_name'];
							$like["modify_date"] = $data_like['modify_date'];
							$like["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_like['user_profile_pic'];

							array_push($feed["like"], $like);
						}
					}

					if ($clike > 0) {
						$feed["like_status"] = "1";
					} else {

						$feed["like_status"] = "0";
					}

					// $qcomment=$d->select("timeline_comments","feed_id='$feed_id'","ORDER BY comments_id DESC");
					$qcomment = $d->select("timeline_comments,users_master", "timeline_comments.timeline_id='$timeline_id' AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id=0", "ORDER BY timeline_comments.comments_id DESC");

					if (mysqli_num_rows($qcomment) > 0) {
						$feed["comment"] = array();

						while ($data_comment = mysqli_fetch_array($qcomment)) {

							$comment = array();

							$comment["comments_id"] = $data_comment['comments_id'];
							$comment["timeline_id"] = $data_comment['timeline_id'];
							$comment["msg"] = $data_comment['msg'];
							$comment["user_name"] = $data_comment['user_full_name'];
							$comment["user_id"] = $data_comment['user_id'];
							$comment["modify_date"] = date("d M Y h:i A", strtotime($data_comment['modify_date']));
							$comment["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_comment['user_profile_pic'];
							if ($user_id == $data_comment['user_id']) {

								$feed["comment_status"] = "1";

							} else {
								$feed["comment_status"] = "0";
							}

							$comment["sub_comment"] = array();
							$q4 = $d->select("timeline_comments,users_master", "timeline_comments.timeline_id='$timeline_id' AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id='$data_comment[comments_id]'", "ORDER BY timeline_comments.comments_id DESC");
							while ($subCommentData = mysqli_fetch_array($q4)) {
								$sub_comment = array();
								$sub_comment["comments_id"] = $subCommentData['comments_id'];
								$sub_comment["timeline_id"] = $subCommentData['timeline_id'];
								$sub_comment["msg"] = html_entity_decode($subCommentData['msg']);
								$sub_comment["user_name"] = $subCommentData['user_full_name'];
								$sub_comment["user_id"] = $subCommentData['user_id'];
								$sub_comment["user_profile_pic"] = $base_url . "img/users/members_profile/" . $subCommentData['user_profile_pic'];
								//$sub_comment["modify_date"] = time_elapsed_string($subCommentData['modify_date']);

				 if(strtotime($subCommentData['modify_date']) < strtotime('-30 days')) {
				   $sub_comment["modify_date"] = date("j M Y", strtotime($subCommentData['modify_date']));
				 } else {
				 	$sub_comment["modify_date"]= time_elapsed_string($subCommentData['modify_date']);
				 }

								array_push($comment["sub_comment"], $sub_comment);
							}
							array_push($feed["comment"], $comment);
						}
					}

					array_push($response["feed"], $feed);
				}

				$q2222 = $d->select("user_notification", "user_id='$user_id' AND  notification_type=1 AND read_status=0");

				$response["unread_notification"] = mysqli_num_rows($q2222);

				$response["total_post"] = $total_post . '';
				$response["followers"] = $followers . '';
				$response["following"] = $following . '';

				$response["follow_status"] = $follow_status;
				$response["totalSocietyFeedLimit"] = 0;

				$response["pos1"] = 0;

				$response["totalSocietyFeedLimit"] = 0;
				$response["pos1"] = 0;

				$response["message"] = "Get Feeds Success.";
				$response["status"] = "200";
				echo json_encode($response);

			} else {
				$response["unread_notification"] = 0;
				$response["total_post"] = $total_post . '';
				$response["followers"] = $followers . '';
				$response["following"] = $following . '';

				$response["follow_status"] = $follow_status;
				$response["totalSocietyFeedLimit"] = 0;

				$response["message"] = "No Timeline Data Available";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} else if ($_POST['getMyFeed'] == "getOtherFeed") {

			$qnotification = $d->select("timeline_master,users_master", "timeline_master.active_status = 0 AND timeline_master.user_id='$user_id' AND users_master.user_id='$user_id'", "ORDER BY timeline_id DESC LIMIT 500");

			$tq11 = $d->selectRow("timeline_id", "timeline_master", "user_id='$user_id'");
			$total_post = mysqli_num_rows($tq11);

			$tq22 = $d->select("users_master,follow_master,user_employment_details,business_categories,business_sub_categories", "business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND follow_master.follow_by=users_master.user_id AND follow_master.follow_to='$user_id'", "ORDER BY users_master.user_full_name ASC");
			// $tq22=$d->selectRow("follow_id","follow_master","follow_by!='$data_app[user_id]'");
			$followers = mysqli_num_rows($tq22);

			$tq33 = $d->select("users_master,follow_master,user_employment_details,business_categories,business_sub_categories", "business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND follow_master.follow_to=users_master.user_id AND follow_master.follow_by='$user_id'", "ORDER BY users_master.user_full_name ASC");
			// $tq33=$d->selectRow("follow_id","follow_master","follow_by='$data_app[user_id]'");
			$following = mysqli_num_rows($tq33);

			$qche = $d->select("follow_master", "follow_by='$my_id' AND follow_to='$user_id'");
			if (mysqli_num_rows($qche) > 0) {
				$follow_status = true;
			} else {
				$follow_status = false;
			}

			if (mysqli_num_rows($qnotification) > 0) {

				$response["feed"] = array();

				while ($data_notification = mysqli_fetch_array($qnotification)) {

					$feed = array();
					$feed["timeline_id"] = $data_notification['timeline_id'];
					$feed["timeline_text"] = $data_notification['timeline_text'];
					$feed["user_name"] = $data_notification['user_full_name'];
					$feed["user_id"] = $data_notification['user_id'];
					$feed["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_notification['user_profile_pic'];
					$timeline_id = $data_notification['timeline_id'];
					$feed["feed_type"] = $data_notification['feed_type'];

					if(strtotime($data_notification['created_date']) < strtotime('-30 days')) {
				     $feed["modify_date"] = date("j M Y", strtotime($data_notification['created_date']));
				 } else {
				 	$feed["modify_date"] = time_elapsed_string($data_notification['created_date']);
				 }
				 

					

					$fi = $d->select("timeline_photos_master", "timeline_id='$timeline_id' AND user_id='$data_notification[user_id]'");

					$feed["timeline_photos"] = array();

					while ($feeData = mysqli_fetch_array($fi)) {
						$timeline_photos = array();
						$timeline_photos["photo_name"] = $base_url . "img/timeline/" . $feeData['photo_name'];
						$timeline_photos["feed_height"] = $feeData['feed_img_height'];
						$timeline_photos["feed_width"] = $feeData['feed_img_width'];
						array_push($feed["timeline_photos"], $timeline_photos);

					}

					$qlike = $d->select("timeline_like_master,users_master", "timeline_like_master.timeline_id='$timeline_id' AND timeline_like_master.user_id=users_master.user_id AND timeline_like_master.active_status=0");
					$totalLikes = mysqli_num_rows($qlike);
					$feed["totalLikes"] = "$totalLikes";

					$clike = $d->count_data_direct("like_id", "timeline_like_master", "timeline_id='$timeline_id' AND user_id = '$user_id' AND active_status=0");

					if (mysqli_num_rows($qlike) > 0) {
						$feed["like"] = array();

						while ($data_like = mysqli_fetch_array($qlike)) {

							$like = array();

							$like["like_id"] = $data_like['like_id'];
							$like["timeline_id"] = $data_like['timeline_id'];
							$like["user_id"] = $data_like['user_id'];
							$like["user_name"] = $data_like['user_full_name'];
							$like["modify_date"] = $data_like['modify_date'];
							$like["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_like['user_profile_pic'];

							array_push($feed["like"], $like);
						}
					}

					if ($clike > 0) {
						$feed["like_status"] = "1";
					} else {

						$feed["like_status"] = "0";
					}

					// $qcomment=$d->select("timeline_comments","feed_id='$feed_id'","ORDER BY comments_id DESC");
					$qcomment = $d->select("timeline_comments,users_master", "timeline_comments.timeline_id='$timeline_id' AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id=0", "ORDER BY timeline_comments.comments_id DESC");

					if (mysqli_num_rows($qcomment) > 0) {
						$feed["comment"] = array();

						while ($data_comment = mysqli_fetch_array($qcomment)) {

							$comment = array();

							$comment["comments_id"] = $data_comment['comments_id'];
							$comment["timeline_id"] = $data_comment['timeline_id'];
							$comment["msg"] = $data_comment['msg'];
							$comment["user_name"] = $data_comment['user_full_name'];
							$comment["user_id"] = $data_comment['user_id'];
							$comment["modify_date"] = date("d M Y h:i A", strtotime($data_comment['modify_date']));
							$comment["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_comment['user_profile_pic'];
							if ($user_id == $data_comment['user_id']) {

								$feed["comment_status"] = "1";

							} else {
								$feed["comment_status"] = "0";
							}

							$comment["sub_comment"] = array();
							$q4 = $d->select("timeline_comments,users_master", "timeline_comments.timeline_id='$timeline_id' AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id='$data_comment[comments_id]'", "ORDER BY timeline_comments.comments_id DESC");
							while ($subCommentData = mysqli_fetch_array($q4)) {
								$sub_comment = array();
								$sub_comment["comments_id"] = $subCommentData['comments_id'];
								$sub_comment["timeline_id"] = $subCommentData['timeline_id'];
								$sub_comment["msg"] = html_entity_decode($subCommentData['msg']);
								$sub_comment["user_name"] = $subCommentData['user_full_name'];
								$sub_comment["user_id"] = $subCommentData['user_id'];
								$sub_comment["user_profile_pic"] = $base_url . "img/users/members_profile/" . $subCommentData['user_profile_pic'];
								//$sub_comment["modify_date"] = time_elapsed_string($subCommentData['modify_date']);

								if(strtotime($subCommentData['modify_date']) < strtotime('-30 days')) {
								     $sub_comment["modify_date"] = date("j M Y", strtotime($subCommentData['modify_date']));
								 } else {
								 	$sub_comment["modify_date"] = time_elapsed_string($subCommentData['modify_date']);
								 }

								array_push($comment["sub_comment"], $sub_comment);
							}
							array_push($feed["comment"], $comment);
						}
					}

					array_push($response["feed"], $feed);
				}

				$response["total_post"] = $total_post . '';
				$response["followers"] = $followers . '';
				$response["following"] = $following . '';

				$response["follow_status"] = $follow_status;
				$response["totalSocietyFeedLimit"] = 0;

				$response["pos1"] = 0;

				$response["totalSocietyFeedLimit"] = 0;
				$response["pos1"] = 0;

				$response["message"] = "Get Feeds Success.";
				$response["status"] = "200";
				echo json_encode($response);

			} else {
				$response["total_post"] = $total_post . '';
				$response["followers"] = $followers . '';
				$response["following"] = $following . '';

				$response["follow_status"] = $follow_status;
				$response["totalSocietyFeedLimit"] = 0;

				$response["message"] = "No Timeline Data Available";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} else if ($_POST['addFeed'] == "editFeed" && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($timeline_id, FILTER_VALIDATE_INT) == true) {

			$m->set_data('timeline_text', $timeline_text);

			$a1 = array(
				'timeline_text' => $m->get_data('timeline_text'),
			);

			$d->update("timeline_master", $a1, "timeline_id='$timeline_id'");

			if ($d == TRUE) {

				$response["message"] = "Updated successfully";
				$response["status"] = "200";
				echo json_encode($response);

			} else {

				$response["message"] = "Something Wrong";
				$response["status"] = "201";
				echo json_encode($response);

			}

		} else if ($_POST['getNotificationFeed'] == "getNotificationFeed" && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($timeline_id, FILTER_VALIDATE_INT) == true) {


$qnotification = $d->select("timeline_master", "active_status = 0 and timeline_id='$timeline_id' ", " ");


			 

// /timeline_master.user_id=users_master.user_id
			/*$qnotification=$d->select("user_employment_details,news_feed,users_master"," user_employment_details.unit_id = users_master.unit_id and   news_feed.society_id='$society_id' AND news_feed.status = 0 AND 
                    ( news_feed.user_id='$user_id' OR news_feed.user_id=0  ) AND users_master.user_id='$user_id'  AND news_feed.feed_id='$feed_id'","ORDER BY feed_id DESC LIMIT 100");*/

			// /	 AND timeline_master.user_id=users_master.user_id 

			if (mysqli_num_rows($qnotification) > 0) {

				$response["feed"] = array();

				while ($data_notification = mysqli_fetch_array($qnotification)) {
					$feed = array();

//23oct2020					
if($data_notification['user_id'] !="0"){
	$uid=$data_notification['user_id']; 
	$userDataQry = $d->select("users_master,user_employment_details", "
user_employment_details.user_id=users_master.user_id and 
users_master.user_id = '$uid' ", "");

	 $userData = mysqli_fetch_array($userDataQry);
        $userProfile = $base_url . "img/users/recident_profile/" . $userData['user_profile_pic'];
        $user_full_name = $userData['user_first_name'].' '.$userData['user_last_name'];
        $company = $userData['company_name'];

        $feed["user_name"] = $userData['user_full_name'];
		$feed["company_name"] = html_entity_decode($userData['company_name']);
		$feed["user_id"] = $userData['user_id'];
		$feed["user_profile_pic"] = $base_url . "img/users/members_profile/" . $userData['user_profile_pic'];
} else {
	$feed["user_profile_pic"] = $base_url . "img/fav.png";
   $feed["user_id"] = 0;                     
    $feed["user_name"] ='Admin';
   $feed["company_name"] = 'ZooBiz';
}
//23oct2020


					
					$feed["timeline_id"] = $data_notification['timeline_id'];
					$feed["timeline_text"] = $data_notification['timeline_text'];
					
					$timeline_id = $data_notification['timeline_id'];

					$feed["feed_type"] = $data_notification['feed_type'];
					$feed["modify_date"] = time_elapsed_string($data_notification['created_date']);

					$fi = $d->select("timeline_photos_master", "timeline_id='$timeline_id' AND user_id='$data_notification[user_id]'");
					$feed["timeline_photos"] = array();

					while ($feeData = mysqli_fetch_array($fi)) {
						$timeline_photos = array();
						$timeline_photos["photo_name"] = $base_url . "img/timeline/" . $feeData['photo_name'];
						$timeline_photos["feed_height"] = $feeData['feed_img_height'];
						$timeline_photos["feed_width"] = $feeData['feed_img_width'];
						array_push($feed["timeline_photos"], $timeline_photos);

					}

					$qlike = $d->select("timeline_like_master,users_master", "timeline_like_master.timeline_id='$timeline_id' AND timeline_like_master.user_id=users_master.user_id");
					$totalLikes = mysqli_num_rows($qlike);
					$feed["totalLikes"] = "$totalLikes";

					$clike = $d->count_data_direct("like_id", "timeline_like_master", "timeline_id='$timeline_id' AND user_id = '$user_id' AND active_status=0");

					if (mysqli_num_rows($qlike) > 0) {
						$feed["like"] = array();

						while ($data_like = mysqli_fetch_array($qlike)) {

							$like = array();

							$like["like_id"] = $data_like['like_id'];
							$like["timeline_id"] = $data_like['timeline_id'];
							$like["user_id"] = $data_like['user_id'];
							$like["user_name"] = $data_like['user_full_name'];
							$like["modify_date"] = $data_like['modify_date'];
							$like["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_like['user_profile_pic'];

							array_push($feed["like"], $like);
						}
					}

					if ($clike > 0) {
						$feed["like_status"] = "1";
					} else {

						$feed["like_status"] = "0";
					}

					// $qcomment=$d->select("timeline_comments","feed_id='$feed_id'","ORDER BY comments_id DESC");
					$qcomment = $d->select("timeline_comments,users_master", "timeline_comments.timeline_id='$timeline_id' AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id=0", "ORDER BY timeline_comments.comments_id DESC");

					if (mysqli_num_rows($qcomment) > 0) {
						$feed["comment"] = array();

						while ($data_comment = mysqli_fetch_array($qcomment)) {

							$comment = array();

							$comment["comments_id"] = $data_comment['comments_id'];
							$comment["timeline_id"] = $data_comment['timeline_id'];
							$comment["msg"] = $data_comment['msg'];
							$comment["user_name"] = $data_comment['user_full_name'];
							$comment["user_id"] = $data_comment['user_id'];
							$comment["modify_date"] = date("d M Y h:i A", strtotime($data_comment['modify_date']));
							$comment["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_comment['user_profile_pic'];
							if ($user_id == $data_comment['user_id']) {

								$feed["comment_status"] = "1";

							} else {
								$feed["comment_status"] = "0";
							}

							$comment["sub_comment"] = array();
							$q4 = $d->select("timeline_comments,users_master", "timeline_comments.timeline_id='$timeline_id' AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id='$data_comment[comments_id]'", "ORDER BY timeline_comments.comments_id DESC");
							while ($subCommentData = mysqli_fetch_array($q4)) {
								$sub_comment = array();
								$sub_comment["comments_id"] = $subCommentData['comments_id'];
								$sub_comment["timeline_id"] = $subCommentData['timeline_id'];
								$sub_comment["msg"] = html_entity_decode($subCommentData['msg']);
								$sub_comment["user_name"] = $subCommentData['user_full_name'];
								$sub_comment["user_id"] = $subCommentData['user_id'];
								$sub_comment["user_profile_pic"] = $base_url . "img/users/members_profile/" . $subCommentData['user_profile_pic'];
								$sub_comment["modify_date"] = time_elapsed_string($subCommentData['modify_date']);

								array_push($comment["sub_comment"], $sub_comment);
							}
							array_push($feed["comment"], $comment);
						}
					}

					$response["totalSocietyFeedLimit"] = 0;

					array_push($response["feed"], $feed);
				}

				$response["message"] = "Get Feeds Success.";
				$response["status"] = "200";
				echo json_encode($response);

			} else {
				$response["totalSocietyFeedLimit"] = 0;
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

}?>