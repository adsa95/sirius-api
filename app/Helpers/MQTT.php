<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use App\Libraries\phpMQTT;

class MQTT{
	static function send($message){
		$conn = new phpMQTT($_ENV['MQTT_HOST'], $_ENV['MQTT_PORT'], uniqid()); //use uniqid to get a unique connection name
		if($conn->connect()){
			$conn->publish('sirius', $message);
			$conn->close();

			Log::debug('Sent message to sirius-server: '.$message);

			return true;
		}else{
			return false;
		}

	}
}