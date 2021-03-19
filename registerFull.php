<?php 
include("common/front_header.php");
 ?>
<header class="site-header" id="header">
        <nav class="navbar navbar-expand-lg fixed-bottom static-nav">
            <div class="container">
                <a class="navbar-brand" href="index">
                    <img height="50"  style="width: 150px !important;"  src="img/zoobizLogo.png" alt="logo" class="logo-default">
                    <img height="50"  style="width: 150px !important;"  src="img/zoobizLogo.png" alt="logo" class="logo-scrolled">
                </a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav mx-auto ml-xl-auto mr-xl-0">
                        <li class="nav-item">
                            <?php //1july2020 ?>
                           <!--  <li class="nav-item">
                                <a class="nav-link " style="color: #2abcaa !important;" href="register">     <i class="fas fa-plus"></i> <b>Register in ZooBiz</b></a>
                            </li>
                            --> <?php //1july2020 ?>
                            <a class="nav-link active pagescroll text-lowercase" style="color: #2abcaa !important;" href="#">  <!-- <button type="submit" id="submit_btn1" class="button gradient-btn w-60"> contact@zoobiz.com</button> --> <i class="fas fa-envelope"></i> <b>contact@zoobiz.in</b></a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active pagescroll scrollupto" style="color: #2abcaa !important;" href="#"><i class="fas fa-phone"></i><b> +91 98252 93889</b></a>
                        </li>

                    </ul>
                </div>
            </div>
            
            </nav>
           
        </header>
        <!-- header -->
        <!--Main Slider-->
        <section id="home" class="p-0 light-slider single-slide">
            <h2 class="d-none">hidden</h2>
            <div id="rev_single_wrapper" class="rev_slider_wrapper fullwidthbanner-container" data-alias="trax_slider_01">
                <!-- START REVOLUTION SLIDER 5.4.8.1 fullscreen mode -->
                <div id="rev_single" class="rev_slider fullwidthabanner" data-version="5.4.8.1">
                    <ul>
                        <!-- slide -->
                        <li data-index="rs-layers" data-transition="fade" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off"  data-easein="default" data-easeout="default" data-masterspeed="500"  data-rotate="0"  data-saveperformance="off"  data-title="Slide" data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="">
                            <!-- main image -->
                            <div class="overlay overlay-dark opacity-7"></div>
                            <img src="img/banner5.jpg" data-bgcolor="#e0e0e0" alt=""  data-bgposition="top center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="9" class="rev-slidebg" data-no-retina>
                            <!-- layers -->
                            <div class="tp-caption tp-resizeme z-index-15"
                            data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']"
                            data-y="['middle','middle','middle','middle']" data-voffset="['-150','-155','-155','-155']"
                            data-whitespace="nowrap" data-responsive_offset="on"
                            data-width="['none','none','none','none']" data-type="text"
                            data-textalign="['center','center','center','center']"
                            data-transform_idle="o:1;"
                            data-transform_in="x:-50px;opacity:0;s:2000;e:Power3.easeOut;"
                            data-transform_out="s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;"
                            data-start="1000" data-splitin="none" data-splitout="none">
                            <h2 class="font-xlight">Register In ZooBiz </h2>
                        </div>

                        <div class="tp-caption tp-resizeme z-index-15"
                        data-x="['center','center','center','center']" data-hoffset="['-20','-20','-20','-20']"
                        data-y="['middle','middle','middle','middle']" data-voffset="['100','100','110','110']"
                        data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:1500;e:Power4.easeInOut;" data-transform_out="s:900;e:Power2.easeInOut;s:900;e:Power2.easeInOut;" data-start="1800" data-splitin="none" data-splitout="none" data-responsive_offset="on">
                        <!-- <a class="transition-3 button btn-primary button-padding pagescroll font-13" href="#"  data-toggle="modal" data-target="#myModal">Register</a> -->
                    </div>
                </li>
            </ul>
        </div>
        <!-- END REVOLUTION SLIDER -->
    </div>
</section>

<!-- Our Team ends-->

         

        <section class="bglight" id="contact">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="heading-title darkcolor wow fadeInUp" data-wow-delay="100ms">
                            <h2 class="font-normal darkcolor heading_space_half">   </h2>
                        </div>
                        
                    </div>
                </div>
                <form id="registerFrm" name="registerFrm" action="controller/registerController.php" class="getin_form" method="POST" enctype="multipart/form-data"  >
                    <div class="row">
                        <?php //new 
                       // echo "<pre>";print_r($_SESSION);echo "</pre>";?>


                     <div class="col-md-6 col-sm-12">
                        <div class="heading-title  wow fadeInLeft" data-wow-delay="300ms">
                            <div class="heading-title heading_small">
                                <h3 class="darkcolor font-normal">Personal Info</h3>
                            </div>
                            <div class="my-3">

                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="salutation" >Salutation <span class="required">*</span></label>
                                        <select class="form-control single-select" name="salutation" id="salutation" type="text" required="">
                                            <option value="">-- Select --</option>
                                            <option <?php if(isset($_SESSION['salutation']) && $_SESSION['salutation'] == 'Mr.'    ){ echo 'selected'; }?>  value="Mr.">Mr.</option>
                                            <option <?php if(isset($_SESSION['salutation']) && $_SESSION['salutation'] == 'Mrs.'    ){ echo 'selected'; }?>  value="Mrs.">Mrs.</option>
                                            <option  <?php if(isset($_SESSION['salutation']) && $_SESSION['salutation'] == 'Miss'    ){ echo 'selected'; }?>  value="Miss">Miss</option>
                                            <option  <?php if(isset($_SESSION['salutation']) && $_SESSION['salutation'] == 'Ms'    ){ echo 'selected'; }?> value="Ms">Ms</option>
                                            <option  <?php if(isset($_SESSION['salutation']) && $_SESSION['salutation'] == 'MDr.'    ){ echo 'selected'; }?> value="Dr.">Dr.</option>
                                            <option  <?php if(isset($_SESSION['salutation']) && $_SESSION['salutation'] == 'Prof.'    ){ echo 'selected'; }?> value="Prof.">Prof.</option>
                                            <option  <?php if(isset($_SESSION['salutation']) && $_SESSION['salutation'] == 'Other'    ){ echo 'selected'; }?> value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="user_first_name" >First name <span class="required">*</span></label>
                                        <input maxlength="30" class="form-control text-capitalize" name="user_first_name" id="user_first_name"  type="text" value="<?php if(isset($_SESSION['user_first_name'])   ){ echo $_SESSION['user_first_name']; }?>" required="" placeholder="User Name">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="user_last_name" >Last Name <span class="required">*</span></label>
                                        <input maxlength="30"  class="form-control text-capitalize" name="user_last_name" id="user_last_name" type="text" value="<?php if(isset($_SESSION['user_last_name'])   ){ echo $_SESSION['user_last_name']; }?>" required="" placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="user_mobile" >Mobile Number (Login) <span class="required">*</span></label>
                                        <input required="" class="form-control onlyNumber" onblur="checkMobileUser()"  name="user_mobile" id="user_mobile"  maxlength="10"  type="text" value="<?php if(isset($_SESSION['user_mobile'])   ){ echo $_SESSION['user_mobile']; }?>"  placeholder="User Mobile">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="autoclose-datepicker-dob" >Birth Date</label>
                                        <input class="form-control" readonly="" id="autoclose-datepicker-dob" name="member_date_of_birth" type="text" value="<?php if(isset($_SESSION['member_date_of_birth'])   ){ echo $_SESSION['member_date_of_birth']; }?>" placeholder="Birth Date" >
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="gender" >Gender</label>

                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio"  <?php if(isset($_SESSION['gender']) && $_SESSION['gender'] == 'Male' ){ echo 'checked'; } else { echo "checked";}?> class="form-check-input" value="Male" name="gender"> Male
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input   <?php if(isset($_SESSION['gender']) && $_SESSION['gender'] == 'Female' ){ echo 'checked'; }?> type="radio"   class="form-check-input" value="Female" name="gender"> Female
                                            </label>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="whatsapp_number" >Whats App Number</label>
                                        <input maxlength="10"  class="form-control onlyNumber" maxlength="10" name="whatsapp_number"   type="text" value="<?php if(isset($_SESSION['whatsapp_number'])   ){ echo $_SESSION['whatsapp_number']; }?>" id="whatsapp_number" placeholder="Whatsapp No." >
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="email1" >Email <span class="required">*</span></label>
                                        <input maxlength="60" class="form-control" type="email" id="user_email" name="user_email"  value="<?php if(isset($_SESSION['user_email'])   ){ echo $_SESSION['user_email']; }?>" id="userEmail" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="plan_id" >Membership Plan</label>
                                        <select id="plan_id" required="" class="form-control single-select" name="plan_id" type="text"   >
                                            <option value="">-- Select --</option>
                                            <?php $qb=$d->select("package_master","","");
                                            while ($bData=mysqli_fetch_array($qb)) {?>
                                                <option  <?php if(isset($_SESSION['plan_id']) && $_SESSION['plan_id'] == $bData['package_id'] ){ echo 'selected'; }?>     value="<?php echo $bData['package_id']; ?>"><?php echo $bData['package_name']; ?>-<?php echo $bData['no_of_month']; ?> Month ( ₹ <?php echo $bData['package_amount']; ?> + 18% GST)</option>
                                            <?php } ?>
                                        </select>

                                        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                                        <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >


                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="imgInp" >Profile Photo</label>
                                        <input accept="image/*" class="form-control-file border" id="imgInp" name="user_profile_pic" type="file">

                                        <input class="form-control" name="user_profile_pic_old" type="hidden" value="<?php if(isset($_SESSION['user_profile_pic'])   ){ echo $_SESSION['user_profile_pic']; }?> ">


                                    </div>
                                </div>


                                <div class="heading-title heading_small">
                                    <h3 class="darkcolor font-normal">Company Info</h3>
                                </div>

                                <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="company_name" >Company Name <span class="required">*</span></label>
                                    <input placeholder="Company Name"  class="form-control" id="company_name" name="company_name"  maxlength="60" value="<?php if(isset($_SESSION['company_name'])){ echo $_SESSION['company_name'];}?>" type="text">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="company_website" >Company Contact Number</label>
                                    <input placeholder="Contact Number"  class="form-control onlyNumber" id="company_contact_number" name="company_contact_number"  maxlength="12" value="<?php if(isset($_SESSION['company_contact_number'])){ echo $_SESSION['company_contact_number'];}?>" type="text">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="designation" >Designation <span class="required">*</span></label>
                                    <input maxlength="60" required="" value="<?php if(isset($_SESSION['designation'])){ echo $_SESSION['designation'];}?>"  class="form-control" type="text" name="designation"    value="" id="designation" placeholder="Designation">
                                </div>
                            </div>

                             <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="gst_number" >GST Number </label>
                                    <input maxlength="15" minlength="15"   value="<?php if(isset($_SESSION['gst_number'])){ echo $_SESSION['gst_number'];}?>"  class="form-control text-uppercase" type="text" name="gst_number"    value="" id="gst_number" placeholder="GST Number">
                                </div>
                            </div>


                                
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="business_sub_category_id" >Business Category <span class="required">*</span></label>
                                        <select id="business_categories_sub" class="form-control single-select" name="business_sub_category_id" type="text"  required="">
                                            <option value="">-- Select --</option>
                                            <?php  
                                            /*if(isset($_SESSION['business_sub_category_id'])){
                                              $q3=$d->select("business_sub_categories"," business_category_id = '$_SESSION[business_category_id]' ","");
                                          } else {*/


                                            $q3=$d->select("business_sub_categories,business_categories"," business_categories.business_category_id= business_sub_categories.business_category_id  "," order by business_categories.category_name asc");
                                        //}

                                        while ($blockRow=mysqli_fetch_array($q3)) {
                                            ?>
                                            <option <?php if(isset($_SESSION['business_sub_category_id']) && $_SESSION['business_sub_category_id'] == $blockRow['business_sub_category_id'].":".$blockRow['business_category_id'] ){ echo 'selected'; }?>      value="<?php echo $blockRow['business_sub_category_id'].":".$blockRow['business_category_id'];?>"><?php echo $blockRow['sub_category_name']." - ".$blockRow['category_name'];?></option>
                                        <?php }   ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="company_website" >Website</label>
                                    <input placeholder="Website"  class="form-control" id="company_website" name="company_website"  maxlength="100" value="<?php if(isset($_SESSION['company_website'])){ echo $_SESSION['company_website'];}?>" type="url">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="company_logo" >Company Logo</label>
                                    <input accept="image/*" class="form-control-file border photoOnly" id="company_logo" name="company_logo" type="file">

                                    <input class="form-control" name="company_logo_old" type="hidden" value="<?php if(isset($_SESSION['company_logo'])){ echo $_SESSION['company_logo'];}?>">
                                </div>
                            </div>

                        </div>

                    </div>
                </div>


                <div class="col-md-6 col-sm-12 order-md-2   text-md-left">
                    <div class="contact-meta pl-0 pl-sm-5 wow fadeInRight" data-wow-delay="300ms">

                        <div class="my-3">

                            <div class="heading-title heading_small">
                                <h3 class="darkcolor font-normal">Address Details</h3>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="adress" >Address <span class="required">*</span> </label>
                                    <input  type="hidden" class="form-control" id="lat" name="latitude"  placeholder="Lattitude"  value="23.0242625">
                                    <input  type="hidden" class="form-control" id="lng"  name="longitude"  placeholder="Longitude" value="72.5720625">
                                    <textarea  maxlength="250" required="" class="form-control" id="adress" name="adress" rows="3"><?php if(isset($_SESSION['adress'])   ){ echo $_SESSION['adress']; }?></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="country_id" >Country <span class="required">*</span></label>
                                    <select type="text" required="" id="country_id" onchange="getStates();" class="form-control single-select" name="country_id">
                                        <option value="">-- Select --</option>
                                        <?php
                                        $q3=$d->select("countries","flag=1","");
                                        while ($blockRow=mysqli_fetch_array($q3)) {
                                            ?>
                                            <option <?php if(  isset($_SESSION['country_id']) && $_SESSION['country_id']==$blockRow['country_id']) {echo "selected";} ?> value="<?php echo $blockRow['country_id'];?>"><?php echo $blockRow['country_name'];?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="state_id" >State <span class="required">*</span></label>

                                    <?php  if(isset($_SESSION['country_id'])) { ?>
                                      <select type="text" onchange="getCity();"  required="" class="form-control single-select" id="state_id" name="state_id">
                                        <?php
                                        $q31=$d->select("states","country_id='$_SESSION[country_id]'","");
                                        while ($blockRow11=mysqli_fetch_array($q31)) {
                                         ?>
                                         <option <?php if( isset($_SESSION['state_id']) && $_SESSION['state_id']==$blockRow11['state_id']) {echo "selected";} ?> value="<?php echo $blockRow11['state_id'];?>"><?php echo $blockRow11['state_name'];?></option>
                                     <?php }  ?>
                                 </select>
                             <?php } else { ?>


                                <select type="text" onchange="getCity();"  required="" class="form-control single-select" id="state_id" name="state_id">
                                    <option value="">-- Select --</option>
                                </select>

                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <label for="city_id" >City <span class="required">*</span></label>

                            <?php  if(isset($_SESSION['state_id'])) { ?>
                              <select type="text" onchange="getArea();"  required="" class="form-control single-select" id="city_id" name="city_id">
                                <?php
                                $q34=$d->select("cities","state_id='$_SESSION[state_id]'","");
                                while ($blockRow12=mysqli_fetch_array($q34)) {
                                 ?>
                                 <option <?php if( isset($_SESSION['city_id']) && $_SESSION['city_id']==$blockRow12['city_id']) {echo "selected";} ?> value="<?php echo $blockRow12['city_id'];?>"><?php echo $blockRow12['city_name'];?></option>
                             <?php }  ?>
                         </select>
                     <?php } else { ?>

                        <select  type="text" onchange="getArea();" required="" class="form-control single-select" name="city_id" id="city_id">
                            <option value="">-- Select --</option>

                        </select>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="form-group">
                    <label for="area_id" >Area <span class="required">*</span></label>


                    <?php  if(isset($_SESSION['city_id'])) { ?>
                      <select type="text"  onchange="getLatLong();" required="" class="form-control single-select" id="area_id" name="area_id">
                        <?php
                        $q34=$d->select("area_master","city_id='$_SESSION[city_id]'","");
                        while ($blockRow12=mysqli_fetch_array($q34)) {
                         ?>
                         <option <?php if( isset($_SESSION['area_id']) && $_SESSION['area_id']==$blockRow12['area_id']) {echo "selected";} ?> value="<?php echo $blockRow12['area_id'];?>"><?php echo $blockRow12['area_name'];?></option>
                     <?php }  ?>
                 </select>
             <?php } else { ?>
                <select  type="text" onchange="getLatLong();" required="" class="form-control single-select" name="area_id" id="area_id">
                    <option value="">-- Select --</option>

                </select>

            <?php } ?>
        </div>
    </div>
    <div class="col-md-12 col-sm-12">
        <div class="form-group">
            <label for="pincode" >Pincode <span class="required">*</span></label>
            <input type="text" id="pincode" maxlength="6" value="<?php  if(isset($_SESSION['pincode'])) {echo $_SESSION['pincode']; }?>" required="" class="form-control onlyNumber" name="pincode" id="pincode" placeholder="pincode" >
        </div>
    </div>

    <div class="col-md-12 col-sm-12">
        <div class="form-group">
            <label for="area_id" >Set Google Map Marker <span class="required">*</span></label>

            <input id="searchInput5" class="form-control" type="text" placeholder="Serach a Google location" >
            <div class="map" id="map" style="width: 100%; height: 400px;"></div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12">
        <div class="form-group">
            <label for="area_id" >Set Google Map Marker <span class="required">*</span></label>

            <input id="searchInput5" class="form-control" type="text" placeholder="Serach a Google location" >
            <div class="map" id="map" style="width: 100%; height: 400px;"></div>
        </div>
    </div>
    <input type="hidden" name="addNewMembertxt" value="addNewMembertxt">
    <div class="col-md-12 col-sm-12">
        <button type="button" id="addNewMember" name="addNewMember" class="button gradient-btn w-100" >Pay & Register </button>
    </div>
</div>

</div>
</div>
<?php //new?>

</div>
</form>
</div>
</div>
</section>
<!--Blog ends-->
<?php 
include("common/front_footer.php");
 ?>