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
                            <a href='mailto:contact@zoobiz.in' class="nav-link active pagescroll text-lowercase" style="color: #2abcaa !important;" href="#">  <!-- <button type="submit" id="submit_btn1" class="button gradient-btn w-60"> contact@zoobiz.com</button> --> <i class="fas fa-envelope"></i> <b>contact@zoobiz.in</b></a>
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
        <h3>CANCELLATION POLICY</h3>
        <hr>
        <p>
             Upon termination of your Account, your right to participate in the Website, including, but not limited to, your right to offer or purchase Services and your right to receive any fees or compensation, including, without limitation, referral discounts, incentive bonuses, or other special offer rewards, shall automatically terminate. You acknowledge and agree that your right to receive any fees or compensation hereunder is conditional upon your proper use of the Website, your adherence to the Terms of Use, the continuous activation of your Account, and your permitted participation in the Website. In the event of Termination of Service, your Account will be disabled and you may not be granted access to your Account or any files or other data contained in your Account. Notwithstanding the foregoing, residual data may remain in the ZooBiz system.
         </p>
         <p>
             Unless ZooBiz India Pvt. Ltd. has previously cancelled or terminated your use of the Website (in which case subsequent notice by ZooBiz India Pvt. Ltd. shall not be required), if you provided a valid email address during registration, ZooBiz India Pvt. Ltd. will notify you via email of any such termination or cancellation, which shall be effective immediately upon ZooBiz India Pvt. Ltd.’s delivery of such notice.
         </p>
         <p>You agree to indemnify and hold ZooBiz India Pvt. Ltd., and its officers, managers, members, affiliates, successor, assigns, directors, agents, service professionals, suppliers, and employees harmless from any claim or demand, including reasonable attorneys’ fees and court costs, made by any third party due to or arising out of the Termination of Service.</p>
    </div>
</section>
<!--Some Feature ends-->

<?php 
include("common/front_footer.php");
 ?>