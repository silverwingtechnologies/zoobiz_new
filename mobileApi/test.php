<?php
include_once 'lib.php';


                    $app_data=$d->select("business_sub_categories","","");


                if(mysqli_num_rows($app_data)>0){

                    $response["appmenu"] = array();


                    while($data_app=mysqli_fetch_array($app_data)) {

                        $business_sub_category_id= $data_app['business_sub_category_id'];
                    	$category_industry= $data_app['category_industry'];

                        $qqq=$d->select("business_categories","category_name='$category_industry'");
                        $mainData=mysqli_fetch_array($qqq);
                        $business_category_id = $mainData['business_category_id'];

                        $a = array(
                        'business_category_id' => $business_category_id,
                        );

                        $d->update("business_sub_categories",$a,"business_sub_category_id='$business_sub_category_id'");



                    }

                     $response["message"]="success.";
                     $response["status"]="200";
                     echo json_encode($response);
                }
?>