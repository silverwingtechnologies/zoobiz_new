<?php
include_once 'lib.php';

if(isset($_POST) && !empty($_POST)){

    if ($key==$keydb) {
	$response = array();
	extract(array_map("test_input" , $_POST));
  $today  = date("Y-m-d");
    if($_POST['getLanguage']=="getLanguage" ){

           
        $q=$d->select("language_master","active_status=0","ORDER BY language_id ASC");
         
        if(mysqli_num_rows($q)>0){

            $response["language"] = array();

            while($data=mysqli_fetch_array($q)) {
                     $language = array(); 
                     $language["language_id"]=$data['language_id'];
                     $language["language_name"]=$data['language_name'];
                     $language["language_name_1"]=$data['language_name_1'];
                     $language["language_file"]=$data['language_file'];
                     $language["continue_btn_name"]=$data['continue_btn_name'];
                     $language["language_icon"]=$base_url.'img/language/'.$data['language_file'];
                     array_push($response["language"], $language);
            }
           
             $response["message"]="Get Language Successfully!";
             $response["status"]="200";
             echo json_encode($response);

        }else{
            $response["message"]="No Language Availble.";
            $response["status"]="201";
            echo json_encode($response);

        }
    }else if($_POST['getLanguageValues']=="getLanguageValues"  && filter_var($language_id, FILTER_VALIDATE_INT) == true){

         $q = $d->select("language_key_master","");
         while ($data=mysqli_fetch_array($q)) {
             $language_key_id =$data['language_key_id'];
             $valuArray=array();
                $qc=$d->select("language_key_value_master","language_id='$language_id' AND language_key_id='$language_key_id'");
                while($oldData=mysqli_fetch_array($qc)){
                  array_push($valuArray,  $oldData['value_name']);
                  array_push($key_value_idArray,  $oldData['key_value_id']);
                }

             if ($data['key_type']==0) {
              $response[$data['key_name']]=$valuArray[0].'';
             } else {
              $response[$data['key_name']]=$valuArray;
             }

         }
               echo json_encode($response);


    }else if($_POST['getLanguageGatekeeper']=="getLanguageGatekeeper" ){

           
        $q=$d->select("language_master","active_status=0","ORDER BY language_id ASC");
         
        if(mysqli_num_rows($q)>0){

            $response["language"] = array();

            while($data=mysqli_fetch_array($q)) {
                     switch ($data['language_id']) {
                         case '1':
                             $language_file= 'EnglishStringGatekeeper.json';
                             break;
                        case '2':
                             $language_file= 'HindiStringGatekeeper.json';
                             break;
                        case '3':
                             $language_file= 'GujaratiStringGatekeeper.json';
                             break;
                        case '4':
                             $language_file= 'HingilishStringGatekeeper.json';
                             break;
                         default:
                             $language_file= 'EnglishStringGatekeeper.json';
                             break;
                     }
                     $language = array(); 
                     $language["language_id"]=$data['language_id'];
                     $language["language_name"]=$data['language_name'];
                     $language["language_name_1"]=$data['language_name_1'];
                     $language["language_file"]=$base_url.'commonApi/'.$language_file;
                     $language["continue_btn_name"]=$data['continue_btn_name'];
                     $language["language_icon"]=$base_url.'img/language/'.$data['language_file'];
                     array_push($response["language"], $language);
            }
           
             $response["message"]="Get Language Successfully!";
             $response["status"]="200";
             echo json_encode($response);

        }else{
            $response["message"]="No Language Availble.";
            $response["status"]="201";
            echo json_encode($response);

        }
    } else if($_POST['getLanguageValuesGatekeeper']=="getLanguageValuesGatekeeper"  && filter_var($language_id, FILTER_VALIDATE_INT) == true){

         $q = $d->select("language_key_master_gatekeeper","");
         while ($data=mysqli_fetch_array($q)) {
             $language_key_id =$data['language_key_id'];
             $valuArray=array();
                $qc=$d->select("language_key_value_master_gatekeeper","language_id='$language_id' AND language_key_id='$language_key_id'");
                while($oldData=mysqli_fetch_array($qc)){
                  array_push($valuArray,  $oldData['value_name']);
                  array_push($key_value_idArray,  $oldData['key_value_id']);
                }

             if ($data['key_type']==0) {
              $response[$data['key_name']]=$valuArray[0].'';
             } else {
              $response[$data['key_name']]=$valuArray;
             }

         }
               echo json_encode($response);


    }else{
      $response["message"]="wrong tag";
      $response["status"]="201";
      echo json_encode($response);
    }
  }
    else{
        $response["message"]="wrong api key";
        $response["status"]="201";
        echo json_encode($response);

    }
}
