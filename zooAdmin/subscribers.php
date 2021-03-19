
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-6">
        <h4 class="page-title"> Subscribers</h4>
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
                    <th class="text-right">#</th>
                    <th>Name</th>
                    <th>Mobile NUmber</th>
                    <th>Email</th>
                     <th>Date</th>
                     
                    
                  </tr>
                </thead>
                <tbody>
                  <?php
                  


                  $q=$d->select("subscribe_master","","ORDER BY created_date DESC");
                  $i = 0;
                  while($row=mysqli_fetch_array($q))
                  {
                  // extract($row);
                  $i++;
                  
                  ?>
                  <tr>
                    
                    <td class="text-right"><?php echo $i; ?></td>
                     
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['mobile']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td data-order="<?php echo date("U",strtotime($row['created_date'])); ?>" ><?php echo $row['created_date']; ?></td> 
                    
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
