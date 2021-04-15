<?php
 
require_once("frontObjectController.php");
 
/*
- Use PAYTM_ENVIRONMENT as 'PROD' if you wanted to do transaction in production environment else 'TEST' for doing transaction in testing environment.
- Change the value of PAYTM_MERCHANT_KEY constant with details received from Paytm.
- Change the value of PAYTM_MERCHANT_MID constant with details received from Paytm.
- Change the value of PAYTM_MERCHANT_WEBSITE constant with details received from Paytm.
- Above details will be different for testing and production environment.
*/


if(isset($city_id)){
 $company_master_qry=$d->select("company_master"," city_id ='$city_id' and is_master = 0  ","");
 if (mysqli_num_rows($company_master_qry) > 0 ) {
    $company_master_data=mysqli_fetch_array($company_master_qry);
    $company_id = $company_master_data['company_id'];
} else {
    $company_id = 1;
}

} else {
	$ORDERID = $_POST['ORDERID'];
	$users_master_temp=$d->select("users_master_temp"," tracking_id ='$ORDERID'  ","");
	 if (mysqli_num_rows($users_master_temp) > 0 ) {
	    $users_master_temp_data=mysqli_fetch_array($users_master_temp);
	    $company_id = $users_master_temp_data['company_id'];
	} else {
	    $company_id = 1;
	}
}
 
$payment_getway_master_qry=$d->select("payment_getway_master,currency_master"," payment_getway_master.company_id ='$company_id' AND payment_getway_master.currency_id=currency_master.currency_id    ","");
 if (mysqli_num_rows($payment_getway_master_qry) > 0 ) {
    $payment_getway_master_data=mysqli_fetch_array($payment_getway_master_qry);


if($payment_getway_master_data['paytm_is_live_mode']=="Yes"){


    define('PAYTM_ENVIRONMENT', 'PROD'); // PROD
    define('PAYTM_MERCHANT_KEY', $payment_getway_master_data['paytm_merrchant_key']); //Change this constant's value with Merchant key received from Paytm.
define('PAYTM_MERCHANT_MID', $payment_getway_master_data['paytm_merchant_id']); //Change this constant's value with MID (Merchant ID) received from Paytm.
define('PAYTM_MERCHANT_WEBSITE', 'DEFAULT'); //Change this constant's value with Website name received from Paytm.

$PAYTM_STATUS_QUERY_NEW_URL='https://securegw.paytm.in/merchant-status/getTxnStatus';
$PAYTM_TXN_URL='https://securegw.paytm.in/theia/processTransaction';
if (PAYTM_ENVIRONMENT == 'PROD') {
	$PAYTM_STATUS_QUERY_NEW_URL='https://securegw.paytm.in/merchant-status/getTxnStatus';
	$PAYTM_TXN_URL='https://securegw.paytm.in/theia/processTransaction';
}

define('PAYTM_REFUND_URL', '');
define('PAYTM_STATUS_QUERY_URL', $PAYTM_STATUS_QUERY_NEW_URL);
define('PAYTM_STATUS_QUERY_NEW_URL', $PAYTM_STATUS_QUERY_NEW_URL);
define('PAYTM_TXN_URL', $PAYTM_TXN_URL); 
} else {
	 define('PAYTM_ENVIRONMENT', 'TEST');
	 define('PAYTM_MERCHANT_KEY', 'uleXzi93011594497165'); //Change this constant's value with Merchant key received from Paytm.
	 define('PAYTM_MERCHANT_MID', '7QqMczMERrqdeb2c'); //Change this constant's value with MID (Merchant ID) received from Paytm.
	 define('PAYTM_MERCHANT_WEBSITE', 'WEBSTAGING'); //Change this constant's value with Website name received from Paytm.
	  

	  $PAYTM_STATUS_QUERY_NEW_URL='https://securegw-stage.paytm.in/merchant-status/getTxnStatus';
$PAYTM_TXN_URL='https://securegw-stage.paytm.in/theia/processTransaction';
if (PAYTM_ENVIRONMENT == 'PROD') {
	$PAYTM_STATUS_QUERY_NEW_URL='https://securegw.paytm.in/merchant-status/getTxnStatus';
	$PAYTM_TXN_URL='https://securegw.paytm.in/theia/processTransaction';
}

define('PAYTM_REFUND_URL', '');
define('PAYTM_STATUS_QUERY_URL', $PAYTM_STATUS_QUERY_NEW_URL);
define('PAYTM_STATUS_QUERY_NEW_URL', $PAYTM_STATUS_QUERY_NEW_URL);
define('PAYTM_TXN_URL', $PAYTM_TXN_URL); 
}




}

?>
