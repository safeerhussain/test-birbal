<?php

include 'includes/config.php';
include 'functions.php';
      
$GLOBALS['debug'] = false;
$GLOBALS['restaurantName'] = 'Koffie Chalet';
$GLOBALS['restaurantContactNo'] = '02135820066';


$input = json_decode(file_get_contents('php://input'), true);

$sender = $input['entry'][0]['messaging'][0]['sender']['id'];
$message = $input['entry'][0]['messaging'][0]['message']['text'];
$quickReplyPayload = $input['entry'][0]['messaging'][0]['message']['quick_reply']['payload'];
$postbackPayload = $input['entry'][0]['messaging'][0]['postback']['payload'];
$msgMetadata = $input['entry'][0]['messaging'][0]['message']['metadata'];
$msgEcho = $input['entry'][0]['messaging'][0]['message']['is_echo'];
$msgTimestamp = $input['entry'][0]['messaging'][0]['timestamp'];
$pageID = $input['entry'][0]['messaging'][0]['recipient']['id'];

/*$message_mid = $input['entry'][0]['messaging'][0]['message']['mid'];
$message_seq = $input['entry'][0]['messaging'][0]['message']['seq'];*/

//////////////
$dateToday = date('D, d M', time());

$date1 = strtotime("+1 days", strtotime($dateToday));
$date1 = date('D, d M', $date1);

$date2 = strtotime("+2 days", strtotime($dateToday));
$date2 = date('D, d M', $date2);

$date3 = strtotime("+3 days", strtotime($dateToday));
$date3 = date('D, d M', $date3);

$date4 = strtotime("+4 days", strtotime($dateToday));
$date4 = date('D, d M', $date4);

$date5 = strtotime("+5 days", strtotime($dateToday));
$date5 = date('D, d M', $date5);

$date6 = strtotime("+6 days", strtotime($dateToday));
$date6 = date('D, d M', $date6);
//////////////

$message_to_reply = '';


if ($GLOBALS['debug']) {
  $sender = '1125859980869487';
  $message = 'hi';
}
else{
  $userData = getUserProfile($sender);
}
if((!empty($postbackPayload)) || (!empty($quickReplyPayload))){
  if (($postbackPayload == 'DE_GET_STARTED_BUTTON') || ($quickReplyPayload == 'DE_GET_STARTED_BUTTON')) {
     senderActions($sender, "typing_on");
     senderActions($sender, "mark_seen");
     greetingMessage($sender, $userData);
  }
  else if (($postbackPayload == 'DE_TALK_TO_HUMAN') || ($quickReplyPayload == 'DE_TALK_TO_HUMAN')) {
     $message_to_reply = "Please wait, our customer service representative will be with you shortly!\u000AFor urgent queries you may contact our call center at ".$GLOBALS['restaurantContactNo']." 😊\u000AYou may click the menu on the left bottom corner for more information.";
     senderActions($sender, "typing_on");
     senderActions($sender, "mark_seen");
     sendTextMessage($sender, $message_to_reply);
  }
  else if (($postbackPayload == 'DE_RESERVATION') || ($quickReplyPayload == 'DE_RESERVATION')) {
     $message_to_reply = "Reservation Pressed!";
     senderActions($sender, "mark_seen");
     senderActions($sender, "typing_on");
     $title = 'Reservation Menu:';
     $subTitle = 'Kindly tell us for what time you\'ll be making the reservation? 😊';
     $imageURL = 'https://digitaleggheads.com/bot/images/reservation.jpg';
     $button1send = '{
                    "type":"postback",
                    "title":"🍳 Breakfast",
                    "payload":"DE_BREAKFAST"
                    }';
     $button2send =  '{
                      "type":"postback",
                      "title":"🍽 Lunch/Dinner",
                      "payload":"DE_LUNCH_DINNER"
                      }';
     $button3send =  '{
                      "type":"postback",
                      "title":"🍱 Brunch",
                      "payload":"DE_BRUNCH"
                      }';
     $buttonsCombined = array($button1send, $button2send, $button3send);
     sendImageNoURLWithButtons($sender, 3, $title, $subTitle, $imageURL, $buttonsCombined);
  }
  else if (($postbackPayload == 'DE_LUNCH_DINNER') || ($quickReplyPayload == 'DE_LUNCH_DINNER')) {
     $message_to_reply = "Lunch Dinner Pressed!";
     senderActions($sender, "mark_seen");
     senderActions($sender, "typing_on");
     $title = 'Lunch/Dinner Menu:';
     $subTitle = 'Please select either of these options to make your reservation or to ask any further query. 😊';
     $imageURL = 'https://digitaleggheads.com/bot/images/lunchdinner.jpg';
     $button1send = '{
                    "type":"postback",
                    "title":"⏱ Reservation",
                    "payload":"DE_LUNCH_DINNER_RESERVATION_PEOPLE"
                    }';
     $button2send =  '{
                      "type":"postback",
                      "title":"🍽 Menu",
                      "payload":"DE_LUNCH_DINNER_MENU"
                      }';
     $button3send =  '{
                      "type":"postback",
                      "title":"💳 Discounts",
                      "payload":"DE_LUNCH_DINNER_DISCOUNTS"
                      }';
     $buttonsCombined = array($button1send, $button2send, $button3send);
     sendImageNoURLWithButtons($sender, 3, $title, $subTitle, $imageURL, $buttonsCombined);
  }
  else if (($postbackPayload == 'DE_BREAKFAST') || ($quickReplyPayload == 'DE_BREAKFAST')) {
     $message_to_reply = "Breakfast timings at Koffie Chalet are 8 A.M to 1 P.M. 🙂";
     senderActions($sender, "mark_seen");
     senderActions($sender, "typing_on");
     sendTextMessage($sender, $message_to_reply);
     $message_to_reply = "Please find our Breakfast Menu attached below: 🙂";
     sendTextMessage($sender, $message_to_reply);
     senderActions($sender, "mark_seen");
     senderActions($sender, "typing_on");
     $title = 'Breakfast Menu:';
     $subTitle = 'Here\'s the link to our menu: 😊';
     $imageURL = 'https://digitaleggheads.com/bot/images/breakfastmenu.jpg';
     $URL = 'http://www.koffiechalet.com/breakfast.php';
     $button1send = '{
                    "type":"web_url",
                    "url":"'.$URL.'",
                    "title":"🍽 View Menu"                    
                    }';
     $buttonsCombined = array($button1send);
     sendSingleImagewithURLandButtons($sender, $title, $subTitle, $imageURL, $URL, $buttonsCombined);
     senderActions($sender, "typing_on");
     $msg = 'Please click on one of the buttons below to continue:';
     sendQuickReplies(2, $sender, $msg,"⏱ Go to Reservation","DE_LUNCH_DINNER_RESERVATION_PEOPLE","🔵 Main Menu","DE_GET_STARTED_BUTTON ","Void","DE_VOID","Void","DE_VOID");
  }
  else if (($postbackPayload == 'DE_BRUNCH') || ($quickReplyPayload == 'DE_BRUNCH')) {
     $message_to_reply = "Our Brunch is held every Sunday from 11am to 3pm, for Rs. 950+tax per head.\u000AWe've got discounts available on UBL, HBL, Silk Bank and Bank Islami cards. 🙂";
     sendTextMessage($sender, $message_to_reply);
     senderActions($sender, "mark_seen");
     senderActions($sender, "typing_on");
     $title = 'Sunday Brunch Menu:';
     $subTitle = 'Please select either of these options to make your reservation or to ask any further query. 😊';
     $imageURL = 'https://digitaleggheads.com/bot/images/sundaybrunch.jpg';
     $button1send = '{
                    "type":"postback",
                    "title":"⏱ Reservation",
                    "payload":"DE_BRUNCH_RESERVATION_PEOPLE"
                    }';
     $button2send =  '{
                      "type":"postback",
                      "title":"🍽 Sunday Brunch Menu",
                      "payload":"DE_BRUNCH_MENU"
                      }';
     $button3send =  '{
                      "type":"postback",
                      "title":"💳 Brunch Discounts",
                      "payload":"DE_BRUNCH_DISCOUNTS"
                      }';
     $buttonsCombined = array($button1send, $button2send, $button3send);
     sendImageNoURLWithButtons($sender, 3, $title, $subTitle, $imageURL, $buttonsCombined);
  }
  else if (($postbackPayload == 'DE_BRUNCH_DISCOUNTS') || ($quickReplyPayload == 'DE_BRUNCH_DISCOUNTS')) {
     senderActions($sender, "mark_seen");
     senderActions($sender, "typing_on");
     $message_to_reply = "We've got discounts available on the following cards: 🙂\u000A💳 UBL \u000A💳 HBL \u000A💳 Silk Bank \u000A💳 Bank Islami";
     sendTextMessage($sender, $message_to_reply);
     senderActions($sender, "mark_seen");
     senderActions($sender, "typing_on");     
     $msg = 'Please click on one of the buttons below to continue:';
     sendQuickReplies(2, $sender, $msg,"⏱ Go to Reservation","DE_BRUNCH_RESERVATION_PEOPLE","🍽 View Menu","DE_BRUNCH_MENU","Void","DE_VOID","Void","DE_VOID");
  }
  else if (($postbackPayload == 'DE_BRUNCH_MENU') || ($quickReplyPayload == 'DE_BRUNCH_MENU')) {
     senderActions($sender, "mark_seen");
     senderActions($sender, "typing_on");
     $message_to_reply = "Please find our Sunday Brunch Menu attached below: 🙂";
     sendTextMessage($sender, $message_to_reply);
     $URL = 'https://digitaleggheads.com/bot/images/discounts/sundaybrunch.jpg';
     sendImageMessage($sender, $URL);
     senderActions($sender, "typing_on");
     $msg = 'Please click on one of the buttons below to continue:';
     sendQuickReplies(2, $sender, $msg,"⏱ Go to Reservation","DE_BRUNCH_RESERVATION_PEOPLE","🍽 Brunch Discounts","DE_BRUNCH_DISCOUNTS","Void","DE_VOID","Void","DE_VOID");
  }
  else if (($postbackPayload == 'DE_BRUNCH_RESERVATION_PEOPLE') || ($quickReplyPayload == 'DE_BRUNCH_RESERVATION_PEOPLE')) {
     senderActions($sender, "typing_on");
     senderActions($sender, "mark_seen");
     $msg = 'How many people will be visiting? 🙂';
     sendQuickReplies(4, $sender, $msg,"🔵 1-4","DE_BRUNCH_RESERVATION_PEOPLE_TIME","🔵 5-8","DE_BRUNCH_RESERVATION_PEOPLE_TIME","🔵 9-12","DE_BRUNCH_RESERVATION_PEOPLE_TIME","🔵 12+ persons","DE_BRUNCH_RESERVATION_PEOPLE_TIME");
  }
  else if (($postbackPayload == 'DE_BRUNCH_RESERVATION_PEOPLE_TIME') || ($quickReplyPayload == 'DE_BRUNCH_RESERVATION_PEOPLE_TIME')) {
     senderActions($sender, "typing_on");
     senderActions($sender, "mark_seen");
     $msg = 'What time will you be arriving? 🙂\u000AFormat: [Time: HH:MM PM]';
     sendTextMessage($sender, $msg);
  }
  else if (($postbackPayload == 'DE_LUNCH_DINNER_MENU') || ($quickReplyPayload == 'DE_LUNCH_DINNER_MENU')) {
     senderActions($sender, "mark_seen");
     senderActions($sender, "typing_on");
     $title = 'Koffie Chalet Menu:';
     $subTitle = 'Here\'s the link to our menu: 😊';
     $imageURL = 'https://digitaleggheads.com/bot/images/menu.jpg';
     $URL = 'http://www.koffiechalet.com/breakfast.php';
     $button1send = '{
                    "type":"web_url",
                    "url":"'.$URL.'",
                    "title":"🍽 View Menu"                    
                    }';
     $buttonsCombined = array($button1send);
     sendSingleImagewithURLandButtons($sender, $title, $subTitle, $imageURL, $URL, $buttonsCombined);
     senderActions($sender, "typing_on");
     $msg = 'Please click on one of the buttons below to continue:';
     sendQuickReplies(2, $sender, $msg,"⏱ Go to Reservation","DE_LUNCH_DINNER_RESERVATION_PEOPLE","💳 View Discounts","DE_LUNCH_DINNER_DISCOUNTS","Void","DE_VOID","Void","DE_VOID");
     
  }
  else if (($postbackPayload == 'DE_LUNCH_DINNER_DISCOUNTS') || ($quickReplyPayload == 'DE_LUNCH_DINNER_DISCOUNTS')) {
     senderActions($sender, "mark_seen");
     senderActions($sender, "typing_on");
     $message_to_reply = "We've got multiple discount deals for our customers. You can check them here: 🙂";
     sendTextMessage($sender, $message_to_reply);
     senderActions($sender, "mark_seen");
     senderActions($sender, "typing_on");
     $URL = 'https://digitaleggheads.com/bot/images/discounts/LunchDinner1.png';
     sendImageMessage($sender, $URL);
     $URL = 'https://digitaleggheads.com/bot/images/discounts/LunchDinner2.jpg';
     sendImageMessage($sender, $URL);
     senderActions($sender, "typing_on");     
     $msg = 'Please click on one of the buttons below to continue:';
     sendQuickReplies(2, $sender, $msg,"⏱ Go to Reservation","DE_LUNCH_DINNER_RESERVATION_PEOPLE","🍽 View Menu","DE_LUNCH_DINNER_MENU","Void","DE_VOID","Void","DE_VOID");
  }
  else if (($postbackPayload == 'DE_LUNCH_DINNER_RESERVATION_PEOPLE') || ($quickReplyPayload == 'DE_LUNCH_DINNER_RESERVATION_PEOPLE')) {
     senderActions($sender, "typing_on");
     senderActions($sender, "mark_seen");
     $msg = 'Can you tell us how many people you\'re reserving a table for? 🙂';
     sendQuickReplies(4, $sender, $msg,"🔵 1-4","DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME","🔵 5-8","DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME","🔵 9-12","DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME","🔵 12+ persons","DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME");
  }
  else if (($postbackPayload == 'DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME') || ($quickReplyPayload == 'DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME')) {
     senderActions($sender, "typing_on");
     senderActions($sender, "mark_seen");
     $msg = 'What time will you be visiting? 🙂\u000AFormat: [Time: HH:MM PM]';
     sendTextMessage($sender, $msg);
  }
  else if (($postbackPayload == 'DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE') || ($quickReplyPayload == 'DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE')) {
     senderActions($sender, "typing_on");
     senderActions($sender, "mark_seen");
     $msg = 'Please tell us what date you\'ll be visiting? 🙂';
     sendDateQuickReplies(8, $sender, $msg,"🗓 Today, ".$dateToday,"DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE_NAME", "🗓 ".$date1,"DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE_NAME","🗓 ".$date2,"DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE_NAME","🗓 ".$date3,"DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE_NAME","🗓 ".$date4,"DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE_NAME","🗓 ".$date5,"DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE_NAME","🗓 ".$date6,"DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE_NAME","🗓 More..","DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE_OTHER");
  }
  else if (($postbackPayload == 'DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE_OTHER') || ($quickReplyPayload == 'DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE_OTHER')) {
    $message_to_reply = "Please enter the date on which you want the reservation to be made. 🙂\u000AFormat: [Date: 12th April 2017]";
     senderActions($sender, "typing_on");
     senderActions($sender, "mark_seen");
     sendTextMessage($sender, $message_to_reply);
  }
  else if (($postbackPayload == 'DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE_NAME') || ($quickReplyPayload == 'DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE_NAME')) {
     senderActions($sender, "typing_on");
     senderActions($sender, "mark_seen");
    $message_to_reply = $userData['first_name'].", do you want to make the reservation by your name? 🙂";
    sendQuickReplies(2, $sender, $message_to_reply,"👍 Yes","DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE_NAME_CONTACT","👎 No, someone else","DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE_NAME_OTHER","Void","DE_VOID","Void","DE_VOID");
  }
  else if (($postbackPayload == 'DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE_NAME_OTHER') || ($quickReplyPayload == 'DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE_NAME_OTHER')) {
    $message_to_reply = "On what name will the reservation be made? 🙂\u000AFormat: [Guest: Captain Misbah Ul Haq]";
     senderActions($sender, "typing_on");
     senderActions($sender, "mark_seen");
     sendTextMessage($sender, $message_to_reply);
  }
  else if (($postbackPayload == 'DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE_NAME_CONTACT') || ($quickReplyPayload == 'DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE_NAME_CONTACT')) {
     
    $message_to_reply = "Please provide us your contact number. 📞\u000AFormat: [Number: 03002502211]";
     senderActions($sender, "typing_on");
     senderActions($sender, "mark_seen");
     sendTextMessage($sender, $message_to_reply);
  }
  else if (($postbackPayload == 'DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE_NAME_CONTACT_DECOR') || ($quickReplyPayload == 'DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE_NAME_CONTACT_DECOR')) {
     
    $message_to_reply = "Do you want us to arrange any sort of decoration? 🎉";
     senderActions($sender, "typing_on");
     senderActions($sender, "mark_seen");
     sendQuickReplies(2, $sender, $message_to_reply,"🎉 Yes, please!","DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE_NAME_CONTACT_DECOR_YES","🙂 No, thanks!","DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE_NAME_CONTACT_DECOR_THANKS","Void","DE_VOID","Void","DE_VOID");
  }
  else if (($postbackPayload == 'DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE_NAME_CONTACT_DECOR_YES') || ($quickReplyPayload == 'DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE_NAME_CONTACT_DECOR_YES')) {
     
    $message_to_reply = "Please wait while our representative contacts you! 🙂\u000AYou may click the menu on the left bottom corner for more information.";
     senderActions($sender, "typing_on");
     senderActions($sender, "mark_seen");
     sendTextMessage($sender, $message_to_reply);
  }
  else if (($postbackPayload == 'DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE_NAME_CONTACT_DECOR_THANKS') || ($quickReplyPayload == 'DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE_NAME_CONTACT_DECOR_THANKS')) {
     $URL = 'https://digitaleggheads.com/bot/images/reservationDone.gif';
     sendImageMessage($sender, $URL);
     $message_to_reply = "Hurray! Your table has been reserved. You will recieve a confirmation call from our team shortly. 👌\u000AYou may click the menu on the left bottom corner for more information.";
     senderActions($sender, "typing_on");
     senderActions($sender, "mark_seen");
     sendTextMessage($sender, $message_to_reply);
  }
  else if (($postbackPayload == 'DE_INQUIRY') || ($quickReplyPayload == 'DE_INQUIRY')) {
     senderActions($sender, "mark_seen");
     senderActions($sender, "typing_on");
     $title = 'Inquiry Menu:';
     $subTitle = 'Please select either of these options regarding your query: 😊';
     $imageURL = 'https://digitaleggheads.com/bot/images/inquiry.jpg';
     $button1send = '{
                    "type":"postback",
                    "title":"🎉 Decoration",
                    "payload":"DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE_NAME_CONTACT_DECOR_YES"
                    }';
     $button2send = '{
                      "type":"postback",
                      "title":"💳 Discounts",
                      "payload":"DE_LUNCH_DINNER_DISCOUNTS"
                    }';
     $button3send = '{
                      "type":"postback",
                      "title":"🤵 Talk to a Human!",
                      "payload":"DE_TALK_TO_HUMAN"
                    }';
     $buttonsCombined = array($button1send, $button2send, $button3send);
     sendImageNoURLWithButtons($sender, 3, $title, $subTitle, $imageURL, $buttonsCombined);
  }
  else if (($postbackPayload == 'DE_COMPLAINT') || ($quickReplyPayload == 'DE_COMPLAINT')) {
    senderActions($sender, "mark_seen");
     senderActions($sender, "typing_on");
     $title = 'Complaint Menu:';
     $subTitle = ' Please tell us what\'s the nature of your complaint? 😊';
     $imageURL = 'https://digitaleggheads.com/bot/images/complaint.jpg';
     $button1send = '{
                    "type":"postback",
                    "title":"🍴 Food Quality",
                    "payload":"DE_COMPLAINT_DATE"
                    }';
     $button2send = '{
                      "type":"postback",
                      "title":"⏳ Ambiance/Service",
                      "payload":"DE_COMPLAINT_DATE"
                    }';
     $button3send = '{
                      "type":"postback",
                      "title":"🔴 Other",
                      "payload":"DE_COMPLAINT_DATE"
                    }';
     $buttonsCombined = array($button1send, $button2send, $button3send);
     sendImageNoURLWithButtons($sender, 3, $title, $subTitle, $imageURL, $buttonsCombined);
  }
  else if (($postbackPayload == 'DE_COMPLAINT_DATE') || ($quickReplyPayload == 'DE_COMPLAINT_DATE')) {
    senderActions($sender, "mark_seen");
    senderActions($sender, "typing_on");
    $message_to_reply = 'Please let us know your comlaint alongwith the date/time of your visit.';
    sendTextMessage($sender, $message_to_reply);
    senderActions($sender, "mark_seen");
    senderActions($sender, "typing_on");
    $message_to_reply = "We\'ll look into the matter right away. Lastly, please send us your contact number so that our management can contact you regarding your complaint. 🙂";
    sendTextMessage($sender, $message_to_reply);
    senderActions($sender, "mark_seen");
    senderActions($sender, "typing_on");
    $message_to_reply = "For more details click the menu on the left bottom corner for more information. 🙂";
    sendTextMessage($sender, $message_to_reply);

  }
  else if (($postbackPayload == 'DE_CALL_US') || ($quickReplyPayload == 'DE_CALL_US')) {
    senderActions($sender, "typing_on");
    callNumber($sender, $GLOBALS['restaurantContactNo']);
  }
 }

/*if(!empty($quickReplyPayload)){
    if($quickReplyPayload == 'DE_PERSONAL_DETAILS'){
      // senderActions($sender, "typing_on");
      // $message_to_reply = "Here are your personal details:  \u000A";
      // $message_to_reply = $message_to_reply.'Your name is: '.$userData['first_name'].' '.$userData['last_name'].' & your gender is: '.$userData['gender'].' & your UID is: '.$sender;
    }
  }*/

$timeMatch = "/\btime\b/i";
$dateMatch = "/\bdate\b/i";
$guestMatch = "/\bguest\b/i";
$numberMatch = "/\bnumber\b/i";
$greetingMatch = "/\b(hi|hey|hello|salaam|salam|sup|howdy|hola)\b/i";

if(preg_match($timeMatch, $message)) {
  $msg = 'Perfect! Please confirm to proceed:';
  sendQuickReplies(2, $sender, $msg,"👎 Enter again","DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME","👍 Confirm","DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE","Void","DE_VOID","Void","DE_VOID");
 }
if(preg_match($dateMatch, $message)) {
  $msg = 'Noted! Please confirm to proceed:';
  sendQuickReplies(2, $sender, $msg,"👎 Enter again","DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE","👍 Confirm","DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE_NAME","Void","DE_VOID","Void","DE_VOID");
 }
if(preg_match($guestMatch, $message)) {
  $msg = 'Alright! Please confirm to proceed:';
  sendQuickReplies(2, $sender, $msg,"👎 Enter again","DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE_NAME_OTHER","👍 Confirm","DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE_NAME_CONTACT","Void","DE_VOID","Void","DE_VOID");
 }
 if(preg_match($numberMatch, $message)) {
  $msg = 'Your contact details have been noted! Please confirm to proceed:';
  sendQuickReplies(2, $sender, $msg,"👎 Enter again","DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE_NAME_CONTACT","👍 Confirm","DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE_NAME_CONTACT_DECOR","Void","DE_VOID","Void","DE_VOID");
 }

if(preg_match($greetingMatch, $message)) {
  greetingMessage($sender, $userData);
 }
else if(strtolower($message) == 'menu') {
  $message_to_reply = $MenuResponse;
  sendTextMessage($sender, $message_to_reply0);
 }
else if(strtolower($message) == 'show details'){
  $message_to_reply =
      "Sender: " . $sender. " --- " 
    . "Message: ". $message . " --- " 
    . "Recipient: ". $recipient_id . " --- " 
    . "Timestamp: ". $timestamp . " --- "
    . "Message MID: ". $message_mid . " --- "
    . "Message SEQ: ". $message_seq . " --- "
    . "Message Quick Reply: ". $message_quick . " --- "
    ;
 }
else {
  $message_to_reply = "Sorry, didn't get you!";
  //sendTextMessage($sender, $message_to_reply);  
}


function greetingMessage($sender, $userData){
  $msg = $userData['first_name'].", thank you for contacting ".$GLOBALS['restaurantName']."!\u000AHow can we help you?";
  sendTextMessage($sender,$msg);
  senderActions($sender, "typing_on");
  $jsonData = '{
        "recipient":{
          "id":"'.$sender.'"
        },
        "message":{
          "attachment":{
            "type":"template",
            "payload":{
              "template_type":"generic",
              "elements":[
                 {
                  "title":"Reservation",
                  "image_url":"https://digitaleggheads.com/bot/images/reservation.jpg",
                  "buttons":[
                    {
                          "type":"postback",
                          "title":"🍳 Breakfast",
                          "payload":"DE_BREAKFAST"
                    },{
                            "type":"postback",
                            "title":"🍽 Lunch/Dinner",
                            "payload":"DE_LUNCH_DINNER"
                    },
                    {
                            "type":"postback",
                            "title":"🍱 Brunch",
                            "payload":"DE_BRUNCH"
                    }              
                  ]      
                },
                {
                  "title":"Inquiry",
                  "image_url":"https://digitaleggheads.com/bot/images/inquiry.jpg",
                  "buttons":[
                    {
                          "type":"postback",
                          "title":"🎉 Decoration",
                          "payload":"DE_LUNCH_DINNER_RESERVATION_PEOPLE_TIME_DATE_NAME_CONTACT_DECOR_YES"
                    },{
                            "type":"postback",
                            "title":"💳 Discounts",
                            "payload":"DE_LUNCH_DINNER_DISCOUNTS"
                    },
                    {
                            "type":"postback",
                            "title":"🤵 Talk to a Human!",
                            "payload":"DE_TALK_TO_HUMAN"
                    }              
                  ]      
                },
                {
                  "title":"Complaints",
                  "image_url":"https://digitaleggheads.com/bot/images/complaint.jpg",
                  "buttons":[
                    {
                          "type":"postback",
                          "title":"🍴 Food Quality",
                          "payload":"DE_COMPLAINT_DATE"
                    },{
                            "type":"postback",
                            "title":"⏳ Ambiance/Service",
                            "payload":"DE_COMPLAINT_DATE"
                    },
                    {
                            "type":"postback",
                            "title":"🔴 Other",
                            "payload":"DE_COMPLAINT_DATE"
                    }               
                  ]      
                },
                {
                  "title":"Talk to a Human!",
                  "image_url":"https://digitaleggheads.com/bot/images/talktoahuman.jpg",
                   "buttons":[
                    {
                            "type":"postback",
                            "title":"🤵 Talk to a Human!",
                            "payload":"DE_TALK_TO_HUMAN"
                    },
                     {
                            "type":"postback",
                            "title":"☎️ Call Us!",
                            "payload":"DE_CALL_US"
                    } 
                  ]      
                }
              ]
            }
          }
        }
      }';

  curlPostMessages($jsonData);

}
?>