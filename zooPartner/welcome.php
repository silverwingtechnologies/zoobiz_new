<?php  //$d->send_sms("7990247516","fffdemo"); 
//$d->send_sms_multiple("7990247516,7433053030","Zoobiz Dev Test");  
  
$accessPage=$d->select("master_menu","status=0 and menu_id in ($accessMenuId) ");
    $accessPageData=mysqli_fetch_array($accessPage);


$allowedMenus = array();
  while($row1=mysqli_fetch_array($accessPage)){ 
    $allowedMenus[] = $row1['menu_link'];
  }
   
?>
<div class="content-wrapper">
    <div class="container-fluid">

      
    <div class="row mt-3">
      <?php
//echo "<pre>";print_r($_SESSION);echo "</pre>";
    ?> 
       <?php if(in_array('payments', $allowedMenus)){ ?>  
        <div class="col-6 col-lg-6 col-xl-3">
          <div class="card gradient-blooker">
            <a href="paymentsMonthly">
            <div class="p-2">
              <div class="media align-items-center">
              <div class="media-body">
                <p class="text-white">Transactions</p>
               
             <?php //24nov2020  transection_master.coupon_id = 0 added to exclude coupon amount from transactions.
             $y = date("Y");
             $m = date("m");
                 /*$count5=$d->selectRow("transection_amount","transection_master","payment_status='success' and is_paid = 0  and YEAR(transection_date) = '$y' and MONTH(`transection_date`) = '$m'  and payment_mode !='Backend Admin' ");*/

                   $qry=$d->select("users_master,company_master,transection_master"," users_master.company_id = company_master.company_id and transection_master.user_id=users_master.user_id   and  payment_status='success' and is_paid = 0  and YEAR(transection_date) = '$y' and MONTH(`transection_date`) = '$m'  and payment_mode !='Backend Admin'  ","ORDER BY transection_master.transection_id DESC");

 
                 $trantotal = 0 ;
 while($row=mysqli_fetch_array($qry)) {
  if(  $row['coupon_id'] == 0){
                    $trantotal +=$row['transection_amount'];
                }
                         
                  }
                  $totalMain=number_format($trantotal,2,'.','');
                  if(strlen($totalMain)> 7){
                   echo  ' <h4 class="text-white line-height-5">'.$totalMain.'</h4>'; 
                  } else {
                    echo  ' <h3 class="text-white line-height-5"> '.$totalMain.'</h3>'; 
                  }
                 /*$count5=$d->select("transection_master,users_master","transection_master.user_id=users_master.user_id AND transection_master.payment_status='success'  and (  transection_master.coupon_id = 0  ) ");
$asif = 0 ;
                  while($row=mysqli_fetch_array($count5))
                 {
                      //$asif=$row['SUM(transection_amount)'];
                  $asif +=$row['transection_amount'];
                
                         
                  }
                  $totalMain=number_format($asif,2,'.','');
                  if(strlen($totalMain)> 7){

                   //echo  ' <h4 class="text-white line-height-5">'.$totalMain.'</h4>'; 
                  } else {
                   // echo  ' <h3 class="text-white line-height-5"> '.$totalMain.'</h3>'; 
                  }*/
               ?>
             
           </a>
            </div>
            <div class="w-circle-icon rounded-circle border-white">
              <img class="myIcon" src="../zooAdmin/img/icons/cash-icon.png"></div>
            </div>
            </div>
            </a>
          </div>
        </div>
         <?php } ?> 
       <?php if(in_array('onlyViewMember', $allowedMenus)){ ?>  
        <div class="col-6 col-lg-6 col-xl-3">
          <div class="card gradient-ohhappiness">
            <?php //24nov2020 manageMembers to memberList?>
            <a href="onlyViewMember">
            <div class="p-2">
              <div class="media align-items-center">
              <div class="media-body">
                <p class="text-white">Users</p>
                <h4 class="text-white line-height-5"><?php 




              //  echo $d->count_data_direct("user_id","users_master, user_employment_details","users_master.active_status  = 0  AND user_employment_details.user_id=users_master.user_id ");
                  $q=$d->select("users_master,user_employment_details,business_categories,business_sub_categories"," business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND users_master.active_status=0 AND users_master.office_member=0   ","ORDER BY users_master.user_id DESC");
              echo   mysqli_num_rows($q);
                 ?></h4>


              </div>
              <div class="w-circle-icon rounded-circle border-white">
                 <img class="myIcon" src="../zooAdmin/img/icons/comittee.png"></div>
            </div>
            </div>
            </a>
          </div>
        </div>
         <?php } ?> 
      
    </div>

    
     
    
    </div>
 