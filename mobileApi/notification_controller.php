<?php
include_once 'lib.php';


/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/


if(isset($_POST) && !empty($_POST)){
  
    if ($key==$keydb) {

    $response = array();
    extract(array_map("test_input" , $_POST));
        
            if($_POST['getNotification']=="getNotification"){

              //23oct2020
              //$app_data=$d->select("user_notification","user_id='0' OR user_id='$user_id' AND notification_type=0","ORDER BY user_notification_id DESC");
           $app_data=$d->select("user_notification"," user_id='$user_id'  AND (notification_type=0 or notification_type=2  or notification_type=3 or notification_type=4 or notification_type=5 )     ","ORDER BY user_notification_id DESC");
                if(mysqli_num_rows($app_data)>0){

                    $response["notification"] = array();


                    while($data_app=mysqli_fetch_array($app_data)) {

                    	$notification=array();
                    	$notification["user_notification_id"]=$data_app["user_notification_id"];
						$notification["user_id"]=$data_app["user_id"];
                        $notification["notification_title"]=$data_app["notification_title"];
                        $notification["notification_desc"]=$data_app["notification_desc"];

                        if($data_app["other_user_id"] !=0){
                            $other_user_id = $data_app["other_user_id"];
                            $users_master_fo = $d->select("users_master", " user_id='$other_user_id'");
                            $users_master_fo_data=mysqli_fetch_array($users_master_fo);
                             $notification["notification_logo"]=$base_url . "img/users/members_profile/" . $users_master_fo_data['user_profile_pic'];

                        }  else {
                            $notification["notification_logo"]=$base_url."img/app_icon/".$data_app["notification_logo"];
                        }
                    	
                        $notification["notification_date"]=date("d M Y h:i A", strtotime($data_app['notification_date']));
                        $notification["notification_status"]=$data_app["notification_status"];
                        $notification["notification_type"]=$data_app["notification_type"];
                        $notification["other_user_id"]=$data_app["other_user_id"];
                        $notification["timeline_id"]=$data_app["timeline_id"];
                        $notification["notification_action"]=$data_app["notification_action"];






                        //23oct2020
 if ( $data_app['notification_action']=="custom_notification") {
                            

                            if($data_app["notification_type"]==5){

                                if($data_app["notification_logo"]=="logo.png" || $data_app["notification_logo"]=="ic_business_card.png"){
                            
                             $notification["notification_img_url"] =$base_url.'img/app_icon/ic_business_card.png';
                                      $notification["notification_logo"] = $base_url.'img/app_icon/ic_business_card.png' ;
                                }   else{
                                     $notification["notification_img_url"] =$base_url.'img/deals/'.$data_app["notification_logo"];
                                      $notification["notification_logo"] = $base_url.'img/deals/'.$data_app["notification_logo"];
                                }
                                     
                                  
                            }else{
                              $notification["notification_img_url"] =$base_url.'img/logo.png';
                              $notification["notification_logo"] = $base_url.'img/logo.png';
                            }
                             
                            $notification["notification_title"] = $data_app['notification_title'];
                            $notification["notification_desc"] = $data_app['notification_desc'];
 
                        } else {
                            if($data_app['notification_action']=='circulars'){
                                $notification["notification_img_url"] =$base_url.'img/ic_circulars.png';
                            } else if($data_app['notification_action']=='classified'){
                                $notification["notification_img_url"] =$base_url.'img/ic_fourm.png';
                            } else {
                                $notification["notification_img_url"] =$base_url.'img/logo.png';
                            }
                            
                        }

 //4nov 2020
  if($data_app["notification_type"] ==4){
   $notification["notification_logo"]=$base_url . "img/app_icon/ic_fourm.png";
   $notification["notification_img_url"] =$base_url.'img/app_icon/ic_fourm.png';
  }
//4nov 2020


                        //23oct2020
                    	array_push($response["notification"], $notification); 
                    }


                    $m->set_data('read_status', '1');

                    $arrayName = array('read_status' => $m->get_data('read_status'));

                    $q2 = $d->update("user_notification", $arrayName, "user_id='$user_id'  ");
                    

                     $response["message"]="success.";
                     $response["status"]="200";
                     echo json_encode($response);
                }else{
                	 $response["message"]="faild.";
                     $response["status"]="201";
                     echo json_encode($response); 
                }

    }else if($_POST['getNotificationTimeline']=="getNotificationTimeline"){

              
                   $app_data=$d->select("user_notification","user_id='$user_id' AND notification_type=1","ORDER BY user_notification_id DESC");
           
                if(mysqli_num_rows($app_data)>0){

                    $response["notification"] = array();


                    while($data_app=mysqli_fetch_array($app_data)) {

                        $qcd=$d->selectRow("user_profile_pic","users_master","user_id='$data_app[other_user_id]'");
                        $userData=mysqli_fetch_array($qcd);

                        $notification=array();
                        $notification["user_notification_id"]=$data_app["user_notification_id"];
                        $notification["user_id"]=$data_app["user_id"];
                        $notification["notification_title"]=$data_app["notification_title"];
                        $notification["notification_desc"]=$data_app["notification_desc"];
                        $notification["notification_logo"]=$base_url."img/users/members_profile/".$userData["user_profile_pic"];
                        $notification["notification_date"]=time_elapsed_string($data_app['notification_date']);
                        $notification["notification_status"]=$data_app["notification_status"];
                        $notification["notification_type"]=$data_app["notification_type"];
                        $notification["other_user_id"]=$data_app["other_user_id"];
                        $notification["timeline_id"]=$data_app["timeline_id"];
                        $notification["notification_action"]="";

                        array_push($response["notification"], $notification); 
                    }

                    $m->set_data('read_status', '1');

                    $arrayName = array('read_status' => $m->get_data('read_status'));

                    $q2 = $d->update("user_notification", $arrayName, "user_id='$user_id'  ");


                     $response["message"]="success.";
                     $response["status"]="200";
                     echo json_encode($response);
                }else{
                     $response["message"]="faild.";
                     $response["status"]="201";
                     echo json_encode($response); 
                }

    }else if ($_POST['DeleteUserNotification'] == "DeleteUserNotification" && $user_notification_id != '' && filter_var($user_notification_id, FILTER_VALIDATE_INT) == true) {


            $qdelete = $d->delete("user_notification", "user_notification_id='$user_notification_id' AND user_id!=0");


            if ($qdelete == TRUE) {

                $response["message"] = "Delete Notification success.";
                $response["status"] = "200";
                echo json_encode($response);
            } else {

                $response["message"] = "Delete Notification Fail.";
                $response["status"] = "201";
                echo json_encode($response);
            }
    }else if ($_POST['DeleteUserNotificationAll'] == "DeleteUserNotificationAll" && $user_id != '' && filter_var($user_id, FILTER_VALIDATE_INT) == true) {


            $qdelete = $d->delete("user_notification", "user_id='$user_id' AND user_id!=0  ");


            if ($qdelete == TRUE) {


                $response["message"] = "Notifications Deleted";
                $response["status"] = "200";
                echo json_encode($response);
            } else {

                $response["message"] = "Delete Notification Fail.";
                $response["status"] = "201";
                echo json_encode($response);
            }
        } else if ($_POST['DeleteUserNotificationAllTimeline'] == "DeleteUserNotificationAllTimeline" && $user_id != '' && filter_var($user_id, FILTER_VALIDATE_INT) == true) {


            $qdelete = $d->delete("user_notification", "user_id='$user_id' AND user_id!=0  ");


            if ($qdelete == TRUE) {


                $response["message"] = "Notifications Deleted";
                $response["status"] = "200";
                echo json_encode($response);
            } else {

                $response["message"] = "Delete Notification Fail.";
                $response["status"] = "201";
                echo json_encode($response);
            }
        }else {
                $response["message"]="wrong tag.";
                $response["status"]="201";
                echo json_encode($response);                  
            }
    }else{

         $response["message"]="wrong api key.";
        $response["status"]="201";
        echo json_encode($response);
    }
}
?>