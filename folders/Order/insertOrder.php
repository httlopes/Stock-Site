<?php
        ini_set('date.timezone', 'Europe/London');
	$data = json_decode(file_get_contents("php://input"),true);
	$product = $data['p'];
	$color = $data['c'];
	$received = $data['r'];
	$spent = $data['s'];
	$wallet = $data['w'];
	$mobile = $data['m'];

	$config = parse_ini_file('../../config.ini'); 
	$connection = mysqli_connect('mysql13.000webhost.com',$config['username'],$config['password'],$config['dbname']);

	if($connection === false) {
		error_log(print_r(mysqli_error($connection),true));
	}else{
		if(!is_numeric($product)){
			mysqli_query($connection,"INSERT INTO product (`name`) VALUES ('".$product."')");
			$product=$connection->insert_id;
		}
		
		if(!is_numeric($color)){
			mysqli_query($connection,"INSERT INTO color (`colorType`) VALUES ('".$color."')");
			$color=$connection->insert_id;
		}

		if(!is_numeric($mobile)){
			mysqli_query($connection,"INSERT INTO mobile (`brand`) VALUES ('".$mobile."')");
			$mobile=$connection->insert_id;
		}
		
		$aux = date("Y-m-d H:i:s");
		mysqli_query($connection,"INSERT INTO orders (`product_id`, `color_id`, `received`, `spent`, `date`, `mobile_id`) 
					VALUES (".$product.", ".$color.", ".$received.", ".$spent.", '".$aux."', ".$mobile.")") 
					or die(error_log(print_r(mysqli_error($connection),true)));
		
		/*Update wallet balance*/
		$aux = $received - $spent;
		$query="UPDATE wallet SET `balance`=(`balance`+".$aux.") WHERE `id` =".$wallet;
		if ($connection->query($query) === TRUE) {
		    echo "Record updated successfully";
		} else {
		    error_log(" ".$connection->error);
		}		

		/*Insert statement*/
		$information="<b>Encomenda</b> de um(a) ";	
		$sql = "SELECT name FROM product WHERE id='{$product}'";
		$result = $connection->query($sql);
		$row = $result->fetch_assoc();
		$information.=$row['name']." para ";
		$sql = "SELECT brand FROM mobile WHERE id='{$mobile}'";
		$result = $connection->query($sql);
		$row = $result->fetch_assoc();
		$information.=$row['brand'];
                $aux = date("Y-m-d H:i:s");
		mysqli_query($connection,"INSERT INTO statement (`amount`, `type`, `wallet_id`, `information`, `date`) 
					VALUES (".$spent.", '', ".$wallet.", '".$information."', '".$aux."')") 
					or die(error_log(print_r(mysqli_error($connection),true)));

		
	}
	mysqli_close($connection);

?>	