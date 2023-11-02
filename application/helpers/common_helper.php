<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* Add new methods for Admin panel */
function checkTabActive($fun)
{	
	$ci = &get_instance();
	$f_name = $ci->router->fetch_method();
	//p($fun);
	if(in_array($f_name, $fun))		
  	{
  		return true;
  	}else
  	{
  		return false;
  	}
}

/* End */

if ( ! function_exists('send_mail'))

{

	function send_mail($message, $subject,$toemail)

	{          

	    $ci =&get_instance();

		$ci->load->library('email');

		$config['mailtype']='html';

		$ci->email->initialize($config);	

		$ci->email->from("doworkless@gmail.com",'Chalkboard');

		$ci->email->to($toemail);

		$ci->email->subject($subject);

        $ci->email->message($message);

        

		if($ci->email->send()) {	

			return true;

		} else {

			return false;

		}

	}

}

function send_smtp_old_mail($message, $subject, $email_address,$from)
{
    
    

	
	$mail = new PHPMailer;
	//$mail->SMTPDebug = true;
	$mail->isSMTP();                                   // Set mailer to use SMTP
	$mail->Host = 'smtp.gmail.com';                    // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                            // Enable SMTP authentication
	$mail->Username = 'doworkless@gmail.com';          // SMTP username
	$mail->Password = 'xsceotcmdilkjutr'; // SMTP password
	$mail->SMTPSecure = 'tls';                         // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 587;                                 // TCP port to connect to

	$mail->setFrom($from, 'Chalkboard');
	$mail->addReplyTo(ADMIN_EMAIL, 'Chalkboard');
	$mail->addAddress($email_address);
	$mail->isHTML(true);  // Set email format to HTML
	$mail->Subject = 'Order Chalkboard';
	$mail->Body    = $message;

	if(!$mail->send()) {
	    // echo 'Message could not be sent.';
	    // echo 'Mailer Error: ' . $mail->ErrorInfo;
	    return false;
	} else {
	    return true;
	}

}

function send_smtp_mail($message, $subject, $email_address,$from)
{
    
    

	

	$ci =&get_instance();

		$ci->load->library('email');

		$config['mailtype'] = 'html';
	    $config['charset'] = 'iso-8859-1';

		$ci->email->initialize($config);	

		$ci->email->from("doworkless@gmail.com",'Chalkboard');

		$ci->email->to($email_address);

		$ci->email->subject($subject);

        $ci->email->message($message);

        

		if($ci->email->send()) {	

			return true;

		} else {

			return false;

		}

}

function sendPushNotification($data,$reg_id,$userrole,$device_type) {

	//$apiKey = "AIzaSyAq5hgSOra5MtMMI0pLRcTlMfmfpx_F-Go"; // For Userrole 2

	if($userrole == 3)
	{
		$apiKey = "AIzaSyDrGKQXy0GNsnT5M3EnzAhtVRvuUJuc7oY";
	}
	else
	{
		$apiKey = "AIzaSyAq5hgSOra5MtMMI0pLRcTlMfmfpx_F-Go"; // For Userrole 2
	}

     // Set POST request body


	 if($device_type == 'ios')
     {
     	$post =  array(
                    //'to'  => $reg_id,
                    'registration_ids' => array($reg_id),
                     'notification' => $data,
                     	'data' => $data
                     );
     }
     if($device_type == 'android')
     {
     	$post =  array(
                    //'to'  => $reg_id,
                    'registration_ids' => array($reg_id),
                     'data' => $data
                     );
     }

     // Set CURL request headers 

    $headers = array( 

                        'Authorization: key=' . $apiKey,

                        'Content-Type: application/json'

                    );

    //return "thanks";



    // Initialize curl handle       

    $ch = curl_init();



    // Set URL to GCM push endpoint     

    //curl_setopt($ch, CURLOPT_URL, 'https://gcm-http.googleapis.com/gcm/send');



    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');



    // Set request method to POST       

    curl_setopt($ch, CURLOPT_POST, true);



    // Set custom request headers       

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);



    // Get the response back as string instead of printing it       

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);



    // Set JSON post data

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    // Actually send the request    
    $err = curl_error($ch);
    $result = curl_exec($ch);
    curl_close($ch);

    if($result == false)
  	{
  		return $error = json_decode($err,true);
  	}

  	return $result;
}




if(!function_exists('p')) {

	function p($array) {

		echo '<pre>';

		print_r($array);

		echo '</pre>';

	}

}



if(!function_exists('check_required_value')) {

	function check_required_value($chk_params, $converted_array) {

        foreach ($chk_params as $param) {

            if (array_key_exists($param, $converted_array) && ($converted_array[$param] != '')) {

                $check_error = 0;

            } else {

                $check_error = array('check_error' => 1, 'param' => $param);

                break;

            }

        }

        return $check_error;

	}

}


function getpagename($page_name)
{
	$ci =&get_instance();
	$data = $ci->common_model->getSingleData("page_management",array("page_name" => $page_name));
	return $data;
}

function getpageValue($page_name)
{
	$ci =&get_instance();
	$optdata = $ci->common_model->getWhereData("page_management",array("page_name" => $page_name));
	//$opt = (!empty($optdata))? $optdata["opt_value"] : "";
	return $optdata;
}



if(!function_exists('send_apn_notification')) {

	function send_apn_notification($deviceToken, $message) {

		//$deviceToken = '5c96f8747d856c8c938a71a17802aea963a19f0a36b3916f054ec833534b2e50';



		// Put your private key's passphrase here:

		$passphrase = '123456';



		$ctx = stream_context_create();

		stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');

		stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);



		// Open a connection to the APNS server

		$fp = stream_socket_client(APNS_GATEWAY_URL, $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);



		if (!$fp) {

			log_message('apn_debug',"APN: Maybe some errors: $err: $errstr");

			//exit("Failed to connect: $err $errstr" . PHP_EOL);

		} else {

			log_message('apn_debug',"Connected to APNS");

			//echo 'Connected to APNS' . PHP_EOL;

		}



		// Create the payload body

		$body['aps'] = array(

			'alert' => $message,

			'sound' => 'default'

			);



		// Encode the payload as JSON

		$payload = json_encode($body);



		// Build the binary notification

		$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;



		// Send it to the server

		$result = fwrite($fp, $msg, strlen($msg));



		if (!$result) {

			log_message('apn_send_debug',"APN: Message not delivered");

			//echo 'Message not delivered' . PHP_EOL;

		} else {

			log_message('apn_send_debug',"APN: Message successfully delivered");

			//echo 'Message successfully delivered' . PHP_EOL;

		}



		// Close the connection to the server

		fclose($fp);

	}

}



if(!function_exists('send_apn_notification_old')) {

	function send_apn_notification_old()

	{	

		$ci =&get_instance();

	    $ci->load->library('apn');

	    $ci->apn->payloadMethod = 'enhance'; // you can turn on this method for debuggin purpose

	    $ci->apn->connectToPush();

	    $device_token = '5c96f8747d856c8c938a71a17802aea963a19f0a36b3916f054ec833534b2e50';

	    /* My access Token */

	    //$device_token = '232b43ca4c5926a1ad9f255f80a3c6cfe9a650c9c5bf9455290d9bd79bcebf03';



	    // adding custom variables to the notification

	    $ci->apn->setData(array( 'someKey' => true ));



	    $send_result = $ci->apn->sendMessage($device_token, 'Test Message', /*badge*/ 2, /*sound*/ 'default');



	    if($send_result)

	        log_message('debug','Sending successful');

	    else

	        log_message('error',$ci->apn->error);





	    $ci->apn->disconnectPush();

	}

}



if(!function_exists('apn_feedback')) {

	// designed for retreiving devices, on which app not installed anymore

	function apn_feedback()

	{	

		$ci =&get_instance();

	    $ci->load->library('apn');



	    $unactive = $ci->apn->getFeedbackTokens();



	    if (!count($unactive))

	    {

	        log_message('info','Feedback: No devices found. Stopping.');

	        return false;

	    }



	    foreach($unactive as $u)

	    {

	        $devices_tokens[] = $u['devtoken'];

	    }

	    //p($unactive);

	}

}



if(!function_exists('send_gcm_notification')) {

	function send_gcm_notification() {

		$ci =&get_instance();

		// simple loading

    	// note: you have to specify API key in config before

        $ci->load->library('gcm');



	    // simple adding message. You can also add message in the data,

	    // but if you specified it with setMesage() already

	    // then setMessage's messages will have bigger priority

        $ci->gcm->setMessage('Test message '.date('d.m.Y H:s:i'));



    	// add recepient or few

        $ci->gcm->addRecepient('RegistrationId');

        $ci->gcm->addRecepient('New reg id');



    	// set additional data

        $ci->gcm->setData(array(

            'some_key' => 'some_val'

        ));



    	// also you can add time to live

        $ci->gcm->setTtl(500);

    	// and unset in further

        $ci->gcm->setTtl(false);



    	// set group for messages if needed

        $ci->gcm->setGroup('Test');

    	// or set to default

        $ci->gcm->setGroup(false);



    	// then send

        if ($ci->gcm->send())

            echo 'Success for all messages';

        else

            echo 'Some messages have errors';



    	// and see responses for more info

        p($ci->gcm->status);

        p($ci->gcm->messagesStatuses);



    	die(' Worked.');

	}

}

/*start paypal code here*/

// function get_accessToken()
// {
//   $curl = curl_init();
//   curl_setopt_array($curl, array(
//     CURLOPT_URL => "https://api.paypal.com/v1/oauth2/token",
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_ENCODING => "",
//     CURLOPT_MAXREDIRS => 10,
//     CURLOPT_TIMEOUT => 30,
//     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//     CURLOPT_CUSTOMREQUEST => "POST",
//     CURLOPT_POSTFIELDS => "grant_type=client_credentials",
//     CURLOPT_SSL_VERIFYPEER => false,
//     CURLOPT_SSL_VERIFYHOST => 2,
//     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//     CURLOPT_USERPWD => getWebOptionValue('paypal_client_id') . ":" . getWebOptionValue('paypal_secret_key'),
//     CURLOPT_HTTPHEADER => array("content-type: application/x-www-form-urlencoded"
//     ),

//   ));

//  //  CURLOPT_USERPWD => getWebOptionValue('paypal_client_id') . ":" . getWebOptionValue('paypal_secret_key')

//   $response = curl_exec($curl);
//   $err = curl_error($curl);

//   curl_close($curl);

//   if ($err) {
//     echo "cURL Error #:" . $err;
//     die();
//   } else {
//     //echo $response;
//     $resp = json_decode($response,true);
//     return $resp;
//   }
// }


// function do_payment($access_token,$pdata)
// {
//   $curl = curl_init();

//   curl_setopt_array($curl, array(
//     CURLOPT_URL => "https://api.paypal.com/v1/payments/payment",
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_ENCODING => "",
//     CURLOPT_MAXREDIRS => 10,
//     CURLOPT_TIMEOUT => 30,
//     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//     CURLOPT_CUSTOMREQUEST => "POST",
//     CURLOPT_POSTFIELDS => json_encode($pdata),
//     CURLOPT_SSL_VERIFYPEER => false,
//     CURLOPT_SSL_VERIFYHOST => 2,
//     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//     CURLOPT_HTTPHEADER => array(
//       "authorization: Bearer $access_token",
//       "content-type: application/json"
//     ),
//   ));

//   $response = curl_exec($curl);
//   $err = curl_error($curl);

//   curl_close($curl);

//   if ($err) {
//     echo  "cURL Error #:" . $err;
//     die();
//   } else {
//     //echo $response;
//     $resp = json_decode($response,true);
//     return $resp;
//   }
// }

function get_accessToken()
{
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.paypal.com/v1/oauth2/token",
    CURLOPT_RETURNTRANSFER => true,
    //CURLOPT_ENCODING => "",
    //CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 3000,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "grant_type=client_credentials",
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => 2,
    //CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_USERPWD => getWebOptionValue('paypal_client_id') . ":" . getWebOptionValue('paypal_secret_key'),
    CURLOPT_HTTPHEADER => array("content-type: application/x-www-form-urlencoded"
    ),

  ));

 //  CURLOPT_USERPWD => getWebOptionValue('paypal_client_id') . ":" . getWebOptionValue('paypal_secret_key')

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);

  if ($err) {
    echo "cURL Error #:" . $err;
    die();
  } else {
    //echo $response;
    $resp = json_decode($response,true);
    return $resp;
  }
}


function do_payment($access_token,$pdata)
{
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.paypal.com/v1/payments/payment",
    CURLOPT_RETURNTRANSFER => true,
    //CURLOPT_ENCODING => "",
    //CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 3000,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode($pdata),
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => 2,
    //CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_HTTPHEADER => array(
      "authorization: Bearer $access_token",
      "content-type: application/json"
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);

  if ($err) {
    echo  "cURL Error #:" . $err;
    die();
  } else {
    //echo $response;
    $resp = json_decode($response,true);
    return $resp;
  }
}

function p($data)
{
  echo "<pre>"; print_r($data); die();
}


function __webtxt($word)
{
	global $user_lang;

	$ci =&get_instance();
	
	$data = $ci->db->get_where("webtexts",array("lang_id" => $user_lang,"text_eng" => $word))->row_array();
	$word = $data["text_lang"];
	return $word;
}

function getWebOption($opt_name)
{
	$ci =&get_instance();
	$data = $ci->common_model->getWhereData("web_option",array("opt_name" => $opt_name));
	return $data;
}

function getWebOptionValue($opt_name)
{
	$ci =&get_instance();
	$optdata = $ci->common_model->getWhereData("web_option",array("opt_name" => $opt_name));
	$opt = (!empty($optdata))? $optdata[0]["opt_value"] : "";
	return $opt;
}

function getpageinfo($page_name)
{
	$ci =&get_instance();
	$data = $ci->common_model->getWhereData("page_management",array("page_name" => $page_name));
	return $data;
}

/*and paypal*/



if(!function_exists('humanTiming')) {

	function humanTiming($time)

	{

	    $time = time() - $time; // to get the time since that moment

	    $time = ($time<1)? 1 : $time;

	    $tokens = array (

	        31536000 => 'y',

	        2592000 => 'm',

	        604800 => 'w',

	        86400 => 'd',

	        3600 => 'h',

	        60 => 'min',

	        1 => 'sec'

	    );



	    foreach ($tokens as $unit => $text) {

	        if ($time < $unit) continue;

	        $numberOfUnits = floor($time / $unit);

	        return $numberOfUnits.' '.$text;

	    }



	}

}



if(!function_exists('is_logged_in')) {

	function is_logged_in($return_uri = '') {

	    $ci =&get_instance();

		$admin_login = $ci->session->userdata('admin_session_data');

		if(!isset($admin_login['is_logged_in']) || $admin_login['is_logged_in'] != true) {

			if($return_uri) {

				redirect('admin/login?return_uri='.urlencode(base_url().$return_uri));	

			} else {

				redirect("admin/login");	

			}		

		}		

	}

}



if(!function_exists('admin_session_data')) {

	function admin_session_data() {

		$ci =&get_instance();

		$session_data = $ci->session->userdata('admin_session_data');

		return $session_data;

	}

}



if(!function_exists('assets_url')) {

	function assets_url() {

		echo base_url().'assets/';

	}

}



if(!function_exists('load_admin_view')) {

	function load_admin_view($view_path, $data = array(), $leftBar = 'yes') {

		if(!empty($view_path)) {

			$ci =&get_instance();



			/* Load Header */

			$ci->load->view('includes/header', $data);



			/* Load sidebar */

			if($leftBar == 'yes') {

				$ci->load->view('includes/left-sidebar', $data);

			}



			/* Load content section */

			$ci->load->view($view_path, $data);



			/* Load footer */

			$ci->load->view('includes/footer', $data);

		} else {

			show_error('Unable to load content view, please check again.');

		}

	}

}



if(!function_exists('add_active_class')) {

	function add_active_class($class) {

		$ci =&get_instance();

		$currentMethod = $ci->router->fetch_method();

		if($currentMethod == $class) {

			echo 'active';

		}

	}

}



if(!function_exists('sendEmail')) {

    function sendEmail($emailData) {

        try {

            $email = $emailData['email'];

            $body = $emailData['template_data'];;

            

            $from_name = "Espsofttech.com";

            $headers = "From: ".$from_name."<noreply@espsofttech.com>\r\n";

            $headers.= "MIME-Version: 1.0\r\n";

            $headers.= "Content-Type: text/html; charset=ISO-8859-1\r\n";

            @mail($email,$emailData['subject'],$body,$headers);

            

            return 1;

        } catch (Exception $e) {

            echo $e->getMessage();

        }

    }

}



if(!function_exists('generate_forgot_code')) {

    function generate_forgot_code($length = 10) {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $charactersLength = strlen($characters);

        $randomString = '';

        for ($i = 0; $i < $length; $i++) {

            $randomString .= $characters[rand(0, $charactersLength - 1)];

        }

        return $randomString;

    }

}

/* for url decode format */

function formatData($data)
{
 foreach($data as $key => $val)
 {
  if(!is_array($val))
  {
   $data[$key] = urldecode($val);
  }else
  {
   $data[$key] = formatData($val);
  }
 }

 return $data; 
}

/*this is  for get distance between two location*/
function getDistance($latitudeFrom, $longitudeFrom, $latitudeTo,$longitudeTo,$unit){
    //Change address format
    // $formattedAddrFrom = str_replace(' ','+',$addressFrom);
    // $formattedAddrTo = str_replace(' ','+',$addressTo);
    
    // //Send request and receive json data
    // $geocodeFrom = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$formattedAddrFrom.'&sensor=false');
    // $outputFrom = json_decode($geocodeFrom);
    // $geocodeTo = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$formattedAddrTo.'&sensor=false');
    // $outputTo = json_decode($geocodeTo);
    
    // //Get latitude and longitude from geo data
    // $latitudeFrom = $outputFrom->results[0]->geometry->location->lat;
    // $longitudeFrom = $outputFrom->results[0]->geometry->location->lng;
    // $latitudeTo = $outputTo->results[0]->geometry->location->lat;
    // $longitudeTo = $outputTo->results[0]->geometry->location->lng;
    
    //Calculate distance from latitude and longitude
    $theta = $longitudeFrom - $longitudeTo;
    $dist = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);
    if ($unit == "K") {
        return ($miles * 1.609344).' km';
    } else if ($unit == "N") {
        return ($miles * 0.8684).' nm';
    } else {
        return $miles.' mi';
    }
}

/* End of file common_helper.php */

/* Location: ./system/application/helpers/common_helper.php */