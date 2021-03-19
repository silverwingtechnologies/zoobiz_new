<?php
include_once 'lib.php';

/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/

if (isset($_POST) && !empty($_POST)) {

    if ($key == $keydb) {
        
    $response = array();
    extract(array_map("test_input" , $_POST));

        if ($_POST['addFollow'] == "addFollow" && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($follow_to, FILTER_VALIDATE_INT) == true) {

            if ($user_id==$follow_to) {
              $response["message"] = "You can't follow yourself";
              $response["status"] = "201";
              echo json_encode($response);
              exit();
            }

            $qche=$d->select("follow_master","follow_by='$user_id' AND follow_to='$follow_to'");
            if (mysqli_num_rows($qche)>0) {
                $response["message"] = "Already Follow By You";
                $response["status"] = "201";
                echo json_encode($response);
                exit();
            } else {

                $m->set_data('follow_by', $user_id);
                $m->set_data('follow_to', $follow_to);
                $a = array(
                    'follow_by' => $m->get_data('follow_by'), 
                    'follow_to' => $m->get_data('follow_to'),
                );

                $d->insert("follow_master",$a);

                $quc=$d->select("users_master","user_id='$follow_to'");
                $userData=mysqli_fetch_array($quc);
                $sos_user_token=$userData['user_token'];
                $device=$userData['device'];
                $feed_user_id=$userData['user_id'];
                $title= "$user_name";
                $msg= "Followed You";

                 $notiAry = array(
                  'user_id'=>$follow_to,
                  'notification_title'=>$title,
                  'notification_desc'=>$msg,    
                  'notification_date'=>date('Y-m-d H:i'),
                  'notification_action'=>'profile',
                  'notification_logo'=>'profile.png',
                  'notification_type'=>'0',
                  'other_user_id'=>$user_id,
                  'timeline_id'=>'',
                  );
                  $d->insert("user_notification",$notiAry);


                if ($device=='android') {
                   $nResident->noti("","",0,$sos_user_token,$title,$msg,'profile');
                }  else if($device=='ios') {
                  $nResident->noti_ios("","",0,$sos_user_token,$title,$msg,'profile');
                }

                $response["message"] = "Following Successfully";
                $response["status"] = "200";
                echo json_encode($response);
                exit();

            }

        }else if ($_POST['unFollow'] == "unFollow" && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($follow_to, FILTER_VALIDATE_INT) == true) {

                $d->delete("follow_master","follow_by='$user_id' AND follow_to='$follow_to'");

                 $quc=$d->select("users_master","user_id='$follow_to'");
                $userData=mysqli_fetch_array($quc);
                $sos_user_token=$userData['user_token'];
                $device=$userData['device'];
                $feed_user_id=$userData['user_id'];
                $title= "$user_name";
                $msg= "Un Followed You";

                //  $notiAry = array(
                //   'user_id'=>$follow_to,
                //   'notification_title'=>$title,
                //   'notification_desc'=>$msg,    
                //   'notification_date'=>date('Y-m-d H:i'),
                //   'notification_action'=>'profile',
                //   'notification_logo'=>'profile.png',
                //   'notification_type'=>'1',
                //   'other_user_id'=>$user_id,
                //   'timeline_id'=>'',
                //   );
                //   $d->insert("user_notification",$notiAry);


                // if ($device=='android') {
                //    $nResident->noti("","",0,$sos_user_token,$title,$msg,'profile');
                // }  else if($device=='ios') {
                //   $nResident->noti_ios("","",0,$sos_user_token,$title,$msg,'profile');
                // }


                $response["message"] = "Un Follow Successfully";
                $response["status"] = "200";
                echo json_encode($response);
                exit();


          
        }else if ($_POST['getFollowDetails'] == "getFollowDetails" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {
               

               $app_data=$d->select("users_master,follow_master,user_employment_details,business_categories,business_sub_categories","business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND follow_master.follow_by=users_master.user_id AND follow_master.follow_to='$user_id'","ORDER BY users_master.user_full_name ASC");

                if(mysqli_num_rows($app_data)>0){

                    $response["followers"] = array();


                    while($data_app=mysqli_fetch_array($app_data)) {
                     

                        $qche=$d->select("follow_master","follow_by='$user_id' AND follow_to='$data_app[user_id]'");
                        if (mysqli_num_rows($qche)>0) {
                            $follow_status= true;
                        } else {
                            $follow_status= false;
                        }

                      $followers=array();
                      $followers["user_id"]=$data_app["user_id"];
                      $followers["user_full_name"]=$data_app["user_full_name"];
                      $followers["user_profile_pic"]=$base_url."img/users/members_profile/".$data_app['user_profile_pic'];
                      $followers["follow_status"]=$follow_status;
                      $followers["bussiness_category_name"]=html_entity_decode($data_app["category_name"]);
                      $followers["sub_category_name"]=html_entity_decode($data_app["sub_category_name"]).'';
                      $followers["company_name"]=html_entity_decode($data_app["company_name"]).'';
                      
                      array_push($response["followers"], $followers); 
                    }
                  $temp=true;
                }else{
                    $temp=false;
                }

                $app_data=$d->select("users_master,follow_master,user_employment_details,business_categories,business_sub_categories","business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND follow_master.follow_to=users_master.user_id AND follow_master.follow_by='$user_id'","ORDER BY users_master.user_full_name ASC");

                if(mysqli_num_rows($app_data)>0){

                    $response["following"] = array();


                    while($data_app=mysqli_fetch_array($app_data)) {
                     
                        

                        $qche=$d->select("follow_master","follow_by='$user_id' AND follow_to='$data_app[user_id]'");
                        if (mysqli_num_rows($qche)>0) {
                            $follow_status= true;
                        } else {
                            $follow_status= false;
                        }

                      $following=array();
                      $following["user_id"]=$data_app["user_id"];
                      $following["user_full_name"]=$data_app["user_full_name"];
                      $following["user_profile_pic"]=$base_url."img/users/members_profile/".$data_app['user_profile_pic'];
                      $following["follow_status"]=$follow_status;
                      $following["bussiness_category_name"]=html_entity_decode($data_app["category_name"]);
                      $following["sub_category_name"]=html_entity_decode($data_app["sub_category_name"]).'';
                      $following["company_name"]=html_entity_decode($data_app["company_name"]).'';
                      
                      array_push($response["following"], $following); 
                    }
                  $timp1=true;
                }else{
                    $timp1=false;
                }

                if ($temp==true || $timp1==true) {
                  $response["message"]="Get Success.";
                  $response["status"]="200";
                  echo json_encode($response);
                } else {
                  $response["message"]="No Data Found";
                  $response["status"]="201";
                  echo json_encode($response); 
                }

        }else {
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
 