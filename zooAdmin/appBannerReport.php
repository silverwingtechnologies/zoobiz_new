<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-4">
        <h4 class="page-title">App Banner Report</h4>
         <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">App Banner Report</li>
         </ol>
      </div>
      
    </div>
    
  </div>
  <!-- End Breadcrumb-->
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table id="example" class="table table-bordered">
              <thead>
                <tr>
                  <th class="text-right">#</th>
                  <th>image</th>
                  <th>Mobile Number</th>
                  <th>Member</th>
                  <th>BUSINESS CATEGORY</th>
                  <th>ABOUT OFFER</th>
                  <th>URL</th>
                  <th>YOUTUBE VIDEO ID</th>
                  <th>date</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $q3=$d->select("slider_master"," status=0 ","");
                $i=1;
                while ($data=mysqli_fetch_array($q3)) {
                extract($data);
                ?>
                <tr>
                  <td class="text-right"><?php echo $i++; ?></td>
                  <td>
                    <a    href="../img/sliders/<?php echo $slider_image; ?>" data-fancybox="images<?php echo $slider_id;?>" data-caption="Photo Name : <?php echo $slider_description;?>">
                      <img style="width:50px;height:50px;" class="d-block w-100" src="../img/sliders/<?php echo $slider_image; ?>" alt="">
                    </a>
                  </td>
                  <td><?php echo  $slider_mobile; ?></td>
                  <td> <?php
                    if($user_id  != 0 ){
                    $users_master_qry = $d->select("users_master","user_id='$user_id' ");
                    $users_master_data = mysqli_fetch_array($users_master_qry);
                    ?><a  target="_blank"  title="View Profile"  href="viewMember?id=<?php echo $user_id; ?>" ><?php echo  $users_master_data['user_full_name']; ?></a> <?php
                    } else {
                    echo "-";
                    }
                    
                  ?>   </td>
                  <td><?php
                    if($business_category_id  != 0 ){
                    $business_categories_qry = $d->select("business_categories","business_category_id='$business_category_id' ");
                    $business_categories_data = mysqli_fetch_array($business_categories_qry);
                    echo  $business_categories_data['category_name'];
                    } else {
                    echo "-";
                    }
                    
                  ?></td>
                  <td> <?php echo   wordwrap( $slider_description,20,"<br>\n");  ?>
                    <td><?php echo  $slider_url; ?></td>
                    <td><?php echo  $slider_video_url; ?></td>
                    <td data-order="<?php echo date("U",strtotime($created_date)); ?>" ><?php if($created_date !="0000-00-00 00:00:00"){  echo date("d-m-Y h:i:s A", strtotime($created_date)); } ?></td>
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