<?php
include_once 'lib.php';

if(isset($_POST) && !empty($_POST)){


    if ($key==$keydb) {
        
    $response = array();
    extract(array_map("test_input" , $_POST));
            if($_POST['getCirculars']=="getCirculars" ){

               
               
                $nqBlock=$d->select("circulars_master","" ,"ORDER BY circular_id DESC LIMIT 500");

                if(mysqli_num_rows($nqBlock)>0){
                $response["circular"] = array();

                    while($data=mysqli_fetch_array($nqBlock)) {

                            $circular = array(); 

                            $circular["circular_id"]=$data['circular_id'];
                            $circular["circular_title"]=$data['circular_title'];
                            $circular["circular_description"]=$data['circular_description'];
                             $circular["notice_time"]=date('d M Y h:i A',strtotime($data['created_date']));
                            // if ($data['circular_attachment']!='') {
                            //     $circular["circular_attachment"]=$base_url.'img/circul/'.$data['circular_attachment'];
                            // }else {
                            //     $circular["circular_attachment"]="";

                            // }
                            
                            array_push($response["circular"], $circular);
                    }
                   
                    $response["message"]="Get circular Success.";
                    $response["status"]="200";
                    echo json_encode($response);
                }else{
                    $response["message"]="No Data Found.";
                    $response["status"]="201";
                    echo json_encode($response);
                }


            }else{
                $response["message"]="wrong tag.";
                $response["status"]="201";
                echo json_encode($response);

            }

        

    }else{

         $response["message"]="wrong api key.";
        $response["status"]="201";
        echo json_encode($response);

    }

}?>