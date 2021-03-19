	<?php
	include_once 'lib.php';
	if (isset($_POST) && !empty($_POST)) {
		if ($key == $keydb) {
			$response = array();
			extract(array_map("test_input", $_POST));
			$today = date('Y-m-d');
			if (isset($couponCodeValidity) && $couponCodeValidity == 'couponCodeValidity' && isset($coupon_code)  ) {
				
				if(isset($coupon_code) && $coupon_code !=''){
					$coupon_code = addslashes($coupon_code);

					$coupon_master=$d->select("coupon_master"," coupon_code ='$coupon_code' and coupon_status = 0   ","");
					if(mysqli_num_rows($coupon_master)  > 0    ){
						
						$coupon_master_data=mysqli_fetch_array($coupon_master);
						
						if( $coupon_master_data['cpn_expiry'] == 1){
							$today= date("Y-m-d");
							$dateExpire=$d->count_data_direct("coupon_id","coupon_master"," coupon_code ='$coupon_code' and coupon_status = 0  and '$today' between start_date and end_date   ","");

							if($dateExpire    ){
								$response["message"] = "Valid Coupon Code.";
								$response["validity"] = "1";
								$response["status"] = "200";
								echo json_encode($response);
							} else {
								$response["message"] = "Coupon Expired";
								$response["validity"] = "0";
								$response["status"] = "201";
								echo json_encode($response);
							}
						} else 


						if( $coupon_master_data['is_unlimited'] == 0 ){
							$coupon_id =  $coupon_master_data['coupon_id'];
							
							$alreadyUsedCounter=$d->count_data_direct("coupon_id","transection_master","  coupon_id= '$coupon_id' ","");
							
							
							if(($alreadyUsedCounter+1) <= $coupon_master_data['coupon_limit']    ){
								$response["coupon_code"] = $coupon_master_data['coupon_code'];
								$response["coupon_id"] = $coupon_master_data['coupon_id'];
								$response["message"] = "Valid Coupon Code.";
								$response["validity"] = "1";
								$response["status"] = "200";
								echo json_encode($response);

							} else {
								$response["message"] = "Coupon Limit Exceeded";
								$response["validity"] = "0";
								$response["status"] = "201";
								echo json_encode($response);
								
							}
						} else {
							$response["coupon_code"] = $coupon_master_data['coupon_code'];
							$response["coupon_id"] = $coupon_master_data['coupon_id'];
							$response["message"] = "Valid Coupon Code.";
							$response["validity"] = "1";
							$response["status"] = "200";
							echo json_encode($response);
							
						}
					} else {
						$response["message"] = "Invalid Coupon Code";
						$response["validity"] = "0";
						$response["status"] = "201";
						echo json_encode($response);

					}
				} else {
					$response["message"] = "Invalid Coupon Code";
					$response["validity"] = "0";
					$response["status"] = "201";
					echo json_encode($response);

				}
				
			}     else {
				$response["message"] = "wrong tag.";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} else {
			$response["message"] = "wrong api key.";
			$response["status"] = "201";
			echo json_encode($response);
		}
	}
	?>