<?php
include_once 'lib.php';


/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/


if(isset($_POST) && !empty($_POST)){
  
    if ($key==$keydb) {
  
    $response = array();
    extract(array_map("test_input" , $_POST));
        
            if($_POST['getBusinessHouses']=="getBusinessHouses"){

                
                $app_data=$d->select("users_master,business_houses,user_employment_details,business_categories,business_sub_categories","   business_categories.category_status = 0 and business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND business_houses.user_id= users_master.user_id ","ORDER BY business_houses.order_id ASC");

                if(mysqli_num_rows($app_data)>0){

                    $response["member"] = array();


                    while($data_app=mysqli_fetch_array($app_data)) {
                        $tq11=$d->selectRow("timeline_id","timeline_master","user_id='$data_app[user_id]'");
                        $total_post= mysqli_num_rows($tq11);

                        $tq22=$d->select("users_master,follow_master,user_employment_details,business_categories,business_sub_categories","   business_categories.category_status = 0 and business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND follow_master.follow_by=users_master.user_id AND follow_master.follow_to='$data_app[user_id]'","ORDER BY users_master.user_full_name ASC");
                        // $tq22=$d->selectRow("follow_id","follow_master","follow_by!='$data_app[user_id]'");
                        $followers= mysqli_num_rows($tq22);

                        $tq33=$d->select("users_master,follow_master,user_employment_details,business_categories,business_sub_categories","   business_categories.category_status = 0 and business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND follow_master.follow_to=users_master.user_id AND follow_master.follow_by='$data_app[user_id]'","ORDER BY users_master.user_full_name ASC");
                        // $tq33=$d->selectRow("follow_id","follow_master","follow_by='$data_app[user_id]'");
                        $following= mysqli_num_rows($tq33);


                        $qche=$d->select("follow_master","follow_by='$user_id' AND follow_to='$data_app[user_id]'");
                        if (mysqli_num_rows($qche)>0) {
                            $follow_status= true;
                        } else {
                            $follow_status= false;
                        }

                    	$member=array();
                    	$member["user_id"]=$data_app["user_id"];
						$member["user_full_name"]=$data_app["salutation"].' '.$data_app["user_full_name"];
                        $member["user_profile_pic"]=$base_url."img/users/members_profile/".$data_app['user_profile_pic'];
                        $member["total_post"]=$total_post.'';
                        $member["followers"]=$followers.'';
                        $member["following"]=$following.'';
                    	$member["follow_status"]=$follow_status;
                        $member["bussiness_category_name"]=html_entity_decode($data_app["category_name"]);
                        $member["sub_category_name"]=html_entity_decode($data_app["sub_category_name"]).'';
                        $member["company_name"]=html_entity_decode($data_app["company_name"]).'';
                    	
                    	array_push($response["member"], $member); 
                    }

                     $response["message"]="Get Success.";
                     $response["status"]="200";
                     echo json_encode($response);
                }else{
                	 $response["message"]="No Data Found";
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