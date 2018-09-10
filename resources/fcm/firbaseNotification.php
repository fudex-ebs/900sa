<?php 
class firbaseNotification{

	public function __construct() {

		// (Android)API access key from Google API's Console. // Server Key
		$this->API_ACCESS_KEY = "AAAASEvWZrg:APA91bG90mI2h3Rgi9gCOYlWoBUN6xri4gRMf0HfYO2YFRAYJvuBgO-y3wkb8EeRTb8po0t8tuDcRn1hnyVynahSPbUVBWculWz0G3CIaYWVAias2nXBqBMo_RKT5l1jTGGXmXxZcZxR";

	}
	
    public function android($data){
    	// Check mandatory data
		if (isset($data) && is_array($data) && !empty($data) &&
    		array_key_exists('message', $data) &&
    		array_key_exists('title', $data) &&
    		array_key_exists('data', $data) &&
    		array_key_exists('registrationIds', $data)
    		){

			// Prepare additional data
			$subtitle = '';
			if (array_key_exists('subtitle', $data)) $subtitle = $data['subtitle'];
			$tickerText = '';
			if (array_key_exists('tickerText', $data)) $tickerText = $data['tickerText'];
			$largeIcon = 'large_icon';
			if (array_key_exists('large_icon', $data)) $large_icon = $data['large_icon'];
			$smallIcon = 'small_icon';
			if (array_key_exists('small_icon', $data)) $small_icon = $data['small_icon'];

			$fields['to'] = $data['registrationIds'][0];

			$fields['notification'] = array(
				'title' => $data['title'],
				'body' => $data['message'],
				'subtitle' => $subtitle,
				'tickerText' => $tickerText,
				'vibrate' => 1,
				'sound' => 1,
				'largeIcon' => $largeIcon,
				'smallIcon' => $smallIcon,
				'priority' => 'high',
				'click_action' => 'FCM_PLUGIN_ACTIVITY',
                                'data' => $data['data']
			);

			if (is_array($data['data']) && !empty($data['data'])){
				$fields['data'] = $data['data'];
			}

                        $fields['priority'] = "high";
			$headers = array(
				'Authorization: key=' . $this->API_ACCESS_KEY,
				'Content-Type: application/json'
			);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields,JSON_FORCE_OBJECT));
			$result = curl_exec($ch);
			echo $result;
			curl_close($ch);
    	}
    }

}
?>
