<?php
include 'functions.php';

// sendQuickReplies(3, 123, "test message", "Fine", "payload1","ds", "payload2");

/*function sendQuickReplies($count, $uID, $textMessage, $title1, $payload1, $title2 = 'Null', $payload2){
	if($count == 2){
		var_dump($count);
		var_dump($uID);
		var_dump($textMessage);
		var_dump($title1);
		var_dump($payload1);
		var_dump($title2);
		var_dump($payload2);
	}
	elseif ($count == 3) {
		var_dump($count);
	}
 }
*/
/*$postbackPayload = '123';
 echo $postbackPayload;
$postbackPayload = '456';
 echo $postbackPayload;

greetingMessage();


 function greetingMessage(){
  $msg = "Hello ! How can we help you?";
  echo $msg;
  // sendQuickReplies(4, , $msg,"Reservation","DE_RESERVATION","Inquiry","DE_INQUIRY","Complaint","DE_COMPLAINT","Talk to a human!","DE_TALK_TO_HUMAN");
}*/
// Lets use a regular expression to match a date string. Ignore
// the output since we are just testing if the regex matches.
// TimeTime:timetime:time :Time :

final class ip2location_lite{
    protected $errors = array();
    protected $service = 'api.ipinfodb.com';
    protected $version = 'v3';
    protected $apiKey = 'b2f1df744eef349f779ecf4dfffa6d63308ce73010bb5eb12e1dd8314de99e5a';

    public function __construct(){}

    public function __destruct(){}

    public function setKey($key){
        if(!empty($key)) $this->apiKey = $key;
    }

    public function getError(){
        return implode("\n", $this->errors);
    }

    public function getCountry($host){
        return $this->getResult($host, 'ip-country');
    }

    public function getCity($host){
        return $this->getResult($host, 'ip-city');
    }

    private function getResult($host, $name){
        $ip = @gethostbyname($host);

        // if(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)){
        if(filter_var($ip, FILTER_VALIDATE_IP)){
            $xml = @file_get_contents('http://' . $this->service . '/' . $this->version . '/' . $name . '/?key=' . $this->apiKey . '&ip=' . $ip . '&format=xml');


            if (get_magic_quotes_runtime()){
                $xml = stripslashes($xml);
            }

            try{
                $response = @new SimpleXMLElement($xml);

                foreach($response as $field=>$value){
                    $result[(string)$field] = (string)$value;
                }

                return $result;
            }
            catch(Exception $e){
                $this->errors[] = $e->getMessage();
                return;
            }
        }

        $this->errors[] = '"' . $host . '" is not a valid IP address or hostname.';
        return;
    }
}

function getUserIP()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}


$user_ip = "39.57.26.154";
$countryObject = new ip2location_lite();
$cityObject = new ip2location_lite();


echo $countryObject->getCountry($user_ip)['countryName'];
echo 'sds'.$cityObject->getCity($user_ip)['cityName'];
echo $user_ip;

var_dump($countryObject);
$regexMatch = '/\b(bad|date|HI)\b/i'; // "/\btime\b/i";
if (preg_match($regexMatch, 'I met hi. DD  ')) {
    echo "Found a match!";
} else {
   echo "The regex pattern does not match. :(";
}

/*if (strlen('d') != NULL)
{
	echo strlen(' ') . 'not null';
}
else
{
	echo 'null';
}*/

$time = time();
//echo $time;
$epoch = 1487848395;
// echo $epoch;
$dateToday = date('D, d M', $epoch);
// var_dump($dateToday);

$dateF = strtotime("+2 days", strtotime($dateToday));
// var_dump(date('D, d M', $dateF));

$dt = new DateTime("@$epoch");  // convert UNIX timestamp to PHP DateTime
$dt->format('Y-m-d H:i:s'); // output = 2017-01-01 00:00:00
// var_dump($dt);
?>

