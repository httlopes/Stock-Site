<?php

    ini_set('date.timezone', 'Europe/London');
	$data = json_decode(file_get_contents("php://input"),true);
	$type = "".$data['t'];
	$amount = $data['a'];
	$information="";
	if(isset($data['i'])) $information = $data['i'];
	$wallet = $data['w'];
        $date_t = date("Y-m-d H:i:s");

	$config = parse_ini_file('../../config.ini'); 
	$connection = mysqli_connect('mysql13.000webhost.com',$config['username'],$config['password'],$config['dbname']);

	if($connection === false) {
		error_log(print_r(mysqli_error($connection),true));
	}else{
		mysqli_query($connection,"INSERT INTO statement (`amount`, `type`, `wallet_id`, `information`, `date`) 
					VALUES (".$amount.", '".$type."', ".$wallet.", '".$information."', '".$date_t."')") 
					or die(error_log(print_r(mysqli_error($connection),true)));
		
		/*Update wallet balance*/
		if(strcmp($type, "Lucro")===0){
			$query="UPDATE wallet SET `balance`=(`balance`+".$amount.") WHERE `id` =".$wallet;
			if ($connection->query($query) === TRUE) {
			    echo "Record updated successfully";
			} else {
			    error_log(" ".$connection->error);
			}		
		}else{
			$query="UPDATE wallet SET `balance`=(`balance`-".$amount.") WHERE `id` =".$wallet;
			if ($connection->query($query) === TRUE) {
			    echo "Record updated successfully";
			} else {
			    error_log(" ".$connection->error);
			}	
		}
		
	}
	mysqli_close($connection);

?>	