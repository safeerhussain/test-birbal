<?php

// include 'config.php';

function senderActions($uID, $action){
	$jsonData = '{
          "recipient" : {"id":"'.$uID.'"},
          "sender_action" : "'.$action.'"
     }';
	curlPostMessages($jsonData);
	if($action == 'typing_on')
	{
		sleep(1);     		
	}

 }

function getUserProfile($uID){
	$input = json_decode(file_get_contents('https://graph.facebook.com/v2.6/'.$uID.'?fields=first_name,last_name,gender&access_token='.$GLOBALS['access_token']), true);
	$result = $input;
	if ($GLOBALS['debug']) {
	    var_dump($result);
    }
    return $result;
 }

function callNumber($uID, $number){
	$jsonData = '{
	    "recipient":{
	      "id":"'.$uID.'"
	    },
	    "message":{
	      "attachment":{
	        "type":"template",
	           "payload":{
	              "template_type":"button",
	              "text":"Have further queries?",
	              "buttons":[
	                 {
	                    "type":"phone_number",
	                    "title":"Call Us!",
	                    "payload":"'.$number.'"
	                 }
	              ]
	           }
	      }
	    }
	  }';
    if ($GLOBALS['debug']) {
	    //var_dump($uID, $number);
	    //echo $jsonData;
    }
	curlPostMessages($jsonData);     
 }

function sendTextMessage($uID, $textMessage){
	$jsonData = '{
          "recipient" : {"id":"'.$uID.'"},
          "message" : {"text":"'.$textMessage.'"}
     }';
	curlPostMessages($jsonData);     
 }

function sendImageMessage($uID, $URL){
	$jsonData = '{
		  "recipient":{ "id":"'.$uID.'"},
		  "message":{
		    "attachment":{
		      "type":"image",
		      "payload":{
		        "url":"'.$URL.'"
		      }
		    }
		  }
	}';


	curlPostMessages($jsonData);     
 }

function sendImageNoURLWithButtons($uID, $count, $title, $subTitle, $imageURL, $args){
	$jsonData = '{
	    "recipient":{
	      "id":"'.$uID.'"
	    },
	    "message":{
	      "attachment":{
	        "type":"template",
	        "payload":{
	          "template_type":"generic",
	          "elements":[
	             {
	              "title":"'.$title.'",
	              "image_url":"'.$imageURL.'",
	              "subtitle":"'.$subTitle.'",
	              "buttons":[
	                '.$args[0].',
	                '.$args[1].',
	                '.$args[2].'  
	              ]      
	            }
	          ]
	        }
	      }
	    }
	  }';
	if ($GLOBALS['debug']) {
      var_dump($jsonData);
    }
	curlPostMessages($jsonData);     
 }

function sendSingleImagewithURLandButtons($uID, $title, $subTitle, $imageURL, $URL, $args){
	$jsonData = '{
	    "recipient":{
	      "id":"'.$uID.'"
	    },
	    "message":{
	      "attachment":{
	        "type":"template",
	        "payload":{
	          "template_type":"generic",
	          "elements":[
	             {
	              "title":"'.$title.'",
	              "image_url":"'.$imageURL.'",
	              "subtitle":"'.$subTitle.'",
                  "default_action": {
		              "type": "web_url",
		              "url": "'.$URL.'",
		              "webview_height_ratio": "tall"		           
		          },
	              "buttons":[
	                '.$args[0].'
	              ]      
	            }
	          ]
	        }
	      }
	    }
	  }';
	if ($GLOBALS['debug']) {
      var_dump($jsonData);
    }
	curlPostMessages($jsonData);     
 }

function sendQuickReplies($count, $uID, $textMessage, $title1, $payload1, $title2, $payload2, $title3, $payload3, $title4, $payload4){
	if($count == 2){
		$jsonData = '{
	          "recipient" : {"id":"'.$uID.'"},
	          "message" : {"text":"'.$textMessage.'", 
	            "quick_replies" :
	            [
	              {
	                "content_type":"text",
	                "title":"'.$title1.'",
	                "payload":"'.$payload1.'"

	              },
	              {
	                "content_type":"text",
	                "title":"'.$title2.'",
	                "payload":"'.$payload2.'"
	              }
	            ]
	          }
	      }';
		curlPostMessages($jsonData);
		if ($GLOBALS['debug']) {
	    	var_dump($jsonData);
    	}	
	}
	else if($count == 3){
		$jsonData = '{
	          "recipient" : {"id":"'.$uID.'"},
	          "message" : {"text":"'.$textMessage.'", 
	            "quick_replies" :
	            [
	              {
	                "content_type":"text",
	                "title":"'.$title1.'",
	                "payload":"'.$payload1.'"
	              },
	              {
	                "content_type":"text",
	                "title":"'.$title2.'",
	                "payload":"'.$payload2.'"
	              },
	              {
	                "content_type":"text",
	                "title":"'.$title3.'",
	                "payload":"'.$payload3.'"
	              }
	            ]
	          }
	      }';
		curlPostMessages($jsonData);
	}
	else if($count == 4){
		$jsonData = '{
	          "recipient" : {"id":"'.$uID.'"},
	          "message" : {"text":"'.$textMessage.'", 
	            "quick_replies" :
	            [
	              {
	                "content_type":"text",
	                "title":"'.$title1.'",
	                "payload":"'.$payload1.'"
	              },
	              {
	                "content_type":"text",
	                "title":"'.$title2.'",
	                "payload":"'.$payload2.'"
	              },
	              {
	                "content_type":"text",
	                "title":"'.$title3.'",
	                "payload":"'.$payload3.'"
	              },
	              {
	                "content_type":"text",
	                "title":"'.$title4.'",
	                "payload":"'.$payload4.'"
	              } 
	            ]
	          }
	      }';
		curlPostMessages($jsonData);
	}
 }
 
function sendDateQuickReplies($count, $uID, $textMessage, $title1, $payload1, $title2, $payload2, $title3, $payload3, $title4, $payload4, $title5, $payload5, $title6, $payload6, $title7, $payload7, $title8, $payload4){
	if($count == 8){
		$jsonData = '{
	          "recipient" : {"id":"'.$uID.'"},
	          "message" : {"text":"'.$textMessage.'", 
	            "quick_replies" :
	            [
	              {
	                "content_type":"text",
	                "title":"'.$title1.'",
	                "payload":"'.$payload1.'"
	              },
	              {
	                "content_type":"text",
	                "title":"'.$title2.'",
	                "payload":"'.$payload2.'"
	              },
	              {
	                "content_type":"text",
	                "title":"'.$title3.'",
	                "payload":"'.$payload3.'"
	              },
	              {
	                "content_type":"text",
	                "title":"'.$title4.'",
	                "payload":"'.$payload4.'"
	              },
	              {
	                "content_type":"text",
	                "title":"'.$title5.'",
	                "payload":"'.$payload5.'"
	              },
	              {
	                "content_type":"text",
	                "title":"'.$title6.'",
	                "payload":"'.$payload6.'"
	              },
	              {
	                "content_type":"text",
	                "title":"'.$title7.'",
	                "payload":"'.$payload7.'"
	              },
	              {
	                "content_type":"text",
	                "title":"'.$title8.'",
	                "payload":"'.$payload8.'"
	              }  
	            ]
	          }
	      }';
		curlPostMessages($jsonData);
	}
 }

function curlPostMessages($getjsonData){
	if ($GLOBALS['debug']) {
    	//var_dump($getjsonData);
    }
	$url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.$GLOBALS['access_token'];
	$ch = curl_init($url);
	$jsonDataEncoded = $getjsonData;
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	$result = curl_exec($ch);
	//if(!empty($input['entry'][0]['messaging'][0]['message'])){
	//}
 }
?>