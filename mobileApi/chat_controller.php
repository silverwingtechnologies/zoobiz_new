<?php
include_once 'lib.php';

if(isset($_POST) && !empty($_POST)){

    $response = array();
    extract(array_map("test_input" , $_POST));

    
    if ($key==$keydb) {
    

        if (isset($getMemberList) && $getMemberList=='getMemberList' && filter_var($user_id, FILTER_VALIDATE_INT) == true) { 
 
   //30 OCT      
 $q3=$d->select("users_master,user_employment_details,business_categories","
             business_categories.category_status = 0 and business_categories.business_category_id = user_employment_details.business_category_id and   user_employment_details.user_id=users_master.user_id AND users_master.user_id!='$user_id'","ORDER BY users_master.user_first_name ASC");
      /*  $q3=$d->select("users_master,user_employment_details","user_employment_details.user_id=users_master.user_id AND users_master.user_id!='$user_id'","ORDER BY users_master.user_first_name ASC");*/

         if (mysqli_num_rows($q3)>0) {
                $response["member"]=array();

                while($data=mysqli_fetch_array($q3)) {

                $cq=$d->select("chat_block_master"," block_for='$user_id' AND block_by='$data[user_id]' OR  block_by='$user_id' AND block_for='$data[user_id]'");

                $qch11=$d->select("user_block_master","user_id='$user_id' AND block_by='$data[user_id]' ");
                

                $member = array(); 
                $member["user_id"]=$data['user_id'];
                $member["user_full_name"]=$data['user_full_name'];
                $member["user_first_name"]=$data['user_first_name'];
                $member["user_last_name"]=$data['user_last_name'];
                $member["gender"]=$data['gender'];
                $member["company_name"]=html_entity_decode($data['company_name']);
                $member["user_mobile"]=$data['user_mobile'];
                $member["public_mobile"]=$data['public_mobile'];
                $member["member_date_of_birth"]="".$data['member_date_of_birth'];
                $member["alt_mobile"] = $data['alt_mobile'];

                $member["user_profile_pic"]=$base_url."img/users/members_profile/".$data['user_profile_pic'];
                if (mysqli_num_rows($qch11)>0 || mysqli_num_rows($cq)>0) {
                    $member["block_status"] = true;
                } else {
                    $member["block_status"] = false;
                }
           

                    array_push($response["member"], $member); 
                }

                $response["message"]="Member List";
                $response["status"]="200";
                 
                echo json_encode($response);

         }else{
            $response["message"]="No Member Found!";
            $response["status"]="201";
            echo json_encode($response);
        }


    }  else if (isset($getRecentChatMember) && $getRecentChatMember=='getRecentChatMember' && filter_var($user_id, FILTER_VALIDATE_INT) == true) { 
       

        $q4=$d->getRecentChatMemberNew("chat_master",$user_id);
        

         

         if (mysqli_num_rows($q4)>0) {
            $response["member"]=array();
               

                while($data1=mysqli_fetch_array($q4)) {
                    if ($data1['msg_for']==$user_id) {
                        $recentUser= $data1['msg_by'];
                        
                    }else if ($data1['msg_by']==$user_id) {
                        $recentUser= $data1['msg_for'];
                    }
                    
                
                if ($recentUser!='') {
                    
                    

                    $member = array(); 
                    $member["chat_id"]=$data1['chat_id'];
                    // $member["msg_data"]=$data1['msg_data'];
                        if ($data1['msg_type']=='1') {
                            $member["msg_data"]="📸 Image";
                        }else if ($data1['msg_type']=='2') {
                            $member["msg_data"]="📃 Document";
                        }else if ($data1['msg_type']=='3') {
                           $member["msg_data"]="🎧 Audio";
                        }else if ($data1['msg_type']=='4') {
                           $member["msg_data"]="📌 Location";
                        }else if ($data1['msg_type']=='5') {
                           $member["msg_data"]="👤 Contact";
                        }else if ($data1['msg_type']=='6') {
                            $member["msg_data"]="🎞️ Video";
                        }else {
                             $member["msg_data"]=$data1['msg_data'];
                        }
                    // }else {
                    //     $member["msg_data"]=$data1['msg_data'];
                    // }
                    $member["msg_date"]=$data1['msg_date'];
                    $member["flag"]="1";
                    $member["member_size"]="1";
                    $member["user_id"]=$recentUser;
                    $member["user_full_name"]=$data1['user_full_name'];
                    $member["user_first_name"]=$data1['user_first_name'];
                    $member["user_last_name"]=$data1['user_last_name'];
                    $member["gender"]=$data1['gender'].'';
                    $member["user_mobile"]=$data1['user_mobile'];
                    $member["public_mobile"]=$data1['public_mobile'];
                    $member["member_date_of_birth"]="".$data1['member_date_of_birth'];
                    $member["alt_mobile"] = "";

                    $member["user_profile_pic"]=$base_url."img/users/members_profile/".$data1['user_profile_pic'];

                    $chatCount=$d->count_data_direct("chat_id","chat_master","msg_for='$user_id' AND msg_by='$recentUser' AND msg_status='0'");

                    $member["chatCount"] = $chatCount.'';

                        array_push($response["member"], $member); 
                    }
                }

              $response["message"]="Member List";
            $response["status"]="200";
            echo json_encode($response);
         } else {
              $response["message"]="No Recent Chat Found";
            $response["status"]="201";
            echo json_encode($response);
         }

     

          

    } else if ($_POST['getPrvChatNew'] == "getPrvChatNew"  && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($userId, FILTER_VALIDATE_INT) == true) {


           
                $qnotification = $d->select("chat_master", "((msg_by='$user_id' AND msg_for='$userId') OR (msg_by='$userId' AND msg_for='$user_id')) AND send_by='0' AND sent_to='0'", "ORDER BY chat_id ASC limit 1500");

                $cq = $d->select("chat_block_master", "block_for='$user_id' AND block_by='$userId'");

                $cq11 = $d->select("chat_block_master", "block_for='$userId' AND block_by='$user_id'");
                

                $qch11=$d->select("user_block_master","user_id='$userId' AND block_by='$user_id' ");
                $qch22=$d->select("user_block_master","user_id='$user_id' AND block_by='$userId' ");
                


            if (mysqli_num_rows($qnotification) > 0) {
                $response["chat"] = array();

                $tempPrvDate = "";

                while ($data_notification = mysqli_fetch_array($qnotification)) {
                    $chat = array();
                    $chat["chat_id"] = $data_notification['chat_id'];
                    $chat["chat_id_reply"] = $data_notification['chat_id_reply'];
                    if ($data_notification['chat_id_reply']!=0) {
                        $qs=$d->selectRow("msg_data,msg_img,msg_type","chat_master","chat_id='$data_notification[chat_id_reply]'");
                        $replyData=mysqli_fetch_array($qs);
                        $chat["reply_msg"] = $replyData['msg_data'];
                        $chat["reply_msg_img"] = $base_url."img/chatImg/".$replyData['msg_img'];
                        $chat["reply_msg_type"] = $replyData['msg_type'].'';
                    } else {
                        $chat["reply_msg"] = "";
                        $chat["reply_msg_img"]="";
                        $chat["reply_msg_type"]="";
                    }
                    $chat_id = $data_notification['chat_id'];
                    $chat["msg_by"] = $data_notification['msg_by'];
                    $chat["msg_for"] = $data_notification['msg_for'];
                    $chat["msg_data"] = html_entity_decode($data_notification['msg_data']);
                    $chat["msg_type"] = $data_notification['msg_type'];
                    if ($data_notification['msg_img']!='') {
                        $chat["msg_img"] = $base_url."img/chatImg/".$data_notification['msg_img'];
                    } else {
                        $chat["msg_img"] = "";
                    }
                    $chat["file_original_name"] = $data_notification['file_original_name'].'';
                    $chat["location_lat_long"] = $data_notification['location_lat_long'].'';
                    $chat["file_size"] = $data_notification['file_size'].'';
                    $chat["file_duration"] = $data_notification['file_duration'].'';
                    $chat["msg_status"] = $data_notification['msg_status'];
                    $chat["msg_delete"] = $data_notification['msg_delete'];
                    $chat["msg_date"] = date("h:i A", strtotime($data_notification['msg_date']));
                    $chatDate = date("d M Y", strtotime($data_notification['msg_date']));
                    $chat["isDate"] = false;
                    $chat["msg_date_view"] = $chatDate;

                    if ($data_notification['msg_by'] == $user_id) {

                        $chat["my_msg"] = '1';
                    } else {
                        $chat["my_msg"] = '0';

                        $m->set_data('msg_status', '1');

                        $a1 = array(
                            'msg_status' => $m->get_data('msg_status')
                        );

                        $d->update('chat_master', $a1, "chat_id='$chat_id'");
                    }
                    if($tempPrvDate!=""){

                        if($tempPrvDate != $chatDate){
                            $tempPrvDate = $chatDate;
                            $chatD = array();
                            $chatD["msg_date"] = $tempPrvDate;
                            $chatD["isDate"] = true;
                            $chatD["msg_date_view"] = $chatDate;

                            array_push($response["chat"], $chatD);
                        }

                    }else{
                        $tempPrvDate = $chatDate;
                        $chatD = array();
                        $chatD["msg_date"] = $tempPrvDate;
                        $chatD["isDate"] = true;
                        $chatD["msg_date_view"] = $chatDate;
                        array_push($response["chat"], $chatD);
                    }
                    array_push($response["chat"], $chat);
                }

                if (mysqli_num_rows($cq) > 0 || mysqli_num_rows($cq11) > 0) {
                    if (mysqli_num_rows($cq) > 0) {
                        // blocked by other user
                        $response["block_status"] = "1";
                    } else if (mysqli_num_rows($cq11) > 0) {
                        // blocked by me
                        $response["block_status"] = "2";
                    }
                } else if (mysqli_num_rows($qch11) > 0) {
                    $response["block_status"] = "2";
                }else if (mysqli_num_rows($qch22) > 0) {
                    $response["block_status"] = "1";
                }  else {
                    //No Bloked
                    $response["block_status"] = "0";
                }

                if ($isRead==1) {
                    $qsm = $d->select("users_master", "user_id='$userId'");
                    $data_notification = mysqli_fetch_array($qsm);
                    $sos_user_token = $data_notification['user_token'];
                    $device = $data_notification['device'];
                    if ($device == 'android') {
                        $nResident->noti("chatMsg","", 0, $sos_user_token, "", "", 'chatMsg');
                    } else if ($device == 'ios') {
                        $nResident->noti_ios("chatMsg","", 0, $sos_user_token, "", "", 'chatMsg');
                    }
                }

                $response["message"] = "Get Chat success.";

                $response["status"] = "200";
                echo json_encode($response);
            } else {
                if (mysqli_num_rows($cq) > 0 || mysqli_num_rows($cq11) > 0) {
                    if (mysqli_num_rows($cq) > 0) {
                        // blocked by other user
                        $response["block_status"] = "1";
                    } else if (mysqli_num_rows($cq11) > 0) {
                        // blocked by me
                        $response["block_status"] = "2";
                    }
                } else if (mysqli_num_rows($qch11) > 0) {
                    $response["block_status"] = "1";
                } else {
                    //No Bloked
                    $response["block_status"] = "0";
                }

                $response["message"] = "No Chat Found.";

                $response["status"] = "201";
                echo json_encode($response);
            }
        } else if ($_POST['addChat'] == "addChat" && filter_var($msg_by, FILTER_VALIDATE_INT) == true) {

            if ($msg_data == '') {
                $response["message"] = "Enter message";
                $response["status"] = "201";
                exit();
            }
            $msg_data = html_entity_decode($msg_data);

            $m->set_data('chat_id_reply', $chat_id_reply);
            $m->set_data('msg_by', $msg_by);
            $m->set_data('msg_for', $msg_for);
            $m->set_data('msg_data', $msg_data);
            $m->set_data('msg_status', '0');
            $m->set_data('send_by', '0');
            $m->set_data('sent_to', '0');
            $m->set_data('msg_type', $msgType);
            $m->set_data('msg_date', date("Y-m-d H:i:s"));
            $m->set_data('location_lat_long', $location_lat_long);

            $a1 = array(
                'chat_id_reply' => $m->get_data('chat_id_reply'),
                'msg_by' => $m->get_data('msg_by'),
                'msg_for' => $m->get_data('msg_for'),
                'msg_data' => $m->get_data('msg_data'),
                'msg_type' => $m->get_data('msg_type'),
                'location_lat_long' => $m->get_data('location_lat_long'),
                'msg_status' => $m->get_data('msg_status'),
                'send_by' => $m->get_data('send_by'),
                'sent_to' => $m->get_data('sent_to'),
                'msg_date' => $m->get_data('msg_date')
            );

            $q = $d->insert('chat_master', $a1);


            if ($q == true) {

                 if ($msgType=='1') {
                $notiDescription="📸 Image";
                }else if ($msgType=='2') {
                   $notiDescription="📃 Document";
                }else if ($msgType=='3') {
                   $notiDescription="🎧 Audio";
                }else if ($msgType=='4') {
                   $notiDescription="📌 Location";
                }else if ($msgType=='5') {
                   $notiDescription="👤 Contact";
                }else if ($msgType=='6') {
                   $notiDescription="🎞️ Video";
                }else {
                    $notiDescription =  $msg_data;
                }



                    $notAry = array(
                        'userType' => "Resident",
                        'userId' => $m->get_data('msg_by'),
                        'userProfile' => $user_profile,
                        'userName' => $user_name,
                        'from' => "1",
                        'sentTo' => "0",
                        'recidentMobile' => $user_mobile,
                        'publicMobile' => $public_mobile,
                    );

                    $qUserToken = $d->select("users_master", "user_id='$msg_for'");
                    $data_notification = mysqli_fetch_array($qUserToken);
                    $sos_user_token = $data_notification['user_token'];
                    $device = $data_notification['device'];
                    if ($device == 'android') {
                        $nResident->noti("chatMsg","", 0, $sos_user_token, "$user_name 💬",  $notiDescription, $notAry);
                    } else if ($device == 'ios') {
                        $nResident->noti_ios("chatMsg","", 0, $sos_user_token, "$user_name 💬",  $notiDescription, $notAry);
                    }

                $response["message"] = "Message Send";
                $response["status"] = "200";
                echo json_encode($response);
            } else {

                $response["message"] = "Fail to add chat.";
                $response["status"] = "201";
                echo json_encode($response);
            }
        }else if ($_POST['addChatWithDoc'] == "addChatWithDoc" && filter_var($msg_by, FILTER_VALIDATE_INT) == true) {


            $total = count($_FILES['chat_doc']['tmp_name']);
            for ($i = 0; $i < $total; $i++) {
              $uploadedFile = $_FILES['chat_doc']['name'][$i];
              if ($uploadedFile != "") {
                $temp = explode(".", $uploadedFile);
                $feed_img = "Chat_" . round(microtime(true)) .$i.'.' . end($temp);
                move_uploaded_file($_FILES['chat_doc']['tmp_name'][$i], "../img/chatImg/" . $feed_img);
                $file_original_name = $uploadedFile;
                $bytesSize = $_FILES['chat_doc']['size'][$i];
                $file_size= $d->formatSizeUnits($bytesSize);
                $m->set_data('chat_id_reply', $chat_id_reply);
                $m->set_data('msg_by', $msg_by);
                $m->set_data('msg_for', $msg_for);
                $m->set_data('msg_data', $_POST['msg_data'][$i]);
                $m->set_data('msg_status', '0');
                $m->set_data('send_by', '0');
                $m->set_data('sent_to', $sent_to);
                $m->set_data('msg_date', date("Y-m-d H:i:s"));
                $m->set_data('msg_type', $msgType);
                $m->set_data('msg_img', $feed_img);
                $m->set_data('file_original_name', $file_original_name);
                $m->set_data('location_lat_long', $location_lat_long);
                $m->set_data('file_size', $file_size);
                $m->set_data('file_duration', $file_duration);
    
                $a1 = array(
                    'chat_id_reply' => $m->get_data('chat_id_reply'),
                    'msg_by' => $m->get_data('msg_by'),
                    'msg_for' => $m->get_data('msg_for'),
                    'msg_data' => $m->get_data('msg_data'),
                    'msg_type' => $m->get_data('msg_type'),
                    'msg_img' => $m->get_data('msg_img'),
                    'file_original_name' => $m->get_data('file_original_name'),
                    'location_lat_long' => $m->get_data('location_lat_long'),
                    'file_size' => $m->get_data('file_size'),
                    'file_duration' => $m->get_data('file_duration'),
                    'msg_status' => $m->get_data('msg_status'),
                    'send_by' => $m->get_data('send_by'),
                    'sent_to' => $m->get_data('sent_to'),
                    'msg_date' => $m->get_data('msg_date')
                );
    
                $q = $d->insert('chat_master', $a1);

              }
            }

            if ($msgType=='1') {
                $notiDescription="📸 Image";
            }else if ($msgType=='2') {
               $notiDescription="📃 Document";
            }else if ($msgType=='3') {
               $notiDescription="🎧 Audio";
            }else if ($msgType=='4') {
               $notiDescription="📌 Location";
            }else if ($msgType=='5') {
               $notiDescription="👤 Contact";
            }else if ($msgType=='6') {
                   $notiDescription="🎞️ Video";
            }else {
                $notiDescription = "📃 Document";
            }


            

                $notAry = array(
                        'userType' => "Resident",
                        'userId' => $m->get_data('msg_by'),
                        'userProfile' => $user_profile,
                        'userName' => $user_name,
                        'from' => "1",
                        'sentTo' => "0",
                        'recidentMobile' => $user_mobile,
                        'publicMobile' => $public_mobile,
                    );

                $qUserToken = $d->select("users_master", "user_id='$msg_for'");
                $data_notification = mysqli_fetch_array($qUserToken);
                $sos_user_token = $data_notification['user_token'];
                $device = $data_notification['device'];
                if ($device == 'android') {
                    $nResident->noti("chatMsg","", 0, $sos_user_token, "$user_name 💬", $notiDescription, $notAry);
                } else if ($device == 'ios') {
                    $nResident->noti_ios("chatMsg","", 0, $sos_user_token, "$user_name 💬", $notiDescription, $notAry);
                }

            $response["message"] = "Message Send";
            $response["status"] = "200";
            echo json_encode($response);

        }  else if ($_POST['chatBlock'] == "chatBlock" && filter_var($block_by, FILTER_VALIDATE_INT) == true && filter_var($block_for, FILTER_VALIDATE_INT) == true) {

            $q1 = $d->select("chat_block_master", "block_by='$block_by' AND block_for='$block_for'");

            if (mysqli_num_rows($q1) > 0) {
                $response["message"] = "User already blocked.";
                $response["status"] = "201";
                echo json_encode($response);
                exit();
            }
            $m->set_data('block_by', $block_by);
            $m->set_data('block_for', $block_for);

            $a1 = array(
                'block_by' => $m->get_data('block_by'),
                'block_for' => $m->get_data('block_for')
            );

            $q = $d->insert('chat_block_master', $a1);


            if ($q == true) {

                $response["message"] = "User blocked.";
                $response["status"] = "200";
                echo json_encode($response);
            } else {

                $response["message"] = "Fail to block.";
                $response["status"] = "201";
                echo json_encode($response);
            }
        } else if ($_POST['chatUnBlock'] == "chatUnBlock" && filter_var($block_for, FILTER_VALIDATE_INT) == true && filter_var($block_by, FILTER_VALIDATE_INT) == true) {

            $q1 = $d->select("chat_block_master", "block_by='$block_by' AND block_for='$block_for'");

            $q2 = $d->select("user_block_master","user_id='$block_for' AND block_by='$block_by' ");


            if (mysqli_num_rows($q1) > 0) {
                $q = $d->delete('chat_block_master', "block_by='$block_by' AND block_for='$block_for'");

                if ($q == true) {

                    $response["message"] = "User unblocked.";
                    $response["status"] = "200";
                    echo json_encode($response);
                } else {

                    $response["message"] = "Fail to unblock.";
                    $response["status"] = "201";
                    echo json_encode($response);
                }
            }else if (mysqli_num_rows($q2) > 0) {

                 $d->delete("user_block_master","user_id='$block_for' AND block_by='$block_by' ");

                 $response["message"] = "User unblocked.";
                $response["status"] = "200";
                echo json_encode($response);
            } else {
                $response["message"] = "User already Unblocked.";
                $response["status"] = "201";
                echo json_encode($response);
            }
        } elseif (isset($deleteChatMulti) && $deleteChatMulti=="deleteChatMulti" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {


                 $chat_idAry = explode(",",$chat_id);
                for ($i=0; $i <count($chat_idAry); $i++) { 
                  $q=$d->delete("chat_master","chat_id='$chat_idAry[$i]' AND chat_id!=0  AND msg_by='$user_id'");
                }

                if($q==true){
                   
                    $response["message"]="Deleted Successfully";
                    $response["status"]="200";
                    echo json_encode($response);

                }else {
                    $response["message"]="Sumething Wrong";
                    $response["status"]="201";
                    echo json_encode($response);                        
                }

            
        } else{
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
