<?php
include 'frontObjectController.php';



 $url = "https://secure.ccavenue.com/transaction/getRSAKey";
//$url = "https://test.ccavenue.com/transaction/getRSAKey";
$fields = array(
        'access_code'=>$_REQUEST['access_code'],
        'order_id'=>$_REQUEST['order_id']
);

$postvars='';
$sep='';
foreach($fields as $key=>$value)
{
        $postvars.= $sep.urlencode($key).'='.urlencode($value);
        $sep='&';
}
 
 //https://asif.zoobiz.in/controller/GetRSA.php?access_code=AVGK04IC24AQ98KGQA&order_id=1615363326
$ch = curl_init();

curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_POST,count($fields));

curl_setopt($ch, CURLOPT_CAINFO, $base_url.'/controller/cacert.pem');
curl_setopt($ch,CURLOPT_POSTFIELDS,$postvars);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($ch);

echo $result;
?>
