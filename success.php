<?php 
include("common/front_header.php");

 if (isset($_SESSION['cpn_success']) || isset($_SESSION['payment_id']) ) {

 } else {
  header("Location: register");
 }
            
 ?>                                <!-- header -->
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
                            <li class="nav-item">
                                <a class="nav-link " style="color: #2abcaa !important;" href="register">     <i class="fas fa-plus"></i> <b>Register in ZooBiz</b></a>
                            </li>
                            <?php //1july2020 ?>
                            <a href="mailto:contact@zoobiz.in" class="nav-link active pagescroll text-lowercase" style="color: #2abcaa !important;" href="#">  <!-- <button type="submit" id="submit_btn1" class="button gradient-btn w-60"> contact@zoobiz.com</button> --> <i class="fas fa-envelope"></i> <b>contact@zoobiz.in</b></a>
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
                            <h2 class="font-xlight">Register Success</h2>
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
<!--Main Slider ends -->
<!--Some Feature -->

<!--Some Feature ends-->
<!-- WOrk Process-->

<!--WOrk Process ends-->
<!-- Mobile Apps -->

<!--Mobile Apps ends-->
<!-- Counters -->

<!-- Counters ends-->
<!-- Our Team-->

<!--Pricing Start-->

       
        <section class="bglight pt-2" id="contact">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="heading-title darkcolor wow fadeInUp" data-wow-delay="100ms">
                            <h2 class="font-normal darkcolor heading_space_half">  <?php

                             echo "Thank you for registration, Your account successfully created !";
         ?> </h2>
            <?php  if (isset($_SESSION['cpn_success'])  ) {
             echo $_SESSION['cpn_success'];

             if (isset($_SESSION['cpn_success_status']) && $_SESSION['cpn_success_status'] == 2 ) {
             echo $_SESSION['payment_id'];
            }


            } else  if (isset($_SESSION['payment_id'])) {
             echo $_SESSION['payment_id'];
            }
              ?>
            <!-- <h3 class="font-normal darkcolor heading_space_half">Thank you for registration</h3> -->
            <h3 class="font-normal darkcolor heading_space_half">Scan and download ZooBiz mobile app</h3>
             <img   style="width: 150px !important;"  src="img/qr-code-android.png" alt="logo" class="logo-scrolled">

             <img    style="width: 150px !important;"  src="img/qr-code-apple.png" alt="logo" class="logo-scrolled">
             <br>
             <a target="_blank" style="width: 150px !important;" href="https://play.google.com/store/apps/details?id=com.silverwing.zoobiz" class="btn btn-info shadow-success waves-effect waves-light m-1"><i class="fa fa-download mr-1"></i>   Android App</a>
              <a target="_blank" style="width: 150px !important;" href="https://apps.apple.com/us/app/zoobiz/id1550560836" class="btn btn-info shadow-success waves-effect waves-light m-1"><i class="fa fa-download mr-1"></i>  iOS App</a>
                        </div>
                        
                    </div>
                </div>
                 
</div>
</div>
</section>
<!--Blog ends-->
<?php 
include("common/front_footer.php");
 ?>