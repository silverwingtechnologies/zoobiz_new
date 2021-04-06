<?php 
error_reporting(0);
include_once '../zooAdmin/lib/dao.php';
include '../zooAdmin/lib/model.php';
$d = new dao();
$m = new model();
extract(array_map("test_input" , $_POST)); 

/* $q=$d->select("users_master","user_mobile='$user_mobile'");
$data=mysqli_fetch_array($q);
if ($data>0) {
     $_SESSION['msg1']="Mobile number alerady registered in Zoobiz Account";
     $data['display_currency']  = "";
    $data['display_amount']    = "";
    $json = json_encode($data);
    echo $json;exit;
        
} 
*/



 
 $q=$d->select("package_master","package_id='$plan_id'","");
    $row1=mysqli_fetch_array($q);

    //9oct2020
    //3nov 2020
    $package_amount_new = $row1["package_amount"];
    if(isset($coupon_code) && $coupon_code !=''){
        $coupon_master=$d->select("coupon_master, package_master","  package_master.package_id =coupon_master.plan_id and  coupon_master.coupon_code ='$coupon_code' and coupon_master.coupon_status = 0    ","");
        if(mysqli_num_rows($coupon_master)  > 0    ){
               $coupon_master_data=mysqli_fetch_array($coupon_master); 
               $package_amount_new= $coupon_master_data['package_amount'];

               
                if($coupon_master_data['coupon_amount'] > 0){
                    $package_amount_new = ($coupon_master_data['package_amount'] - $coupon_master_data['coupon_amount']);
                } else if($coupon_master_data['coupon_per'] > 0){
                    $per_dis = ( ($coupon_master_data['package_amount']*$coupon_master_data['coupon_per'])/100 );
                   $package_amount_new = ($coupon_master_data['package_amount'] - $per_dis);
                }
            }
    }
    //3nov2020

     if($row1['gst_slab_id'] !="0"){
      $gst_slab_id = $row1['gst_slab_id'];
           $gst_master=$d->select("gst_master","slab_id = '$gst_slab_id'","");
           $gst_master_data=mysqli_fetch_array($gst_master);
           $slab_percentage= $gst_master_data['slab_percentage'] ;
           $gst_amount= (($package_amount_new*$slab_percentage) /100);

    } else {
            $gst_amount= 0 ;
    }
    // $package_amount=number_format($row1["package_amount"]+$gst_amount,2,'.','');
      //9oct2020


 // find gst_amount
//$gst_amount= $row1["package_amount"]*18 /100;

//3nov 2020
//$package_amount=number_format($row1["package_amount"]+$gst_amount,2,'.','');
    
if($package_amount_new <1 && $package_amount_new > 0 ){
            //because razorpay do not accept payment less then 1 rs.
            $package_amount_new =1;
            $gst_amount= 0 ; 
         }
    $package_amount=number_format($package_amount_new+$gst_amount,2,'.','');


require('../razorpay_config.php');
require('../razorpay-php/Razorpay.php');
session_start();

// Create the Razorpay Order

use Razorpay\Api\Api;

$api = new Api($keyId, $keySecret);

//
// We create an razorpay order using orders api
// Docs: https://docs.razorpay.com/docs/orders
//
$orderData = [
    'receipt'         => 3456,
    'amount'          => $package_amount * 100, // 2000 rupees in paise
    'currency'        => $displayCurrency, //'INR',
    'payment_capture' => 1 // auto capture
];

$razorpayOrder = $api->order->create($orderData);
$razorpayOrderId = $razorpayOrder['id'];

$_SESSION['razorpay_order_id'] = $razorpayOrderId;

$displayAmount = $amount = $orderData['amount'];

if ($displayCurrency !== 'INR')
{
    $url = "https://zoobiz.in/img/zoobizLogo.png";
    $exchange = json_decode(file_get_contents($url), true);

    $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
}

/*$checkout = 'automatic';

if (isset($_GET['checkout']) and in_array($_GET['checkout'], ['automatic', 'manual'], true))
{
    $checkout = $_GET['checkout'];
}*/

$data = [
    "key"               => $keyId,
    "amount"            => $amount,
    "name"              => $user_first_name." ".$user_last_name,
    "description"       => $row1['package_name'],
    "image"             => "https://zoobiz.in/img/zoobizLogo.png",
    "prefill"           => [
    "name"              => "Zoo Biz",
    "email"             => $user_email,
    "contact"           => $user_mobile,
    ],
    "notes"             => [
    "address"           => "101, Parshwa Tower, Above Kotak Mahindra Bank,Bodakdev, Ahmedabad,India(380054)",
    "merchant_order_id" => "rzp_live_TaSD2HoRfw1kpa",
    ],
    "theme"             => [
    "color"             => "#1B99F8"
    ],
    "order_id"          => $razorpayOrderId,
];

if ($displayCurrency !== 'INR')
{
    $data['display_currency']  = $displayCurrency;
    $data['display_amount']    = $displayAmount;
}

$json = json_encode($data);
 echo $json;exit;
?>
<script>
// Checkout details as a json

 
</script>
<?php 
//require("checkout/{$checkout}.php");



?>