
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-6">
        <h4 class="page-title">  Member Transactions </h4>
      </div>

      <?php 
      //24nov2020
      /* ?>
      <div class="col-sm-3">
        <div class="btn-group float-sm-right">
          <!-- <a href="buyPlan" class="btn btn-primary waves-effect waves-light"><i class="fa fa-plus mr-1"></i> Renew  Plan </a> -->

          
        </div>
      </div>
      <?php */

$where="";
                  if (isset($_GET['mode']) && $_GET['mode']== 1 ) { 
                 extract(array_map("test_input" , $_GET));
                $where .=" and  transection_master.coupon_id  = 0 ";
}  else if (isset($_GET['mode']) && $_GET['mode']== 2 ) { 
                 extract(array_map("test_input" , $_GET));
                $where .=" and  transection_master.coupon_id  != 0 ";
}  
      $qry=$d->select("users_master,transection_master","transection_master.user_id=users_master.user_id AND (transection_master.payment_status='success' OR transection_master.payment_status='SUCCESS' ) $where ","ORDER BY transection_master.transection_id DESC");
                  $total_transaction = 0 ;
                  $total_coupon = 0 ;
                  while($qry_data=mysqli_fetch_array($qry))
                  {
                    if(  $qry_data['coupon_id'] != 0){
                      $total_coupon += $qry_data['transection_amount'];
                      
                    } else {
                      $total_transaction += $qry_data['transection_amount'];
                    }
                    
                  }
                   ?> 

      <div class="col-sm-3">
           <?php if($total_transaction>0){ ?> 
           <span class="badge badge-pill badge-success m-1"> <span >Earning <i class="fa fa-inr"></i> <?php echo number_format($total_transaction,2,'.',''); ?> </span > </span > 
          <?php } ?> 
      </div>
       <div class="col-sm-3">
         <?php if($total_coupon>0){ ?>  
          <a href="couponReport"> <span class="badge badge-pill badge-danger m-1"> <span >Coupon <i class="fa fa-inr"></i><?php echo number_format($total_coupon,2,'.',''); ?> </span > </span > </a>
          <?php } ?> 
      </div>
      <?php //24nov2020 ?>


    </div>

    <form action="" method="get">
      <div class="row pt-2 pb-2">
        <div class="col-sm-4">
          <select name="mode"  class="form-control single-select">
           <option <?php if ( isset($_REQUEST['mode']) && $_REQUEST['mode']==0   ) { echo 'selected';} ?>  value="0">All</option>
           <option <?php if ( isset($_REQUEST['mode']) && $_REQUEST['mode']==1   ) { echo 'selected';} ?>  value="1">Transaction</option>
           <option <?php if ( isset($_REQUEST['mode']) && $_REQUEST['mode']==2   ) { echo 'selected';} ?> value="2">Coupon</option>
           
        </select>
        </div>

        <div class="col-lg-2 col-3">
            <label  class="form-control-label"> </label>
              <input  class="btn btn-success" type="submit" name="getReport" class="form-control" value="Get Report">
          </div>


      </div>
    </form>
    <!-- End Breadcrumb-->
    
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <!-- <div class="card-header"><i class="fa fa-table"></i> Data Exporting</div> -->
          <div class="card-body">
            <div class="table-responsive">
              <table id="example" class="table table-bordered">
                <thead>
                  <tr>
                    <th class="text-right">#</th>
                    <th>Name</th>
                    <th>Package</th>
                    <th>Mode</th>
                    <th class="text-right">Amount</th>
                    <th>Date</th>
                    <th>Txt Id</th>
                    
                  </tr>
                </thead>
                <tbody>
                  <?php
                  


                  $q=$d->select("transection_master,users_master","transection_master.user_id=users_master.user_id AND transection_master.payment_status='success' $where ","ORDER BY transection_master.transection_id DESC");
                  $i = 0;
                  while($row=mysqli_fetch_array($q))
                  {
                  // extract($row);
                  $i++;
                  
                  ?>
                  <tr>
                    
                    <td class="text-right"><?php echo $i; ?></td>
                    <td><a href="viewMember?id=<?php echo $row['user_id'];?>"> <?php echo $row['user_full_name']; ?></td>
                    <td><?php echo $row['package_name']; ?></td>
                    <td><?php echo $row['payment_mode']; ?></td>
                    <td class="text-right"><?php echo $row['transection_amount']; ?></td>
                    <td data-order="<?php echo date("U",strtotime($row['transection_date'])); ?>" ><?php echo $row['transection_date']; ?></td>
                    <td><?php echo $row['razorpay_payment_id']; ?></td>
                    
                  </tr>
                  <?php }?>
                </tbody>
                
              </div>
            </table>
          </div>
        </div>
      </div>
    </div>
    </div><!-- End Row-->
  </div>
  <!-- End container-fluid-->
  
  </div><!--End content-wrapper-->
  <!--Start Back To Top Button-->
