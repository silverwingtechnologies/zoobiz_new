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
                        <h2 class="font-xlight">Terms & Conditions </h2>
                    </div>
                   <!--  <div class="tp-caption tp-resizeme z-index-15"
                         data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']"
                         data-y="['middle','middle','middle','middle']" data-voffset="['-70','-70','-70','-70']"
                         data-whitespace="nowrap" data-responsive_offset="on"
                         data-width="['none','none','none','none']" data-type="text"
                         data-textalign="['center','center','center','center']"
                         data-transform_idle="o:1;"
                         data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power4.easeInOut;"
                         data-transform_out="s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;"
                         data-start="900" data-splitin="none" data-splitout="none">
                        <h2 class="font-bold">Business Networking</h2>
                    </div> -->
                   <!--  <div class="tp-caption tp-resizeme z-index-15"
                         data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']"
                         data-y="['middle','middle','middle','middle']" data-voffset="['0','0','0','0']"
                         data-whitespace="nowrap" data-responsive_offset="on"
                         data-width="['none','none','none','none']" data-type="text"
                         data-textalign="['center','center','center','center']" data-fontsize="['24','24','20','20']"
                         data-transform_idle="o:1;"
                         data-transform_in="z:0;rX:0deg;rY:0;rZ:0;sX:2;sY:2;skX:0;skY:0;opacity:0;s:1000;e:Power2.easeOut;"
                         data-transform_out="s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;"
                         data-mask_in="x:0px;y:0px;s:inherit;e:inherit;"
                         data-start="1600" data-splitin="none" data-splitout="none">
                        <p class="font-light">Need Content 1</p>
                    </div> -->
                    <!-- <div class="tp-caption tp-resizeme z-index-15"
                         data-x="['center','center','center','center']" data-hoffset="['-20','-20','-20','-20']"
                         data-y="['middle','middle','middle','middle']" data-voffset="['100','100','110','110']"
                         data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:1500;e:Power4.easeInOut;" data-transform_out="s:900;e:Power2.easeInOut;s:900;e:Power2.easeInOut;" data-start="1800" data-splitin="none" data-splitout="none" data-responsive_offset="on">
                        <a class="transition-3 button btn-primary button-padding pagescroll font-13" href="#about">Register</a>
                    </div> -->
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
        <div class="mb-5">
            <h5>How ZooBiz India Pvt. Ltd. Uses the Information We Collect</h5>
            <hr>
            <p>We collect your personal information and aggregate information about the use of our Website and Services to better understand your needs and to provide you with a better Website experience. Specifically, we may use your personal information for any of the following reasons: </p>
            <ul>
                <li>• To provide our Services to you, including registering you for our Services, verifying your identity and authority to use our Services, and to otherwise enable you to use our Website and our Services</li>
                <li>• For customer support and to respond to your inquiries</li>
                <li>• For internal record-keeping purposes</li>
                <li>• To process billing and payments, including sharing details with third party payment gateways in connection with Website and/or products and Services</li>
                <li>• To improve and maintain our Website and our Services (for example, we track information entered through the “Search” function; this helps us determine which areas of our Website users like best and areas that we may want to enhance; we also will use for trouble-shooting purposes, where applicable)</li>
                <li>• To periodically send promotional emails to the email address you provide regarding new products from ZooBiz India Pvt. Ltd., special offers from ZooBiz India Pvt. Ltd. or other information about ZooBiz India Pvt. Ltd. that we think you may find interesting</li>
                <li>• To contact you via email, telephone, facsimile or mail, or, where requested, by text message, to deliver certain services or information you have requested</li>
                <li>• For ZooBiz India Pvt. Ltd.’s market research purposes, including, but not limited to, the customization of the Website according to your interests</li>
                <li>• We may use your demographic information (i.e., age, postal code, residential and commercial addresses, and other various data) to more effectively facilitate the promotion of goods and services to appropriate target audiences and for other research and analytical purposes</li>
                <li>• To resolve disputes, to protect ourselves and other users of our Website and Services, and to enforce our Terms of Use</li>
                <li>• We also may compare personal information collected through the Website and Services to verify its accuracy with personal information collected from third parties and may combine aggregate data with the personal information we collect about you</li>
            </ul>
            <p>From time to time, ZooBiz India Pvt. Ltd. may use personal information for new and unanticipated uses not previously disclosed in our Privacy Policy. If our information practices change regarding information previously collected, ZooBiz India Pvt. Ltd. shall make reasonable efforts to provide notice and obtain consent of any such uses as may be required by law. </p>
        </div>
        <div class="mb-5">
            <h5>Security</h5>
            <hr>
            <p>We employ procedural and technological security measures, which are reasonably designed to help protect your personal information from unauthorized access or disclosure. ZooBiz India Pvt. Ltd. may use encryption, passwords, and physical security measures to help protect your personal information against unauthorized access and disclosure. No security measures, however, are 100% complete. Therefore, we do not promise and cannot guarantee, and thus you should not expect, that your personal information or private communications will not be collected and used by others. You should take steps to protect against unauthorized access to your password, phone, and computer by, among other things, signing off after using a shared computer, choosing a robust password that nobody else knows or can easily guess, and keeping your log-in and password private. ZooBiz India Pvt. Ltd. is not responsible for the unauthorized use of your information or for any lost, stolen, compromised passwords, or for any activity on your Account via unauthorized password activity.</p>
        </div>
        <div class="mb-5">
            <h5>Disclosure</h5>
            <hr>
            <p>We may share the information that we collect about you, including your personal information, as follows: </p>
            <p>INFORMATION DISCLOSED TO PROTECT US AND OTHERS</p>
            <p>We may disclose your information including Personal Information if: (i) ZooBiz India Pvt. Ltd. reasonably believes that disclosure is necessary in order to comply with a legal process (such as a court order, search warrant, etc.) or other legal requirement of any governmental authority, (ii) disclosure would potentially mitigate our liability in an actual or potential lawsuit, (iii) reasonably necessary to enforce this Privacy Policy, our Terms of Use etc. (iv) disclosure is intended to help investigate or prevent unauthorized transactions or other illegal activities, or (v) necessary or appropriate to protect our rights or property, or the rights or property of any person or entity. </p>
            <p>INFORMATION DISCLOSED TO THIRD PARTY SERVICE PROVIDERS AND BUSINESS PARTNERS</p>
            <p>We may contract with various third parties for the provision and maintenance of the Website, Services and our business operations, and ZooBiz India Pvt. Ltd. may need to share your personal information and data generated by cookies and aggregate information (collectively, “information”) with these vendors and service agencies. For example, we may provide your information to a credit card processing company to process your payment. The vendors and service agencies will not receive any right to use your personal information beyond what is necessary to perform its obligations to provide the Services to you. If you complete a survey, we also may share your information with the survey provider; if we offer a survey in conjunction with another entity, we also will disclose the results to that entity. </p>
            <p>DISCLOSURE TO NON-AFFILIATED THIRD PARTIES IN FURTHERANCE OF YOUR REQUEST</p>
            <p>Your request for services may be shared with third party websites with whom we have a contractual relationship in order to provide your request with maximum exposure. The post on the third party website will include the details of your request, including your location, and other contact details. Interested bidders, however, will be able to click on your request on such third party site, and will be directed to our Website where they will have access to your contact details (Partial or complete), as would any other service provider on our Website interested in bidding on your request. </p>
            <p>DISCLOSURE TO OTHER USERS OF OUR WEBSITE</p>
            <p>If you are a Service Provider, the information that you post (other than your payment information) is available to other users of our Website and our Services. Comments that users post to our Website also will be available to other visitors to our Website (see our discussion of User Generated Content below). In addition, we will post the results (in aggregate form) of surveys to our Website. If you are a Service User, name, and location, as well as the details of your request, may be available to all visitors to our Website. Service Providers also may be permitted to see the consumer’s full name, telephone number, email address and the -location </p>
            <p>INFORMATION DISCLOSED TO LAW ENFORCEMENT OR GOVERNMENT OFFICIALS</p>
            <p>We will disclose your information, including, without limitation, your name, city, state, telephone number, email address, user ID history, quoting and listing history, and fraud complaints, to law enforcement or other government officials if we are required to do so by law, regulation or other government authority or otherwise in cooperation with an investigation of a governmental authority.</p>
        </div>
        <div class="mb-5">
            <h5>Updating, Deleting and Correcting Your Personal Information</h5>
            <hr>
            <p>You can review, correct and delete your personal information by logging into the Website and navigating to your profile page in “Edit Profile.” You must promptly update your personal information if it changes or is inaccurate. Typically, we will not manually alter your personal information because it is very difficult to verify your identity remotely. Nonetheless, upon your request we will close your Account and remove your personal information from view as soon as reasonably possible based on your Account activity and in accordance with applicable law. We do retain information from closed Accounts in order to comply with the law, prevent fraud, collect any fees owed, resolve disputes, troubleshoot problems, assist with any investigations of any Registered User, enforce our Terms of Use, and take any other actions otherwise permitted by law that we deem necessary in our sole and absolute discretion. You should understand, however, that once you publicly post a Request, Offer, Want, Feedback, or any other information onto the Website, you may not be able to change or remove it. Once we have deleted or removed your Account, you agree that ZooBiz India Pvt. Ltd. shall not be responsible for any personal information that was not included within your deleted and/or removed Account that remains on the Website.</p>
        </div>
    </div>
</section>
<!--Some Feature ends-->

<?php 
include("common/front_footer.php");
 ?>