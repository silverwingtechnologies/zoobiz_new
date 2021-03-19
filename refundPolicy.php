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
                            <!-- <li class="nav-item">
                                <a class="nav-link " style="color: #2abcaa !important;" href="register">     <i class="fas fa-plus"></i> <b>Register in ZooBiz</b></a>
                            </li> -->
                            <?php //1july2020 ?>
                            <a class="nav-link active pagescroll text-lowercase" style="color: #2abcaa !important;" href="#">  <!-- <button type="submit" id="submit_btn1" class="button gradient-btn w-60"> contact@zoobiz.com</button> --> <i class="fas fa-envelope"></i> <b>contact@zoobiz.in</b></a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active pagescroll scrollupto" style="color: #2abcaa !important;" href="#"><i class="fas fa-phone"></i><b> +91 98252 93889</b></a>
                        </li>

                    </ul>
            </div>
        </div>
    </nav>
<!-- header -->
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
                        <h2 class="font-xlight">Refund Policy</h2>
                    </div>
                </li>
            </ul>
        </div>
        <!-- END REVOLUTION SLIDER -->
    </div>
</section>
<!--Main Slider ends -->
<!--Some Feature -->
<section id="about" class="single-feature mt-4">
    <div class="container">
        <h3>REFUND POLICY</h3>
        <hr>
        <!-- <p>When you enroll with us, you have an opportunity to review and accept the fees that will be charged. Prices, availability, and other purchase terms are subject to change. ZooBiz reserves the right without prior notice to discontinue or change specifications and prices on services offered on and outside of the ZooBiz Site without incurring any obligation to you. All fees may be subject to taxes.</p>
        <p>We offer a full money-back guarantee, excluding the payment gateway fees incurred, for all purchases made on our website. If you are not satisfied with the product that you have purchased from us, you can get your money back no questions asked. You are eligible for a full reimbursement within 10 calendar days of your purchase.</p>
        <p>After the 10-day period you will no longer be eligible and won't be able to receive a refund. We encourage our customers to try the service in the first week after their purchase to ensure it fits your needs.<b>If you have any additional questions or would like to request a refund, feel free to contact us.</b></p> -->
        <b>All sales on ZooBiz are final and non-refundable.</b> <br>

        Refunds will be made in cases of technical issues while making payments or double payments happened due to error on payment gateway site.</p>
        <p>Support team of ZooBiz India Pvt. Ltd will evaluate and make refunds in special cases on user request. For this user will have to send email describing reason for refund request, Support team will evaluate the request and make partial/full refund if issue described is geniune. The Support team will have final authority in taking such decisions. </p>
    </div>
</section>
<!--Some Feature ends-->

<?php 
include("common/front_footer.php");
 ?>