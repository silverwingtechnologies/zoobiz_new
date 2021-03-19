  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <h4 class="page-title">Business Houses</h4>
         
       </div>
       <div class="col-sm-3">
         <div class="btn-group float-sm-right">
          <a href="#" data-toggle="modal" data-target="#addCategory" class="btn btn-sm btn-primary waves-effect waves-light"><i class="fa fa-plus mr-1"></i> Add New </a>
       </div>
     </div>
   </div>
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
                 
                  <th>#</th>
                  <th>Name</th>
                  <th>Category</th>
                  <th>Company</th>
                   <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;
              $q=$d->select("users_master,business_houses,user_employment_details,business_categories,business_sub_categories","    business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND business_houses.user_id= users_master.user_id ","ORDER BY business_houses.order_id ASC");
              $alredyAray=array();
               while ($data=mysqli_fetch_array($q)) {
                extract($data);
                array_push($alredyAray, $user_id);
                ?>
                <tr>
                
                  <td><?php echo $i++; ?></td>
                  <td><?php echo $salutation.' '.$user_full_name; ?></td>
                  <td><?php echo $category_name; ?>-<?php echo $sub_category_name; ?></td>
                  <td><?php echo $company_name; ?></td>
                 <td>
                    <form action="controller/memberController.php" method="post">    
                          <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">    
                          <input type="hidden" name="business_houses_id" value="<?php echo $business_houses_id; ?>">    
                          <input type="hidden" name="removeBusinesHouses" value="removeBusinesHouses">                 
                          <button type="submit" name="" class="btn shadow-danger btn-danger btn-sm form-btn">Remove </button>
                        </form>
                 </td>
                

               </tr>

             <?php } ?> 
           </tbody>

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



<div class="modal fade" id="addCategory">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-fincasys">
      <div class="modal-header bg-fincasys">
        <h5 class="modal-title text-white">Add Business Houses</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form id="addHousesForm" action="controller/memberController.php" method="post" enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label">Select Member <span class="required">*</span></label>
                    <div class="col-sm-8">
                       <select required="" type="text" name="user_id"  class="single-select form-control">
                        <option value="">-- Select --</option>
                         <?php
                         $ids = join("','",$alredyAray);   
                          $q=$d->select("users_master,user_employment_details,business_categories,business_sub_categories","    business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND users_master.user_id NOT IN  ('$ids') ");
                        while($row=mysqli_fetch_array($q)){ ?> 
                        <option value="<?php echo $row['user_id']; ?>"><?php echo $row['user_full_name']; ?>-<?php echo $row['category_name']; ?></option>
                        <?php }?>
                      </select>
                    </div>
                </div>
               
         
                <div class="form-footer text-center">
                  <input type="hidden" name="addBusinessHouses" value="addBusinessHouses">
                  <button type="submit" name="" value="" class="btn btn-sm btn-success"><i class="fa fa-check-square-o"></i> Add</button>
                </div>

          </form> 
      </div>
     
    </div>
  </div>
</div><!--End Modal -->

