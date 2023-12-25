<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
defined('BASEPATH') OR exit('No direct script access allowed');
// $GLOBALS['url'] = 'http://localhost/backend/';
$GLOBALS['url'] = 'https://api.victus.club/';

$GLOBALS['app_url'] = '';
$GLOBALS['ipfs_url'] = '';
//$GLOBALS['url'] = 'https://espsofttechnologies.com/freedomcell/';
//$GLOBALS['app_url'] = 'https://espsofttechnologies.com/freedom-cells-react/';




// This can be removed if you use __autoload() in config.php OR use Modular Extensions

require APPPATH . '/libraries/REST_Controller.php';
//REST_Controller

// require APPPATH . '/libraries/twilio-php-master/Twilio/autoload.php';

//require APPPATH . '/libraries/PHPMailer/PHPMailerAutoload.php';
use Twilio\Rest\Client;


class Users extends REST_Controller 
{   
/*=========== Swiming Api Start From Here =========*/

        public function email_confirmation($to_email,$subject,$msg)
        {  
           $path = base_url();
           $this->mailerclass();
           $mail = new PHPMailer();  
           $mail->IsSMTP(); 
           $mail->isHTML(true); 
           $mail->SMTPDebug = 1;  
           $mail->SMTPAuth = true;  
           $mail->Host = 'smtp.gmail.com';
           $mail->Port = 587;
           $mail->Timeout = 3600;     
           $mail->Username = 'doworkless@gmail.com';  
           $mail->Password = 'xsceotcmdilkjutr';      
           $mail->SMTPSecure = "tls";    
           $mail->SetFrom('doworkless@gmail.com');
           $mail->Subject = $subject; 
           $mail->Body = $msg;
           $mail->AltBody = "";
           $mail->AddAddress($to_email);
           if(!$mail->Send()) 
           {
               $error = 'Mail error: '.$mail->ErrorInfo; 
           }
         }

     
public function ipfs_upload_pinata($file){

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.pinata.cloud/pinning/pinFileToIPFS',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('file'=> new CURLFILE($file)),
  CURLOPT_HTTPHEADER => array(
    'pinata_api_key: b28e33b391548c8b9efb',
    'pinata_secret_api_key: 4e0398938ff70b4e0bc8b1dc0b5d426a600cae2f3ddd196774820bd28271c3c9'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
return $response;
}


public function ipfs_upload($file){
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://15.207.99.96:3003/ipfs',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('file'=> new CURLFILE($file),'apiKey' => 'wqk5EWa/QLVlFLPOPyk5vQ==','secretKey' => 'DbPN+495s8HgCHnhzj91z6WlR06ZSIA8WFjv8P9Hhfc='),
));

$response = curl_exec($curl);
curl_close($curl);
echo $response;
return $response;
}


public function test_ipfs_post(){
 if(!empty($_FILES['file'])){
 echo $this->ipfs_upload($_FILES['file']['tmp_name']);

 } 
}

      public function email_confirmation_OLD($to_email,$subject,$msg)
      { 
        error_reporting('E_all');
         $this->load->library('email');   
         $config['mailtype'] = 'html';
         $this->email->initialize($config); 
         $this->email->from('doworkless@gmail.com', 'Admin'); 
         $this->email->to($to_email);
         $this->email->subject($subject); 
         $this->email->message($msg); 
        
         //Send mail 
         if($this->email->send()){
          echo "sent";
         }else{
          echo "not send";
         }
       }


        function mailerclass()
        {
            require APPPATH . '/libraries/class.phpmailer.php';
        }

 ///////////////////////////////////////////////////////////////////////////////
 ///////////////////////////////////////////////////////////////////////////////



function decodeEmoticons($src) {
    $replaced = preg_replace("/\\\\u([0-9A-F]{1,4})/i", "&#x$1;", $src);
    $result = mb_convert_encoding($replaced, "UTF-16", "HTML-ENTITIES");
    $result = mb_convert_encoding($result, 'utf-8', 'utf-16');
    return $result;
}
public function test1_get()
{
$src = "\u263a\ud83d\ude00\ud83d\ude01\ud83d\ude02\ud83d\ude03";
echo $this->decodeEmoticons($src);
}

public function test2_get()
{
$src = "\u263a\ud83d\ude00\ud83d\ude01\ud83d\ude02\ud83d\ude03";
echo $this->decodeEmoticons($src);
}

public function two_factor_auth_post()
    {
        $this->load->library('GoogleAuthenticator');
        $ga = new GoogleAuthenticator();
        // Check for required parameter /
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        $required_parameter = array('user_id','code','is_enable_google_auth_code');
        $chk_error = check_required_value($required_parameter, $object_info);
        if ($chk_error) {
           $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));

           $this->response($resp);
        }
          $user_id   = $data['user_id'];

          // Check header authantication
          // $authorization  = $data['authorization'];
          // $authentication = check_auth($user_id, $authorization);
          // if($authentication == "false"){
          //     $resp = array('code' => false, 'message' => array('error' => 'FAILURE', 'error_label' => 'authentication error'));
          //     $this->response($resp); exit;
          // }

                if($user_id)
                {
                    $userDetails = $this->common_model->getSingleRecordById('users',array('id'=>$user_id));
                }                
                if($userDetails)
                {
                    $secret=$userDetails['google_auth_code'];
                }

                $checkResult = $ga->verifyCode($secret, $data['code'], 2);

                if($checkResult){
                    $secretkey = $ga->createSecret(); 
                    $post_data = array( 'is_enable_google_auth_code' => (($data['is_enable_google_auth_code'])?'1':'0'));
                    $updatedata = $this->common_model->updateRecords('users', $post_data, array('id' => $user_id));

                    $updatedata = $this->common_model->updateRecords('users', $post_data, array('id' => $user_id));
                    if($updatedata){

                      if($data['code'] AND $data['is_enable_google_auth_code']){
                        $resp = array('code' => true, 'message' => 'SUCCESS', 'response' => array('sucess'=> 'SUCCESS','success_label'=>'Enable successfully!', 'status' => 1));
                      }else{
                          $resp = array('code' => true, 'message' => 'SUCCESS', 'response' => array('sucess'=> 'SUCCESS','success_label'=>'Disable successfully!', 'status' => 0));
                      }
                    }

                }else{
                  $resp = array('code' => false, 'message' => array('error' => 'FAILURE', 'error_label' => 'Sorry! Invalid code please try again.'));
                  
                }
 
        $this->response($resp);
    }




public function check_two_factor_auth_post()
    {
        $this->load->library('GoogleAuthenticator');
        $ga = new GoogleAuthenticator();
        // Check for required parameter /
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        $required_parameter = array('user_id');
        $chk_error = check_required_value($required_parameter, $object_info);
        if ($chk_error) {
           $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));

           $this->response($resp);
        }
          $user_id   = $data['user_id'];

          // Check header authantication
          // $authorization  = $data['authorization'];
          // $authentication = check_auth($user_id, $authorization);
          // if($authentication == "false"){
          //     $resp = array('code' => false, 'message' => array('error' => 'FAILURE', 'error_label' => 'authentication error'));
          //     $this->response($resp); exit;
          // }

                if($user_id)
                {
                    $userDetails = $this->common_model->getSingleRecordById('users',array('id'=>$user_id));
                }                
                if($userDetails)
                {
                    $data['google_auth_code']=$userDetails['google_auth_code'];
                    $data['is_enable_google_auth_code']=$userDetails['is_enable_google_auth_code'];
                    $data['email']=$userDetails['email'];
                    $data['qrCodeUrl'] = $qrCodeUrl=$ga->getQRCodeGoogleUrl($data['email'], $data['google_auth_code'],'9lessons Demos');
                    $data['code']="";

                }else{
                  $data['qrCodeUrl'] = "";
                }
              
                  if($userDetails){
                  $resp = array('code' => true, 'message' => 'SUCCESS', 'user_data' =>$data);
 
                }else{
                  $resp = array('code' => false, 'message' => 'No data found');
                  
                }
 
        $this->response($resp);
    }


public function update_balance_get(){

 // UPDATE WALLET BALANCE
              $query="select * from users_wallet";
              $wallet=$this->common_model->getArrayByQuery($query);             
              foreach ($wallet as $value) {
              $from=$value['public_key'];
              $private=$value['private_key'];
              $balance=$this->get_balance($from,"0xffEfc73c8edc2bfbe3916b13f5E21c81d1Ce25ff");
              $balance=json_decode($balance,true);         
              $balance=$balance['balance'];
              $updateArr = array('balance' => $balance);
              $condition = array('id' => $value['id']);
              $this->common_model->updateRecords("users_wallet", $updateArr,$condition);   
              }
              echo "wallet updated";
}

public function send_token($from_address,$to_address,$from_private_key,$value){

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://blockchainexpert.co.in:7001/api/glr/mainnet/transfer",
  //CURLOPT_URL => "13.233.136.121:7001/api/fcell_token/transfer",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"{\r\n\"from_address\" : \"".$from_address."\",\r\n\"to_address\" : \"".$to_address."\",\r\n\"from_private_key\":\"".$from_private_key."\",\r\n\"contract_address\":\"0xffEfc73c8edc2bfbe3916b13f5E21c81d1Ce25ff\",\r\n\"value\": ".$value."\r\n}",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
return $response;

}

public function send_btc($from_address,$to_address,$from_private_key,$value){
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "13.233.136.121:7001/api/testbtc/transfer",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"{\r\n\t\"from_address\":\"".$from_address."\",\r\n\t\"to_address\":\"".$to_address."\",\r\n\t\"from_private_key\":\"".$from_private_key."\",\r\n\t\"value\":".$value."\r\n}",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json"
  ),
));

$response = curl_exec($curl);
curl_close($curl);
return $response;
}

public function send_eth($from_address,$to_address,$from_private_key,$value){
$curl = curl_init();

curl_setopt_array($curl, array(
  //CURLOPT_URL => "52.66.202.69:7000/api/eth/transfer",
  CURLOPT_URL => "13.233.136.121:7001/api/eth/transfer",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"{\r\n    \"from_address\":\"".$from_address."\",\r\n    \"from_private_key\":\"".$from_private_key."\",\r\n    \"to_address\":\"".$to_address."\",\r\n    \"value\":\"".$value."\"\r\n}",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json"
  ),
));
$response = curl_exec($curl);
curl_close($curl);
return $response;
}

public function get_balance($wallet_address,$contract_address){

  $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://blockchainexpert.co.in:7001/api/glr/mainnet/getBalance/".$wallet_address."/".$contract_address."",
  //CURLOPT_URL => "13.233.136.121:7001/api/fcell_token/token_balance/".$wallet_address."/".$contract_address."",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
));

$response = curl_exec($curl);

curl_close($curl);
return $response;
}


public function get_BTC_balance($wallet_address){
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "13.233.136.121:7001/api/testbtc/getBalance/".$wallet_address."",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
));

$response = curl_exec($curl);

curl_close($curl);
return $response;
}

public function get_ETH_balance($wallet_address){
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "52.66.202.69:7000/api/eth/getBalance/".$wallet_address."",
  //CURLOPT_URL => "13.233.136.121:7001/api/eth/getBalance/".$wallet_address."",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
));

$response = curl_exec($curl);

curl_close($curl);
return $response;
}

        public function test_get(){

          $query="SELECT * FROM `users_wallet` WHERE btc_public_key is null";
          $recdata=$this->common_model->getArrayByQuery($query);
          foreach ($recdata as $value) {
             $recdata2=file_get_contents('http://52.66.202.69:7000/api/eth/create_wallet');
             //$recdata2=file_get_contents('http://52.66.202.69:7000/api/eth/create_wallet');
              $data=json_decode($recdata2,true);
               if($data['code']==200){
              $private=$data['data']['wallet']['private'];
              $public=$data['data']['wallet']['public'];

              $recdata2=file_get_contents('52.66.202.69:7000/api/btc/create_wallet');
              //$recdata2=file_get_contents('http://13.233.136.121:7001/api/testbtc/create_wallet');
              $data=json_decode($recdata2,true);
              $btc_private=$data['data']['wallet']['private'];
              $btc_public=$data['data']['wallet']['public'];

              $dataArray = array('btc_public_key'=>$btc_public, 'btc_private_key'=>$btc_private,'btc_balance'=>0);
              $condition=array('id'=>$value['id']);
              $this->common_model->updateRecords("users_wallet", $dataArray,$condition);
                }
          }
          
        }


     /*Country List */
  public function country_get() {

        $table='countries';
        $whr = array();
        $orderby='name';
        $ascdesc='asc';


        $recdata= $this->common_model->getAllRecordsOrderById($table,$orderby,$ascdesc,$whr);

        if(!empty($recdata))
        {


             $resp = array('code' => SUCCESS, 'message' => 'SUCCESS', 'response' => array('recdata' => $recdata));

        } else {

          $resp = array('code' => ERROR, 'message' => 'FAILURE', 'response' => array('error' => 'INVALID_DETAILS', 'error_label' => 'Data not found'));
        }
        $this->response($resp);
  }

public function nsfw_get() {

        $table='nsfw_type';
        $whr = array();
        $orderby='nsfw';
        $ascdesc='asc';
        $recdata= $this->common_model->getAllRecordsOrderById($table,$orderby,$ascdesc,$whr);
        if(!empty($recdata))
        {
             $resp = array('code' =>true, 'message' => 'SUCCESS', 'recdata' => $recdata);
        } else {
          $resp = array('code' => false, 'message' => 'FAILURE', 'response'=> 'Error!!');
        }
        $this->response($resp);
  }


public function get_coinprice($coin_input, $coin_output) {
    $apiurl = "https://api.coinbase.com/v2/prices/".$coin_input."-".$coin_output."/buy";
    $ch = curl_init($apiurl);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json'
    ));
    $response = json_decode(curl_exec($ch));
    return @$response->data->amount;
}

public function test_post(){
  $pdata = file_get_contents("php://input");
  $data = json_decode( $pdata,true );
  $inputCoin  =$data['inputcoin'];
  $output = $data['currency'];
  echo 'VALUE='.$eqValue= $this->get_coinprice($inputCoin, $output);
}

  //  public function register_post() {
  //         $this->load->library('GoogleAuthenticator');
  //         $ga = new GoogleAuthenticator();
  //         $secret = $ga->createSecret();

  //       /* Check for required parameter */
  //       $pdata = file_get_contents("php://input");
  //       $data = json_decode( $pdata,true );
  //       $object_info = $data;
  //       $required_parameter = array( 'full_name','email','password','confirm_password');
  //       $chk_error = check_required_value($required_parameter, $object_info);
  //       if ($chk_error) {
  //          $resp = array('code' => MISSING_PARAM, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));

  //          $this->response($resp);
  //       }
  //           if($data['password'] != $data['confirm_password']) {
  //           $resp = array('code' => false, 'message' =>'Password and confirm password fields not matched');
  //           $this->response($resp);
  //       }

  //           $check_email = $this->common_model->getRecordCount("users", array('email' => $data['email']));

  //           if($check_email > 0) {
  //               $resp = array('code' => false, 'message' => 'EMAIL_IS_ALREADY_EXISTS');
  //               $this->response($resp);
  //           }

  //           $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
  //           $code= md5(substr(str_shuffle($permitted_chars), 0, 10));
  //           $ref=strtoupper(substr(str_shuffle($permitted_chars), 0, 8));

  //             $ref_by="";
  //             if(!empty($data['referral_code'])){
  //             $check_ref = $this->common_model->getRecordCount("users", array('referral_code' => $data['referral_code']));
  //           if($check_ref == 0) {
  //               $resp = array('code' => false, 'message' => 'Invalid referral code!!');
  //               $this->response($resp);
  //           }
  //             $ref_by=$data['referral_code'];
  //           }

  //           $dataArray = array('email' => $data['email'],'referral_code'=>$ref,'referred_by'=>$ref_by,  'email_auth_code'=>$code, 'password' => md5($data['password']), 'full_name' => $data['full_name'],'google_auth_code'=>$secret,'ip'=>$_SERVER['REMOTE_ADDR']);
         
  //           $userId = $this->common_model->addRecords("users", $dataArray);
  //           if($userId) { 
  //           $dataArray = array('user_id' => $userId, 'plan_id' => 1, 'start_date' => date('Y-m-d'),'ip'=>$_SERVER['REMOTE_ADDR']);
  //           $this->common_model->addRecords("user_plan", $dataArray);
  //           $to_email=$data['email'];
  //           $subject="Verify your email";
  //           $msg="Dear User, to complete your Freedomcells registration process, plese varify your email by follow this link  http://localhost:3000/profilesetup?code=".$code;
  //           $this->email_confirmation($to_email,$subject,$msg);

  //             // $recdata=file_get_contents('http://blockchainexpert.co.in:7001/api/eth/create_wallet');
  //             $recdata=file_get_contents('http://52.66.202.69:7000/api/eth/create_wallet');
  //             $data=json_decode($recdata,true);
  //              if($data['code']==200){
  //             $private=$data['data']['wallet']['private'];
  //             $public=$data['data']['wallet']['public'];

  //             $recdata=file_get_contents('52.66.202.69:7000/api/btc/create_wallet');
  //             //$recdata=file_get_contents('http://13.233.136.121:7001/api/testbtc/create_wallet');
  //             $data=json_decode($recdata,true);
  //             $btc_private=$data['data']['wallet']['private'];
  //             $btc_public=$data['data']['wallet']['public'];

  //             $dataArray = array('user_id' => $userId, 'public_key' => $public, 'private_key' => $private,'btc_public_key'=>$btc_public, 'btc_private_key'=>$btc_private,'balance'=>0,'btc_balance'=>0);
  //             $this->common_model->addRecords("users_wallet", $dataArray);
  //               }
  //             $whr=" where u.id=$userId";
  //             $orderby="";
  //           /* Get user data */
  //             $userData = $this->common_model->getUserProfile($whr,$orderby);
  //             $resp = array('code' => true, 'message' => 'Please follow link send to your registered email to verfy your email address!','user_data' => $userData[0]);
  //           } 
  //           else 
  //           {
  //               $resp = array('code' => false, 'message' => 'Some error occured, please try again');
  //           }
  //           $this->response($resp);
  // }

//   public function register_post() {
//     $this->load->library('GoogleAuthenticator');
//     $ga = new GoogleAuthenticator();
//     $secret = $ga->createSecret();

//     /* Get JSON data from the request */
//     $json_data = $this->input->raw_input_stream;
//     $data = json_decode($json_data, true);

//     /* Validate required parameters */
//     $required_parameters = ['full_name', 'email', 'password', 'confirm_password'];
//     foreach ($required_parameters as $param) {
//         if (empty($data[$param])) {
//             $resp = ['code' => false, 'message' => 'Missing required parameter: ' . $param];
//             $this->response($resp);
//         }
//     }

//     /* Check if password and confirm_password match */
//     if ($data['password'] !== $data['confirm_password']) {
//         $resp = ['code' => false, 'message' => 'Password and confirm password do not match'];
//         $this->response($resp);
//     }

//     /* Check if email already exists */
//     $check_email = $this->common_model->getRecordCount("users", ['email' => $data['email']]);
//     if ($check_email > 0) {
//         $resp = ['code' => false, 'message' => 'Email is already registered'];
//         $this->response($resp);
//     }

//     /* Generate email verification code and referral code */
//     $email_auth_code = md5(substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'), 0, 10));
//     $referral_code = strtoupper(substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'), 0, 8));

//     /* Check and process referral code */
//     $referred_by = "";
//     if (!empty($data['referral_code'])) {
//         $check_ref = $this->common_model->getRecordCount("users", ['referral_code' => $data['referral_code']]);
//         if ($check_ref > 0) {
//             $referred_by = $data['referral_code'];
//         } else {
//             $resp = ['code' => false, 'message' => 'Invalid referral code'];
//             $this->response($resp);
//         }
//     }

//     /* Prepare user data for insertion */
//     $user_data = [
//         'email' => $data['email'],
//         'referral_code' => $referral_code,
//         'referred_by' => $referred_by,
//         'email_auth_code' => $email_auth_code,
//         'password' => md5($data['password']),
//         'full_name' => $data['full_name'],
//         'google_auth_code' => $secret,
//         'email_verify' => 1
//         'userstatusid' => 1
//         'ip' => $_SERVER['REMOTE_ADDR']
//     ];

//     /* Insert user data into the database */
//     $user_id = $this->common_model->addRecords("users", $user_data);
//     if ($user_id) {
//         /* Prepare data for user plan insertion */
//         $user_plan_data = [
//             'user_id' => $user_id,
//             'plan_id' => 1,
//             'start_date' => date('Y-m-d'),
//             'ip' => $_SERVER['REMOTE_ADDR']
//         ];
//         $this->common_model->addRecords("user_plan", $user_plan_data);

//         /* Send email verification link to the user */
//         $to_email = $data['email'];
//         $subject = "Verify your email";
//         $verification_link = base_url("profilesetup?code=" . $email_auth_code); // Adjust the URL as needed
//         $msg = "Dear User, to complete your Freedomcells registration process, please verify your email by following this link: $verification_link";
//         $this->email_confirmation($to_email, $subject, $msg);

//         /* Attempt to create wallet */
//         $wallet_creation_result = $this->createWallet($user_id);
//         if (!$wallet_creation_result['code'] === true) {
//             /* Get user data and send the response */
//             $user_data = $this->common_model->getUserProfile("WHERE u.id=$user_id", "");
//             $resp = ['code' => true, 'message' => 'Please follow the link sent to your registered email to verify your email address!', 'user_data' => $user_data[0]];
//         } else {
//             /* Handle wallet creation failure */
//             $resp = ['code' => false, 'message' => 'Failed to create wallet. Please try again later.'];
//         }
//     } else {
//         /* Handle user registration failure */
//         $resp = ['code' => false, 'message' => 'Some error occurred, please try again.'];
//     }

//     $this->response($resp);
// }
public function register_post() {
  $this->load->library('GoogleAuthenticator');
  $ga = new GoogleAuthenticator();
  $secret = $ga->createSecret();

  /* Get JSON data from the request */
  $json_data = $this->input->raw_input_stream;
  $data = json_decode($json_data, true);

  /* Validate required parameters */
  $required_parameters = ['full_name', 'email', 'password', 'confirm_password'];
  foreach ($required_parameters as $param) {
      if (empty($data[$param])) {
          $resp = ['code' => false, 'message' => 'Missing required parameter: ' . $param];
          $this->response($resp);
      }
  }

  /* Check if password and confirm_password match */
  if ($data['password'] !== $data['confirm_password']) {
      $resp = ['code' => false, 'message' => 'Password and confirm password do not match'];
      $this->response($resp);
  }

  /* Check if email already exists */
  $check_email = $this->common_model->getRecordCount("users", ['email' => $data['email']]);
  if ($check_email > 0) {
      $resp = ['code' => false, 'message' => 'Email is already registered'];
      $this->response($resp);
  }

  /* Generate email verification code and referral code */
  $email_auth_code = md5(substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'), 0, 10));
  $referral_code = strtoupper(substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'), 0, 8));

  /* Check and process referral code */
  $referred_by = "";
  if (!empty($data['referral_code'])) {
      $check_ref = $this->common_model->getRecordCount("users", ['referral_code' => $data['referral_code']]);
      if ($check_ref > 0) {
          $referred_by = $data['referral_code'];
      } else {
          $resp = ['code' => false, 'message' => 'Invalid referral code'];
          $this->response($resp);
      }
  }

  /* Prepare user data for insertion */
  $user_data = [
      'email' => $data['email'],
      'referral_code' => $referral_code,
      'referred_by' => $referred_by,
      'email_auth_code' => $email_auth_code,
      'password' => md5($data['password']),
      'full_name' => $data['full_name'],
      'google_auth_code' => $secret,
      'email_verify' => 1,
      'userstatusid' => 1,
      'ip' => $_SERVER['REMOTE_ADDR']
  ];

  /* Insert user data into the database */
  $user_id = $this->common_model->addRecords("users", $user_data);
  if ($user_id) {
      /* Prepare data for user plan insertion */
      $user_plan_data = [
          'user_id' => $user_id,
          'plan_id' => 1,
          'start_date' => date('Y-m-d'),
          'ip' => $_SERVER['REMOTE_ADDR']
      ];
      $this->common_model->addRecords("user_plan", $user_plan_data);

      /* Send email verification link to the user */
      $to_email = $data['email'];
      $subject = "Verify your email";
      $verification_link = base_url("profilesetup?code=" . $email_auth_code); // Adjust the URL as needed
      $msg = "Dear User, to complete your Freedomcells registration process, please verify your email by following this link: $verification_link";
      $this->email_confirmation($to_email, $subject, $msg);

      /* Attempt to create wallet */
      // $wallet_creation_result = $this->createWallet($user_id);
      // if ($wallet_creation_result['code'] === true) {
          /* Get user data and send the response */
          $user_data = $this->common_model->getUserProfile("WHERE u.id=$user_id", "");
          $resp = ['code' => true, 'message' => 'Please follow the link sent to your registered email to verify your email address!', 'user_data' => $user_data[0]];
      // } else {
          /* Handle wallet creation failure */
          // $resp = ['code' => false, 'message' => 'Failed to create wallet. Please try again later.'];
      // }
  } else {
      /* Handle user registration failure */
      $resp = ['code' => false, 'message' => 'Some error occurred, please try again.'];
  }

  $this->response($resp);
}

private function createWallet($user_id) {
    $eth_wallet_url = 'https://walletconnect.com';
    $btc_wallet_url = 'https://walletconnect.com';

    $eth_wallet_data = json_decode(@file_get_contents($eth_wallet_url), true);
    if ($eth_wallet_data['code'] === 200) {
        $eth_private = $eth_wallet_data['data']['wallet']['private'];
        $eth_public = $eth_wallet_data['data']['wallet']['public'];

        $btc_wallet_data = json_decode(@file_get_contents($btc_wallet_url), true);
        if ($btc_wallet_data['code'] === 200) {
            $btc_private = $btc_wallet_data['data']['wallet']['private'];
            $btc_public = $btc_wallet_data['data']['wallet']['public'];

            $wallet_data = [
                'user_id' => $user_id,
                'public_key' => $eth_public,
                'private_key' => $eth_private,
                'btc_public_key' => $btc_public,
                'btc_private_key' => $btc_private,
                'balance' => 0,
                'btc_balance' => 0
            ];

            $this->common_model->addRecords("users_wallet", $wallet_data);
            return ['code' => true, 'message' => 'Wallet created successfully.'];
        }
    }

    return ['code' => false, 'message' => 'Failed to create wallet. Please try again later.'];
}




  /* Users login service*/
  // public function login_post() {

      /* Check for required parameter */
    //   $pdata = file_get_contents("php://input");
    //   $data = json_decode( $pdata,true );
    //  // print_r($data);exit;
    // $object_info = $data;
    // $required_parameter = array('email', 'password');
    //     $chk_error = check_required_value($required_parameter, $object_info);
    //   if ($chk_error) {
    //        $resp = array('code' => MISSING_PARAM, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
    //        $this->response($resp);
    //   }
    //   /* Check for email */
    //   $check_email = $this->common_model->getRecordCount("users", array('email' => $data['email']));
    //   if($check_email == 0) {
    //     $resp = array('code' => false, 'message' => 'Enter a registered e-mail address');
    //     $this->response($resp);
    //   }

    //       if(!empty($data['code'])){
    //       $check_auth = $this->common_model->getSingleRecordById("users", array('email_auth_code' => $data['code'],'email_verify' =>'1'));
    //       if(!empty($check_auth)){
    //         $resp = array('code' => false, 'message' =>  'Your account is already verified !');
    //       $this->response($resp);
    //       }

    //       $condition = array('email_auth_code' => $data['code'],'email_verify' =>'0');
    //       $updateArr = array('email_verify' =>'1');
    //       $this->common_model->updateRecords('users', $updateArr, $condition);
    //       }


    //   $check_login = $this->common_model->getSingleRecordById("users", array('email' => $data['email'], 'password' => MD5($data['password'])));

    //    if(empty($check_login))
    //    {

    //       $resp = array('code' => false, 'message' =>  'Email or password does not match !');
    //       $this->response($resp);
    //    }

    //    if($check_login){
    //     if($check_login['email_verify']==0){
    //        $resp = array('code' => false, 'message' =>  'First verify your email !');
    //       $this->response($resp);
    //     } 
    //     if($check_login['userstatusid']<>1){
    //        $resp = array('code' => false, 'message' =>  'User Not Activate, Please contact Admin !');
    //       $this->response($resp);
    //     }
    //            if(empty($check_login['google_auth_code'])){

    //             $this->load->library('GoogleAuthenticator');
    //             $ga = new GoogleAuthenticator();
    //             $secret = $ga->createSecret();
    //             $post_data = array( 'google_auth_code' => $secret);
    //                 $updatedata = $this->common_model->updateRecords('users', $post_data, array('id' => $check_login['id']));
    //           }
            
    //     $userId=$check_login['id'];

    //         // CHECK USER WALLET
    //           $check_wallet = $this->common_model->getSingleRecordById("users_wallet", array('user_id' => $userId));
    //           if(empty($check_wallet)){
    //            $recdata=file_get_contents('https://walletconnect.com/');
    //            //$recdata=file_get_contents('http://52.66.202.69:7000/api/eth/create_wallet');
    //           $data=json_decode($recdata,true);
    //            if($data['code']==200){
    //             // echo "Successfully created"
    //           $private=$data['data']['wallet']['private'];
    //           $public=$data['data']['wallet']['public'];

    //           $recdata=file_get_contents('https://walletconnect.com/');
    //           //$recdata=file_get_contents('http://13.233.136.121:7001/api/testbtc/create_wallet');
    //           $data=json_decode($recdata,true);
    //           $btc_private=$data['data']['wallet']['private'];
    //           $btc_public=$data['data']['wallet']['public'];

    //           $dataArray = array('user_id' => $userId, 'public_key' => $public, 'private_key' => $private,'btc_public_key'=>$btc_public, 'btc_private_key'=>$btc_private,'balance'=>0,'btc_balance'=>0);
    //           $this->common_model->addRecords("users_wallet", $dataArray);
    //             }
    //           }
         
            /*   // UPDATE WALLET BALANCE
             
              $from=$check_wallet['public_key'];
              $private=$check_wallet['private_key'];
              $balance=$this->get_balance($from,"0xffEfc73c8edc2bfbe3916b13f5E21c81d1Ce25ff");
              $balance=json_decode($balance,true);         
              $balance=$balance['balance'];
              $updateArr = array('balance' => $balance);
              $condition = array('id' => $check_wallet['id']);
              $this->common_model->updateRecords("users_wallet", $updateArr,$condition);   
*/

//           $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
//           $code= md5(substr(str_shuffle($permitted_chars), 0, 40));
//           $updateArr = array('api_key' => $code);
//           $condition = array('id' => $check_login['id']);
//           $this->common_model->updateRecords("users", $updateArr,$condition);

//         $user_id=$check_login['id'];
//         $whr=" where u.id=$user_id";
//               $orderby="";
//             /* Get user data */
//               $userData = $this->common_model->getUserProfile($whr,$orderby);
//        $resp = array('code' => true, 'message' => 'Login has been successfully done!','user_data' => $userData[0]);
//       $this->response($resp);
//   }
// }


public function login_post() {
  $pdata = file_get_contents("php://input");
  $data = json_decode($pdata, true);

  if (empty($data['email']) || empty($data['password'])) {
      $resp = array('code' => false, 'message' => 'Email and password are required.');
      $this->response($resp);
  }

  // Check if the email exists
  $check_email = $this->common_model->getRecordCount("users", array('email' => $data['email']));
  if ($check_email == 0) {
      $resp = array('code' => false, 'message' => 'Enter a registered e-mail address');
      $this->response($resp);
  }

  // Validate email and password
  $check_login = $this->common_model->getSingleRecordById("users", array('email' => $data['email'], 'password' => MD5($data['password'])));
  
  if (empty($check_login)) {
      $resp = array('code' => false, 'message' => 'Email or password does not match!');
      $this->response($resp);
  }

  // Check email verification status and user status
  if ($check_login['email_verify'] == 0) {
      $resp = array('code' => false, 'message' => 'First verify your email!');
      $this->response($resp);
  } elseif ($check_login['userstatusid'] != 1) {
      $resp = array('code' => false, 'message' => 'User Not Activated, Please contact Admin!');
      $this->response($resp);
  }

  // Generate Google Authenticator code if not already set
  if (empty($check_login['google_auth_code'])) {
      $this->load->library('GoogleAuthenticator');
      $ga = new GoogleAuthenticator();
      $secret = $ga->createSecret();
      $post_data = array('google_auth_code' => $secret);
      $this->common_model->updateRecords('users', $post_data, array('id' => $check_login['id']));
  }

  // Check and create user wallet if not exists
  $userId = $check_login['id'];
  $check_wallet = $this->common_model->getSingleRecordById("users_wallet", array('user_id' => $userId));

  if (empty($check_wallet)) {

                $recdata=file_get_contents('https://walletconnect.com/');
               //$recdata=file_get_contents('http://52.66.202.69:7000/api/eth/create_wallet');
              $data=json_decode($recdata,true);
              //  if($data['code']==200){
                // echo "Successfully created"
              // $private=$data['data']['wallet']['private'];
              // $public=$data['data']['wallet']['public'];

              // $recdata=file_get_contents('https://walletconnect.com/');
              //$recdata=file_get_contents('http://13.233.136.121:7001/api/testbtc/create_wallet');
              // $data=json_decode($recdata,true);
              // $btc_private=$data['data']['wallet']['private'];
              // $btc_public=$data['data']['wallet']['public'];

              // $dataArray = array('user_id' => $userId, 'public_key' => $public, 'private_key' => $private,'btc_public_key'=>$btc_public, 'btc_private_key'=>$btc_private,'balance'=>0,'btc_balance'=>0);
              // $this->common_model->addRecords("users_wallet", $dataArray);
              //   }
              // }
         
             // UPDATE WALLET BALANCE
             
              // $from=$check_wallet['public_key'];
              // $private=$check_wallet['private_key'];
              // $balance=$this->get_balance($from,"0xffEfc73c8edc2bfbe3916b13f5E21c81d1Ce25ff");
              // $balance=json_decode($balance,true);         
              // $balance=$balance['balance'];
              // $updateArr = array('balance' => $balance);
              // $condition = array('id' => $check_wallet['id']);
              // $this->common_model->updateRecords("users_wallet", $updateArr,$condition); 
      // Code to create user wallet
      // ...
      // $dataArray = array(...); // Set wallet data
      // $this->common_model->addRecords("users_wallet", $dataArray);
  }

  // Generate API key and update it in the database
  $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
  $code = md5(substr(str_shuffle($permitted_chars), 0, 40));
  $updateArr = array('api_key' => $code);
  $condition = array('id' => $check_login['id']);
  $this->common_model->updateRecords("users", $updateArr, $condition);

  // Get user data
  $user_id = $check_login['id'];
  $whr = "where u.id = $user_id";
  $orderby = "";
  $userData = $this->common_model->getUserProfile($whr, $orderby);

  $resp = array('code' => true, 'message' => 'Login has been successfully done!', 'user_data' => $userData[0]);
  $this->response($resp);
}



  public function background_update_post() {
          //check api key
      $api_key= $_POST['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$_POST['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }
          $x=$_POST['x'];
          $y=$_POST['y'];
          $width=$_POST['width'];
          $height=$_POST['height'];
          $file=null;
          if(!isset($_FILES["file"]['name'])) {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response' => 'You must upload background image');
              $this->response($resp);
          }
                     
          //remove old image
           $recdata=$this->common_model->getSingleRecordById('users',array('id' =>$_POST['user_id']));
           if(!empty($recdata['background_image'])){

           $file='uploads2/users_profile/'.$recdata['background_image'];
           unlink($file);
          }

           if(isset($_FILES["file"]['name']))
            {
                $fileType   = $_FILES["file"]["type"];
                $imagename=time().$_FILES["file"]["name"];
                $tnm=$_FILES["file"]["tmp_name"];
                $dbpath = base_url().'uploads2/users_profile/bg_'.$imagename;
                $flag=move_uploaded_file($tnm,"uploads2/users_profile/bg_".$imagename);
                $file='bg_'.$imagename;

                switch($fileType) {
                case "image/gif":
                    $im = imagecreatefromgif("uploads2/users_profile/bg_".$imagename); 
                    break;
                case "image/pjpeg":
                case "image/jpeg":
                case "image/jpg":
                    $im = imagecreatefromjpeg("uploads2/users_profile/bg_".$imagename); 
                    break;
                case "image/png":
                case "image/x-png":
                    $im = imagecreatefrompng("uploads2/users_profile/bg_".$imagename); 
                    break;
            }
            //$im = imagecreatefromjpeg('test.jpg');
            $size = min(imagesx($im), imagesy($im));
            $im2 = imagecrop($im, ['x' => $x, 'y' => $y, 'width' => $width, 'height' =>$height]);
            if ($im2 !== FALSE) {
                imagepng($im2, "uploads2/users_profile/bg_".$imagename);
                imagedestroy($im2);
            }
            imagedestroy($im);

            } 

         $condition = array('id' => $_POST['user_id']);
        $updateArr = array('background_image' => $file);
        $post=$this->common_model->updateRecords('users', $updateArr, $condition);

       if($post){
          $recdata=$this->common_model->getSingleRecordById('users',array('id' =>$_POST['user_id']));
            $resp = array('code' => true, 'message' => 'SUCCESS', 'response' => 'Background image updated successfully','recdata'=>$recdata['background_image']);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response' => 'Not Posted');
        }
        $this->response($resp);
  }

  // public function profile_pic_update_post() {

  //         //check api key
  //          $path_of_file = "C:/xampp/htdocs/backend/uploads2/";
  //     $api_key= $_POST['api_key'];
  //     $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$_POST['user_id'], 'api_key'=>$api_key));
  //     if(empty($check_key)){
  //         $resp = array('code' => false, 'message' => 'Api key not matched');
  //         $this->response($resp);
  //     }
  //         $x=$_POST['x'];
  //         $y=$_POST['y'];
  //         $width=$_POST['width'];
  //         $height=$_POST['height'];
  //         $file=null;
  //         if(!isset($_FILES["profile_pic"]['name'])) {
  //           $resp = array('code' => false, 'message' => 'FAILURE', 'response' => 'You must upload profile image');
  //             $this->response($resp);
  //         }
                     
  //         //remove old image
  //          $recdata=$this->common_model->getSingleRecordById('users',array('id' =>$_POST['user_id']));
  //          if(!empty($recdata['profile_pic'])){
  //          $file='uploads2/users_profile/'.$recdata['profile_pic'];
  //          unlink($file);
  //         }

  //          if(isset($_FILES["profile_pic"]['name']))
  //           {
  //               $fileType = $_FILES["profile_pic"]["type"];
  //               $imagename=time().$_FILES["profile_pic"]["name"];
  //               $tnm=$_FILES["profile_pic"]["tmp_name"];
               
  //               $dbpath = base_url().'uploads2/users_profile/pp_'.$imagename;
  //               $flag=move_uploaded_file($tnm,"uploads2/users_profile/pp_".$imagename);
  //               $file='pp_'.$imagename;
               
  //               switch($fileType) {
  //               case "image/gif":
  //                   $im = imagecreatefromgif("uploads2/users_profile/pp_".$imagename); 
  //                   break;
  //               case "image/pjpeg":
  //               case "image/jpeg":
  //               case "image/jpg":
  //                   $im = imagecreatefromjpeg("uploads2/users_profile/pp_".$imagename); 
  //                   break;
  //               case "image/png":
  //               case "image/x-png":
  //                   // $im = imagecreatefrompng("uploads2/users_profile/pp_".$imagename); 
  //                   $im = imagecreatefrompng($path_of_file.$imagename); 

  //                   break;
  //           }
  //           //$im = imagecreatefromjpeg('test.jpg');
  //           $size = min(imagesx($im), imagesy($im));
  //           $im2 = imagecrop($im, ['x' => $x, 'y' => $y, 'width' => $width, 'height' =>$height]);
  //           if ($im2 !== FALSE) {
  //               imagepng($im2, "uploads/users_profile/pp_".$imagename);
  //               imagedestroy($im2);
  //           }
  //           imagedestroy($im);

  //           } 

  //        $condition = array('id' => $_POST['user_id']);
  //       $updateArr = array('profile_pic' => $file);
  //       $post=$this->common_model->updateRecords('users', $updateArr, $condition);

  //      if($post){
  //         $recdata=$this->common_model->getSingleRecordById('users',array('id' =>$_POST['user_id']));
  //           $resp = array('code' => true, 'message' => 'SUCCESS', 'response' => 'Profile pic updated successfully','recdata'=>$recdata['profile_pic']);
  //       } else {
  //           $resp = array('code' => false, 'message' => 'FAILURE', 'response' => 'Not Posted');
  //       }
  //       $this->response($resp);
  // }

  public function profile_pic_update_post() {

    //check api key
     $path_of_file = "C:/xampp/htdocs/backend/uploads2/users_profile/";
$api_key= $_POST['api_key'];
$check_key = $this->common_model->getSingleRecordById('users',array('id' =>$_POST['user_id'], 'api_key'=>$api_key));
if(empty($check_key)){
    $resp = array('code' => false, 'message' => 'Api key not matched');
    $this->response($resp);
}
    $x=$_POST['x'];
    $y=$_POST['y'];
    $width=$_POST['width'];
    $height=$_POST['height'];
    $file=null;
    if(!isset($_FILES["profile_pic"]['name'])) {
      $resp = array('code' => false, 'message' => 'FAILURE', 'response' => 'You must upload profile image');
        $this->response($resp);
    }
               
    //remove old image
     $recdata=$this->common_model->getSingleRecordById('users',array('id' =>$_POST['user_id']));
     if(!empty($recdata['profile_pic'])){
     $file=$path_of_file.$recdata['profile_pic'];
     unlink($file);
    }

     if(isset($_FILES["profile_pic"]['name']))
      {
          $fileType = $_FILES["profile_pic"]["type"];
          $imagename=time().$_FILES["profile_pic"]["name"];
          $tnm=$_FILES["profile_pic"]["tmp_name"];
         
          $dbpath = base_url().'uploads2/users_profile/pp_'.$imagename;
          $flag=move_uploaded_file($tnm,"uploads2/users_profile/pp_".$imagename);
          $file='pp_'.$imagename;
         
          switch($fileType) {
          case "image/gif":
             // $im = imagecreatefromgif("uploads2/users_profile/pp_".$imagename); 
              $im = imagecreatefromgif($path_of_file.$file); 
              break;
          case "image/pjpeg":
          case "image/jpeg":
          case "image/jpg":
             // $im = imagecreatefromjpeg("uploads2/users_profile/pp_".$imagename); 
                $im = imagecreatefromjpeg($path_of_file.$file); 
              break;
          case "image/png":
          case "image/x-png":
              // $im = imagecreatefrompng("uploads2/users_profile/pp_".$imagename); 
              $im = imagecreatefrompng($path_of_file.$file); 

              break;
      }
      //$im = imagecreatefromjpeg('test.jpg');
      $size = min(imagesx($im), imagesy($im));
      $im2 = imagecrop($im, ['x' => $x, 'y' => $y, 'width' => $width, 'height' =>$height]);
      if ($im2 !== FALSE) {
        //  imagepng($im2, "uploads/users_profile/pp_".$imagename);
            $im = imagecreatefrompng($path_of_file.$file); 
          imagedestroy($im2);
      }
      imagedestroy($im);

      } 

   $condition = array('id' => $_POST['user_id']);
  $updateArr = array('profile_pic' => $file);
  $post=$this->common_model->updateRecords('users', $updateArr, $condition);

 if($post){
    $recdata=$this->common_model->getSingleRecordById('users',array('id' =>$_POST['user_id']));
      $resp = array('code' => true, 'message' => 'SUCCESS', 'response' => 'Profile pic updated successfully','recdata'=>$recdata['profile_pic']);
  } else {
      $resp = array('code' => false, 'message' => 'FAILURE', 'response' => 'Not Posted');
  }
  $this->response($resp);
}


  public function add_post_post() {
   
    $data = $this->input->post();
 
  

          //check api key
      // $api_key= $_POST['api_key'];
      // $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$_POST['user_id'], 'api_key'=>$api_key));
      $check_key = $this->common_model->getSingleRecordById("users", array('id' => $data['user_id'], 'api_key' => $data['api_key']));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

        /* Check for required parameter */
        // $pdata = file_get_contents("php://input");
        // $data = json_decode( $pdata,true );
        // $object_info = $data;
        // //print_r($object_info);exit;
        // $required_parameter = array('user_id', 'message');
        // $chk_error = check_required_value($required_parameter, $object_info);
        //   if ($chk_error) {
        //       $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
        //       $this->response($resp);
        //   }
          // $group_id=null;
          // $file=null;
          // $file_type=null;
          // $filepath=null;

          $group_id = isset($data['group_id']) ? $data['group_id'] : null;
          $file_path = '';
      
         
    //if (!empty($_FILES["file"]["name"])) {
   // $hash_response = $this->ipfs_upload($_FILES['file']['tmp_name']);
    //$hash = json_decode($hash_response);

    // Log the entire response for debugging purposes
    //error_log('IPFS Upload Response: ' . print_r($hash, true));

   // if ($hash && is_object($hash) && isset($hash->result) && isset($hash->result->hash)) {
        // Process the expected structure
        // $file_path = $hash->result->hash;
  //  } else {
        // Log unexpected response structure
        // error_log('Unexpected response structure from IPFS: ' . print_r($hash, true));

        // Handle unexpected response or error from ipfs_upload
        //$resp = array('code' => false, 'message' => 'Error in ipfs_upload response', 'details' => $hash);
        //$this->response($resp);
    //}
//}
        // new file upload code
        if(isset($_FILES['file']['name']) && !empty($_FILES["file"]["name"])) 
                        {
                          $file_path = 'uploads2'; // folder name
                            $config['allowed_types'] = '*';   // * is indicated all type
                            //$config['max_size'] = 1024 * 8;
                            $config['encrypt_name'] = TRUE;    
                            $config['upload_path'] = $file_path;
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            if ($this->upload->do_upload('file')) 
                            {
                                $file_data = $this->upload->data();
                                $filename = $file_data['file_name']; // filename with extention e.g. abc.png
                                $return_uploaded_file_path = base_url().'uploads2/' . $filename;
                                
                                //echo $return_uploaded_file_path;
                                // below is output of the above echo 
                                // http://localhost/aaa/upload2/735aa31bf474eaa0e2739c416342dcc5.jpeg
                                 
                                // you can return to your function this file url 
                                $file_path = $return_uploaded_file_path;
                            }
                            else {
                                // file upload error
                                $error = array('error' => $this->upload->display_errors());
                                //echo $error['error']; die; // if file upload error then error show and script is stopped;

                                $resp = array('code' => false, 'message' => $error['error'], 'details' => '');
                                 $this->response($resp);

                            } 
                        }
                        else {
                          // fil not select or file is blank
                          $file_path ="";
                        }
                        // new file uploads ends

        $dataArray = array(
          'group_id' => $group_id,
          'user_id' => $data['user_id'],
          'message' => $data['message'],
          'file' => $file_path,
          'file_type' => $data['file_type'],
          'ip' => $_SERVER['REMOTE_ADDR']
      );

       // print_R($dataArray); die;
  
      $post = $this->common_model->addRecords("post", $dataArray);
  
       if($post){
        if(!empty($data['hashtag'])) {
          $hash=explode(',', $data['hashtag']);
          foreach ($hash as $value) {
          $dataArray = array('post_id' => $post,'hashtag' => trim($value),'ip'=>$_SERVER['REMOTE_ADDR']);
          $this->common_model->addRecords("post_hashtag", $dataArray);
          }
          
        } 

        if(!empty($data['nsfw'])) {
          $hash=explode(',', $data['nsfw']);
          foreach ($hash as $value) {
          $dataArray = array('post_id' => $post,'nsfw' => $value,'ip'=>$_SERVER['REMOTE_ADDR']);
          $this->common_model->addRecords("post_nsfw", $dataArray);
          }
          
        }
        $recdata=$this->common_model->getSingleRecordById('post',array('id' =>$post));
          //NOTIFICATION STARTS
        $app_url=$GLOBALS['app_url'];
        $post_user_id=$recdata['user_id'];
        $group_id=$recdata['group_id'];

        if($group_id>0){
        $query="select get_group_name($group_id) as sender,p.user_id as sender_id,gm.member_id as recipient_id from post as p inner join group_member as gm on gm.group_id=p.group_id and gm.isapproved=1 and gm.isblocked=0 where p.id=$post and gm.member_id<>".$_POST['user_id']."";
        }else{
        $query="select get_user_fullname($post_user_id) as sender,p.user_id as sender_id,f.follower_id as recipient_id from post as p inner join follow as f on f.following_id=p.user_id where p.id=$post";
        }
        $ndata=$this->common_model->getArrayByQuery($query);
        foreach ($ndata as $value) {
        $title="Post added by ".$value['sender']."";
        $message="Post added by ".$value['sender']."";
        $dataArray = array('recipient_id'=>$value['recipient_id'],'sender_id'=>$value['sender_id'],'title'=>$title,'message'=>$message,'link'=>$app_url.'timeLine/'.$_POST['user_id']);
        $this->common_model->addRecords("notification", $dataArray);
        }
        //NOTIFICATION ENDS

            $resp = array('code' => true, 'message' => 'SUCCESS', 'response' => 'Post successfully','recdata'=>$recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response' => 'Not Posted');
        }
        $this->response($resp);
  }



  public function group_chat_post() {

          //check api key
      $api_key= $_POST['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$_POST['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }
          $group_id=$_POST['group_id'];
          $file=null;
          $file_type=null;
          $message=null;

          if(!empty($_POST['message'])){
            $message=$_POST['message'];
          }

           if(!empty($_FILES["file"]['name']) )
            {
                $imagename=time().$_FILES["file"]["name"];
                $tnm=$_FILES["file"]["tmp_name"];
                $dbpath = base_url().'uploads2/'.$imagename;
                $flag=move_uploaded_file($tnm,"uploads2/".$imagename);
                $file=$imagename;
                $file_type=$_POST['file_type'];
            } 

          $dataArray = array('group_id' => $group_id, 'sender_id' => $_POST['user_id'], 'message' => $message,'file' => $file, 'file_type' => $file_type,'ip'=>$_SERVER['REMOTE_ADDR']);
        $chat= $this->common_model->addRecords("group_chat", $dataArray);
       if($chat){
        $recdata=$this->common_model->getSingleRecordById('group_chat',array('id' =>$chat));

            $resp = array('code' => true, 'message' => 'SUCCESS', 'response' => 'Chat posted successfully','recdata'=>$recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response' => 'Not Posted');
        }
        $this->response($resp);
  }


  public function group_chat_delete_post() {
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        $required_parameter = array('group_chat_id','user_id','api_key');
          $chk_error = check_required_value($required_parameter, $object_info);
        if ($chk_error)
        {

            $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
            $this->response($resp);
        }

         /* Update in users Table */   
       $updateArr = array( 'is_deleted' => 1);
       $condition = array('id' => $data['group_chat_id']);

            /* Update in users Table */        
            $recdata=$this->common_model->updateRecords("group_chat", $updateArr,$condition);
       
            
            if(!empty($recdata))
            {    
               $resp = array('code' => true, 'message' => 'Group chat deleted!!');
            } 
            else 
            { 
               $resp = array('code' => ERROR, 'message' => 'error!!!');
            }
            $this->response($resp);    
  }

  public function delete_user_post() {
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        $required_parameter = array('id');
          $chk_error = check_required_value($required_parameter, $object_info);
        if ($chk_error)
        {

            $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
            $this->response($resp);
        }
          $user_id=$data['id'];
         $condition=array('id' => $data['id']);
          $param = $this->common_model->deleteRecords("user_plan",array('user_id'=>$data['id']));
          $param = $this->common_model->deleteRecords("users",array($data['id']));

            
            if(!empty($param))
            {    
               $resp = array('code' => true, 'message' => 'User deleted!!');
            } 
            else 
            { 
               $resp = array('code' => ERROR, 'message' => 'error!!!');
            }
            $this->response($resp);    
  }

  public function group_chat_like_post() {
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        $required_parameter = array('group_chat_id','user_id','api_key');
          $chk_error = check_required_value($required_parameter, $object_info);
        if ($chk_error)
        {

            $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
            $this->response($resp);
        }
          $group_chat_id=$data['group_chat_id'];
          $check_like = $this->common_model->getSingleRecordById("group_chat_like", array('group_chat_id' => $data['group_chat_id'],'user_id' => $data['user_id']));
              $id=$check_like['id'];
        if(!empty($check_like)) {
                $param = $this->common_model->do_delete("group_chat_like",$check_like['id']);
                $query="select count(id) as count from group_chat_like where group_chat_id=$group_chat_id";
                $param = $this->common_model->getArrayByQuery($query);
                $resp = array('code' => true, 'message' => 'SUCCESS', 'response'   => 'Like Removed' ,'like_count'=>$param[0]['count']);
                $this->response($resp);
            }
          

          $dataArray = array( 'group_chat_id' => $data['group_chat_id'],'user_id'=>$data['user_id']);
       

            /* Update in users Table */        
            $recdata=$this->common_model->addRecords("group_chat_like",$dataArray);
       
            if(!empty($recdata))
            {    
               $query="select count(id) as count from group_chat_like where group_chat_id=$group_chat_id";
                $param = $this->common_model->getArrayByQuery($query);
                $resp = array('code' => true, 'message' => 'SUCCESS', 'response'   => 'Group chat liked!!' ,'like_count'=>$param[0]['count']);
            } 
            else 
            { 
               $resp = array('code' => false, 'message' => 'error!!!');
            }
            $this->response($resp);    
  }

    public function group_chat_dislike_post() {
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        $required_parameter = array('group_chat_id','user_id','api_key');
          $chk_error = check_required_value($required_parameter, $object_info);
        if ($chk_error)
        {

            $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
            $this->response($resp);
        }
          $group_chat_id=$data['group_chat_id'];
          $check_like = $this->common_model->getSingleRecordById("group_chat_dislike", array('group_chat_id' => $data['group_chat_id'],'user_id' => $data['user_id']));
              $id=$check_like['id'];
        if(!empty($check_like)) {
                $param = $this->common_model->do_delete("group_chat_dislike",$check_like['id']);
                $query="select count(id) as count from group_chat_dislike where group_chat_id=$group_chat_id";
                $param = $this->common_model->getArrayByQuery($query);
                $resp = array('code' => true, 'message' => 'SUCCESS', 'response'   => 'Dislike Removed' ,'dislike_count'=>$param[0]['count']);
                $this->response($resp);
            }
          

          $dataArray = array( 'group_chat_id' => $data['group_chat_id'],'user_id'=>$data['user_id']);
       
          $recdata=$this->common_model->addRecords("group_chat_dislike",$dataArray);
       
            if(!empty($recdata))
            {    
               $query="select count(id) as count from group_chat_dislike where group_chat_id=$group_chat_id";
                $param = $this->common_model->getArrayByQuery($query);
                $resp = array('code' => true, 'message' => 'SUCCESS', 'response'   => 'Group chat disliked!!' ,'dislike_count'=>$param[0]['count']);
            } 
            else 
            { 
               $resp = array('code' => false, 'message' => 'error!!!');
            }
            $this->response($resp);    
  }

  public function group_chat_list_post() {
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        $required_parameter = array('group_chat_id','user_id','api_key');
          $chk_error = check_required_value($required_parameter, $object_info);
        if ($chk_error)
        {

            $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
            $this->response($resp);
        }
          $user_id=$data['user_id'];
          $url=$GLOBALS['url'];
          $group_chat_id=$data['group_chat_id'];
          $query="SELECT c.id as chat_id,u.id,u.full_name, c.message,c.file,concat('".$url."','uploads2/',c.file) as file,file_type,case when u.profile_pic is null then '".$url."uploads2/users_profile/avatar.jpg' else concat('".$url."','uploads2/users_profile/',u.profile_pic) end as avatar,get_duration(c.datetime) as duration,
          get_group_chat_like(c.id) as like_count,
          get_group_chat_dislike(c.id) as dislike_count,
          case when gcl.id is null then 0 else 1 end as user_like,
          case when gcd.id is null then 0 else 1 end as user_dislike,
          get_group_chat_reply(c.id) as reply_count,
          g.user_id as group_owner_id

          FROM users as u INNER JOIN group_chat as c ON u.id=c.sender_id
          left join `groups` as g on g.id=c.group_id 
            left join group_chat_like as gcl on gcl.group_chat_id=c.id and gcl.user_id=$user_id
            left join group_chat_dislike as gcd on gcd.group_chat_id=c.id and gcd.user_id=$user_id
            WHERE c.group_id=$group_chat_id and c.is_deleted=0 ORDER BY c.id";

            $recdata= $this->common_model->getArrayByQuery($query);
            $allcmnt=array();
            foreach ($recdata as $value) {
              $group_chat_id=$value['chat_id'];
              $query="SELECT c.id as chat_reply_id,u.id,u.full_name, c.message,c.file,concat('".$url."','uploads2/',c.file) as file,file_type,case when u.profile_pic is null then '".$url."uploads2/users_profile/avatar.jpg' else concat('".$url."','uploads2/users_profile/',u.profile_pic) end as avatar,get_duration(c.datetime) as duration FROM users as u INNER JOIN group_chat_reply as c ON u.id=c.sender_id WHERE c.group_chat_id=$group_chat_id and c.is_deleted=0 ORDER BY c.id";
              $c = $this->common_model->getArrayByQuery($query);
              $value['reply'] = $c;
              $allcmnt=$value;
              $arr[]=$allcmnt;
                  }
                  
            if(!empty($arr))
            {    
               $resp = array('code' => true, 'message' => 'Chat data found','recdata'=>$arr);
            } 
            else 
            { 
               $resp = array('code' => ERROR, 'message' => 'error!!!');
            }
            $this->response($resp);    
  }



  public function group_chat_reply_post() {

          //check api key
      $api_key= $_POST['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$_POST['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }
          $group_chat_id=$_POST['group_chat_id'];
          $file=null;
          $file_type=null;

           if(!empty($_FILES["file"]['name']) )
            {
                $imagename=time().$_FILES["file"]["name"];
                $tnm=$_FILES["file"]["tmp_name"];
                $dbpath = base_url().'uploads2/'.$imagename;
                $flag=move_uploaded_file($tnm,"uploads2/".$imagename);
                $file=$imagename;
                $file_type=$_POST['file_type'];
            } 

          $dataArray = array('group_chat_id' => $group_chat_id, 'sender_id' => $_POST['user_id'], 'message' => $_POST['message'],'file' => $file, 'file_type' => $file_type,'ip'=>$_SERVER['REMOTE_ADDR']);
        $chat= $this->common_model->addRecords("group_chat_reply", $dataArray);
       if($chat){
        $recdata=$this->common_model->getSingleRecordById('group_chat_reply',array('id' =>$chat));

            $resp = array('code' => true, 'message' => 'SUCCESS', 'response' => 'Chat reply posted successfully','recdata'=>$recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response' => 'Not Posted');
        }
        $this->response($resp);
  }


  public function group_chat_reply_like_post() {
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        $required_parameter = array('group_chat_reply_id','user_id','api_key');
          $chk_error = check_required_value($required_parameter, $object_info);
        if ($chk_error)
        {

            $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
            $this->response($resp);
        }
          $group_chat_reply_id=$data['group_chat_reply_id'];
          $check_like = $this->common_model->getSingleRecordById("group_chat_reply_like", array('group_chat_reply_id' => $data['group_chat_reply_id'],'user_id' => $data['user_id']));
              $id=$check_like['id'];
        if(!empty($check_like)) {
                $param = $this->common_model->do_delete("group_chat_reply_like",$check_like['id']);
                $query="select count(id) as count from group_chat_reply_like where group_chat_reply_id=$group_chat_reply_id";
                $param = $this->common_model->getArrayByQuery($query);
                $resp = array('code' => true, 'message' => 'SUCCESS', 'response'   => 'Like Removed' ,'like_count'=>$param[0]['count']);
                $this->response($resp);
            }
          

          $dataArray = array( 'group_chat_reply_id' => $data['group_chat_reply_id'],'user_id'=>$data['user_id']);
       

            
            $recdata=$this->common_model->addRecords("group_chat_reply_like",$dataArray);
       
            if(!empty($recdata))
            {    
               $query="select count(id) as count from group_chat_reply_like where group_chat_reply_id=$group_chat_reply_id";
                $param = $this->common_model->getArrayByQuery($query);
                $resp = array('code' => true, 'message' => 'SUCCESS', 'response'   => 'Group chat reply liked!!' ,'like_count'=>$param[0]['count']);
            } 
            else 
            { 
               $resp = array('code' => false, 'message' => 'error!!!');
            }
            $this->response($resp);    
  }


  public function group_chat_reply_dislike_post() {
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        $required_parameter = array('group_chat_reply_id','user_id','api_key');
          $chk_error = check_required_value($required_parameter, $object_info);
        if ($chk_error)
        {

            $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
            $this->response($resp);
        }
          $group_chat_reply_id=$data['group_chat_reply_id'];
          $check_like = $this->common_model->getSingleRecordById("group_chat_reply_dislike", array('group_chat_reply_id' => $data['group_chat_reply_id'],'user_id' => $data['user_id']));
              $id=$check_like['id'];
        if(!empty($check_like)) {
                $param = $this->common_model->do_delete("group_chat_reply_dislike",$check_like['id']);
                $query="select count(id) as count from group_chat_reply_dislike where group_chat_reply_id=$group_chat_reply_id";
                $param = $this->common_model->getArrayByQuery($query);
                $resp = array('code' => true, 'message' => 'SUCCESS', 'response'   => 'Dislike Removed' ,'dislike_count'=>$param[0]['count']);
                $this->response($resp);
            }
          

          $dataArray = array( 'group_chat_reply_id' => $data['group_chat_reply_id'],'user_id'=>$data['user_id']);
          $recdata=$this->common_model->addRecords("group_chat_reply_dislike",$dataArray);
       
            if(!empty($recdata))
            {    
               $query="select count(id) as count from group_chat_reply_dislike where group_chat_reply_id=$group_chat_reply_id";
                $param = $this->common_model->getArrayByQuery($query);
                $resp = array('code' => true, 'message' => 'SUCCESS', 'response'   => 'Group chat reply disliked!!' ,'dislike_count'=>$param[0]['count']);
            } 
            else 
            { 
               $resp = array('code' => false, 'message' => 'error!!!');
            }
            $this->response($resp);    
  }


  public function group_chat_reply_delete_post() {
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        $required_parameter = array('group_chat_reply_id','user_id','api_key');
          $chk_error = check_required_value($required_parameter, $object_info);
        if ($chk_error)
        {

            $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
            $this->response($resp);
        }

         /* Update in users Table */   
       $updateArr = array( 'is_deleted' => 1);
       $condition = array('id' => $data['group_chat_reply_id']);

            /* Update in users Table */        
            $recdata=$this->common_model->updateRecords("group_chat_reply", $updateArr,$condition);
       
            
            if(!empty($recdata))
            {    
               $resp = array('code' => true, 'message' => 'Group chat reply deleted!!');
            } 
            else 
            { 
               $resp = array('code' => ERROR, 'message' => 'error!!!');
            }
            $this->response($resp);    
  }


  public function repost_post() {

      
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id', 'repost_comment','post_id','api_key');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }
              //check api key
      $api_key= $data['api_key'];
      $post_id= $data['post_id'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }


        $postdata=$this->common_model->getSingleRecordById('post',array('id' =>$data['post_id']));

        $dataArray = array('repost_id'=>$data['post_id'],'repost_comment'=>$data['repost_comment'],'repost_user_id'=>$postdata['user_id'],'repost_datetime'=>$postdata['datetime'], 'group_id' => $postdata['group_id'],'user_id' => $data['user_id'], 'message' => $postdata['message'],'file' =>$postdata['file'], 'file_type' => $postdata['file_type'],'ip'=>$_SERVER['REMOTE_ADDR']);
        $post= $this->common_model->addRecords("post", $dataArray);
       if($post){
        $query="select * from post_hashtag where post_id=$post_id";
        $hashtag= $this->common_model->getArrayByQuery($query);

        if(!empty($hashtag)) {
        
          foreach ($hashtag as $value) {
          $dataArray = array('post_id' => $post,'hashtag' => trim($value['hashtag']),'ip'=>$_SERVER['REMOTE_ADDR']);
          $this->common_model->addRecords("post_hashtag", $dataArray);
          }
          
        } 

        $query="select * from post_nsfw where post_id=$post_id";
        $nsfw= $this->common_model->getArrayByQuery($query);
        if(!empty($nsfw)) {
          foreach ($nsfw as $value) {
          $dataArray = array('post_id' => $post,'nsfw' => $value['nsfw'],'ip'=>$_SERVER['REMOTE_ADDR']);
          $this->common_model->addRecords("post_nsfw", $dataArray);
          }
          
        }
        $recdata=$this->common_model->getSingleRecordById('post',array('id' =>$post));
          //NOTIFICATION STARTS
        $app_url=$GLOBALS['app_url'];
        $post_user_id=$recdata['user_id'];
        $group_id=$recdata['group_id'];
        $query="select case when p.group_id is null then get_user_fullname($post_user_id) else get_group_name($group_id) end as sender,p.user_id as sender_id,f.follower_id as recipient_id from post as p inner join follow as f on f.following_id=p.user_id where p.id=$post";
        $ndata=$this->common_model->getArrayByQuery($query);
        foreach ($ndata as $value) {
        $title="Post shared by ".$value['sender']."";
        $message="Post shared by ".$value['sender']."";
        $dataArray = array('recipient_id'=>$value['recipient_id'],'sender_id'=>$value['sender_id'],'title'=>$title,'message'=>$message,'link'=>$app_url.'timeLine/'.$post);
        $this->common_model->addRecords("notification", $dataArray);
        }
        //NOTIFICATION ENDS

            $resp = array('code' => true, 'message' => 'SUCCESS', 'response' => 'Post successfully','recdata'=>$recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response' => 'Not Posted');
        }
        $this->response($resp);
  }

  public function edit_post_post() {

          //check api key
      $api_key= $_POST['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$_POST['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }
           $check_key = $this->common_model->getSingleRecordById('post',array('id' =>$_POST['post_id']));
          $group_id=$check_key['group_id'];
          $file=$check_key['file'];
          $file_type=$check_key['file_type'];
          $filepath=null;
          if(!empty($_POST['group_id'])) {
            $group_id=$_POST['group_id'];
          }
           if(!empty($_POST['old_file_path'])){
              $file=$check_key['file'];
              $file_type=$check_key['file_type'];
              $filepath=$check_key['file'];
            }
              else{
              $file=null;
              $file_type=null;
            }

            
            if(!empty($_FILES["file"]['name']) )
            {
                 $hash=$this->ipfs_upload($_FILES['file']['tmp_name']);
              $hash=json_decode($hash);
              //$filepath=$hash->IpfsHash.str_replace('/tmp','',$_FILES['file']['tmp_name']);
                $filepath=$hash->result->hash;
                $imagename=time().$_FILES["file"]["name"];
                $tnm=$_FILES["file"]["tmp_name"];
                $dbpath = base_url().'uploads2/'.$imagename;
                $flag=move_uploaded_file($tnm,"uploads2/".$imagename);
                $file=$imagename;
                $file_type=$_POST['file_type'];
            } 

            if($_POST['is_repost']==0){
          $dataArray = array('group_id' => $check_key['group_id'], 'user_id' => $check_key['user_id'], 'message' => $_POST['message'],'file' => $filepath, 'file_type' => $file_type,'ip'=>$_SERVER['REMOTE_ADDR']);
        }
        else{
          $dataArray = array('group_id' => $check_key['group_id'], 'user_id' => $check_key['user_id'], 'repost_comment' => $_POST['message'],'file' => $file, 'file_type' => $file_type,'ip'=>$_SERVER['REMOTE_ADDR']);
        }
          $condition=array('id'=>$_POST['post_id']);
        $post= $this->common_model->updateRecords("post", $dataArray,$condition);
       if($post){
        if(!empty($_POST['hashtag'])) {
          $condition=array('post_id' => $check_key['id']);
          $this->common_model->deleteRecords("post_hashtag",$condition);
          $hash=explode(',', $_POST['hashtag']);
          foreach ($hash as $value) {
          $dataArray = array('post_id' => $check_key['id'],'hashtag' => trim($value),'ip'=>$_SERVER['REMOTE_ADDR']);
          $this->common_model->addRecords("post_hashtag", $dataArray);
          }
          
        } 

        if(!empty($_POST['nsfw'])) {
          $condition=array('post_id' => $check_key['id']);
          $this->common_model->deleteRecords("post_nsfw",$condition);
          $hash=explode(',', $_POST['nsfw']);
          foreach ($hash as $value) {
          $dataArray = array('post_id' => $check_key['id'],'nsfw' => $value,'ip'=>$_SERVER['REMOTE_ADDR']);
          $this->common_model->addRecords("post_nsfw", $dataArray);
          }
          
        }
        $post_id=$_POST['post_id'];
        $user_id=$_POST['user_id'];
        $url=$GLOBALS['url'];
         $query="SELECT 
              p.id as post_id,
              p.user_id,
              coalesce(g.id,'') as group_id,
              coalesce(g.group_name,'') as group_name,
              u.full_name,
              coalesce(p.file_type,'') as file_type,
              case when u.profile_pic is null then '".$url."uploads2/users_profile/avatar.jpg' else concat('".$url."','uploads2/users_profile/',u.profile_pic) end as profile_pic,
              case when u.background_image is null then '".$url."uploads2/users_profile/banner.jpg' else concat('".$url."','uploads2/users_profile/',u.background_image) end as background_image,
              case when repost_id is null then p.message else p.repost_comment end as message,
              case when repost_id is null then coalesce(p.repost_comment,'') else p.message end as repost_comment,
              
              case when p.file is null then '' else concat('".$url."','uploads2/',p.file) end as file,
              get_hashtag(p.id) as hashtag,
              is_nsfw(p.id) as is_nsfw,
              get_nsfw(p.id) as nsfw,
              case when p.repost_id is not null then 1 else 0 end as is_repost,
              coalesce(get_repost_count(p.id),'') as repost_count,
              coalesce(ru.id,'') as repost_user_id,
              coalesce(ru.full_name,'') as repost_user,
              case when repost_datetime is null then '' else get_duration(repost_datetime) end as repost_duration,
              
              case when ru.profile_pic is null then '".$url."uploads2/users_profile/avatar.jpg' else concat('".$url."','uploads2/users_profile/',ru.profile_pic) end as repost_profile_pic,
              get_duration(p.datetime) as duration,
              get_likes(p.id) as like_count, 
              get_dislikes(p.id) as dislike_count,
              case when pl.id is null then 0 else 1 end as user_like,
              case when pd.id is null then 0 else 1 end as user_dislike,
              get_comments(p.id) as comments_count,
              case when f.id is null then 0 else 1 end as is_following
              FROM post as p 
              left join `groups` as g on g.id=p.group_id
              left join users as u on u.id=p.user_id
              left join users as ru on ru.id=p.repost_user_id 
              left join post_like as pl on pl.post_id=p.id and pl.user_id=$user_id 
              left join post_dislike as pd on pd.post_id=p.id and pd.user_id=$user_id 
               left join follow as f on f.following_id=p.user_id and f.follower_id=$user_id 
              where p.id=$post_id";
            $recdata= $this->common_model->getArrayByQuery($query);
          //$recdata=$this->common_model->getSingleRecordById('post',array('id' =>$check_key['id']));
            $resp = array('code' => true, 'message' => 'SUCCESS', 'response' => 'Post updated successfully','recdata'=>$recdata[0]);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response' => 'Not updated!!');
        }
        $this->response($resp);
  }


  public function post_comment_post() {
        $user_id=$_POST['user_id'];
         //check api key
      $api_key= $_POST['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$_POST['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

        /* Check for required parameter */
        // $pdata = file_get_contents("php://input");
        // $data = json_decode( $pdata,true );
        // $object_info = $data;
        // //print_r($object_info);exit;
        // $required_parameter = array('user_id', 'message');
        // $chk_error = check_required_value($required_parameter, $object_info);
        //   if ($chk_error) {
        //       $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
        //       $this->response($resp);
        //   }
          $file=null;
          if(isset($_FILES["file"]['name']))
            {
                $imagename=time().$_FILES["file"]["name"];
                $tnm=$_FILES["file"]["tmp_name"];
                $dbpath = base_url().'uploads2/'.$imagename;
                $flag=move_uploaded_file($tnm,"uploads2/".$imagename);
                $file=$imagename;
                
            } 

          $dataArray = array('post_id' => $_POST['post_id'],'user_id' => $_POST['user_id'], 'comment' => $_POST['comment'],'file' => $file,'file_type' => $_POST['file_type'],'ip'=>$_SERVER['REMOTE_ADDR']);
        $post= $this->common_model->addRecords("post_comment", $dataArray);
       if($post){
           $recdata=$this->common_model->getSingleRecordById('post_comment',array('id' =>$post));
           $post_user=$this->common_model->getSingleRecordById('post',array('id' =>$recdata['post_id']));

              //NOTIFICATION STARTS
           $app_url=$GLOBALS['app_url'];
        $commented_by=$recdata['user_id'];
        $recipient_id=$post_user['user_id'];
        $post_id=$post_user['id'];
        $query="select get_user_fullname($commented_by) as sender,$commented_by as sender_id,$recipient_id as recipient_id from post as p where p.id=$post_id and user_id<>$user_id";
        
        $ndata=$this->common_model->getArrayByQuery($query);
        foreach ($ndata as $value) {
        $title=$value['sender']." commented on your post";
        $message=$value['sender']." commented on your post";
        $dataArray = array('recipient_id'=>$value['recipient_id'],'sender_id'=>$value['sender_id'],'title'=>$title,'message'=>$message,'link'=>$app_url.'timeLine/'.$_POST['user_id']);
        
        $this->common_model->addRecords("notification", $dataArray);
        }
        //NOTIFICATION ENDS


            $resp = array('code' => true, 'message' => 'SUCCESS', 'response' => 'Post commented successfully','recdata'=>$recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response' => 'Not Posted');
        }
        $this->response($resp);
  }

  public function post_comment_edit_post() {

         //check api key
      $api_key= $_POST['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$_POST['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

          $check_key = $this->common_model->getSingleRecordById('post_comment',array('id' =>$_POST['post_comment_id']));
          $file=$check_key['file'];
          if(isset($_FILES["file"]['name']))
            {
                $imagename=time().$_FILES["file"]["name"];
                $tnm=$_FILES["file"]["tmp_name"];
                $dbpath = base_url().'uploads2/'.$imagename;
                $flag=move_uploaded_file($tnm,"uploads2/".$imagename);
                $file=$imagename;
            } 

          $dataArray = array('post_id' => $check_key['post_id'],'user_id' => $check_key['user_id'], 'comment' => $_POST['comment'],'file' => $file,'file_type' => $_POST['file_type'],'ip'=>$_SERVER['REMOTE_ADDR']);
          $condition=array('id' => $_POST['post_comment_id'] );
        $post= $this->common_model->updateRecords("post_comment", $dataArray,$condition);
       if($post){
           $recdata=$this->common_model->getSingleRecordById('post_comment',array('id' =>$_POST['post_comment_id']));
            $resp = array('code' => true, 'message' => 'SUCCESS', 'response' => 'Post commented updated successfully','recdata'=>$recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response' => 'Error!!');
        }
        $this->response($resp);
  }

  public function post_comment_reply_post() {

                //check api key
      $api_key= $_POST['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$_POST['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

          $file=null;
          if(isset($_FILES["file"]['name']))
            {
                $imagename=time().$_FILES["file"]["name"];
                $tnm=$_FILES["file"]["tmp_name"];
                $dbpath = base_url().'uploads2/'.$imagename;
                $flag=move_uploaded_file($tnm,"uploads2/".$imagename);
                $file=$imagename;
            } 

          $dataArray = array('post_comment_id' => $_POST['post_comment_id'],'user_id' => $_POST['user_id'], 'reply' => $_POST['reply'],'file' => $file,'file_type' => $_POST['file_type'],'ip'=>$_SERVER['REMOTE_ADDR']);
        $post= $this->common_model->addRecords("post_comment_reply", $dataArray);
       if($post){
        $recdata=$this->common_model->getSingleRecordById('post_comment_reply',array('id' =>$post));
        $post_comment=$this->common_model->getSingleRecordById('post_comment',array('id' =>$recdata['post_comment_id']));
        $post=$this->common_model->getSingleRecordById('post',array('id' =>$post_comment['post_id']));
        

        //NOTIFICATION STARTS
        $app_url=$GLOBALS['app_url'];
        $replyed_by=$recdata['user_id'];
        $recipient_id=$post['user_id'];
        $post_id=$post['id'];
        $query="select get_user_fullname($replyed_by) as sender,$replyed_by as sender_id,$recipient_id as recipient_id from post as p where p.id=$post_id";
        
        $ndata=$this->common_model->getArrayByQuery($query);
        foreach ($ndata as $value) {
        $title=$value['sender']." replyed on your comment ".$post_comment['comment'];
        $message=$value['sender']." replyed on your comment ".$post_comment['comment'];
        $dataArray = array('recipient_id'=>$value['recipient_id'],'sender_id'=>$value['sender_id'],'title'=>$title,'message'=>$message,'link'=>$app_url.'timeLine/'.$_POST['user_id']);
        
        $this->common_model->addRecords("notification", $dataArray);
        }
        //NOTIFICATION ENDS

            $resp = array('code' => true, 'message' => 'SUCCESS', 'response' => 'Comment replyed successfully','recdata'=>$recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response' => 'Not replyed');
        }
        $this->response($resp);
  }


  public function post_comment_reply_edit_post() {

                //check api key
      $api_key= $_POST['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$_POST['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }
          $check_key = $this->common_model->getSingleRecordById('post_comment_reply',array('id' =>$_POST['post_comment_reply_id']));
          $file=$check_key['file'];
          if(isset($_FILES["file"]['name']))
            {
                $imagename=time().$_FILES["file"]["name"];
                $tnm=$_FILES["file"]["tmp_name"];
                $dbpath = base_url().'uploads2/'.$imagename;
                $flag=move_uploaded_file($tnm,"uploads2/".$imagename);
                $file=$imagename;
            } 

          $dataArray = array('post_comment_id' => $check_key['post_comment_id'],'user_id' => $check_key['user_id'], 'reply' => $_POST['reply'],'file' => $file,'file_type' => $_POST['file_type'],'ip'=>$_SERVER['REMOTE_ADDR']);
          $condition= array('id' => $_POST['post_comment_reply_id']);
        $post= $this->common_model->updateRecords("post_comment_reply", $dataArray,$condition);
       if($post){
            $recdata=$this->common_model->getSingleRecordById('post_comment_reply',array('id' =>$_POST['post_comment_reply_id']));
            $resp = array('code' => true, 'message' => 'SUCCESS', 'response' => 'Comment replyed updated successfully','recdata'=>$recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response' => 'Error!!');
        }
        $this->response($resp);
  }


    public function post_like_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('post_id',  'user_id','api_key');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }


          $post_id=$data['post_id'];
          $user_id=$data['user_id'];
          //CHECK IF POST ALLREADY LIKED 
        $check_like = $this->common_model->getSingleRecordById("post_like", array('post_id' => $data['post_id'],'user_id' => $data['user_id']));
        
        
        if(!empty($check_like)) {
        $id=$check_like['id'];
                $param = $this->common_model->do_delete("post_like",$check_like['id']);
                $query="select count(id) as count from post_like where post_id=$post_id";
                $param = $this->common_model->getArrayByQuery($query);
                $resp = array('code' => true, 'message' => 'SUCCESS', 'response'   => 'Like Removed' ,'like_count'=>$param[0]['count']);
                $this->response($resp);
            }
            $data=array('post_id'=>$post_id,'user_id'=>$user_id,'ip'=>$_SERVER['REMOTE_ADDR']);
        $param = $this->common_model->addRecords("post_like", $data);
        if($param){
        $query="select count(id) as count from post_like where post_id=$post_id";
        $param = $this->common_model->getArrayByQuery($query);

         $post_like = $this->common_model->getSingleRecordById("post_like", array('post_id' => $data['post_id'],'user_id' => $data['user_id']));
         $post = $this->common_model->getSingleRecordById("post", array('id' => $post_like['post_id']));
         //NOTIFICATION STARTS
         $app_url=$GLOBALS['app_url'];
        $sender_id=$post_like['user_id'];
        $recipient_id=$post['user_id'];
        $post_id=$post['id'];
        $query="select get_user_fullname($sender_id) as sender,$sender_id as sender_id,$recipient_id as recipient_id from post as p where p.id=$post_id";
        
        $ndata=$this->common_model->getArrayByQuery($query);
        foreach ($ndata as $value) {
        $title=$value['sender']." liked your post ".$post['message'];
        $message=$value['sender']." liked your post ".$post['message'];
        $dataArray = array('recipient_id'=>$value['recipient_id'],'sender_id'=>$value['sender_id'],'title'=>$title,'message'=>$message,'link'=>$app_url.'timeLine/'.$post['user_id'].'/'.$post_id,'post_id'=>$post_id);
        
        $this->common_model->addRecords("notification", $dataArray);
        }
        //NOTIFICATION ENDS

          /* Response array */
            $resp = array('code' => true, 'message' => 'SUCCESS', 'response'  => 'Liked','like_count'=>$param[0]['count']);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'Invalid Data, please try again');
        }
        $this->response($resp);
  }

    public function post_dislike_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('post_id',  'user_id','api_key');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

            $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }



          $post_id=$data['post_id'];
          $user_id=$data['user_id'];
          //CHECK IF POST ALLREADY LIKED 
        $check_like = $this->common_model->getSingleRecordById("post_dislike", array('post_id' => $data['post_id'],'user_id' => $data['user_id']));
        $id=$check_like['id'];
        
        if(!empty($check_like)) {
                $param = $this->common_model->do_delete("post_dislike",$check_like['id']);
                $query="select count(id) as count from post_dislike where post_id=$post_id";
                $param = $this->common_model->getArrayByQuery($query);
                $resp = array('code' => true, 'message' => 'SUCCESS', 'response'   => 'Dislike Removed' ,'dislike_count'=>$param[0]['count']);
                $this->response($resp);
            }
            $data=array('post_id'=>$post_id,'user_id'=>$user_id,'ip'=>$_SERVER['REMOTE_ADDR']);
        $param = $this->common_model->addRecords("post_dislike", $data);
        if($param){
        $query="select count(id) as count from post_dislike where post_id=$post_id";
        $param = $this->common_model->getArrayByQuery($query);

          /* Response array */
            $resp = array('code' => true, 'message' => 'SUCCESS', 'response'  => 'Disliked','dislike_count'=>$param[0]['count']);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'Invalid Data, please try again');
        }
        $this->response($resp);
  }


  public function post_comment_like_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('post_comment_id',  'user_id','api_key');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

          $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

          $post_comment_id=$data['post_comment_id'];
          $user_id=$data['user_id'];
          //CHECK IF POST ALLREADY LIKED 
        $check_like = $this->common_model->getSingleRecordById("post_comment_like", array('post_comment_id' => $data['post_comment_id'],'user_id' => $data['user_id']));
        $id=$check_like['id'];
        
        if(!empty($check_like)) {
                $param = $this->common_model->do_delete("post_comment_like",$check_like['id']);
                $query="select count(id) as count from post_comment_like where post_comment_id=$post_comment_id";
                $param = $this->common_model->getArrayByQuery($query);
                $resp = array('code' => true, 'message' => 'SUCCESS', 'response'   => 'Like Removed' ,'like_count'=>$param[0]['count']);
                $this->response($resp);
            }
        $data=array('post_comment_id'=>$post_comment_id,'user_id'=>$user_id,'ip'=>$_SERVER['REMOTE_ADDR']);
        $param = $this->common_model->addRecords("post_comment_like", $data);
        if($param){
        $query="select count(id) as count from post_comment_like where post_comment_id=$post_comment_id";
        $param = $this->common_model->getArrayByQuery($query);

        $post_comment = $this->common_model->getSingleRecordById('post_comment', array('id' => $data['post_comment_id'] ) );
         //NOTIFICATION STARTS
        $app_url=$GLOBALS['app_url'];
        $sender_id=$data['user_id'];
        $recipient_id=$post_comment['user_id'];
        $post_id=$post_comment['post_id'];
        $query="select get_user_fullname($sender_id) as sender,$sender_id as sender_id,$recipient_id as recipient_id from post as p where p.id=$post_id";
        
        $ndata=$this->common_model->getArrayByQuery($query);
        foreach ($ndata as $value) {
        $title=$value['sender']." liked your comment ".$post_comment['comment'];
        $message=$value['sender']." liked your comment ".$post_comment['comment'];
        $dataArray = array('recipient_id'=>$value['recipient_id'],'sender_id'=>$value['sender_id'],'title'=>$title,'message'=>$message,'link'=>$app_url.'timeLine/'.$sender_id);
        
        $this->common_model->addRecords("notification", $dataArray);
        }
        //NOTIFICATION ENDS


          /* Response array */
            $resp = array('code' => true, 'message' => 'SUCCESS', 'response'  => 'Liked','like_count'=>$param[0]['count']);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'Invalid Data, please try again');
        }
        $this->response($resp);
  }


  public function forget_password_post() {

      $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        $required_parameter = array('email');
        $chk_error = check_required_value($required_parameter, $object_info);
      if ($chk_error) 
      {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
      }
        $get_userdata = $this->common_model->getSingleRecordById('users', array('email' => $data['email'] ) );

        if(!empty($get_userdata))
        {
          $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
          $code= md5(substr(str_shuffle($permitted_chars), 0, 10));
          $to_email=$data['email'];
          $subject="Forget Password Link ";
          $msg="Dear User, to complete your forget password process, plese follow this link  
          https://api.victus.club/resetpassword/".$code;
          $this->email_confirmation($to_email,$subject,$msg);
          $this->common_model->updateRecords('users', array('forget_password_code'=> $code) , array('email' =>$data['email']));
          $get_userdata = $this->common_model->getSingleRecordById('users', array('email' => $data['email'] ) );
          $resp = array('code' => true, 'message' => 'An email send to you to recover your password ', 'result_data' => $get_userdata);
        } else {

          $resp = array('code' => false, 'message' => 'FAILURE', 'response' =>  'Some error occured');
        }
        $this->response($resp);
  }


 /** Change Password */
  public function reset_password_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('code','new_password','confirm_password');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

       if($data['new_password'] != $data['confirm_password']) {
            $resp = array('code' => false, 'message' =>  'Password and confirm password fields not matched');
            $this->response($resp);
        }

        $code= $data['code'];
        $check = $this->common_model->getSingleRecordById("users", array('forget_password_code' => $code));
         //print_r($check_key);exit;
        if(!empty($check)) {
            /* Change password */
            $condition = array('
              id' => $check['id']);
            $updateArr = array('password' => md5($data['new_password']));
            $this->common_model->updateRecords('users', $updateArr, $condition);
          /* Response array */
        $resp = array('code' => true, 'message' =>  'Password reset successfully');
        } else {
            $resp = array('code' => false, 'message' =>  'Invalid Data, please try again');
        }
        $this->response($resp);
  }

 /** Change Password */
  public function change_password_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','old_password', 'new_password','confirm_password','api_key');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

          $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

       if($data['new_password'] != $data['confirm_password']) {
            $resp = array('code' => false, 'message' =>  'Password and confirm password fields not matched');
            $this->response($resp);
        }

        $userId = $data['user_id'];
        
        $check_key = $this->common_model->getRecordCount("users", array('id' => $userId,'password' =>md5($data['old_password'])));
         //print_r($check_key);exit;
        if($check_key == 0) {
            $resp = array('code' => true, 'message' =>  'Old Password Not Matched');
             $this->response($resp);
           }
        if($check_key == 1) {
            /* Change password */
            $condition = array('
              id' => $userId);
            $updateArr = array('password' => md5($data['new_password']));
            $this->common_model->updateRecords('users', $updateArr, $condition);
          /* Response array */
            $resp = array('code' => true, 'message' =>  'Password changed successfully');
        } else {
            $resp = array('code' => false, 'message' =>  'Invalid Data, please try again');
        }
        $this->response($resp);
  }


  /** Profile Api */
  public function timeline_post() {

       /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        $required_parameter = array('user_id','api_key');
          $chk_error = check_required_value($required_parameter, $object_info);
        if ($chk_error)
        {

            $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
            $this->response($resp);
        }
         $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$data['api_key']));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }
            $url=$GLOBALS['url']; 
            $ipfs_url=$GLOBALS['ipfs_url'];
            $user_id=$data['user_id'];
            $query="SELECT 
              p.id as post_id,
              p.user_id,
              coalesce(g.id,'') as group_id,
              coalesce(g.group_name,'') as group_name,
              u.full_name,
              coalesce(p.file_type,'') as file_type,
              case when u.profile_pic is null then '".$url."uploads2/users_profile/avatar.jpg' else concat('".$url."','uploads2/users_profile/',u.profile_pic) end as profile_pic,
              case when u.background_image is null then '".$url."uploads2/users_profile/banner.jpg' else concat('".$url."','uploads2/users_profile/',u.background_image) end as background_image,
              case when repost_id is null then p.message else p.repost_comment end as message,
              case when repost_id is null then coalesce(p.repost_comment,'') else p.message end as repost_comment,
              
              case when p.file is null then '' else concat('".$ipfs_url."',p.file) end as file,
              get_hashtag(p.id) as hashtag,
              is_nsfw(p.id) as is_nsfw,
              get_nsfw(p.id) as nsfw,
              case when p.repost_id is not null then 1 else 0 end as is_repost,
              coalesce(get_repost_count(p.id),'') as repost_count,
              coalesce(ru.id,'') as repost_user_id,
              coalesce(ru.full_name,'') as repost_user,
              case when repost_datetime is null then '' else get_duration(repost_datetime) end as repost_duration,
              
              case when ru.profile_pic is null then '".$url."uploads2/users_profile/avatar.jpg' else concat('".$url."','uploads2/users_profile/',ru.profile_pic) end as repost_profile_pic,
              get_duration(p.datetime) as duration,
              get_likes(p.id) as like_count, 
              get_dislikes(p.id) as dislike_count,
              case when pl.id is null then 0 else 1 end as user_like,
              case when pd.id is null then 0 else 1 end as user_dislike,
              get_comments(p.id) as comments_count,
              case when f.id is null then 0 else 1 end as is_following
              FROM post as p 
              left join `groups` as g on g.id=p.group_id
              left join users as u on u.id=p.user_id
              left join users as ru on ru.id=p.repost_user_id 
              left join post_like as pl on pl.post_id=p.id and pl.user_id=$user_id 
              left join post_dislike as pd on pd.post_id=p.id and pd.user_id=$user_id 
               left join follow as f on f.following_id=p.user_id and f.follower_id=$user_id 
              where p.isdeleted=0 and p.group_id is null
              and p.user_id not in (select blocked_user_id from block where user_id=$user_id)
              and p.user_id not in (select user_id from block where blocked_user_id=$user_id)
             
              order by p.id desc limit 100";
            $recdata= $this->common_model->getArrayByQuery($query);
            //$recdata1 = array();
            foreach ($recdata as $value) {
              
              $post_id=$value['post_id'];
              $query="select 
                pc.id as post_comment_id,
                pc.user_id,
                u.full_name,
                case when u.profile_pic is null then '".$url."uploads2/users_profile/avatar.jpg' else concat('".$url."','uploads2/users_profile/',u.profile_pic) end as profile_pic,
                coalesce(comment,'') as comment,
                case when pc.file is null then '' else concat('".$url."','uploads2/',pc.file) end as file, 
                pc.file_type,
                get_comment_reply(pc.id) as reply_count,
                get_duration(pc.datetime) as duration  
                from post_comment as pc left join users as u on u.id=pc.user_id where pc.post_id=$post_id and isdeleted=0 order by pc.id ";
              $comments = $this->common_model->getArrayByQuery($query); 
                $allcmnt = array();
                foreach ($comments as $c) {
                   $post_comment_id=$c['post_comment_id'];
                       $query="select 
                pcr.id as post_comment_reply_id,
                pcr.user_id,
                u.full_name,
                 case when u.profile_pic is null then '".$url."uploads2/users_profile/avatar.jpg' else concat('".$url."','uploads2/users_profile/',u.profile_pic) end as profile_pic,
                coalesce(reply,'') as reply,
                case when pcr.file is null then '' else concat('".$url."','uploads2/',pcr.file) end as file,
                pcr.file_type,
                get_duration(pcr.datetime) as duration  
                from post_comment_reply as pcr left join users as u on u.id=pcr.user_id where pcr.post_comment_id=$post_comment_id and isdeleted=0 order by pcr.id";                
                $c['reply'] = $this->common_model->getArrayByQuery($query);
                $allcmnt[] = $c;
                  }
                  $value['comments'] = $allcmnt;
                
                  $query="select hashtag from post_hashtag where post_id=$post_id";
                  $tag = $this->common_model->getArrayByQuery($query); 
                  $value['hashtag_link']=$tag;
                  $recdata1[]= $value;
                
            }
            // $recdata1=json_encode($recdata1,true);
            if(!empty($recdata1))
            {    
               $resp = array('code' => true, 'message' => 'SUCCESS', 'recdata' =>$recdata1 );
            } 
            else 
            { 
               $resp = array('code' => false, 'message' => array('error' => 'FAILURE', 'error_label' => 'Some error occured'));
            }
            $this->response($resp);
  }

  /** Profile Api */
  public function post_detail_post() {
       /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        $required_parameter = array('user_id','api_key','post_id');
          $chk_error = check_required_value($required_parameter, $object_info);
        if ($chk_error)
        {

            $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
            $this->response($resp);
        }
         $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }
            $url=$GLOBALS['url'];
            $ipfs_url=$GLOBALS['ipfs_url'];
            $user_id=$data['user_id'];
            $post_id=$data['post_id'];
            $query="SELECT 
              p.id as post_id,
              p.user_id,
              u.full_name,
              coalesce(p.file_type,'') as file_type,
              case when u.profile_pic is null then '".$url."uploads2/users_profile/avatar.jpg' else concat('".$url."','uploads2/users_profile/',u.profile_pic) end as profile_pic,
              case when u.background_image is null then '".$url."uploads2/users_profile/banner.jpg' else concat('".$url."','uploads2/users_profile/',u.background_image) end as background_image,
              case when repost_id is null then p.message else p.repost_comment end as message,
              case when repost_id is null then coalesce(p.repost_comment,'') else p.message end as repost_comment,
              case when p.file is null then '' else concat('".$ipfs_url."',p.file) end as file,
              case when repost_id is null then 0 else 1 end as is_repost,
              get_hashtag(p.id) as hashtag,
              is_nsfw(p.id) as is_nsfw,
              get_nsfw(p.id) as nsfw,
              get_duration(p.datetime) as duration,
              get_likes(p.id) as like_count, 
              get_dislikes(p.id) as dislike_count,
              case when pl.id is null then 0 else 1 end as user_like,
              case when pd.id is null then 0 else 1 end as user_dislike,
              get_comments(p.id) as comments_count,
              case when f.id is null then 0 else 1 end as is_following
              FROM post as p 
              left join users as u on u.id=p.user_id 
              left join post_like as pl on pl.post_id=p.id and pl.user_id=$user_id 
              left join post_dislike as pd on pd.post_id=p.id and pd.user_id=$user_id 
               left join follow as f on f.following_id=p.user_id and f.follower_id=$user_id 
              where p.id=$post_id";
            $recdata= $this->common_model->getArrayByQuery($query);
           
            if(!empty($recdata))
            {    
               $resp = array('code' => true, 'message' => 'SUCCESS', 'recdata' =>$recdata[0]);
            } 
            else 
            { 
               $resp = array('code' => false, 'message' => array('error' => 'FAILURE', 'error_label' => 'Some error occured'));
            }
            $this->response($resp);
  }

public function sujjested_channels_post() {
      //  /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        $required_parameter = array('user_id','api_key');
          $chk_error = check_required_value($required_parameter, $object_info);
        if ($chk_error)
        {

            $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
            $this->response($resp);
        }
         $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }
            $url=$GLOBALS['url'];
            $user_id=$data['user_id'];
            $query="SELECT 
          u.id as user_id,
          left(u.full_name,15) as full_name,
          case when u.profile_pic is null then '".$url."uploads2/users_profile/avatar.jpg' else concat('".$url."','uploads2/users_profile/',u.profile_pic) end as profile_pic,
         get_follower(u.id) as follower
         FROM users as u
         where u.id<>$user_id and u.id not in (select b.blocked_user_id from block as b where b.user_id=$user_id) and u.id not in (select b2.user_id from block as b2 where b2.blocked_user_id=$user_id) and u.id not in (select f.following_id from follow as f  where f.follower_id=$user_id) order by rand() limit 5";
            $recdata= $this->common_model->getArrayByQuery($query);
           
            if(!empty($recdata))
            {    
               $resp = array('code' => true, 'message' => 'SUCCESS', 'recdata' =>$recdata);
            } 
            else 
            { 
               $resp = array('code' => false, 'message' =>  'Some error occured');
            }
            $this->response($resp);
  }



  public function block_sujjested_channel_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','group_id','api_key');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

          $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

          $group_id=$data['group_id'];
          $user_id=$data['user_id'];
          //CHECK IF POST ALLREADY LIKED 
        $check_like = $this->common_model->getSingleRecordById("sujjected_channel_block", array('user_id' => $data['user_id'],'group_id' => $data['group_id']));
        $id=$check_like['id'];
        
        if(!empty($check_like)) {
                $resp = array('code' => false, 'message' => 'You already blocked this group');
                $this->response($resp);
            }

        $data=array('group_id'=>$group_id,'user_id'=>$user_id,'ip'=>$_SERVER['REMOTE_ADDR']);
        $param = $this->common_model->addRecords("sujjected_channel_block", $data);
        if($param){
        $resp = array('code' => true, 'message' => 'SUCCESS', 'response'  => 'Group Blocked!!');
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'Some error occured, please try again!!');
        }
        $this->response($resp);
  }


  /** Profile Api */
  public function user_timeline_post() {
       /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        $required_parameter = array('user_id','api_key','view_user_id');
          $chk_error = check_required_value($required_parameter, $object_info);
        if ($chk_error)
        {

            $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
            $this->response($resp);
        }
         $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

            $where="";
            
            $url=$GLOBALS['url'];
            $ipfs_url=$GLOBALS['ipfs_url'];
            $user_id=$data['user_id'];
            $view_user_id=$data['view_user_id'];
            if(!empty($data['post_id'])){
              $post_id=$data['post_id'];
              $where=" p.id=$post_id and ";
            }

            $query="SELECT 
              p.id as post_id,
              p.user_id,
              coalesce(g.id,'') as group_id,
              coalesce(g.group_name,'') as group_name,
              u.full_name,
              coalesce(p.file_type,'') as file_type,
              case when u.profile_pic is null then '".$url."uploads2/users_profile/avatar.jpg' else concat('".$url."','uploads2/users_profile/',u.profile_pic) end as profile_pic,
              case when u.background_image is null then '".$url."uploads2/users_profile/banner.jpg' else concat('".$url."','uploads2/users_profile/',u.background_image) end as background_image,
              case when repost_id is null then p.message else p.repost_comment end as message,
              case when repost_id is null then coalesce(p.repost_comment,'') else p.message end as repost_comment,
              case when p.file is null then '' else concat('".$ipfs_url."',p.file) end as file,
              get_hashtag(p.id) as hashtag,
              is_nsfw(p.id) as is_nsfw,
              get_nsfw(p.id) as nsfw,
              case when p.repost_id is not null then 1 else 0 end as is_repost,
              coalesce(get_repost_count(p.id),'') as repost_count,
              coalesce(ru.id,'') as repost_user_id,
              coalesce(ru.full_name,'') as repost_user,
              case when repost_datetime is null then '' else get_duration(repost_datetime) end as repost_duration,
              
              case when ru.profile_pic is null then '".$url."uploads/users_profile/avatar.jpg' else concat('".$url."','uploads2/users_profile/',ru.profile_pic) end as repost_profile_pic,
              get_duration(p.datetime) as duration,
              get_likes(p.id) as like_count, 
              get_dislikes(p.id) as dislike_count,
              case when pl.id is null then 0 else 1 end as user_like,
              case when pd.id is null then 0 else 1 end as user_dislike,
              get_comments(p.id) as comments_count,
              case when f.id is null then 0 else 1 end as is_following
              FROM post as p 
              left join `groups` as g on g.id=p.group_id
              left join users as u on u.id=p.user_id 
              left join users as ru on ru.id=p.repost_user_id
              left join post_like as pl on pl.post_id=p.id and pl.user_id=$user_id 
              left join post_dislike as pd on pd.post_id=p.id and pd.user_id=$view_user_id 
              left join follow as f on f.following_id=p.user_id and f.follower_id=$user_id 
              where $where p.user_id=$view_user_id and p.isdeleted=0  and p.group_id is null 
              order by p.id desc";

            $recdata= $this->common_model->getArrayByQuery($query);
            //$recdata1 = array();
            foreach ($recdata as $value) {
              
              $post_id=$value['post_id'];
              $query="select 
                pc.id as post_comment_id,
                pc.user_id,
                u.full_name,
                case when u.profile_pic is null then '".$url."uploads2/users_profile/avatar.jpg' else concat('".$url."','uploads2/users_profile/',u.profile_pic) end as profile_pic,
                coalesce(comment,'') as comment,
                case when pc.file is null then '' else concat('".$url."','uploads2/',pc.file) end as file,
                pc.file_type, 
                get_comment_reply(pc.id) as reply_count,
                get_duration(pc.datetime) as duration  
                from post_comment as pc left join users as u on u.id=pc.user_id where pc.post_id=$post_id and isdeleted=0 order by pc.id";
              $comments = $this->common_model->getArrayByQuery($query); 
                $allcmnt = array();
                foreach ($comments as $c) {
                   $post_comment_id=$c['post_comment_id'];
                       $query="select 
                pcr.id as post_comment_reply_id,
                pcr.user_id,
                u.full_name,
                case when u.profile_pic is null then '".$url."uploads2/users_profile/avatar.jpg' else concat('".$url."','uploads2/users_profile/',u.profile_pic) end as profile_pic,
                coalesce(reply,'') as reply,
                case when pcr.file is null then '' else concat('".$url."','uploads2/',pcr.file) end as file,
                pcr.file_type,
                get_duration(pcr.datetime) as duration  
                from post_comment_reply as pcr left join users as u on u.id=pcr.user_id where pcr.post_comment_id=$post_comment_id and isdeleted=0 order by pcr.id";                
                $c['reply'] = $this->common_model->getArrayByQuery($query);
                $allcmnt[] = $c;
                  }
                  $value['comments'] = $allcmnt;
                   $query="select hashtag from post_hashtag where post_id=$post_id";
                  $tag = $this->common_model->getArrayByQuery($query); 
                  $value['hashtag_link']=$tag;
                  $recdata1[]= $value;
              
            }
            // $recdata1=json_encode($recdata1,true);
            if(!empty($recdata1))
            {    
               $resp = array('code' => true, 'message' => 'SUCCESS', 'recdata' =>$recdata1 );
            } 
            else 
            { 
               $resp = array('code' => false, 'message' => array('error' => 'FAILURE', 'error_label' => 'Some error occured'));
            }
            $this->response($resp);
  }


public function hashtag_timeline_post() {
        
       /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        $required_parameter = array('user_id','api_key','hashtag');
          $chk_error = check_required_value($required_parameter, $object_info);
        if ($chk_error)
        {

            $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
            $this->response($resp);
        }
         $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));

      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }
            $url=$GLOBALS['url'];
            $ipfs_url=$GLOBALS['ipfs_url'];
            $user_id=$data['user_id'];
            $hashtag=$data['hashtag'];
            $query="SELECT 
              p.id as post_id,
              p.user_id,
              coalesce(g.id,'') as group_id,
              coalesce(g.group_name,'') as group_name,
              u.full_name,
              coalesce(p.file_type,'') as file_type,
              case when u.profile_pic is null then '".$url."uploads2/users_profile/avatar.jpg' else concat('".$url."','uploads2/users_profile/',u.profile_pic) end as profile_pic,
              case when u.background_image is null then '".$url."uploads2/users_profile/banner.jpg' else concat('".$url."','uploads2/users_profile/',u.background_image) end as background_image,
              case when repost_id is null then p.message else p.repost_comment end as message,
              case when repost_id is null then coalesce(p.repost_comment,'') else p.message end as repost_comment,
              case when p.file is null then '' else concat('".$ipfs_url."',p.file) end as file,
              get_hashtag(p.id) as hashtag,
              is_nsfw(p.id) as is_nsfw,
              get_nsfw(p.id) as nsfw,
              case when p.repost_id is not null then 1 else 0 end as is_repost,
              coalesce(get_repost_count(p.id),'') as repost_count,
              coalesce(ru.id,'') as repost_user_id,
              coalesce(ru.full_name,'') as repost_user,
              case when repost_datetime is null then '' else get_duration(repost_datetime) end as repost_duration,
              
              case when ru.profile_pic is null then '".$url."uploads2/users_profile/avatar.jpg' else concat('".$url."','uploads2/users_profile/',ru.profile_pic) end as repost_profile_pic,
              get_duration(p.datetime) as duration,
              get_likes(p.id) as like_count, 
              get_dislikes(p.id) as dislike_count,
              case when pl.id is null then 0 else 1 end as user_like,
              case when pd.id is null then 0 else 1 end as user_dislike,
              get_comments(p.id) as comments_count,
              case when f.id is null then 0 else 1 end as is_following
              FROM post as p 
              left join `groups` as g on g.id=p.group_id
              left join users as u on u.id=p.user_id 
              left join users as ru on ru.id=p.repost_user_id
              left join post_like as pl on pl.post_id=p.id and pl.user_id=$user_id 
              left join post_dislike as pd on pd.post_id=p.id and pd.user_id=$user_id 
              left join follow as f on f.following_id=p.user_id and f.follower_id=$user_id 
              where p.id in (select distinct post_id from post_hashtag where hashtag=trim('$hashtag')) and  p.isdeleted=0  and p.group_id is null 
              order by p.id desc";
              
            $recdata= $this->common_model->getArrayByQuery($query);
            //$recdata1 = array();
            foreach ($recdata as $value) {
              
              $post_id=$value['post_id'];
              $query="select 
                pc.id as post_comment_id,
                pc.user_id,
                u.full_name,
                case when u.profile_pic is null then '".$url."uploads2/users_profile/avatar.jpg' else concat('".$url."','uploads2/users_profile/',u.profile_pic) end as profile_pic,
                coalesce(comment,'') as comment,
                case when pc.file is null then '' else concat('".$url."','uploads2/',pc.file) end as file,
                pc.file_type, 
                get_comment_reply(pc.id) as reply_count,
                get_duration(pc.datetime) as duration  
                from post_comment as pc left join users as u on u.id=pc.user_id where pc.post_id=$post_id and isdeleted=0 order by pc.id";
              $comments = $this->common_model->getArrayByQuery($query); 
                $allcmnt = array();
                foreach ($comments as $c) {
                   $post_comment_id=$c['post_comment_id'];
                       $query="select 
                pcr.id as post_comment_reply_id,
                pcr.user_id,
                u.full_name,
                case when u.profile_pic is null then '".$url."uploads2/users_profile/avatar.jpg' else concat('".$url."','uploads2/users_profile/',u.profile_pic) end as profile_pic,
                coalesce(reply,'') as reply,
                case when pcr.file is null then '' else concat('".$url."','uploads2/',pcr.file) end as file,
                pcr.file_type,
                get_duration(pcr.datetime) as duration  
                from post_comment_reply as pcr left join users as u on u.id=pcr.user_id where pcr.post_comment_id=$post_comment_id and isdeleted=0 order by pcr.id";                
                $c['reply'] = $this->common_model->getArrayByQuery($query);
                $allcmnt[] = $c;
                  }
                  $value['comments'] = $allcmnt;

                   $query="select hashtag from post_hashtag where post_id=$post_id";
                  $tag = $this->common_model->getArrayByQuery($query); 
                  $value['hashtag_link']=$tag;
                  $recdata1[]= $value;
              
            }
            // $recdata1=json_encode($recdata1,true);
            if(!empty($recdata1))
            {    
               $resp = array('code' => true, 'message' => 'SUCCESS','hashtag'=>$hashtag, 'recdata' =>$recdata1 );
            } 
            else 
            { 
               $resp = array('code' => false, 'message' => array('error' => 'FAILURE', 'error_label' => 'Some error occured'));
            }
            $this->response($resp);
          }


  /** Profile Api */
  public function group_timeline_post() {
       /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        $required_parameter = array('user_id','api_key','group_id');
          $chk_error = check_required_value($required_parameter, $object_info);
        if ($chk_error)
        {

            $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
            $this->response($resp);
        }
         $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }
            $url=$GLOBALS['url'];
            $ipfs_url=$GLOBALS['ipfs_url'];
            $user_id=$data['user_id'];
            $group_id=$data['group_id'];
            $query="SELECT
              p.id as post_id,
              p.user_id,
              g.user_id as group_owner_id,
              coalesce(g.id,'') as group_id,
              coalesce(g.group_name,'') as group_name,
              u.full_name,
              case when u.profile_pic is null then '".$url."uploads2/users_profile/avatar.jpg' else concat('".$url."','uploads2/users_profile/',u.profile_pic) end as profile_pic,
              case when repost_id is null then p.message else p.repost_comment end as message,
              case when repost_id is null then coalesce(p.repost_comment,'') else p.message end as repost_comment,
              get_hashtag(p.id) as hashtag,
              concat('".$ipfs_url."',p.file) as file,
              case when gm.id is null then 'non_member' else 'member' end as is_member,
              p.file_type,
               get_hashtag(p.id) as hashtag,
              is_nsfw(p.id) as is_nsfw,
              get_nsfw(p.id) as nsfw,
              case when p.repost_id is not null then 1 else 0 end as is_repost,
              coalesce(get_repost_count(p.id),'') as repost_count,
              get_duration(p.datetime) as duration,
              get_likes(p.id) as like_count, 
              get_dislikes(p.id) as dislike_count,
              case when pl.id is null then 0 else 1 end as user_like,
              case when pd.id is null then 0 else 1 end as user_dislike,
              get_comments(p.id) as comments_count
              FROM post as p 
              left join users as u on u.id=p.user_id
              left join `groups` as g on g.id=p.group_id
              left join group_member as gm on gm.group_id=g.id and gm.member_id=$user_id 
              left join post_like as pl on pl.post_id=p.id and pl.user_id=$user_id 
              left join post_dislike as pd on pd.post_id=p.id and pd.user_id=$user_id 
              where p.group_id=$group_id and p.isdeleted=0 and p.repost_id is null
              order by p.id desc";
            $recdata= $this->common_model->getArrayByQuery($query);
            //$recdata1 = array();
            foreach ($recdata as $value) {
              
              $post_id=$value['post_id'];
              $query="select 
                pc.id as post_comment_id,
                pc.user_id,
                u.full_name,
                case when u.profile_pic is null then '".$url."uploads2/users_profile/avatar.jpg' else concat('".$url."uploads2/users_profile/',u.profile_pic) end as profile_pic,
                coalesce(comment,'') as comment,
                case when pc.file is null then '' else concat('".$url."uploads2/',pc.file) end as file,
                pc.file_type, 
                get_comment_reply(pc.id) as reply_count,
                get_duration(pc.datetime) as duration  
                from post_comment as pc left join users as u on u.id=pc.user_id where pc.post_id=$post_id and isdeleted=0 order by pc.id desc";
              $comments = $this->common_model->getArrayByQuery($query); 
                $allcmnt = array();
                foreach ($comments as $c) {
                   $post_comment_id=$c['post_comment_id'];
                       $query="select 
                pcr.id as post_comment_reply_id,
                pcr.user_id,
                u.full_name,
                case when u.profile_pic is null then '".$url."uploads2/users_profile/avatar.jpg' else concat('".$url."uploads2/users_profile/',u.profile_pic) end as profile_pic,
                coalesce(reply,'') as reply,
                case when pcr.file is null then '' else concat('".$url."uploads2/',pcr.file) end as file,
                pcr.file_type,
                get_duration(pcr.datetime) as duration  
                from post_comment_reply as pcr left join users as u on u.id=pcr.user_id where pcr.post_comment_id=$post_comment_id and isdeleted=0 order by pcr.id";                
                $c['reply'] = $this->common_model->getArrayByQuery($query);
                $allcmnt[] = $c;
                  }
                  $value['comments'] = $allcmnt;

                   $query="select hashtag from post_hashtag where post_id=$post_id";
                  $tag = $this->common_model->getArrayByQuery($query); 
                  $value['hashtag_link']=$tag;

                  $recdata1[]= $value;
              
            }
            // $recdata1=json_encode($recdata1,true);
            if(!empty($recdata1))
            {    
               $resp = array('code' => true, 'message' => 'SUCCESS', 'recdata' =>$recdata1 );
            } 
            else 
            { 
               $resp = array('code' => false, 'message' => array('error' => 'FAILURE', 'error_label' => 'Some error occured'));
            }
            $this->response($resp);
  }

  public function group_hash_timeline_post() {
       /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        $required_parameter = array('user_id','api_key','group_id','hashtag');
          $chk_error = check_required_value($required_parameter, $object_info);
        if ($chk_error)
        {

            $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
            $this->response($resp);
        }
         $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }
            $url=$GLOBALS['url'];
            $ipfs_url=$GLOBALS['ipfs_url'];
            $user_id=$data['user_id'];
            $group_id=$data['group_id'];
            $hashtag=$data['hashtag'];
            $query="SELECT
              p.id as post_id,
              p.user_id,
              g.user_id as group_owner_id,
              coalesce(g.id,'') as group_id,
              coalesce(g.group_name,'') as group_name,
              u.full_name,
              case when u.profile_pic is null then '".$url."uploads2/users_profile/avatar.jpg' else concat('".$url."','uploads2/users_profile/',u.profile_pic) end as profile_pic,
              case when repost_id is null then p.message else p.repost_comment end as message,
              case when repost_id is null then coalesce(p.repost_comment,'') else p.message end as repost_comment,
              get_hashtag(p.id) as hashtag,
              concat('".$ipfs_url."',p.file) as file,
              case when gm.id is null then 'non_member' else 'member' end as is_member,
              p.file_type,
               get_hashtag(p.id) as hashtag,
              is_nsfw(p.id) as is_nsfw,
              get_nsfw(p.id) as nsfw,
              case when p.repost_id is not null then 1 else 0 end as is_repost,
              coalesce(get_repost_count(p.id),'') as repost_count,
              get_duration(p.datetime) as duration,
              get_likes(p.id) as like_count, 
              get_dislikes(p.id) as dislike_count,
              case when pl.id is null then 0 else 1 end as user_like,
              case when pd.id is null then 0 else 1 end as user_dislike,
              get_comments(p.id) as comments_count
              FROM post as p 
              left join users as u on u.id=p.user_id
              left join `groups` as g on g.id=p.group_id
              left join group_member as gm on gm.group_id=g.id and gm.member_id=$user_id 
              left join post_like as pl on pl.post_id=p.id and pl.user_id=$user_id 
              left join post_dislike as pd on pd.post_id=p.id and pd.user_id=$user_id 
              where p.group_id=$group_id and p.isdeleted=0 and p.repost_id is null
              and p.id in (select distinct post_id from post_hashtag where hashtag=trim('$hashtag')) 
              order by p.id desc";
            $recdata= $this->common_model->getArrayByQuery($query);
            //$recdata1 = array();
            foreach ($recdata as $value) {
              
              $post_id=$value['post_id'];
              $query="select 
                pc.id as post_comment_id,
                pc.user_id,
                u.full_name,
                case when u.profile_pic is null then '".$url."uploads2/users_profile/avatar.jpg' else concat('".$url."uploads2/users_profile/',u.profile_pic) end as profile_pic,
                coalesce(comment,'') as comment,
                case when pc.file is null then '' else concat('".$url."uploads2/',pc.file) end as file,
                pc.file_type, 
                get_comment_reply(pc.id) as reply_count,
                get_duration(pc.datetime) as duration  
                from post_comment as pc left join users as u on u.id=pc.user_id where pc.post_id=$post_id and isdeleted=0 order by pc.id desc";
              $comments = $this->common_model->getArrayByQuery($query); 
                $allcmnt = array();
                foreach ($comments as $c) {
                   $post_comment_id=$c['post_comment_id'];
                       $query="select 
                pcr.id as post_comment_reply_id,
                pcr.user_id,
                u.full_name,
                case when u.profile_pic is null then '".$url."uploads2/users_profile/avatar.jpg' else concat('".$url."uploads2/users_profile/',u.profile_pic) end as profile_pic,
                coalesce(reply,'') as reply,
                case when pcr.file is null then '' else concat('".$url."uploads2/',pcr.file) end as file,
                pcr.file_type,
                get_duration(pcr.datetime) as duration  
                from post_comment_reply as pcr left join users as u on u.id=pcr.user_id where pcr.post_comment_id=$post_comment_id and isdeleted=0 order by pcr.id";                
                $c['reply'] = $this->common_model->getArrayByQuery($query);
                $allcmnt[] = $c;
                  }
                  $value['comments'] = $allcmnt;

                   $query="select hashtag from post_hashtag where post_id=$post_id";
                  $tag = $this->common_model->getArrayByQuery($query); 
                  $value['hashtag_link']=$tag;

                  $recdata1[]= $value;
              
            }
            // $recdata1=json_encode($recdata1,true);
            if(!empty($recdata1))
            {    
               $resp = array('code' => true, 'message' => 'SUCCESS', 'recdata' =>$recdata1 );
            } 
            else 
            { 
               $resp = array('code' => false, 'message' => array('error' => 'FAILURE', 'error_label' => 'Some error occured'));
            }
            $this->response($resp);
  }


  public function post_delete_post() {
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        $required_parameter = array('post_id','user_id','api_key');
          $chk_error = check_required_value($required_parameter, $object_info);
        if ($chk_error)
        {

            $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
            $this->response($resp);
        }

         /* Update in users Table */   
       $updateArr = array( 'isdeleted' => 1);
       $condition = array('id' => $data['post_id']);

            /* Update in users Table */        
            $recdata=$this->common_model->updateRecords("post", $updateArr,$condition);
       
            
            if(!empty($recdata))
            {    
               $resp = array('code' => true, 'message' => 'Post deleted!!');
            } 
            else 
            { 
               $resp = array('code' => ERROR, 'message' => 'error!!!');
            }
            $this->response($resp);    
  }


  public function post_comment_delete_post() {
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        $required_parameter = array('post_comment_id','user_id','api_key');
          $chk_error = check_required_value($required_parameter, $object_info);
        if ($chk_error)
        {

            $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
            $this->response($resp);
        }

         /* Update in users Table */   
       $updateArr = array( 'isdeleted' => 1);
       $condition = array('id' => $data['post_comment_id']);

            /* Update in users Table */        
            $recdata=$this->common_model->updateRecords("post_comment", $updateArr,$condition);
       
            
            if(!empty($recdata))
            {    
               $resp = array('code' => true, 'message' => 'Post comment deleted!!');
            } 
            else 
            { 
               $resp = array('code' => ERROR, 'message' => 'error!!!');
            }
            $this->response($resp);
      
  }
  

  public function post_comment_reply_delete_post() {
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        $required_parameter = array('post_comment_reply_id','user_id','api_key');
          $chk_error = check_required_value($required_parameter, $object_info);
        if ($chk_error)
        {

            $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
            $this->response($resp);
        }

         /* Update in users Table */   
       $updateArr = array( 'isdeleted' => 1);
       $condition = array('id' => $data['post_comment_reply_id']);

            /* Update in users Table */        
            $recdata=$this->common_model->updateRecords("post_comment_reply", $updateArr,$condition);
            if(!empty($recdata))
            {    
               $resp = array('code' => true, 'message' => 'Post comment reply deleted!!');
            } 
            else 
            { 
               $resp = array('code' => ERROR, 'message' => 'error!!!');
            }
            $this->response($resp);
  }

  public function group_delete_post() {
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        $required_parameter = array('group_id','user_id','api_key');
        $chk_error = check_required_value($required_parameter, $object_info);
        if ($chk_error)
        {

            $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
            $this->response($resp);
        }

           $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }


       $updateArr = array( 'isdeleted' => 1);
       $condition = array('id' => $data['group_id']);

            /* Update in users Table */        
            $recdata=$this->common_model->updateRecords("groups", $updateArr,$condition);
       
            
            if(!empty($recdata))
            {    
               $resp = array('code' => true, 'message' => 'Group deleted!!');
            } 
            else 
            { 
               $resp = array('code' => ERROR, 'message' => 'error!!!');
            }
            $this->response($resp);
      
  }
  

  public function block_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','blocked_user_id','api_key');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

          $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }
          $blocked_user_id=$data['blocked_user_id'];
          $user_id=$data['user_id'];
          //CHECK IF POST ALLREADY LIKED 
        $check_like = $this->common_model->getSingleRecordById("block", array('user_id' => $data['user_id'],'blocked_user_id' => $data['blocked_user_id']));
        $id=$check_like['id'];
        
        if(!empty($check_like)) {
                $resp = array('code' => false, 'message' => 'You already blocked this user');
                $this->response($resp);
            }

        $data=array('blocked_user_id'=>$blocked_user_id,'user_id'=>$user_id,'ip'=>$_SERVER['REMOTE_ADDR']);
        $param = $this->common_model->addRecords("block", $data);
        if($param){
        $resp = array('code' => true, 'message' => 'SUCCESS', 'response'  => 'User Blocked!!');
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'Some error occured, please try again!!');
        }
        $this->response($resp);
  }

  public function unblock_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','blocked_user_id','api_key');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

          $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

          $blocked_user_id=$data['blocked_user_id'];
          $user_id=$data['user_id'];
         $condition=array('user_id' => $data['user_id'],'blocked_user_id' => $data['blocked_user_id']);
          $param = $this->common_model->deleteRecords("block",$condition);

        if($param){
        $resp = array('code' => true, 'message' => 'SUCCESS', 'response'  => 'User unblocked!!');
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'Some error occured, please try again!!');
        }
        $this->response($resp);
  }

  

  public function blocked_user_list_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

          $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

         $user_id=$data['user_id'];
         $url=$GLOBALS['url'];
         $query="SELECT b.id,b.user_id,b.blocked_user_id,u.full_name, case when u.profile_pic is null then '".$url."uploads2/users_profile/avatar.jpg' else concat('".$url."','uploads2/users_profile/',u.profile_pic) end as profile_pic,get_duration(b.datetime) as duration FROM block as b left join users as u on u.id=b.blocked_user_id where user_id=$user_id";
         $recdata= $this->common_model->getArrayByQuery($query);
        if($recdata){
        $resp = array('code' => true, 'message' => 'SUCCESS', 'recdata'  => $recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'Record not found!!');
        }
        $this->response($resp);
  }

  
  public function trx_type_list_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

          $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

         $query="select 0 as id,'All Type' as name union all SELECT id,name from trx_type order by name";
         $recdata= $this->common_model->getArrayByQuery($query);
        if($recdata){
        $resp = array('code' => true, 'message' => 'SUCCESS', 'recdata'  => $recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'Record not found!!');
        }
        $this->response($resp);
  }

  
  public function transaction_list_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key','trx_type_id');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

          $api_key= $data['api_key'];
          $user_id= $data['user_id'];
          $trx_type_id= $data['trx_type_id'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

        $where ="where t.user_id=$user_id";
        if($data['trx_type_id']>0){
          $where.=" and t.trx_type_id=$trx_type_id";
        }
         $query="SELECT DISTINCT
          t.trx_date as fdate,
          date_format(t.trx_date,'%d-%m-%Y') as trx_date,
          t.trx_number,
          tt.name as trx_type,
          t.trx_amount,
          t.description,
          t.from_wallet,
          t.to_wallet,
          case when t.hash like 'TRX%' then '' else t.hash end as hash,
          CONCAT('https://etherscan.io/tx/',t.hash) as hash_link,
          case when t.hash like 'TRX%' then '' else concat(left(t.hash,10),'..',RIGHT(t.hash,10)) end as short_hash,
          case when t.trx_type_id in (1,4) then  case when t.user_id<>coalesce(g.user_id,p.user_id) then coalesce(concat('(To ',coalesce(g.group_name,u.full_name),')'),'') else coalesce(concat('(By ',get_user_fullname(t2.user_id),')'),'') end else '' end as reward_to  
        FROM transaction as t 
        left join trx_type as tt on tt.id=t.trx_type_id 
        left join post as p on p.id=t.post_id
        left join `groups` as g on g.id=t.group_id
        left join transaction as t2 on t2.trx_number=t.trx_number and t2.user_id<>$user_id
        left join users as u on u.id=p.user_id  
        $where
        order by t.trx_date desc ,t.trx_number desc";
        
         $recdata= $this->common_model->getArrayByQuery($query);
        if($recdata){
        $resp = array('code' => true, 'message' => 'SUCCESS', 'recdata'  => $recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'Record not found!!');
        }
        $this->response($resp);
  }

  



  public function follow_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','following_id','api_key');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

          $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

          $following_id=$data['following_id'];
          $user_id=$data['user_id'];
          //CHECK IF POST ALLREADY LIKED 
        $check= $this->common_model->getSingleRecordById("follow", array('follower_id' => $data['user_id'],'following_id' => $data['following_id']));
        $id=$check['id']; 
        
        if(!empty($check)) {
                $resp = array('code' => false, 'message' => 'You already follow this user!!');
                $this->response($resp);
            }

        $data=array('follower_id'=>$user_id,'following_id'=>$following_id,'ip'=>$_SERVER['REMOTE_ADDR']);
        $param = $this->common_model->addRecords("follow", $data);
        if($param){
        //NOTIFICATION STARTS 
        $app_url=$GLOBALS['app_url'];
        //$user_id=$data['user_id'];
        $query="select u2.id as recipient_id,u.id as sender_id,u.full_name from users as u cross join (select id from users where id=$following_id) as u2 where u.id=$user_id";
        $ndata=$this->common_model->getArrayByQuery($query);
        foreach ($ndata as $value) {
        $title="".$value['full_name']." follow you!!";
        $message="".$value['full_name']." follow you!!";
        $dataArray = array('recipient_id'=>$value['recipient_id'],'sender_id'=>$value['sender_id'],'title'=>$title,'message'=>$message,'link'=>$app_url.'timeLine/'.$value['sender_id']);
        $this->common_model->addRecords("notification", $dataArray);
        }
        //NOTIFICATION ENDS
        $resp = array('code' => true, 'message' => 'SUCCESS', 'response'  => 'Followed!!');
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'Some error occured, please try again!!');
        }
        $this->response($resp);
  }

  
  public function unfollow_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','following_id','api_key');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

          $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

          $following_id=$data['following_id'];
          $user_id=$data['user_id'];
         $condition=array('follower_id' => $data['user_id'],'following_id' => $data['following_id']);
          $param = $this->common_model->deleteRecords("follow",$condition);

        if($param){
          //NOTIFICATION STARTS 
        $app_url=$GLOBALS['app_url'];
        //$user_id=$data['user_id'];
        $query="select $following_id as recipient_id,$user_id as sender_id,full_name from users where id=$user_id";
        $ndata=$this->common_model->getArrayByQuery($query);
        foreach ($ndata as $value) {
        $title="".$value['full_name']." unfollow you!!";
        $message="".$value['full_name']." unfollow you!!";
        $dataArray = array('recipient_id'=>$value['recipient_id'],'sender_id'=>$value['sender_id'],'title'=>$title,'message'=>$message,'link'=>$app_url.'timeLine/'.$value['sender_id']);
        $this->common_model->addRecords("notification", $dataArray);
        }
        //NOTIFICATION ENDS
        $resp = array('code' => true, 'message' => 'SUCCESS', 'response'  => 'User unfollow!!');
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'Some error occured, please try again!!');
        }
        $this->response($resp);
  }

  

  public function following_list_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key','view_user_id');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

          $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

         $user_id=$data['user_id'];
         $view_user_id=$data['view_user_id'];
         $url=$GLOBALS['url'];
         $query="SELECT f.id, u.id as user_id,u.full_name, 1 as is_following, case when u.profile_pic is null then '".$url."uploads2/users_profile/avatar.jpg' else concat('".$url."','uploads2/users_profile/',u.profile_pic) end as profile_pic,get_duration(f.datetime) as duration FROM follow as f left join users as u on u.id=f.following_id where follower_id=$view_user_id";
         $recdata= $this->common_model->getArrayByQuery($query);
        if($recdata){
        $resp = array('code' => true, 'message' => 'SUCCESS', 'recdata'  => $recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => '0');
        }
        $this->response($resp);
  }

  


  public function follower_list_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key','view_user_id');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

          $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

         $user_id=$data['user_id'];
         $view_user_id=$data['view_user_id'];
         $url=$GLOBALS['url'];
         $query="SELECT f.id,u.id as user_id, u.full_name, case when u.profile_pic is null then '".$url."users_profile/avatar.jpg' else concat('".$url."','uploads2/users_profile/',u.profile_pic) end as profile_pic,get_duration(f.datetime) as duration FROM follow as f left join users as u on u.id=f.follower_id where following_id=$view_user_id and f.follower_id not in (select blocked_user_id from block where user_id=$view_user_id)";
         $recdata= $this->common_model->getArrayByQuery($query);
        if($recdata){
        $resp = array('code' => true, 'message' => 'SUCCESS', 'recdata'  => $recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => '0');
        }
        $this->response($resp);
  }



  public function friend_list_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key','view_user_id');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

          $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

         $user_id=$data['user_id'];
         $view_user_id=$data['view_user_id'];
         $url=$GLOBALS['url'];
         $query="SELECT u.id,u.full_name, case when u.profile_pic is null then '".$url."uploads2/users_profile/avatar.jpg' else concat('".$url."','uploads2/users_profile/',u.profile_pic) end as profile_pic FROM  users as u  where  u.id in (select case when f.follower_id=$view_user_id then f.following_id else f.follower_id end as friend from follow as f inner join follow as f2 on f2.follower_id=f.following_id and f2.following_id=$view_user_id where f.follower_id=$view_user_id)";
         
         $recdata= $this->common_model->getArrayByQuery($query);
        if($recdata){
        $resp = array('code' => true, 'message' => 'SUCCESS', 'recdata'  => $recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => '0');
        }
        $this->response($resp);
  }


  public function group_create_post() {
    // $pdata = file_get_contents("php://input");
     $data = $this->input->post();
    // $data = json_decode($pdata, true);
         //check api key
      // $api_key= $_POST['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$data['api_key']));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

          $avatar="avatar.jpg";
          $banner="banner.jpg";
          $funding_target=0;
          if(isset($_FILES["avatar"]['name']))
            {
                $imagename=time().$_FILES["avatar"]["name"];
                $tnm=$_FILES["avatar"]["tmp_name"];
                $dbpath = base_url().'uploads2/group_avatar/'.$imagename;
                $flag=move_uploaded_file($tnm,"uploads2/group_avatar/".$imagename);
                $avatar=$imagename;
            } 

            if(isset($_FILES["banner"]['name']))
            {
                $imagename=time().$_FILES["banner"]["name"];
                $tnm=$_FILES["banner"]["tmp_name"];
                $dbpath = base_url().'uploads2/group_avatar/banner_'.$imagename;
                $flag=move_uploaded_file($tnm,"uploads2/group_avatar/banner_".$imagename);
                $banner='banner_'.$imagename;
            } 
           
        $dataArray = array('user_id' => $data['user_id'],'group_name' => $data['group_name'], 'description' => $data['description'], 'is_closed_group' => $data['is_closed_group'],'avatar' => $avatar,'banner' => $banner,'ip'=>$_SERVER['REMOTE_ADDR']);
        $post= $this->common_model->addRecords("groups", $dataArray);
        
       if($post){
           $dataArray = array('member_id' => $data['user_id'],'group_id' => $post, 'isapproved' => 1,'approveddate' =>date('Y-m-d'),'isadmin' => 1,'isblocked' => 0,'ip'=>$_SERVER['REMOTE_ADDR']);
        $this->common_model->addRecords("group_member", $dataArray);

    $recdata=$this->common_model->getSingleRecordById('groups',array('id' =>$post));
            $resp = array('code' => true, 'message' => 'SUCCESS', 'response' => 'Group created successfully','recdata'=>$recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response' => 'Not Posted');
        }
        $this->response($resp);
  }  


  public function project_create_post() {

    $pdata = file_get_contents("php://input");
    $data = json_decode($pdata, true);
      // $api_key= $_POST['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$data['api_key']));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

          $avatar="avatar.jpg";
          $banner="banner.jpg";
          $funding_target=0;
          if(isset($_FILES["avatar"]['name']))
            {
                $imagename=time().$_FILES["avatar"]["name"];
                $tnm=$_FILES["avatar"]["tmp_name"];
                $dbpath = base_url().'uploads2/group_avatar/'.$imagename;
                $flag=move_uploaded_file($tnm,"uploads2/group_avatar/".$imagename);
                $avatar=$imagename;
            } 

            if(isset($_FILES["banner"]['name']))
            {
                $imagename=time().$_FILES["banner"]["name"];
                $tnm=$_FILES["banner"]["tmp_name"];
                $dbpath = base_url().'uploads2/group_avatar/banner_'.$imagename;
                $flag=move_uploaded_file($tnm,"uploads2/group_avatar/banner_".$imagename);
                $banner='banner_'.$imagename;
            } 
            if(isset($funding_target))
            {
                $funding_target=$data['funding_target'];
            } 
            
            $days=null;
            if(isset($data['days']))
            {
                $days=$data['days'];
            } 

        $dataArray = array('user_id' => $data['user_id'],'group_name' => $data['group_name'], 'description' => $data['description'],'funding_target'=>$data['funding_target'],'days'=>$data['days'], 'is_project'=>1, 'is_closed_group' => $data['is_closed_group'],'avatar' => $avatar,'banner' => $banner,'ip'=>$_SERVER['REMOTE_ADDR']);
        $post= $this->common_model->addRecords("groups", $dataArray);
        
       if($post){
           $dataArray = array('member_id' => $data['user_id'],'group_id' => $post, 'isapproved' => 1,'approveddate' =>date('Y-m-d'),'isadmin' => 1,'isblocked' => 0,'ip'=>$_SERVER['REMOTE_ADDR']);
        $this->common_model->addRecords("group_member", $dataArray);

    $recdata=$this->common_model->getSingleRecordById('groups',array('id' =>$post));
            $resp = array('code' => true, 'message' => 'SUCCESS', 'response' => 'Group created successfully','recdata'=>$recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response' => 'Not Posted');
        }
        $this->response($resp);
  }  


  public function group_update_post() {

         //check api key
      $api_key= $_POST['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$_POST['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

      $group_id=$_POST['group_id'];

        $recdata=$this->common_model->getSingleRecordById('groups',array('id' =>$group_id));
          $avatar=$recdata['avatar'];
          $banner=$recdata['banner'];
          $group_name=$recdata['group_name'];
          $description=$recdata['description'];

          if(isset($_POST['group_name'])){
            $group_name=$_POST['group_name'];
          }
          
          if(isset($_POST['description'])){
            $description=$_POST['description'];
          }

          if(isset($_FILES["avatar"]['name']))
            {
                $imagename=time().$_FILES["avatar"]["name"];
                $tnm=$_FILES["avatar"]["tmp_name"];
                $dbpath = base_url().'uploads2/group_avatar/'.$imagename;
                $flag=move_uploaded_file($tnm,"uploads2/group_avatar/".$imagename);
                $avatar=$imagename;
            } 

            if(isset($_FILES["banner"]['name']))
            {
                $imagename=time().$_FILES["banner"]["name"];
                $tnm=$_FILES["banner"]["tmp_name"];
                $dbpath = base_url().'uploads2/group_avatar/banner_'.$imagename;
                $flag=move_uploaded_file($tnm,"uploads2/group_avatar/banner_".$imagename);
                $banner='banner_'.$imagename;
            } 

        $dataArray = array('group_name' => $group_name, 'description' => $description,'avatar' => $avatar,'banner' => $banner);
        $condition = array('id' => $group_id);
            /* Update in users Table */        
        $post=$this->common_model->updateRecords("groups", $dataArray,$condition);
        
       if($post){
        
        $recdata=$this->common_model->getSingleRecordById('groups',array('id' =>$group_id));
        $resp = array('code' => true, 'message' => 'SUCCESS', 'response' => 'Group updated successfully','recdata'=>$recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response' => 'Not updated!!');
        }
        $this->response($resp);
  }  



  public function group_type_update_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key','group_id','type');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

          $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

         $group_id=$data['group_id'];
         $type=$data['type'];

        $updateArr = array( 'is_closed_group' => $type);
        $condition = array('id' => $group_id);
        $this->common_model->updateRecords("groups", $updateArr,$condition);

         $url=$GLOBALS['url'];
         $query="SELECT 
          g.id,g.
          user_id,
          g.group_name,
          concat('".$url."uploads2/group_avatar/',g.avatar) as vatar,
          g.description,
          case when g.is_closed_group=0 then 'Public' else 'Private' end as type,
          count(gm.id) as member_count 
         FROM `groups` as g 
         left join group_member as gm on gm.group_id=g.id 
         where g.id=$group_id 
         group by g.id,g.user_id,g.group_name,g.avatar,g.description,g.is_closed_group";
         $recdata= $this->common_model->getArrayByQuery($query);

        if($recdata){
        $resp = array('code' => true, 'message' => 'Group type changed successfully!!', 'recdata'  => $recdata[0]);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'Error occured!!');
        }
        $this->response($resp);
  }



  public function avatar_banner_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key','view_user_id');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

          $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

         $user_id=$data['user_id'];
         $view_user_id=$data['view_user_id'];
          $url=$GLOBALS['url'];
          $is_friend=0;
          $is_following=0;
          //$query="select * from follow where (follower_id=$view_user_id and following_id=$user_id) or (follower_id=$user_id and following_id=$view_user_id)";
          $query="select * from follow where follower_id=$user_id and following_id=$view_user_id";
          $recdata= $this->common_model->getArrayByQuery($query);
          if(!empty($recdata)){
            $is_friend=1;
          }
          if($view_user_id==$user_id){
            $is_friend=1;
          }
          //check is following
          $check_key = $this->common_model->getSingleRecordById('follow',array('following_id' =>$data['view_user_id'], 'follower_id'=>$data['user_id']));
          if(!empty($check_key)){
            $is_following=1;
          }
         $query="SELECT 
          u.id,
          u.id as user_id,
          u.full_name, 
          case when u.profile_pic is null then '".$url."uploads2/users_profile/avatar.jpg' else concat('".$url."','uploads2/users_profile/',u.profile_pic) end as avatar,
          case when u.background_image is null then '".$url."uploads2/users_profile/banner.jpg' else concat('".$url."uploads2/users_profile/',u.background_image) end as background_image
          FROM users as u 
          where u.id=$view_user_id";
         $recdata= $this->common_model->getArrayByQuery($query);
         $recdata[0]['is_friend']=$is_friend;
         $recdata[0]['is_following']=$is_following;
        if($recdata){
        $resp = array('code' => true, 'message' => 'SUCCESS', 'recdata'  => $recdata[0]);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'Data not found!!');
        }
        $this->response($resp);
  }

  public function group_list_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key','view_user_id');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

          $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

         $user_id=$data['user_id'];
         $view_user_id=$data['view_user_id'];
         $url=$GLOBALS['url'];
         $query="SELECT 
          g.id,
          g.user_id,
          g.group_name,
          concat('".$url."uploads2/group_avatar/',g.avatar) as vatar,
          g.description,
          case when gm.id is null then 'non_member' else 'member' end as is_member,
          case when g.is_closed_group=0 then 'Public' else 'Private' end as type,
          count(gm.id) as member_count,
          case when g.user_id=$user_id then 'admin' else 'member' end as user_type
         FROM `groups` as g 
         left join group_member as gm on gm.group_id=g.id 
         where gm.member_id=$view_user_id and g.isdeleted=0 and g.is_project=0
         group by gm.id,g.id,g.user_id,g.group_name,g.avatar,g.description,g.is_closed_group";
         $recdata= $this->common_model->getArrayByQuery($query);
        if($recdata){
        $resp = array('code' => true, 'message' => 'SUCCESS', 'recdata'  => $recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'No data found!!');
        }
        $this->response($resp);
  }


  public function all_group_list_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

          $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

         $user_id=$data['user_id'];
         $url=$GLOBALS['url'];
         $query="SELECT 
          g.id,g.
          user_id,
          g.group_name,
          concat('".$url."uploads2/group_avatar/',g.avatar) as avatar,
          g.description,
          case when g.is_closed_group=0 then 'Public' else 'Private' end as type,
          count(gm.id) as member_count 
         FROM `groups` as g 
         left join group_member as gm on gm.group_id=g.id 
         where g.isdeleted=0 and g.is_project=0
         group by g.id,g.user_id,g.group_name,g.avatar,g.description,g.is_closed_group
          order by rand() limit 100";
         $recdata= $this->common_model->getArrayByQuery($query);
        if($recdata){
        $resp = array('code' => true, 'message' => 'SUCCESS', 'recdata'  => $recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'No data found!!');
        }
        $this->response($resp);
  }



  public function project_list_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key','view_user_id');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

          $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

         $user_id=$data['user_id'];
         $view_user_id=$data['view_user_id'];
         $url=$GLOBALS['url'];
         $query="SELECT 
          g.id,g.
          user_id,
          g.group_name,
          concat('".$url."uploads2/group_avatar/',g.avatar) as vatar,
          g.description,
          case when g.is_closed_group=0 then 'Public' else 'Private' end as type,
          count(gm.id) as member_count,
          case when g.user_id=$user_id then 'admin' else 'member' end as user_type
         FROM `groups` as g 
         left join group_member as gm on gm.group_id=g.id 
         where gm.member_id=$view_user_id and  g.is_project=1 and g.isdeleted=0 and g.is_blocked=0
         group by g.id,g.user_id,g.group_name,g.avatar,g.description,g.is_closed_group";
         $recdata= $this->common_model->getArrayByQuery($query);
        if($recdata){
        $resp = array('code' => true, 'message' => 'SUCCESS', 'recdata'  => $recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'No data found!!');
        }
        $this->response($resp);
  }




  public function all_project_list_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

          $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

         $user_id=$data['user_id'];
         $url=$GLOBALS['url'];
         $query="SELECT 
          g.id,g.
          user_id,
          g.group_name,
          concat('".$url."uploads2/group_avatar/',g.avatar) as vatar,
          g.description,
          case when g.is_closed_group=0 then 'Public' else 'Private' end as type,
          count(gm.id) as member_count 
         FROM `groups` as g 
         left join group_member as gm on gm.group_id=g.id 
         where g.is_project=1 and g.isdeleted=0 and g.is_blocked=0
         group by g.id,g.user_id,g.group_name,g.avatar,g.description,g.is_closed_group";
         $recdata= $this->common_model->getArrayByQuery($query);
        if($recdata){
        $resp = array('code' => true, 'message' => 'SUCCESS', 'recdata'  => $recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'No data found!!');
        }
        $this->response($resp);
  }




  public function voting_list_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

          $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

         $user_id=$data['user_id'];
         $query="select * from voting_title where user_id=$user_id and is_deleted=0";
         $recdata= $this->common_model->getArrayByQuery($query);
         $rec=array();
         foreach ($recdata as $value) {
           $voteid=$value['id'];
           $query="select * from voting_option where voting_title_id=$voteid";
           $option=$this->common_model->getArrayByQuery($query);
           $value['options']=$option;
           $rec[] = $value;           
         }
        if($recdata){
        $resp = array('code' => true, 'message' => 'SUCCESS', 'recdata'  => $rec);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'No data found!!');
        }
        $this->response($resp);
  }

public function show_voting_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

          $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

         $user_id=$data['user_id'];
         $query="select * from voting_title where is_deleted=0  and id not in (select distinct voting_title_id from user_voting where user_id=$user_id) order by rand() limit 1";
         $recdata= $this->common_model->getArrayByQuery($query);
         $rec=array();
         foreach ($recdata as $value) {
           $voteid=$value['id'];
           $query="select * from voting_option where voting_title_id=$voteid";
           $option=$this->common_model->getArrayByQuery($query);
           $value['options']=$option;
           $rec[] = $value;           
         }
        if($recdata){
        $resp = array('code' => true, 'message' => 'SUCCESS', 'recdata'  => $rec);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'No data found!!');
        }
        $this->response($resp);
  }

  public function create_voting_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key','title','options');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

         $user_id=$data['user_id'];
         $title=$data['title'];
         $options=$data['options'];

         $dataArray = array('user_id' => $user_id, 'title' => $title, 'ip' => $_SERVER['REMOTE_ADDR']);
         $newid= $this->common_model->addRecords("voting_title", $dataArray);
        
         foreach ($options as $value) {
         $dataArray = array('voting_title_id' => $newid, 'options' => $value, 'ip' => $_SERVER['REMOTE_ADDR']);
         $recdata= $this->common_model->addRecords("voting_option", $dataArray);
         }
         $query="select * from voting_title where id =$recdata";
         $recdata= $this->common_model->getArrayByQuery($query);
         
        if($newid){
        $resp = array('code' => true, 'message' => 'SUCCESS', 'recdata'  => $recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'No data found!!');
        }
        $this->response($resp);
  }

public function delete_voting_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key','voting_title_id');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

          $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

         $voting_id=$data['voting_title_id'];
         $recdata=$this->common_model->updateRecords('voting_title',array('is_deleted' =>1),array('id'=>$voting_id));
          
        if($recdata){
        $resp = array('code' => true, 'message' => 'Voting deleted', 'recdata'  => $recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'No data found!!');
        }
        $this->response($resp);
  }

 public function voting_detail_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key','voting_title_id');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

         $user_id=$data['user_id'];
         $voting_title_id=$data['voting_title_id'];
         
         $query="select vt.id,vt.title,vo.options,count(uv.id) as vote_count,(count(uv.id)*100)/t.total as percent,t.total as total_vote  from voting_title as vt
      left join voting_option as vo on vt.id=vo.voting_title_id
      left join user_voting as uv on uv.voting_title_id=vo.voting_title_id and vo.id=uv.option_id
      left join (select voting_title_id,count(id) as total from user_voting where voting_title_id=$voting_title_id group by voting_title_id) as t on t.voting_title_id=vo.voting_title_id 
      where vo.voting_title_id=$voting_title_id
      group by vt.id,vt.title,vo.options,t.total";
         $recdata= $this->common_model->getArrayByQuery($query);

         $query="SELECT vt.id,vt.title,count(vo.id) as vote_count from voting_title as vt left join user_voting as vo on vt.id=vo.voting_title_id where vt.id=$voting_title_id group by vt.id,vt.title";
         $data=$this->common_model->getArrayByQuery($query);
         $voting_id=$data[0]['id'];
         $title=$data[0]['title'];
         $vote_count=$data[0]['vote_count'];
         
        if($recdata){
        $resp = array('code' => true, 'message' => 'SUCCESS','voting_id'=>$voting_id,'title'=>$title,'vote_count'=>$vote_count, 'recdata'  => $recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'No data found!!');
        }
        $this->response($resp);
  }




  public function user_voting_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key','voting_title_id','option_id');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

         $user_id=$data['user_id'];
         $voting_title_id=$data['voting_title_id'];
         $option_id=$data['option_id'];

         $dataArray = array('user_id' => $user_id, 'voting_title_id' => $voting_title_id,'option_id' => $option_id, 'ip' => $_SERVER['REMOTE_ADDR']);
         $newid= $this->common_model->addRecords("user_voting", $dataArray);
        
         $query="select vt.id,vt.title,vo.options,count(uv.id) as vote_count,(count(uv.id)*100)/t.total as percent,t.total as total_vote  from voting_title as vt
      left join voting_option as vo on vt.id=vo.voting_title_id
      left join user_voting as uv on uv.voting_title_id=vo.voting_title_id and vo.id=uv.option_id
      left join (select voting_title_id,count(id) as total from user_voting where voting_title_id=$voting_title_id group by voting_title_id) as t on t.voting_title_id=vo.voting_title_id 
      where vo.voting_title_id=$voting_title_id
      group by vt.id,vt.title,vo.options,t.total";
         $recdata= $this->common_model->getArrayByQuery($query);
         
        if($newid){
        $resp = array('code' => true, 'message' => 'SUCCESS', 'recdata'  => $recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'No data found!!');
        }
        $this->response($resp);
  }



  public function group_detail_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key','group_id');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

          $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

         $user_id=$data['user_id'];
         $group_id=$data['group_id'];
         $url=$GLOBALS['url'];
         $query="SELECT 
          g.id,g.
          user_id,
          g.group_name,
          concat('".$url."uploads2/group_avatar/',g.avatar) as avatar,
          concat('".$url."uploads2/group_avatar/',g.banner) as banner,
          g.description,
          case when g.is_closed_group=0 then 'Public' else 'Private' end as type,
          case when g.funding_target>0 then 1 else 0 end as if_funding_group,
          g.is_project,
          g.funding_target,
          concat(g.days,'days') as days,
          concat(round(coalesce(((get_funded_value(g.id)*100)/g.funding_target),0),2),'%','  (',get_funded_value(g.id),')') as funded_percent,
          concat('(',get_funded_value(g.id),')') as funded_vale,
          count(gm.id) as member_count,
          is_group_member($user_id,$group_id) as is_group_member
         FROM `groups` as g 
         left join group_member as gm on gm.group_id=g.id 
         where g.id=$group_id and g.isdeleted=0
         group by g.id,g.user_id,g.group_name,g.avatar,g.description,g.is_closed_group";
         $recdata= $this->common_model->getArrayByQuery($query);
        if($recdata){
        $resp = array('code' => true, 'message' => 'SUCCESS', 'recdata'  => $recdata[0]);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'No data found!!');
        }
        $this->response($resp);
  }

  public function project_list_get() {

   
         $url=$GLOBALS['url'];
         $query="SELECT 
          g.id,g.
          user_id,
          case when length(g.group_name)>25 then  concat(substring(g.group_name,1,25),'...')  else g.group_name end as short_group_name,
          g.group_name,
          concat('".$url."uploads2/group_avatar/',g.avatar) as avatar,
          concat('".$url."uploads2/group_avatar/',g.banner) as banner,
          case when length(g.description)>60 then  concat(substring(g.description,1,60),'...') else g.description end  as short_description,
          g.description,
          case when g.is_closed_group=0 then 'Public' else 'Private' end as type,
          case when g.funding_target>0 then 1 else 0 end as if_funding_group,
          g.is_project,
          concat(g.funding_target,'$') as funding_target,
          concat(g.days,'days') as days,
          concat(round(coalesce(((get_funded_value(g.id)*100)/g.funding_target),0),2),'%') as funded_percent,
          count(gm.id) as member_count
         FROM `groups` as g 
         left join group_member as gm on gm.group_id=g.id 
         where g.is_project=1 and g.isdeleted=0 and g.is_blocked=0
         group by g.id,g.user_id,g.group_name,g.avatar,g.description,g.is_closed_group
         order by rand() limit 10";
         
         $recdata= $this->common_model->getArrayByQuery($query);
        if($recdata){
        $resp = array('code' => true, 'message' => 'SUCCESS', 'recdata'  => $recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'No data found!!');
        }
        $this->response($resp);
  }

  public function group_member_list_post() {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key','group_id');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

         $user_id=$data['user_id'];
         $group_id=$data['group_id'];
         $url=$GLOBALS['url'];
         $query="SELECT 
          u.id as user_id,
          u.full_name,
          case when u.profile_pic is null then '".$url."uploads2/users_profile/avatar.jpg' else concat('".$url."uploads2/users_profile/',u.profile_pic) end as profile_pic,
          case when u.background_image is null then '".$url."uploads2/users_profile/banner.jpg' else concat('".$url."uploads2/users_profile/',u.background_image) end as background_image,
          gm.isadmin,
          gm.isapproved,
          case when f.id is null then 0 else 1 end as is_following
         FROM group_member as gm 
         left join users as u on u.id=gm.member_id 
         left join follow as f on f.following_id=u.id and f.follower_id=$user_id 
         where gm.group_id=$group_id and gm.isapproved=1 and gm.isblocked=0";
         $recdata= $this->common_model->getArrayByQuery($query);
        if($recdata){
        $resp = array('code' => true, 'message' => 'SUCCESS', 'recdata'  => $recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'No data found!!');
        }
        $this->response($resp);
  }

  

  public function group_member_add_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key','group_id','add_user_id');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

          $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }
         $check_key = $this->common_model->getSingleRecordById('group_member',array('id' =>$data['group_id'], 'member_id'=>$data['add_user_id']));
      if(!empty($check_key)){
          $resp = array('code' => false, 'message' => 'Member already added');
          $this->response($resp);
      }

         $user_id=$data['user_id'];
         $add_user_id=$data['add_user_id'];
         $group_id=$data['group_id'];
         $isapproved=1;
         $approveddate=date('Y-m-d');
         $check= $this->common_model->getSingleRecordById('groups',array('id' =>$group_id));
         if($check['is_closed_group']==1){
          $isapproved=1;
          $approveddate=date('Y-m-d');
         }

         $dataArray = array('group_id' => $group_id, 'member_id' => $add_user_id, 'isapproved' => $isapproved,'approveddate' => $approveddate,'isadmin' => 0,'ip' => $_SERVER['REMOTE_ADDR']);
         $recdata= $this->common_model->addRecords("group_member", $dataArray);

        if($recdata){
        $resp = array('code' => true, 'message' => 'SUCCESS', 'recdata'  => $recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'No data found!!');
        }
        $this->response($resp);
  }


  public function join_group_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key','group_id');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

          $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }
         $check_key = $this->common_model->getSingleRecordById('group_member',array('group_id' =>$data['group_id'], 'member_id'=>$data['user_id']));
      if(!empty($check_key)){
          $resp = array('code' => false, 'message' => 'You are already added in group');
          $this->response($resp);
      }

         $user_id=$data['user_id'];
         $group_id=$data['group_id'];
         $check_type = $this->common_model->getSingleRecordById('groups',array('id' =>$data['group_id']));
         $isapproved=1;
         $approveddate=date('Y-m-d');
         if($check_type['is_closed_group']==1){
         $isapproved=0;
         $approveddate=null;
          }
         
         $check= $this->common_model->getSingleRecordById('groups',array('id' =>$group_id));
         $dataArray = array('group_id' => $group_id, 'member_id' => $user_id, 'isapproved' => $isapproved,'approveddate' => $approveddate,'isadmin' => 0,'ip' => $_SERVER['REMOTE_ADDR']);
         $recdata= $this->common_model->addRecords("group_member", $dataArray);

        if($recdata){
        $resp = array('code' => true, 'message' => 'SUCCESS', 'recdata'  => $recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'Error!!');
        }
        $this->response($resp);
  }

    public function group_member_delete_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key','group_id','delete_user_id');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

          $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

         $user_id=$data['user_id'];
         $delete_user_id=$data['delete_user_id'];
         $group_id=$data['group_id'];
         $condition=array('member_id' => $delete_user_id,'group_id' => $group_id);
         $recdata = $this->common_model->deleteRecords("group_member",$condition);
          
        if($recdata){
        $resp = array('code' => true, 'message' => 'Member removed from group', 'recdata'  => $recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'No data found!!');
        }
        $this->response($resp);
  }


  public function user_search_post() {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key','search');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

         $user_id=$data['user_id'];
         $search=$data['search'];
         $url=$GLOBALS['url'];
         $query="SELECT 
          u.id as user_id,
          u.full_name,
          u.email,
          case when u.profile_pic is null then '".$url."uploads2/users_profile/avatar.jpg' else concat('".$url."uploads2/users_profile/',u.profile_pic) end as profile_pic
          FROM users u 
         where u.full_name like '%$search%' or u.email  like '%$search%' ";
         $recdata= $this->common_model->getArrayByQuery($query);
        if($recdata){
        $resp = array('code' => true, 'message' => 'SUCCESS', 'recdata'  => $recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'No data found!!');
        }
        $this->response($resp);
  }


  public function tip_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key','post_id','token');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

        $user_id=$data['user_id'];
        $post_id=$data['post_id'];
        $token=$data['token'];
        
        $wallet = $this->common_model->getSingleRecordById('users_wallet',array('user_id'=>$user_id));
        $from=$wallet['public_key'];
        $private=$wallet['private_key'];
        // $balance=$this->get_balance($from,"0xffEfc73c8edc2bfbe3916b13f5E21c81d1Ce25ff");
        //  $balance=json_decode($balance,true);         
        //  $balance=$balance['balance'];

        $query="select p.user_id,uw.public_key from post as p inner join users_wallet as uw on uw.user_id=p.user_id where p.id=$post_id";
        $wallet = $this->common_model->getArrayByQuery($query);
        $to=$wallet[0]['public_key'];
        $to_user_id=$wallet[0]['user_id'];

         $trx_id ='TRX'.rand(1111111,9999999);
       
        $value=$token;
        $to_address=$to;
        $wallet = $this->common_model->getSingleRecordById('users_wallet',array('user_id' =>$data['user_id']));
        $from_address=$wallet['public_key'];
        $from_private_key=$wallet['private_key'];

        //$hash=$this->send_token($from_address,$to_address,$from_private_key,$value);
       // $hash=json_decode($hash,true);
       // $hash=json_decode($hash,true);
        $hash['hash']=$trx_id;

        if(!empty($hash['hash']))
          {
            
          $dataArray = array(
          'user_id'=>$user_id,
          'trx_type_id'=>1,
          'trx_date'=>date("Y-m-d"),
          'from_wallet'=>$from, 
          'to_wallet'=>$to,
          'trx_number'=>$trx_id, 
          'trx_amount'=>$token*-1,
          'currency'=>'FCELL',
          'post_id'=>$post_id,
          'hash'=>$hash['hash'],
          'description'=>'Reward on post',
          'is_complete'=>1,
          'ip'=>$_SERVER['REMOTE_ADDR']
        );

          $newid=$this->common_model->addRecords('transaction', $dataArray);
          $this->common_model->updateRecords('transaction',array('trx_number' =>$trx_id.'-'.$newid),array('id'=>$newid));

          $dataArray = array(
          'user_id'=>$to_user_id,
          'trx_type_id'=>1,
          'trx_date'=>date("Y-m-d"),
          'from_wallet'=>$from, 
          'to_wallet'=>$to,
          'trx_number'=>$trx_id.'-'.$newid, 
          'trx_amount'=>$token,
          'currency'=>'FCELL',
          'post_id'=>$post_id,
          'hash'=>$hash['hash'],
          'description'=>'Reward on post',
          'is_complete'=>1,
          'ip'=>$_SERVER['REMOTE_ADDR']
        );

        $newid=$this->common_model->addRecords('transaction', $dataArray);

        $check3 = $this->common_model->getSingleRecordById('users_wallet',array('public_key'=>$from));
          $this->common_model->updateRecords('users_wallet',array('balance' =>$check3['balance']-$value),array('public_key'=>$from));
        $check3 = $this->common_model->getSingleRecordById('users_wallet',array('public_key'=>$to));
          $this->common_model->updateRecords('users_wallet',array('balance' =>$check3['balance']+$token),array('public_key'=>$to));


          
        $recdata= $this->common_model->getSingleRecordById('transaction',array('id' =>$newid));
         }

        if($newid){
            //NOTIFICATION STARTS 
        $app_url=$GLOBALS['app_url'];
        $query="select id,full_name from users where  id =$user_id";
        $ndata=$this->common_model->getArrayByQuery($query);
        foreach ($ndata as $value) {
        $title="".$value['full_name']." rewarded you!!";
        $message="".$value['full_name']." rewarded you!!";
        $dataArray = array('recipient_id'=>$to_user_id,'sender_id'=>$data['user_id'],'title'=>$title,'message'=>$message,'link'=>$app_url.'timeLine/'.$value['id']);
        $this->common_model->addRecords("notification", $dataArray);
        }        
        //NOTIFICATION TO SENDER
        $query="select id,full_name from users where  id =$to_user_id";
        $ndata2=$this->common_model->getArrayByQuery($query);
        foreach ($ndata2 as $value) {
        $title="".$value['full_name']." rewarded by you!!";
        $message="".$value['full_name']." rewarded by you!!";
        $dataArray = array('recipient_id'=>$data['user_id'],'sender_id'=>$to_user_id,'title'=>$title,'message'=>$message,'link'=>$app_url.'timeLine/'.$value['id']);
        $this->common_model->addRecords("notification", $dataArray);
        }
        //NOTIFICATION ENDS
        $resp = array('code' => true, 'message' => 'SUCCESS', 'recdata'  => $hash['hash']);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  =>$hash);
        }
        $this->response($resp);
  }


  public function crowdfunding_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key','group_id','token');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

        $user_id=$data['user_id'];
        $group_id=$data['group_id'];
        $token=$data['token'];
        
        $wallet = $this->common_model->getSingleRecordById('users_wallet',array('user_id'=>$user_id));
        $from=$wallet['public_key'];
        $private=$wallet['private_key'];
        
        $query="select g.user_id,uw.public_key from `groups` as g inner join users_wallet as uw on uw.user_id=g.user_id where g.id=$group_id";
        $wallet = $this->common_model->getArrayByQuery($query);
        $to_address=$wallet[0]['public_key'];


        $to_user_id=$wallet[0]['user_id'];

        $trx_id ='TRX'.rand(1111111,9999999);
       
        $value=$token;
        $wallet = $this->common_model->getSingleRecordById('users_wallet',array('user_id' =>$data['user_id']));
        $from_address=$wallet['public_key'];
        $from_private_key=$wallet['private_key'];

        //$hash=$this->send_token($from_address,$to_address,$from_private_key,$value);
        //$hash=json_decode($hash,true);
        $hash['hash']=$trx_id;
        if(!empty($hash['hash']))
          {
            
          $dataArray = array(
          'user_id'=>$user_id,
          'trx_type_id'=>4,
          'trx_date'=>date("Y-m-d"),
          'from_wallet'=>$from_address, 
          'to_wallet'=>$to_address,
          'trx_number'=>$trx_id, 
          'trx_amount'=>$token*-1,
          'currency'=>'FCELL',
          'group_id'=>$group_id,
          'hash'=>$hash['hash'],
          'description'=>'Crowdfunding',
          'is_complete'=>1,
          'ip'=>$_SERVER['REMOTE_ADDR']
        );

          $newid=$this->common_model->addRecords('transaction', $dataArray);
          $this->common_model->updateRecords('transaction',array('trx_number' =>$trx_id.'-'.$newid),array('id'=>$newid));

          $dataArray = array(
          'user_id'=>$to_user_id,
          'trx_type_id'=>4,
          'trx_date'=>date("Y-m-d"),
          'from_wallet'=>$from_address, 
          'to_wallet'=>$to_address,
          'trx_number'=>$trx_id.'-'.$newid, 
          'trx_amount'=>$token,
          'currency'=>'FCELL',
          'group_id'=>$group_id,
          'hash'=>$hash['hash'],
          'description'=>'Crowdfunding',
          'is_complete'=>1,
          'ip'=>$_SERVER['REMOTE_ADDR']
        );

        $newid=$this->common_model->addRecords('transaction', $dataArray);
        
        $check3 = $this->common_model->getSingleRecordById('users_wallet',array('public_key'=>$from_address));
          $this->common_model->updateRecords('users_wallet',array('balance' =>$check3['balance']-$token),array('public_key'=>$from_address));
        $check3 = $this->common_model->getSingleRecordById('users_wallet',array('public_key'=>$to_address));
          $this->common_model->updateRecords('users_wallet',array('balance' =>$check3['balance']+$token),array('public_key'=>$to_address));

        $recdata= $this->common_model->getSingleRecordById('transaction',array('id' =>$newid));
         }
        if(isset($newid)){
             //NOTIFICATION STARTS 
        $app_url=$GLOBALS['app_url'];
        $query="select id,full_name from users where  id =$user_id";
        $ndata=$this->common_model->getArrayByQuery($query);
        foreach ($ndata as $value) {
        $title="".$value['full_name']." crowdfunded you!!";
        $message="".$value['full_name']." crowdfunded you!!";
        $dataArray = array('recipient_id'=>$to_user_id,'sender_id'=>$data['user_id'],'title'=>$title,'message'=>$message,'link'=>$app_url.'timeLine/'.$value['id']);
        $this->common_model->addRecords("notification", $dataArray);
        }        
        //NOTIFICATION TO SENDER
        $query="select id,full_name from users where  id =$to_user_id";
        $ndata2=$this->common_model->getArrayByQuery($query);
        foreach ($ndata2 as $value) {
        $title="".$value['full_name']." crowdfunded by you!!";
        $message="".$value['full_name']." crowdfunded by you!!";
        $dataArray = array('recipient_id'=>$data['user_id'],'sender_id'=>$to_user_id,'title'=>$title,'message'=>$message,'link'=>$app_url.'timeLine/'.$value['id']);
        $this->common_model->addRecords("notification", $dataArray);
        }
        //NOTIFICATION ENDS


        //        //NOTIFICATION STARTS 
        // $app_url=$GLOBALS['app_url'];
        // $query="select id,full_name from users where  id =$user_id";
        // $ndata=$this->common_model->getArrayByQuery($query);
        // foreach ($ndata as $value) {
        // $title="".$value['full_name']." crowdfunded you!!";
        // $message="".$value['full_name']." crowdfunded you!!";
        // $dataArray = array('recipient_id'=>$to_user_id,'sender_id'=>$data['user_id'],'title'=>$title,'message'=>$message,'link'=>$app_url.'timeLine/'.$value['id']);
        // $this->common_model->addRecords("notification", $dataArray);
        // }
        // //NOTIFICATION ENDS
        $resp = array('code' => true, 'message' => 'SUCCESS', 'recdata'  => $hash['hash']);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  =>$hash);
        }
        $this->response($resp);
  }



  public function buy_token_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key','currency','token_value','currency_value');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

        $user_id=$data['user_id'];
        $currency=$data['currency'];
        $token_value=$data['token_value'];
        $currency_value=$data['currency_value'];
        
        $wallet = $this->common_model->getSingleRecordById('users_wallet',array('user_id'=>$user_id));
        $setting = $this->common_model->getSingleRecordById('setting',array('id'=>1));
        $trx_id ='TRX'.rand(1111111,9999999);
        
        if($currency=='ETH'){
        $from_address=$wallet['public_key'];
        $to_address=$setting['eth_public_key'];
        $from_private_key=$wallet['private_key'];
        $value=$currency_value;
        $hash=$this->send_eth($from_address,$to_address,$from_private_key,$value);
        $hash=json_decode($hash,true);
        if(!empty($hash['hash'])){

          $dataArray = array(
          'user_id'=>$user_id,
          'trx_type_id'=>3,
          'trx_date'=>date("Y-m-d"),
          'from_wallet'=>$from_address, 
          'to_wallet'=>$to_address,
          'trx_number'=>$trx_id, 
          'trx_amount'=>$value*-1,
          'currency'=>'ETH',
          'hash'=>$hash['hash'],
          'description'=>'Buy Token',
          'is_complete'=>1,
          'ip'=>$_SERVER['REMOTE_ADDR']
        );

        $newid=$this->common_model->addRecords('transaction', $dataArray);
        $this->common_model->updateRecords('transaction',array('trx_number' =>$trx_id.'-'.$newid),array('id'=>$newid));

        // send fcell to user
        $from_address=$setting['eth_public_key'];
        $to_address=$wallet['public_key'];
        $from_private_key=$setting['eth_private_key'];
        $value=$token_value;
       // $fcell_hash=$this->send_token($from_address,$to_address,$from_private_key,$value);
       // $fcell_hash=json_encode($hash);
        if(!empty($hash['hash'])){
          $dataArray = array(
          'user_id'=>$user_id,
          'trx_type_id'=>3,
          'trx_date'=>date("Y-m-d"),
          'from_wallet'=>$from_address, 
          'to_wallet'=>$to_address,
          'trx_number'=>$trx_id.'-'.$newid, 
          'trx_amount'=>$value,
          'currency'=>'FCELL',
          'hash'=>$hash['hash'],
          'description'=>'Buy Token',
          'is_complete'=>1,
          'ip'=>$_SERVER['REMOTE_ADDR']
        );
        $newid=$this->common_model->addRecords('transaction', $dataArray);
        $check3 = $this->common_model->getSingleRecordById('users_wallet',array('user_id'=>$user_id));
          $this->common_model->updateRecords('users_wallet',array('balance' =>$check3['balance']+$value),array('user_id'=>$user_id));
        }
        }
      }

        //BUY TOKEN WITH BTC
        if($currency=='BTC'){
        $from_address=$wallet['btc_public_key'];
        $to_address=$setting['btc_public_key'];
        $from_private_key=$wallet['btc_private_key'];
        $value=$currency_value;
        $hash=$this->send_btc($from_address,$to_address,$from_private_key,$value);
        $hash=json_decode($hash,true);
        if(!empty($hash['hash'])){

          $dataArray = array(
          'user_id'=>$user_id,
          'trx_type_id'=>3,
          'trx_date'=>date("Y-m-d"),
          'from_wallet'=>$from_address, 
          'to_wallet'=>$to_address,
          'trx_number'=>$trx_id, 
          'trx_amount'=>$value*-1,
          'currency'=>'BTC',
          'hash'=>$hash['hash'],
          'description'=>'Buy Token',
          'is_complete'=>1,
          'ip'=>$_SERVER['REMOTE_ADDR']
        );

        $newid=$this->common_model->addRecords('transaction', $dataArray);
        $this->common_model->updateRecords('transaction',array('trx_number' =>$trx_id.'-'.$newid),array('id'=>$newid));

        // send fcell to user
        $from_address=$setting['eth_public_key'];
        $to_address=$wallet['public_key'];
        $from_private_key=$setting['eth_private_key'];
        $value=$token_value;
        //$fcell_hash=$this->send_token($from_address,$to_address,$from_private_key,$value);
        //$fcell_hash=json_encode($hash);
        if(!empty($hash['hash'])){
          $dataArray = array(
          'user_id'=>$user_id,
          'trx_type_id'=>3,
          'trx_date'=>date("Y-m-d"),
          'from_wallet'=>$from_address, 
          'to_wallet'=>$to_address,
          'trx_number'=>$trx_id.'-'.$newid, 
          'trx_amount'=>$value,
          'currency'=>'FCELL',
          'hash'=>$hash['hash'],
          'description'=>'Buy Token',
          'is_complete'=>1,
          'ip'=>$_SERVER['REMOTE_ADDR']
        );
        $newid=$this->common_model->addRecords('transaction', $dataArray);
        }
        }
      }
      if(isset($newid)){
        $recdata= $this->common_model->getSingleRecordById('transaction',array('id' =>$newid));
        $resp = array('code' => true, 'message' => 'SUCCESS', 'hash' => $hash['hash']);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  =>$hash);
        }
        $this->response($resp);
  }



  public function withdraw_token_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key','fcell','ether','fees');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

        $user_id=$data['user_id'];
        $fcell=$data['fcell'];
        $ether=$data['ether'];
        $fees=$data['fees'];
        
        $wallet = $this->common_model->getSingleRecordById('users_wallet',array('user_id'=>$user_id));
        $setting = $this->common_model->getSingleRecordById('setting',array('id'=>1));
        $trx_id ='TRX'.rand(1111111,9999999);
        
        $to_address=$wallet['public_key'];
        $from_address=$setting['eth_public_key'];
        $from_private_key=$setting['eth_private_key'];
        $value=$ether;
        $hash=$this->send_eth($from_address,$to_address,$from_private_key,$value);
        $hash=json_decode($hash,true);
        if(!empty($hash['hash'])){

          $dataArray = array(
          'user_id'=>$user_id,
          'trx_type_id'=>6,
          'trx_date'=>date("Y-m-d"),
          'from_wallet'=>$from_address, 
          'to_wallet'=>$to_address,
          'trx_number'=>$trx_id, 
          'trx_amount'=>$ether,
          'currency'=>'ETH',
          'hash'=>$hash['hash'],
          'description'=>'Withdraw Token',
          'is_complete'=>1,
          'ip'=>$_SERVER['REMOTE_ADDR']
        );

        $newid=$this->common_model->addRecords('transaction', $dataArray);
        $this->common_model->updateRecords('transaction',array('trx_number' =>$trx_id.'-'.$newid),array('id'=>$newid));

        // send fcell to admin
        $to_address=$setting['eth_public_key'];
        $from_address=$wallet['public_key'];
        $from_private_key=$wallet['private_key'];
        $value=$fcell;
        //$fcell_hash=$this->send_token($from_address,$to_address,$from_private_key,$value);
        //$fcell_hash=json_encode($hash);
        $fcell_hash['hash']="Offchain";
        if(!empty($fcell_hash['hash'])){
          $dataArray = array(
          'user_id'=>$user_id,
          'trx_type_id'=>6,
          'trx_date'=>date("Y-m-d"),
          'from_wallet'=>$from_address, 
          'to_wallet'=>$to_address,
          'trx_number'=>$trx_id.'-'.$newid, 
          'trx_amount'=>$value*-1,
          'currency'=>'FCELL',
          'hash'=>$hash['hash'],
          'description'=>'Withdraw Token',
          'is_complete'=>1,
          'ip'=>$_SERVER['REMOTE_ADDR']
        );
        $newid=$this->common_model->addRecords('transaction', $dataArray);
        $check3 = $this->common_model->getSingleRecordById('users_wallet',array('public_key'=>$from_address));
          $this->common_model->updateRecords('users_wallet',array('balance' =>$check3['balance']-$value),array('public_key'=>$from_address));
          
        }
        }
      

      if(isset($newid)){
        $recdata= $this->common_model->getSingleRecordById('transaction',array('id' =>$newid));
        $resp = array('code' => true, 'message' => 'SUCCESS', 'hash' => $hash['hash']);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  =>$hash);
        }
        $this->response($resp);
  }


  public function wallet_balance_post() {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

         $user_id=$data['user_id'];
         $recdata = $this->common_model->getSingleRecordById("users_wallet", array('user_id' => $user_id));
         $setting= $this->common_model->getSingleRecordById("setting", array('id' =>1));

         /// TRACK HASH STARTS
         $curl = curl_init();
          curl_setopt_array($curl, array(
          CURLOPT_URL => '52.66.202.69:7000/api/eth/track_address/'.$recdata['public_key'].'',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
          ));
          $response = curl_exec($curl);
          curl_close($curl);
          $resp=json_decode($response);
          foreach ($resp as $value) {
          if(!empty($value->hash)){
          $hash=$value->hash;
          
          $trxcheck = $this->common_model->getSingleRecordById("transaction", array('hash' => $hash,'user_id' => $user_id));

          if(empty($trxcheck)){
            $trx_amt=$value->value/1000000000000000000;
            if(strtoupper($recdata['public_key'])==strtoupper($value->from)){
              $trx_amt=$trx_amt*-1;
            }
          $dataArray = array('user_id'=>$user_id,'trx_type_id'=>11,'from_wallet'=>$value->from,'to_wallet'=>$value->to,'trx_date'=>date("Y-m-d H:i:s",$value->timeStamp),'trx_amount'=>$trx_amt,'currency'=>'ETH','hash'=>$value->hash,'is_complete'=>1,'ip'=>$_SERVER['REMOTE_ADDR']);
          $this->common_model->addRecords('transaction', $dataArray); 
        }
        }
          }

          /// track hash end

         //get fcell balance
         //$balance=$this->get_balance($recdata['public_key'],"0xffEfc73c8edc2bfbe3916b13f5E21c81d1Ce25ff");
         //$balance=json_decode($balance,true);         
         //$balance=$balance['balance'];
         $balance=$recdata['balance'];
         //get btc balance
         //$btc_balance=$this->get_BTC_balance($recdata['btc_public_key']);
        // $btc_balance=json_decode($btc_balance,true);         
        // $btc_balance=$btc_balance['balance'];
         //get eth balance
         $eth_balance=$this->get_ETH_balance($recdata['public_key']);
         $eth_balance=json_decode($eth_balance,true);         
         $eth_balance=$eth_balance['balance'];
         
         $data[]=array();
         $rec['ETH_address']=$recdata['public_key'];
         $rec['BTC_address']=$recdata['btc_public_key'];
         $rec['fcell_balance']=number_format($balance,2,'.',',');
         //$rec['btc_balance']=number_format($btc_balance,2,'.',',');
         $rec['eth_balance']=number_format($eth_balance,4,'.',',');
         $usd=$balance*$setting['fcell_usd_price'];
         $fcell_btc_value=(1/($this->get_coinprice('BTC','USD')*$setting['fcell_usd_price']));
         $fcell_eth_value=(1/($this->get_coinprice('ETH','USD')*$setting['fcell_usd_price']));
        
         if($balance>0){
         $eth=$this->get_coinprice('ETH','USD');
         $eth=round(($usd/$eth),2);
         $btc=number_format((1/($this->get_coinprice('BTC','USD'))),10)*$usd;
         $czk=$this->get_coinprice('ETH','CZK')/$this->get_coinprice('ETH','USD');
         $czk=round(($czk)*($balance*$setting['fcell_usd_price']),2);
         $rec['fcell_balance_eth']=number_format($eth,4,'.',',');
         $rec['fcell_balance_btc']=number_format($btc,4,'.',',');
         $rec['fcell_balance_usd']=number_format($usd,2,'.',',');
         $rec['fcell_balance_czk']=number_format($czk,2,'.',',');
       }
       else{
        $rec['fcell_balance_eth']=0;
         $rec['fcell_balance_btc']=0;
         $rec['fcell_balance_usd']=0;
         $rec['fcell_balance_czk']=0;
       }

       $query="select withdraw_fee_percent from plan_type where id in (select plan_id from user_plan where user_id=$user_id)";
       $fee = $this->common_model->getArrayByQuery($query);
         $rec['withdraw_fee_percent']=$fee[0]['withdraw_fee_percent'];
         $rec['fcell_btc_value']=number_format($fcell_btc_value,4,'.',',');
         $rec['fcell_eth_value']=number_format($fcell_eth_value,4,'.',',');
         $btc_balance=0;
        /* if(!empty($recdata['btc_public_key'])){
         $btc_public_key=$recdata['btc_public_key'];
         $pdata = file_get_contents("http://13.233.136.121:7001/api/testbtc/getBalance/$btc_public_key");
         $data = json_decode( $pdata,true );
         $btc_balance=$data['balance'];
          }*/
         $rec['btc_balance']=$btc_balance;
        if($recdata){
        $resp = array('code' => true, 'message' => 'SUCCESS','recdata'=> $rec);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'No data found!!');
        }
        $this->response($resp);
  }

  public function show_display_name_post() {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

         $user_id=$data['user_id'];
         $recdata = $this->common_model->getSingleRecordById("users", array('id' => $user_id));
        if($recdata){
        $resp = array('code' => true, 'message' => 'SUCCESS', 'display_name'  => $recdata['full_name']);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'No data found!!');
        }
        $this->response($resp);
  }


  public function show_referral_code_post() {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);  
          }
 
      $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

         $user_id=$data['user_id'];
         $recdata = $this->common_model->getSingleRecordById("users", array('id' => $user_id));
        if($recdata){
        
        $resp = array('code' => true, 'message' => 'SUCCESS', 'referral_code'  => $recdata['referral_code']);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'No data found!!');
        }
        $this->response($resp);
  }


  public function update_display_name_post() {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','display_name','api_key');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

         $display_name=$data['display_name'];
         $user_id=$data['user_id'];
         $recdata=$this->common_model->updateRecords('users',array('full_name' =>$display_name),array('id'=>$user_id));
        if($recdata){
          $recdata= $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id']));
        $resp = array('code' => true, 'message' => 'SUCCESS', 'display_name'  => $recdata['full_name']);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'Error occured!!');
        }
        $this->response($resp);
  }


public function show_email_post() {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

         $user_id=$data['user_id'];
         $recdata = $this->common_model->getSingleRecordById("users", array('id' => $user_id));
        if($recdata){
        $resp = array('code' => true, 'message' => 'SUCCESS', 'display_name'  => $recdata['email']);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'No data found!!');
        }
        $this->response($resp);
  }

public function show_language_post() {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

         $user_id=$data['user_id'];
         $query="select * from language order by language";
         $recdata = $this->common_model->getArrayByQuery($query);
        if($recdata){
        $resp = array('code' => true, 'message' => 'SUCCESS', 'display_name'  => $recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'No data found!!');
        }
        $this->response($resp);
  }


public function show_user_language_post() {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

         $user_id=$data['user_id'];
         $query="select u.id as user_id,l.language from users as u left join language as l on l.id=u.language_id where u.id=$user_id";
         $recdata = $this->common_model->getArrayByQuery($query);
        if($recdata){
        $resp = array('code' => true, 'message' => 'SUCCESS', 'display_name'  => $recdata[0]);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'No data found!!');
        }
        $this->response($resp);
  }


  public function update_language_post() {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','language_id','api_key');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }
         $language_id=$data['language_id'];
         $user_id=$data['user_id'];
         $recdata=$this->common_model->updateRecords('users',array('language_id' =>$language_id),array('id'=>$user_id));
        if($recdata){
        $resp = array('code' => true, 'message' => 'SUCCESS', 'recdata'  => 'Language updated successfully!!');
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'Error occured!!');
        }
        $this->response($resp);
  }


public function show_email_notification_post() {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

         $user_id=$data['user_id'];

         $recdata = $this->common_model->getSingleRecordById("users", array('id' => $user_id));
        if($recdata){
        $resp = array('code' => true, 'message' => 'SUCCESS', 'email_notification'  => $recdata['email_notification']);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'No data found!!');
        }
        $this->response($resp);
  }


  public function update_email_notification_post() {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','email_notification','api_key');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

         $email_notification=$data['email_notification'];
         $user_id=$data['user_id'];
         $recdata=$this->common_model->updateRecords('users',array('email_notification' =>$email_notification),array('id'=>$user_id));
        if($recdata){
          $recdata= $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id']));
        $resp = array('code' => true, 'message' => 'SUCCESS', 'email_notification'  => $recdata['email_notification']);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'Error occured!!');
        }
        $this->response($resp);
  }


  public function add_user_interest_post() {
      
        $interest=null;
        $mobile=null;
        $address=null;
        $dob=null;
        $profile_pic=null;
        $file=null;

        if(!empty($_POST['mobile'])) {
            $mobile=$_POST['mobile'];
          }
        if(!empty($_POST['address'])) {
            $address=$_POST['address'];
          }
        if(!empty($_POST['dob'])) {
            $dob=$_POST['dob'];
          }
         if(isset($_FILES["profile_pic"]['name']))
          {
              $imagename=time().$_FILES["profile_pic"]["name"];
              $tnm=$_FILES["profile_pic"]["tmp_name"];
              $dbpath = base_url().'uploads2/users_profile/pp_'.$imagename;
              $flag=move_uploaded_file($tnm,"uploads2/users_profile/pp_".$imagename);
              $file='pp_'.$imagename;
          }
         $user= $this->common_model->getSingleRecordById('users',array('email_auth_code'=>$_POST['code']));
        
          if(empty($user)){
          $resp = array('code' => false, 'message' => 'Invalid user!!');
          $this->response($resp);
          }
        
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
          $code= md5(substr(str_shuffle($permitted_chars), 0, 40));
          
        $dataArray = array('mobile'=>$mobile,'api_key'=>$code, 'email_verify'=>1,'address'=>$address,'dob'=>$dob,'profile_pic'=>$file, 'ip'=>$_SERVER['REMOTE_ADDR']);
         $condition=array('id' => $user['id']);
         $recdata=$this->common_model->updateRecords('users', $dataArray,$condition);

        if(!empty($_POST['interest'])) {
          $int=explode(',', $_POST['interest']);
         foreach ($int as $value) {
         
         $dataArray = array('user_id'=>$user['id'],'interest_id'=>$value,'ip'=>$_SERVER['REMOTE_ADDR']);
         $this->common_model->addRecords('user_interest', $dataArray); 
          } 
        }

        if($recdata){
         $user_id=$user['id'];
 
        $whr=" where u.id=$user_id";
        $orderby="";
        /* Get user data */
        $recdata = $this->common_model->getUserProfile($whr,$orderby);
       $resp = array('code' => true, 'message' => 'SUCCESS', 'user_data'  => $recdata[0]);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'Error occured!!');
        }
        $this->response($resp);
  }


  public function add_hashtag_post() {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','hashtag','api_key','lable');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }
         $hashtag=$data['hashtag'];
         $lable=$data['lable'];
         $user_id=$data['user_id'];
         $dataArray = array('user_id'=>$user_id,'lable'=>$lable,'hashtag'=>$hashtag,'ip'=>$_SERVER['REMOTE_ADDR']);
         $recdata=$this->common_model->addRecords('user_hashtag', $dataArray);
        if($recdata){
        $query="select id,lable,case when hashtag like '#%' then hashtag else concat('#',hashtag) end as hashtag from user_hashtag where user_id=$user_id order by id desc";
        $recdata= $this->common_model->getArrayByQuery($query);
        $resp = array('code' => true, 'message' => 'SUCCESS', 'hashtags'  => $recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'Error occured!!');
        }
        $this->response($resp);
  }

  public function hashtag_list_post() {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key','offset','limit');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

        $user_id=$data['user_id'];
        $offset=$data['offset'];
        $limit =$data['limit'];
        $query="select id,lable,case when hashtag like '#%' then hashtag else concat('#',hashtag) end as hashtag from user_hashtag where user_id=$user_id order by id desc limit $offset,$limit";
        $recdata=$this->common_model->getArrayByQuery($query);
        if($recdata){
        $query="select count(id) as count from user_hashtag where user_id=$user_id";
        $cdata=$this->common_model->getArrayByQuery($query);
          
        $resp = array('code' => true, 'message' => 'SUCCESS', 'count'=>$cdata[0]['count'],'offset'=>$offset, 'hashtags'  => $recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'Error occured!!');
        }
        $this->response($resp);
  }

  public function plan_price_post() {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }
        $user_id=$data['user_id'];
         //get fcell balance
         $recdata = $this->common_model->getSingleRecordById("users_wallet", array('user_id' => $user_id));
         //$balance=$this->get_balance($recdata['public_key'],"0xffEfc73c8edc2bfbe3916b13f5E21c81d1Ce25ff");
         //$balance=json_decode($balance,true);         
         $balance=$recdata['balance'];

        $query="select id,name,round(monthly_charges) as monthly_charges,round(yearly_charges) as yearly_charges,$balance as token_balance from plan_type where id<>1 order by id";
        $recdata=$this->common_model->getArrayByQuery($query);
        if($recdata){
        $resp = array('code' => true, 'message' => 'SUCCESS', 'recdata'  => $recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'Error occured!!');
        }
        $this->response($resp);
  }

  public function interest_list_get() {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        /*$required_parameter = array('user_id','api_key');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }
*/
        $query="select id,name from interest_type";
        $recdata=$this->common_model->getArrayByQuery($query);
        if($recdata){
        $resp = array('code' => true, 'message' => 'SUCCESS', 'recdata'  => $recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'Error occured!!');
        }
        $this->response($resp);
  }


public function sujjested_hashtag_post() {
       /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        $required_parameter = array('user_id','api_key');
          $chk_error = check_required_value($required_parameter, $object_info);
        if ($chk_error)
        {
            $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
            $this->response($resp);
        }
         $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }
            $url=$GLOBALS['url'];
            $user_id=$data['user_id'];
            $query="SELECT hashtag,count(distinct post_id) as post_count from post_hashtag as ph inner join post as p on p.id=ph.post_id and p.isdeleted=0 and hashtag like '#%'group by hashtag order by count(distinct post_id) desc limit 5";
            $recdata= $this->common_model->getArrayByQuery($query);
           
            if(!empty($recdata))
            {    
               $resp = array('code' => true, 'message' => 'SUCCESS', 'recdata' =>$recdata);
            } 
            else 
            { 
               $resp = array('code' => false, 'message' =>  'Some error occured');
            }
            $this->response($resp);
  }




  public function select_hashtag_post() {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

        $user_id=$data['user_id'];
        $query="select case when hashtag like '#%' then hashtag else concat('#',hashtag) end as hashtag from user_hashtag where user_id=$user_id 
        union all 
        select distinct hashtag from post_hashtag where hashtag not in (select hashtag from user_hashtag where user_id=$user_id)
        order by rand() limit 5";
        $recdata=$this->common_model->getArrayByQuery($query);
        if($recdata){
        $resp = array('code' => true, 'message' => 'SUCCESS','hashtags'  => $recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'Error occured!!');
        }
        $this->response($resp);
  }


  public function search_hashtag_post() {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key','search');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

        $user_id=$data['user_id'];
        $search=$data['search'];
        $query="select distinct hashtag from post_hashtag where hashtag like '%$search%'";
        $recdata=$this->common_model->getArrayByQuery($query);
        if($recdata){          
        $resp = array('code' => true, 'message' => 'SUCCESS','recdata'  => $recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'Error occured!!');
        }
        $this->response($resp);
  }

  public function all_search_post() {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }
      if(empty($data['search'])){
          $resp = array('code' => false, 'message' => 'Search criteria not found!!');
          $this->response($resp);
      }

        $user_id=$data['user_id'];
        $search=$data['search'];
        $url=$GLOBALS['url'];
        $query="
        select 
          u.id as id,
          'user' as type,
          u.full_name as name,
          u.full_name as fullname,
          u.email,
          case when u.profile_pic is null then '".$url."uploads2/users_profile/avatar.jpg' else concat('".$url."','uploads2/users_profile/',u.profile_pic) end as profile_pic
          from users as u where u.full_name like '%$search%' or u.email like '%$search%'
          union all 
          select 
            g.id,
            case when is_project=0 then 'group' else 'project' end as type,
            substring(group_name,1,20) as name,
            group_name as fullname,
            '' as email,
            concat('".$url."uploads2/group_avatar/',g.avatar) as profile_pic
            from `groups` as g where g.group_name like '%$search%' or g.description like '%$search%' and g.is_closed_group=0 and g.isdeleted=0

          ";
          
        $recdata=$this->common_model->getArrayByQuery($query);
        if($recdata){          
        $resp = array('code' => true, 'message' => 'SUCCESS','recdata'  => $recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'Error occured!!');
        }
        $this->response($resp);
  }

  public function all_hashtag_list_post() {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

        $user_id=$data['user_id'];
        $query="select distinct hashtag from post_hashtag";
        $recdata=$this->common_model->getArrayByQuery($query);
        if($recdata){
        $resp = array('code' => true, 'message' => 'SUCCESS','hashtags'  => $recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'Error occured!!');
        }
        $this->response($resp);
  }

    public function delete_hashtag_post() {

        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key','hashtag_id');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
        }

          $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

         $user_id=$data['user_id'];
         $hashtag_id=$data['hashtag_id'];
         $condition=array('id' => $hashtag_id);
         $recdata = $this->common_model->deleteRecords("user_hashtag",$condition);
          
        if($recdata){
          $query="select * from user_hashtag where user_id=$user_id order by id desc";
        $recdata= $this->common_model->getArrayByQuery($query);
        $resp = array('code' => true, 'message' => '#tag removed', 'recdata'  => $recdata);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'Error occured!!');
        }
        $this->response($resp);
  }


  public function coin_transfer_post() {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key','to_wallet','amount','currency','fees');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }
        
        $user_id=$data['user_id'];
        $value=$data['amount'];
        $to_address=$data['to_wallet'];
        $currency=$data['currency'];
        $fees=$data['fees'];
        
        $wallet = $this->common_model->getSingleRecordById('users_wallet',array('user_id' =>$data['user_id']));
        $from_address=$wallet['public_key'];
        $from_private_key=$wallet['private_key'];
        

        if($currency=='FCELL'){
            $wallet = $this->common_model->getSingleRecordById('users_wallet',array('user_id'=>$user_id));
            $setting = $this->common_model->getSingleRecordById('setting',array('id'=>1));
            $trx_id ='TRX'.rand(1111111,9999999);
            
            $from_address=$wallet['public_key'];
            $to_address=$setting['eth_public_key'];
            $from_private_key=$wallet['private_key'];
            $fees=$fees;
            $hash=$this->send_eth($from_address,$to_address,$from_private_key,$fees);
            $hash=json_decode($hash,true);
            if(!empty($hash['hash'])){
             $dataArray = array(
            'user_id'=>$user_id,
            'trx_type_id'=>7,
            'trx_date'=>date("Y-m-d"),
            'from_wallet'=>$from_address, 
            'to_wallet'=>$to_address,
            'currency'=>'ETH',
            'trx_number'=>$trx_id, 
            'trx_amount'=>$fees*-1,
            'description'=>'Token Transfer Fees',
            'is_complete'=>1,
            'ip'=>$_SERVER['REMOTE_ADDR']
          );

        $newid=$this->common_model->addRecords('transaction', $dataArray);
        $this->common_model->updateRecords('transaction',array('trx_number' =>$trx_id.'-'.$newid),array('id'=>$newid));

        $from_address=$wallet['public_key'];
        $from_private_key=$wallet['private_key'];
        //$hash=$this->send_token($from_address,$to_address,$from_private_key,$value);
        //$hash=json_decode($hash,true);
        $hash['hash']=$hash;
       }
       else{
        $hash['hash']="";
       }
     }
        
        if($currency=='BTC'){
        $from_address=$wallet['btc_public_key'];
        $from_private_key=$wallet['btc_private_key'];
        $value=$data['amount']*100000000;
        $hash=$this->send_btc($from_address,$to_address,$from_private_key,$value);
        $hash=json_decode($hash,true);
       }

       if($currency=='ETH'){
        $from_address=$wallet['public_key'];
        $from_private_key=$wallet['private_key'];
        $hash=$this->send_btc($from_address,$to_address,$from_private_key,$value);
        $hash=json_decode($hash,true);
       }


        if(!empty($hash['hash']))
          {

          $trx_id ='TRX'.rand(1111111,9999999);
          $hash=$hash['hash'];

         $dataArray = array(
          'user_id'=>$user_id,
          'trx_type_id'=>2,
          'trx_date'=>date("Y-m-d"),
          'from_wallet'=>$from_address, 
          'to_wallet'=>$to_address,
          'currency'=>'FCELL',
          'trx_number'=>$trx_id, 
          'trx_amount'=>$value*-1,
          'hash'=>$hash['hash'],
          'description'=>'Token Transfer',
          'is_complete'=>1,
          'ip'=>$_SERVER['REMOTE_ADDR']
        );

          $newid=$this->common_model->addRecords('transaction', $dataArray);
          $this->common_model->updateRecords('transaction',array('trx_number' =>$trx_id.'-'.$newid),array('id'=>$newid));
          $check3 = $this->common_model->getSingleRecordById('users_wallet',array('public_key'=>$from_address));
          $this->common_model->updateRecords('users_wallet',array('balance' =>$check3['balance']-$value),array('public_key'=>$from_address));
          
          $check3 = $this->common_model->getSingleRecordById('users_wallet',array('public_key'=>$to_address));
          $this->common_model->updateRecords('users_wallet',array('balance' =>$check3['balance']+$value),array('public_key'=>$to_address));
        }
        if(!empty($newid)){
        
        $resp = array('code' => true, 'message' => 'SUCCESS', 'hash'  => $hash);
        } else {

        $resp = array('code' => false, 'message' => 'FAILURE', 'response'=>$hash);
        }
        $this->response($resp);
  }

  public function withdraw_eth_post() {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key','to_wallet','amount','fees');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }
        
        $user_id=$data['user_id'];
        $value=$data['amount']-$data['fees'];
        $to_address=$data['to_wallet'];
        $fee=$data['fees'];
        
        $wallet = $this->common_model->getSingleRecordById('users_wallet',array('user_id' =>$data['user_id']));
        $from_address=$wallet['public_key'];
        $from_private_key=$wallet['private_key'];
        $setting = $this->common_model->getSingleRecordById('setting',array('id' =>1));
        $fee_address=$setting['eth_public_key'];
        
        ///// eth airdrop

            $curl = curl_init();

            curl_setopt_array($curl, array(
              //CURLOPT_URL => "13.233.136.121:7001/api/testnet/multieth/transfer",
              CURLOPT_URL => "http://13.233.136.121:7001/api/mainnet/multieth/transfer",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS =>"{\r\n\"from_address\": \"".$from_address."\",\r\n\"from_private_key\": \"".$from_private_key."\",\r\n\"to_address\": [\"".$to_address."\",\"".$fee_address."\"],\r\n\"value\": [\"".$value."\",\"".$fee."\"]\r\n}",
              CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
              ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            
             $hash=json_decode($response,true);
            
            
        if(!empty($hash['hash']))
          {
          $trx_id ='TRX'.rand(1111111,9999999);
          $hash=$hash['hash'];

         $dataArray = array(
          'user_id'=>$user_id,
          'trx_type_id'=>8,
          'trx_date'=>date("Y-m-d"),
          'from_wallet'=>$from_address, 
          'to_wallet'=>$to_address,
          'currency'=>'ETH',
          'trx_number'=>$trx_id, 
          'trx_amount'=>$value*-1,
          'hash'=>$hash,
          'description'=>'ETH Transfer',
          'is_complete'=>1,
          'ip'=>$_SERVER['REMOTE_ADDR']
        );

          $newid=$this->common_model->addRecords('transaction', $dataArray);
          $this->common_model->updateRecords('transaction',array('trx_number' =>$trx_id.'-'.$newid),array('id'=>$newid));


        
        //// TRANSACTION FEE TRANSACTION

         
          $dataArray = array(
          'user_id'=>$user_id,
          'trx_type_id'=>9,
          'trx_date'=>date("Y-m-d"),
          'from_wallet'=>$from_address, 
          'to_wallet'=>$fee_address,
          'currency'=>'ETH',
          'trx_number'=>$trx_id.'-'.$newid, 
          'trx_amount'=>$fee*-1,
          'hash'=>$hash,
          'description'=>'ETH Transfer Fee',
          'is_complete'=>1,
          'ip'=>$_SERVER['REMOTE_ADDR']
        );
           $newid2=$this->common_model->addRecords('transaction', $dataArray);

        }
        

        if(!empty($newid)){
          $check4 = $this->common_model->getSingleRecordById('users_wallet',array('public_key'=>$to_address));
          if(!empty($check4)){

            $rec=$check4['user_id'];
          //// TRANSACTION FOR RECEIVER

             $dataArray = array(
          'user_id'=>$rec,
          'trx_type_id'=>10,
          'trx_date'=>date("Y-m-d"),
          'from_wallet'=>$from_address, 
          'to_wallet'=>$to_address,
          'currency'=>'ETH',
          'trx_number'=>$trx_id.'-'.$newid, 
          'trx_amount'=>$value,
          'hash'=>$hash,
          'description'=>'ETH Received',
          'is_complete'=>1,
          'ip'=>$_SERVER['REMOTE_ADDR']
        );

          $newid=$this->common_model->addRecords('transaction', $dataArray);

          
        //NOTIFICATION STARTS 
        $app_url=$GLOBALS['app_url'];
        //$user_id=$data['user_id'];
        $query="select u2.id as recipient_id,u.id as sender_id,u.full_name from users as u cross join (select id from users where id=$rec) as u2 where u.id=$user_id";
        $ndata=$this->common_model->getArrayByQuery($query);
        foreach ($ndata as $value) {
        $title="".$value['full_name']." send you ETH!!";
        $message="".$value['full_name']." send you ETH!!";
        $dataArray = array('recipient_id'=>$value['recipient_id'],'sender_id'=>$value['sender_id'],'title'=>$title,'message'=>$message,'link'=>$app_url.'wallet');
        $this->common_model->addRecords("notification", $dataArray);
        }
        //NOTIFICATION ENDS
        }

        $resp = array('code' => true, 'message' => 'Transaction Successfull!!- '.$hash, 'hash'  => $hash);
        } else {

        $resp = array('code' => false, 'message' => 'FAILURE', 'response'=>$hash);
        }
        $this->response($resp);
  }


  public function webtxt_post() {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','lang_key');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }
/*
      $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }
*/
        $user_id=$data['user_id'];
        $lang_key=$data['lang_key'];
        $query="select coalesce(lang_text,'$lang_key') as lang_txt from web_txt where lang_key='$lang_key' and language_id=get_language_id($user_id) limit 1";
        
        $recdata=$this->common_model->getArrayByQuery($query);
        if($recdata){
        $resp = array('code' => true, 'message' => 'SUCCESS', 'recdata'  => $recdata[0]);
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'Error occured!!');
        }
        $this->response($resp);
  }


  public function plan_update_post() {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key','plan_id','duration');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

        $user_id=$data['user_id'];
        $plan_id=$data['plan_id'];
        $duration=$data['duration'];
        $query="select id,monthly_charges,yearly_charges from plan_type where id=$plan_id";
        $temp=$this->common_model->getArrayByQuery($query);

        if($duration=='m'){
          $next_payment_date =  date('Y-m-d',strtotime(date('Y-m-d')." +1 Months"));
          $value=$temp[0]['monthly_charges'];
        }
        if($duration=='y'){
          $next_payment_date =  date('Y-m-d',strtotime(date('Y-m-d')." +12 Months"));
          $value=$temp[0]['yearly_charges'];
        }

        $wallet = $this->common_model->getSingleRecordById('users_wallet',array('user_id' =>$data['user_id']));
        $setting = $this->common_model->getSingleRecordById('setting',array('id' =>1));
        $from_address=$wallet['public_key'];
        $from_private_key=$wallet['private_key'];
        $to_address=$setting['eth_public_key'];
        $balance=$wallet['balance'];

        //$hash=$this->send_token($from_address,$to_address,$from_private_key,$value);
        //$hash=json_decode($hash,true);
       $pay=$this->common_model->updateRecords('users_wallet',array('balance' =>$balance-$value),array('user_id'=>$data['user_id']));
       $hash['hash']='Offchain';
        if(!empty($hash['hash']))
          {

           $trx_id ='TRX'.rand(1111111,9999999);
          $dataArray = array(
          'user_id'=>$user_id,
          'trx_type_id'=>5,
          'trx_date'=>date("Y-m-d"),
          'from_wallet'=>$from_address, 
          'to_wallet'=>$to_address,
          'trx_number'=>$trx_id, 
          'trx_amount'=>$value*-1,
          'currency'=>'FCELL',
          'hash'=>$hash['hash'],
          'description'=>'Plan Purchase',
          'is_complete'=>1,
          'ip'=>$_SERVER['REMOTE_ADDR']
        );

         
          $newid=$this->common_model->addRecords('transaction', $dataArray);
          $this->common_model->updateRecords('transaction',array('trx_number' =>$trx_id.'-'.$newid),array('id'=>$newid));
          
        $dataArray = array('plan_id'=>$plan_id, 'start_date'=>date('Y-m-d'),'last_payment_date'=>date('Y-m-d'),'next_payment_date'=>$next_payment_date);
              $condition=array('user_id'=>$user_id);
        $recdata=$this->common_model->updateRecords("user_plan", $dataArray,$condition);
      }
        if($recdata){          
        $resp = array('code' => true, 'message' => 'Your plan updated successfully!!');
        } else {
            $resp = array('code' => false, 'message' => 'FAILURE', 'response'  => 'Error occured!!');
        }
        $this->response($resp);
  }




public function notification_list_post()

{



      $pdata = file_get_contents("php://input");
      $data = json_decode( $pdata,true );  
      $object_info = $data;
      $required_parameter = array('user_id','api_key');
      $chk_error = check_required_value($required_parameter, $object_info);
      if ($chk_error) {
        $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
        $this->response($resp);
        }    
         $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

        $user_id=$data['user_id'];
        $query="SELECT unread_notification_count(".$user_id.") as count";
      $count= $this->common_model->getArrayByQuery($query);
      $limit="";
      if(isset($data['limit'])){
        $limit=" limit ".$data['limit'];
      }
      $url=$GLOBALS['url'];
      $query="SELECT 
        n.id as notification_id, 
        getnotificationtype(n.notification_type_id) as type,
        n.link,
        n.recipient_id,
        get_user_fullname(n.recipient_id) as recipient,
        n.sender_id,
        get_user_fullname(n.sender_id) as sender,
        case when u.profile_pic is null then '".$url."uploads2/users_profile/avatar.jpg' else concat('".$url."','uploads2/users_profile/',u.profile_pic) end as profile_pic,
        n.title,
        n.message,
        coalesce(n.post_id,'') as post_id,
        n.isread,
        n.is_flash,
        get_duration(n.datetime) as duration
      FROM notification  as n
      left join users as u on u.id=n.sender_id
      where recipient_id=$user_id order by n.id desc".$limit."";
    $recdata= $this->common_model->getArrayByQuery($query);
    $condition = array('recipient_id' => $user_id);
    $dataArray = array('is_flash'=>1);
    $this->common_model->updateRecords('notification', $dataArray, $condition);
    if(!empty($recdata)){
      $resp = array('code' => true, 'message' => 'SUCCESS','unread_count'=>$count[0]['count'],'recdata' => $recdata);
    }else{
      $resp = array('code' => false, 'message' => 'SUCCESS', 'unread_count' =>'0');
    }
      $this->response($resp);
}



public function notification_read_post()

{
      $pdata = file_get_contents("php://input");
      $data = json_decode( $pdata,true );  
      $object_info = $data;
      $required_parameter = array('user_id','notification_id','api_key');
      $chk_error = check_required_value($required_parameter, $object_info);
      if ($chk_error) {
        $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
        $this->response($resp);
        }  

         $api_key= $data['api_key'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }

        
    $user_id=$data['user_id'];
    $notification_id=$data['notification_id'];
    $condition = array('id' => $data['notification_id']);
    if($notification_id=='0'){
      $condition = array('recipient_id' => $data['user_id']);
    }
    $dataArray = array(
        'isread'=>1
        );
    $recdata=$this->common_model->updateRecords('notification', $dataArray, $condition);
    $query="SELECT unread_notification_count(".$user_id.") as count";
    $count= $this->common_model->getArrayByQuery($query);
    if(!empty($recdata)){
      $resp = array('code' => true, 'message' => 'SUCCESS','unread_count'=>$count[0]['count']);
    }else{
      $resp = array('code' => false, 'message' => 'FAILURE', 'response' =>'Data not found');
    }
      $this->response($resp);
}

































 
  /* Get All Notifications...... */
  public function notification_get() {
        $whr = array('status !=' => 2);
        $notification = $this->common_model->getAllRecordsById('notification', $whr);
        if(!empty($notification))
        {
             $resp = array('code' => true, 'message' => 'SUCCESS', 'response' => array('city_data' => $notification));
        } else {

          $resp = array('code' => false, 'message' => 'FAILURE', 'response' => array('error' => 'INVALID_DETAILS', 'error_label' => 'Data not found'));
        }
        $this->response($resp);
  }




  public function search_user_post() {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $user_name =$data['name'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }
        $url=$GLOBALS['url'];
       $query="SELECT u.id,u.full_name, case when u.profile_pic is null then '".$url."uploads2/users_profile/avatar.jpg' else concat('".$url."','uploads2/users_profile/',u.profile_pic) end as avatar,case when u.background_image is null then '".$url."uploads2/users_profile/banner.jpg' else concat('".$url."','uploads2/users_profile/',u.background_image) end as background_image FROM users as u where u.full_name LIKE '$user_name%' || u.email LIKE '$user_name%'  ";
       
         $recdata= $this->common_model->getArrayByQuery($query);
      if(!empty($recdata)){        
          $resp = array('code' => true, 'message' => 'SUCCESS','users'=>$recdata);
      }else{
        $resp = array('code' => false, 'message' => 'No Data Found !');
      }   
          $this->response($resp);
  }



    public function start_chat_post() {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key','friend_id');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $friend_id =$data['friend_id'];
      $user_id= $data['user_id'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }
      $mainArr = array('user_id'=>$user_id,'friend_id'=>$friend_id);
      $chk = $this->common_model->getSingleRecordById('current_chat',$mainArr);
      if(empty($chk)){
        $this->common_model->addRecords('current_chat',$mainArr);
      $resp = array('code' => true, 'message' => 'SUCCESS');
      }else{
        $resp = array('code' => false, 'message' => 'No Record Found !');
      } 
      $this->response($resp);
    }

    public function current_chat_post() {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $user_id= $data['user_id'];
      $url=$GLOBALS['url'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }
      $sql ="SELECT c.id as chat_id,c.open_chat_box,u.id,u.full_name, case when u.profile_pic is null then '".$url."uploads2/users_profile/avatar.jpg' else concat('".$url."','uploads2/users_profile/',u.profile_pic) end as avatar FROM users as u INNER JOIN current_chat as c ON u.id=c.friend_id WHERE c.user_id=$user_id AND u.id !=$user_id ORDER BY c.id DESC";
      $chat_user = $this->common_model->getArrayByQuery($sql);
      foreach ($chat_user as $v) {
     $blocked_chat_by=0;

     $chk_block = $this->common_model->getSingleRecordById('chat_block',array('user_id'=>$user_id,'blocked_user_id'=>$v['id']));
     if(!empty($chk_block)){
     	$blocked_chat_by=$user_id;
     }

     $chk_block = $this->common_model->getSingleRecordById('chat_block',array('user_id'=>$v['id'],'blocked_user_id'=>$user_id));
     if(!empty($chk_block)){
     	$blocked_chat_by=$v['id'];
     }
     	$v['blocked_chat_by']=$blocked_chat_by;

       $q = "SELECT *,DATE_FORMAT(datetime, '%b %d, %Y, %h:%i:%s %p') as date FROM chat_messenger WHERE (sender_id='".$v['id']."' AND  receiver_id=$user_id and receiver_destroy=0) || (sender_id=$user_id AND receiver_id='".$v['id']."' and sender_destroy=0)";
        $message = $this->common_model->getArrayByQuery($q);
        $v['open_chat_box']=$v['open_chat_box'];
        $v['message'] = $message;

        $chk_seen = $this->common_model->getRecordCount('chat_messenger',array('sender_id'=>$v['id'],'receiver_id'=>$user_id,'seen'=>0));
        $v['unread_count']=$chk_seen;

        $arr[]=$v;

        $this->common_model->updateRecords('chat_messenger',array('seen'=>1),array('sender_id'=>$v['id'],'receiver_id'=>$user_id,'seen'=>0));
      }

      if(!empty($arr))
      {
        $resp = array('code' => true, 'message' => 'SUCCESS','users'=>$arr);
      }else{
        $resp = array('code' => false, 'message' => 'No Data Found !');
      }
      $this->response($resp);
    }

    public function close_chat_post()
    {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key','chat_id');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $user_id= $data['user_id'];
      $chat_id = $data['chat_id'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }
      $chk = $this->common_model->deleteRecords('current_chat',array('id'=>$chat_id,'user_id'=>$user_id));
      if($chk){
        $resp = array('code' => true, 'message' =>'Chat closed !');
      }else{
        $resp = array('code' => false, 'message' => 'No Record Found !');
      }
      $this->response($resp);
    }


    public function minimize_chat_box_post()
    {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key','chat_id','status');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $user_id= $data['user_id'];
      $chat_id = $data['chat_id'];
      $status = $data['status'];

      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }
      $chk = $this->common_model->updateRecords('current_chat',array('open_chat_box' =>$status),array('id'=>$chat_id,'user_id'=>$user_id));
      $resp = array('code' => true, 'message' =>'SUCCESS');
      $this->response($resp);
    }

    public function send_massage_post()
    {
        /* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key','friend_id','message');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $user_id= $data['user_id'];
      $friend_id = $data['friend_id'];
      $message = $data['message'];

      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }
     
      $mainArr = array('user_id'=>$friend_id,'friend_id'=>$user_id);
      $chk = $this->common_model->getSingleRecordById('current_chat',$mainArr);
      if(empty($chk)){
        $this->common_model->addRecords('current_chat',$mainArr);
      }else{
        $this->common_model->updateRecords('current_chat',array('open_chat_box'=>1),$mainArr);
      } 
      $msgArr = array('sender_id'=>$user_id,'receiver_id'=>$friend_id,'message'=>$message);
      $chk = $this->common_model->addRecords('chat_messenger',$msgArr);
     
      if($chk){
        $resp = array('code' => true, 'message' =>'SUCCESS');  
      }else{
        $resp = array('code' => false, 'message' =>'FAILURE');
      }
      $this->response($resp);
    }

    public function block_chat_post()
    {
    	/* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key','friend_id','status');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $user_id= $data['user_id'];
      $friend_id = $data['friend_id'];
      $status = $data['status'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }
     
     // $sql = "SELECT * FROM chat_block WHERE (user_id=$user_id AND blocked_user_id=$friend_id) || (user_id=$friend_id AND blocked_user_id=$user_id) ";
      if($status==1)
      {
      	$this->common_model->addRecords('chat_block',array('user_id' =>$user_id ,'blocked_user_id'=>$friend_id ));
      }else{
      	$sql = "DELETE FROM chat_block WHERE user_id=$user_id AND blocked_user_id=$friend_id";
      	$this->db->query($sql);
      }

      if($status==1){
        $resp = array('code' => true, 'message' =>'User is blocked.');  
      }else{
        $resp = array('code' => true, 'message' =>'User is Unblocked');
      }
      $this->response($resp);
    }


    public function destroy_chat_post()
    {
    	/* Check for required parameter */
        $pdata = file_get_contents("php://input");
        $data = json_decode( $pdata,true );
        $object_info = $data;
        //print_r($object_info);exit;
        $required_parameter = array('user_id','api_key','friend_id');
        $chk_error = check_required_value($required_parameter, $object_info);
          if ($chk_error) {
              $resp = array('code' => false, 'message' => 'YOU_HAVE_MISSED_A_PARAMETER_' . strtoupper($chk_error['param']));
              $this->response($resp);
          }

      $api_key= $data['api_key'];
      $user_id= $data['user_id'];
      $friend_id = $data['friend_id'];
      $check_key = $this->common_model->getSingleRecordById('users',array('id' =>$data['user_id'], 'api_key'=>$api_key));
      if(empty($check_key)){
          $resp = array('code' => false, 'message' => 'Api key not matched');
          $this->response($resp);
      }
     
    $sql = "UPDATE chat_messenger SET sender_destroy=1 WHERE sender_id='$user_id' AND  receiver_id=$friend_id and sender_destroy=0 ";    
    $this->db->query($sql);    

    $sql = "UPDATE chat_messenger SET receiver_destroy=1 WHERE sender_id='$friend_id' AND  receiver_id=$user_id and receiver_destroy=0 ";    
    $this->db->query($sql);    

      $resp = array('code' => true, 'message' =>'SUCCESS');
      $this->response($resp);
    }

}