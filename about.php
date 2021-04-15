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
                            <a href='mailto:contact@zoobiz.in's class="nav-link active pagescroll text-lowercase" style="color: #2abcaa !important;" href="#">  <!-- <button type="submit" id="submit_btn1" class="button gradient-btn w-60"> contact@zoobiz.com</button> --> <i class="fas fa-envelope"></i> <b>contact@zoobiz.in</b></a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active pagescroll scrollupto" style="color: #2abcaa !important;" href="#"><i class="fas fa-phone"></i><b> +91 98252 93889</b></a>
                        </li>

                    </ul>
                <!-- <ul class="navbar-nav mx-auto ml-xl-auto mr-xl-0">
                    <li class="nav-item">
                        <a class="nav-link active pagescroll" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pagescroll scrollupto" href="#about">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pagescroll" href="#pricing">Plans</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pagescroll" href="#outTeam">Team</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pagescroll" href="#contact">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pagescroll"  data-toggle="modal" data-target="#login" href="#">Login</a>
                    </li>
                </ul> -->
            </div>
        </div>
        <!--side menu open button-->
        <!-- <a href="javascript:void(0)" class="d-inline-block sidemenu_btn" id="sidemenu_toggle">
            <span class="bg-dark"></span> <span class="bg-dark"></span> <span class="bg-dark"></span>
        </a> -->
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
                        <h2 class="font-xlight">About Us </h2>
                    </div>
                </li>
            </ul>
        </div>
        <!-- END REVOLUTION SLIDER -->
    </div>
</section>
<!--Main Slider ends -->
<section id="about" class="single-feature padding">
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-lg-6 col-md-12 col-sm-12 text-sm-left text-center wow fadeInLeft" data-wow-delay="300ms">
                <div class="heading-title mb-4">
                    <h2 class="darkcolor font-normal bottom30">Grow Your <span class="defaultcolor">Business </span> and <span class="defaultcolor">Connects</span> through Referrals </h2>
                </div>
                <div class="row">
                    <div class=" col-md-3 col-sm-3 mb-5 text-center">
                        <img width="80" src="img/connection.png" alt=""><br> <b>Geo Tagging of Businesses</b>
                    </div>
                    <div class=" col-md-3 col-sm-3 mb-5 text-center">
                        <img width="80" src="img/laptop.png" alt=""><br> <b>Android & IOS Connectivity </b>
                    </div>
                    <div class=" col-md-3 col-sm-3 mb-5 text-center">
                        <img width="80" src="img/chat.png" alt=""><br> <b>In App Messaenger </b>
                    </div>
                    <div class=" col-md-3 col-sm-3 mb-5 text-center">
                        <img width="80" src="img/shop.png" alt=""><br> <b> Virtual Store for Each Member </b>
                    </div>
                    <div class=" col-md-3 col-sm-3 mb-5 text-center">
                        <img width="80" src="img/social-media.png" alt=""><br> <b> "Follow Feature" for Partnering Categories</b>
                    </div>
                    <div class=" col-md-3 col-sm-3 mb-5 text-center">
                        <img width="80" src="img/arrowsNew.png" alt=""><br> <b> Classified for Business Requirements</b>
                    </div>
                    <div class=" col-md-3 col-sm-3 mb-5 text-center">
                        <img width="80" src="img/timeline.png" alt=""><br> <b> Unique Member Timeline</b>
                    </div>
                    <div class=" col-md-3 col-sm-3 mb-5 text-center">
                        <img width="80" src="img/maps-and-flags.png" alt=""><br> <b> Location Based Business Search</b>
                    </div>

                  <!--  <div class=" col-md-4 col-sm-4 text-center">
                       <b>And much more</b>
                   </div> -->
               </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 text-justify wow fadeInRight" data-wow-delay="300ms">
                <h5>ZooBiz is an initiative by ZooBiz India Pvt. Ltd., an Indian company based in Ahmedabad, Gujarat. We provide a remote setup for business to interact with the right people to grow and move ahead. Growth, Technology, Connection are the pillars of this venture.</h5>
                <br>
                <h5>Our aim to connect Businesses and stimulate a growth environment for everyone. The idea behind the initiative is to bring service providers and users on the same platform across multiple categories and use referencing as a medium.</h5>
            </div>
            
        </div>
    </div>
</section>
<section id="bg-counters" class="padding bg-white">
    <div class="container">
        <div class="col-lg-12 row wow fadeInDown">
            <div class="quote-wrapper">
                <blockquote class="text">
                <p class="pt-4">To inspire healthier communities by connecting people and providing growth environment</p>
                <footer>Our Vision</footer>
                </blockquote>
            </div>
            <div class="quote-wrapper">
                <blockquote class="text" >
                <p class="pt-4">We wish to empower professional community through desirable business friendships that harvest quality business</p>
                <footer>Our Mission</footer>
                </blockquote>
            </div>
        </div>
    </div>
</section>
<?php 
include("common/front_footer.php");
 ?>