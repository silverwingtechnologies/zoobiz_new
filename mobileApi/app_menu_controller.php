<?php
include_once 'lib.php';


/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/


if(isset($_POST) && !empty($_POST)){
  
    if ($key==$keydb) {
  
    $response = array();
    extract(array_map("test_input" , $_POST));
        
            if($_POST['getAppMenu']=="getAppMenu"){

              
                if ($device=='android') {
                    $app_data=$d->select("resident_app_menu","menu_status='0' AND menu_status_android='0' AND parent_menu_id=0","ORDER BY menu_sequence ASC");
                }else  if ($device=='ios') {
                    $app_data=$d->select("resident_app_menu","menu_status='0' AND menu_status_ios='0' AND parent_menu_id=0","ORDER BY menu_sequence ASC");
                }else {
                    $app_data=$d->select("resident_app_menu","menu_status='0'  AND parent_menu_id=0","ORDER BY menu_sequence ASC");

                }

                if(mysqli_num_rows($app_data)>0){

                    $response["appmenu"] = array();


                    while($data_app=mysqli_fetch_array($app_data)) {

                    	$appmenu=array();
                    	$appmenu["app_menu_id"]=$data_app["app_menu_id"];
						$appmenu["menu_title"]=$data_app["menu_title"];
                        $appmenu["menu_click"]=$data_app["menu_click"];
                        $appmenu["ios_menu_click"]=$data_app["ios_menu_click"];
                    	$appmenu["menu_icon"]=$base_url."img/app_icon/".$data_app["menu_icon"];
                        $appmenu["menu_icon_ios"]=$base_url."img/app_icon/".$data_app["menu_icon_ios"];
                        $appmenu["menu_sequence"]=$data_app["menu_sequence"];
                        $appmenu["tutorial_video"]=$data_app["tutorial_video"].'';
                    	if ($data_app["is_new"]==1) {
                          $appmenu["is_new"]=true;
                        } else {
                            $appmenu["is_new"]=false;
                        }

                        $appmenu["appmenu_sub"] = array();
                        if ($device=='android') {
                            $qs=$d->select("resident_app_menu","menu_status='0' AND menu_status_android='0' AND parent_menu_id='$data_app[app_menu_id]'");
                        }else  if ($device=='ios') {
                            $qs=$d->select("resident_app_menu","menu_status='0' AND menu_status_ios='0' AND parent_menu_id='$data_app[app_menu_id]'");
                        }else {
                            $qs=$d->select("resident_app_menu","menu_status='0' AND parent_menu_id='$data_app[app_menu_id]'");

                        }

                        while ($subData=mysqli_fetch_array($qs)) {
                            $appmenu_sub = array();
                            $appmenu_sub["app_menu_id"]=$subData["app_menu_id"];
                            $appmenu_sub["menu_title"]=$subData["menu_title"];
                            $appmenu_sub["menu_click"]=$subData["menu_click"];
                            $appmenu_sub["ios_menu_click"]=$subData["ios_menu_click"];
                            $appmenu_sub["menu_icon"]=$base_url."img/app_icon/".$subData["menu_icon"];
                             $appmenu_sub["menu_icon_ios"]=$base_url."img/app_icon/".$appmenu_sub["menu_icon_ios"];
                            $appmenu_sub["menu_sequence"]=$subData["menu_sequence"];
                            $appmenu_sub["tutorial_video"]=$subData["tutorial_video"].'';
                            if ($subData["is_new"]==1) {
                              $appmenu_sub["is_new"]=true;
                            } else {
                                $appmenu_sub["is_new"]=false;
                            }

                            array_push($appmenu["appmenu_sub"], $appmenu_sub); 

                        }

                    	array_push($response["appmenu"], $appmenu); 
                    }

                     $response["message"]="success.";
                     $response["status"]="200";
                     echo json_encode($response);
                }else{
                	 $response["message"]="faild.";
                     $response["status"]="201";
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