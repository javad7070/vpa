<?php

@mysql_connect('localhost','adminjtVEHeF','27swH_l4P521')  or die('DB connection error');
@mysql_select_db('phpp');
mysql_query('SET NAMES UTF8');


function apiRequestWebhook($method, $parameters) {

  $parameters["method"] = $method;

 header("Content-Type: application/json");
  echo json_encode($parameters);
  return true;
}

function apiRequestWebhook2($method, $parameters) {

  $parameters["method"] = $method;

 header("Content-Type: application/json");
  echo json_encode($parameters);
  return true;
}

    function mainmenu()
{
    $reply=array(
            'keyboard'=>array(
                array('ساخت پست با دکمه های لایک','ساخت نظر سنجی','راهنمای استفاده')
                //,array('ساخت آزمون چهار گزینه ای','ساخت نظر سنجی')
              // , array('سفارش طراحی ربات اختصاصی','ارتباط با ما')
            ),
  'resize_keyboard'=>true 
            
        ) ;
        return $reply;

}

function registermenu($text){
	$sql = mysql_query("INSERT INTO selectedmenu VALUES(
    NULL,
    '$text'
    )"); 
}

function registercode($chat_id,$code,$file_id,$caption){
	$sql = mysql_query("INSERT INTO postcode VALUES(
    NULL,
    '$file_id',
    '$code',
    '$chat_id',
    '$caption'
    )");
}

function sendpostcode($chat_id,$code,$file_id,$type){

	
	$codefirstpart ="<code>@glass_alfabtn_bot ". $type . ' ' . $code . "</code>";
	$token = "271681195:AAEHWpI0vJUN0_TyfXeNNcWnPaUwOenPfLM";
	
	$request = curl_init('https://api.telegram.org/bot'.$token.'/sendMessage?chat_id='.$chat_id);
    curl_setopt($request,CURLOPT_POST,true);
    curl_setopt($request,CURLOPT_POSTFIELDS,array('text' => ' مطلب بالا حالت پیشنمایش پست شما بوده و کد مطلب شما به شکل زیر می باشد اگر با طرز استفاده آن آشنا نیستید لطفا راهنما را بخوانید'));
    curl_exec($request);
	
	
    $request = curl_init('https://api.telegram.org/bot'.$token.'/sendMessage?chat_id='.$chat_id);
    curl_setopt($request,CURLOPT_POST,true);
    curl_setopt($request,CURLOPT_POSTFIELDS,array('text' =>  $codefirstpart,'parse_mode' =>  'HTML' ));
    curl_exec($request);
}

function getlikemenu(){
	$reply = array(
            'inline_keyboard'=>array(
                
                array(array('text' =>'❌ دوست ندارم','callback_data' => 'شروع آزمون ریدینگ'),array('text' =>'✅ دوست دارم','callback_data' => 'شروع آزمون ریدینگ')),
                array(array('text' =>'هزینه استفاده فقط 5 تا صلواة','callback_data' => '4'))
            )
            
        ) ;
        
        return $reply;
}

function sendpreview($method,$chat_id,$file_id,$caption){
	
	$reply = getlikemenu();
	
	
	if ($method == 'sendPhoto' ){
	
		$token = "271681195:AAEHWpI0vJUN0_TyfXeNNcWnPaUwOenPfLM";
    		$request = curl_init('https://api.telegram.org/bot'.$token.'/'.$method.'?chat_id='.$chat_id);
    		curl_setopt($request,CURLOPT_POST,true);
    		curl_setopt($request,CURLOPT_POSTFIELDS,array('photo' =>$file_id,'caption' =>$caption,'reply_markup' => json_encode($reply)));
  	  	curl_exec($request);
  	  		
	}else if ($method == 'sendAudio' ){
	
		$token = "271681195:AAEHWpI0vJUN0_TyfXeNNcWnPaUwOenPfLM";
    		$request = curl_init('https://api.telegram.org/bot'.$token.'/'.$method.'?chat_id='.$chat_id);
    		curl_setopt($request,CURLOPT_POST,true);
    		curl_setopt($request,CURLOPT_POSTFIELDS,array('audio' =>$file_id,'reply_markup' => json_encode($reply)));
  	  	curl_exec($request);
  	  		
	}else if ($method == 'sendVideo' ){
	
		$token = "271681195:AAEHWpI0vJUN0_TyfXeNNcWnPaUwOenPfLM";
    		$request = curl_init('https://api.telegram.org/bot'.$token.'/'.$method.'?chat_id='.$chat_id);
    		curl_setopt($request,CURLOPT_POST,true);
    		curl_setopt($request,CURLOPT_POSTFIELDS,array('video' =>$file_id,'reply_markup' => json_encode($reply)));
  	  	curl_exec($request);
  	  		
	}else if ($method == 'sendVoice' ){
	
		$token = "271681195:AAEHWpI0vJUN0_TyfXeNNcWnPaUwOenPfLM";
    		$request = curl_init('https://api.telegram.org/bot'.$token.'/'.$method.'?chat_id='.$chat_id);
    		curl_setopt($request,CURLOPT_POST,true);
    		curl_setopt($request,CURLOPT_POSTFIELDS,array('voice' =>$file_id,'reply_markup' => json_encode($reply)));
  	  	curl_exec($request);
  	  		
	}else if ($method == 'sendDocument' ){
	
		$token = "271681195:AAEHWpI0vJUN0_TyfXeNNcWnPaUwOenPfLM";
    		$request = curl_init('https://api.telegram.org/bot'.$token.'/'.$method.'?chat_id='.$chat_id);
    		curl_setopt($request,CURLOPT_POST,true);
    		curl_setopt($request,CURLOPT_POSTFIELDS,array('document' =>$file_id,'reply_markup' => json_encode($reply)));
  	  	curl_exec($request);
  	  		
	}
	
	
	
}

function getfileid($code){
	$sql = mysql_query("SELECT * FROM postcode WHERE code = '$code'" );
	$row = mysql_fetch_assoc($sql);
	$result = $row['file_id'];
	return $result;
}


function getcaption($code){
	$sql = mysql_query("SELECT * FROM postcode WHERE code = '$code'" );
	$row = mysql_fetch_assoc($sql);
	$result = $row['caption'];
	return $result;
}
    function userRegister($tgid,$username,$first_name,$active)
{    
    $sql = mysql_query("INSERT INTO users VALUES(
    NULL,
    '$tgid',
    '$username',
    '$first_name',
    '$active'
    )");        
}

function processMessage($message) {
  // process incoming message
  $message_id = $message['message_id'];
  $chat_id = $message['chat']['id'];
  $first_name = $message['chat']['first_name'];
  $username = $message['chat']['username'];
  $Pfile_id =   $message['photo']['0']['file_id'];
  $Afile_id =   $message['audio']['file_id'];
  $Vfile_id =   $message['video']['file_id'];
  $VOfile_id =   $message['voice']['file_id'];
  $Dfile_id =   $message['document']['file_id']; 
  if (isset($message['text'])) {
    // incoming text message
    $text = $message['text'];
       
    if($text == '/start'){
    
    	$reply = mainmenu();
                
           $sql = mysql_query("SELECT * FROM users WHERE tgid='$chat_id' ");

 if (mysql_num_rows($sql) >= 1)
 {
     
    apiRequestWebhook("sendMessage", array('chat_id' => $chat_id, "reply_to_message_id" => $message_id, "text" => $first_name. 'گرامی شما قبلا در ربات آموزش انگلیسی سرو ثبت نام کرده اید','reply_markup' => json_encode($reply),'resize_keyboard' => true) ); 
 }else
 {
         $active = '0' ;
   userRegister($chat_id,$username,$first_name,$active);  
    apiRequestWebhook("sendMessage", array('chat_id' => $chat_id, "reply_to_message_id" => $message_id, "text" => '🌹 ربات تولز برای ارایه انواع ابزار مدیریتی کانال  و گروه 🌹
        
✅ سلام  *'.$first_name.'* گرامی ثبت نام شما با موفقیت انجام گرفت. از اینکه ربات تولز را برای مدیریت انتخاب کرده اید بسیار خرسندیم پست های این ربات فعلا فقط در گروه ها و چت های شخصی قابل استفاده می باشند. اکنون می توانید فعالیت خود را شروع کنید.
        
                                                                                   🌺 به امید موفقیت شما 🌺
        
       @(^_^)@  با تشکر مدیریت آموزشی. @glass_alfabtn_bot  ','reply_markup' => json_encode($reply) )); 
 } 
         


    }else if($text == 'راهنمای استفاده'){
    	apiRequestWebhook("sendMessage", array('chat_id' => $chat_id, "reply_to_message_id" => $message_id, "text" => 'کد تولید شده رو در گروه یا  چتی که می خواهید در ان استفاده کنید کپی کرده و بر روی جعبه ای که بالای محل نوشتن پیام ظاهر می شود کلیک کنید.' ));
    }
    else if($text == 'بازگشت به منوی اصلی'){
    
    //registermenu($text);
    
    	$reply = mainmenu();
    	
        apiRequestWebhook("sendMessage", array('chat_id' => $chat_id, "reply_to_message_id" => $message_id, "text" => $first_name. 'شما اکنون در منوی اصلی می باشید','reply_markup' => json_encode($reply)) );
        
    }else if($text == 'ساخت نظر سنجی'){
    
    //registermenu($text);
    
    	$reply = array(
            'keyboard'=>array(
                array('پست ویدیویی','پست متنی','پست صوتی','پست تصویری'),
                array('بازگشت به منوی اصلی')
            ),
  'resize_keyboard'=>true 
            
        ) ;
    
    	apiRequestWebhook("sendMessage", array('chat_id' => $chat_id, "text" =>' این قسمت در حال تکمیل می باشد ' ) );
    }else if($text == 'ساخت پست با دکمه های لایک'){
    
    //registermenu($text);
    
    	$reply = array(
            'keyboard'=>array(
                array('پست ویدیویی','پست متنی','پست صوتی','پست تصویری'),
                array('بازگشت به منوی اصلی')
            ),
  'resize_keyboard'=>true 
            
        ) ;
    
    	apiRequestWebhook("sendMessage", array('chat_id' => $chat_id, "text" =>'لطفا نوع پست خود را مشخص بفرمایید','reply_markup' => json_encode($reply) ) );
    }else if($text == 'پست تصویری' ){
   	        //registermenu($text);
    		apiRequestWebhook("sendMessage", array('chat_id' => $chat_id, "text" =>'لطفا تصویر پست خود را وارد کنید' ) );
    }else if($text == 'پست ویدیویی' ){
   	       // registermenu($text);
    		apiRequestWebhook("sendMessage", array('chat_id' => $chat_id, "text" =>'لطفا ویدیو پست خود را وارد کنید' ) ); 
    }else if($text == 'پست صوتی' ){
   	       // registermenu($text);
    		apiRequestWebhook("sendMessage", array('chat_id' => $chat_id, "text" =>'لطفا فایل صوتی خود را وارد کنید' ) );
    }else if($text == 'پست متنی' ){
   	       // registermenu($text);
    		apiRequestWebhook("sendMessage", array('chat_id' => $chat_id, "text" =>' برای ارسال پست متنی همراه با دکمه های لایک لطفا ابتدا glass_alfabtn_bot@ را در گروه یا چت مورد نظر خود تایپ کرده و  سپس یک فاصله بگذارید و بعد از آن پیام خود را تایپ کرده سپس ارسال بفرمایید. با تشکر  ' ) );
    }else{
    
    $result = mysql_query("SELECT * FROM selectedmenu ORDER BY id DESC LIMIT 1 " );
    $row = mysql_fetch_assoc($result);
    $selectedmenu = $row['selectedmenu'];
    
    if($selectedmenu == 'ساخت نظر سنجی'){
    
   $reply = getlikemenu();
        
        $A=rand(1,999999999);
    
    	apiRequestWebhook("sendMessage", array('chat_id' => $chat_id, "text" =>$text ,'reply_markup' => json_encode($reply) ) );
    }
    		
    }
    
        
   } else if (isset($message['audio']['file_id'])){
    
    		$token = "271681195:AAEHWpI0vJUN0_TyfXeNNcWnPaUwOenPfLM";
    		$url = 'https://api.telegram.org/bot'.$token.'/getFile?file_id='.$Afile_id;
    		$content = file_get_contents($url);
    		$file = json_decode($content,true);
    		//file_put_contents('17.txt',var_export($file,true));
    		
    		$file_id = $file[result][file_id];
    		$file_size = $file[result][file_size];
    		$file_path = $file[result][file_path];
    		
    		$A=rand(1,999999999);
  		$code = $chat_id + $A;
  		$type = 'getAlike';
  		
    		registercode($chat_id,$code,$file_id,'no capiton');
    		sendpreview('sendAudio',$chat_id,$file_id,'no caption');
    		sendpostcode($chat_id,$code,$file_id,$type);

  			
   	
    }else if (isset($message['voice']['file_id'])){
    
    		$token = "271681195:AAEHWpI0vJUN0_TyfXeNNcWnPaUwOenPfLM";
    		$url = 'https://api.telegram.org/bot'.$token.'/getFile?file_id='.$VOfile_id;
    		$content = file_get_contents($url);
    		$file = json_decode($content,true);
    		//file_put_contents('17.txt',var_export($file,true));
    		
    		$file_id = $file[result][file_id];
    		$file_size = $file[result][file_size];
    		$file_path = $file[result][file_path];
    		
    		$A=rand(1,999999999);
  		$code = $chat_id + $A;
  		$type = 'getVOlike';
  		
    		registercode($chat_id,$code,$file_id,'no capiton');
    		sendpreview('sendVoice',$chat_id,$file_id,'no caption');
    		sendpostcode($chat_id,$code,$file_id,$type);

  			
   	
    }else if (isset($message['video']['file_id'])){
    
    		$token = "271681195:AAEHWpI0vJUN0_TyfXeNNcWnPaUwOenPfLM";
    		$url = 'https://api.telegram.org/bot'.$token.'/getFile?file_id='.$Vfile_id;
    		$content = file_get_contents($url);
    		$file = json_decode($content,true);
    		//file_put_contents('17.txt',var_export($file,true));
    		
    		$file_id = $file[result][file_id];
    		$file_size = $file[result][file_size];
    		$file_path = $file[result][file_path];
    		
    		$A=rand(1,999999999);
  		$code = $chat_id + $A;
  		$type = 'getVlike';
  		
    		registercode($chat_id,$code,$file_id,'no capiton');
    		sendpreview('sendVideo',$chat_id,$file_id,'no caption');
    		sendpostcode($chat_id,$code,$file_id,$type);

  			
   	
    }else if (isset($message['document']['file_id'])){
    
    		$token = "271681195:AAEHWpI0vJUN0_TyfXeNNcWnPaUwOenPfLM";
    		$url = 'https://api.telegram.org/bot'.$token.'/getFile?file_id='.$Dfile_id;
    		$content = file_get_contents($url);
    		$file = json_decode($content,true);
    		//file_put_contents('17.txt',var_export($file,true));
    		
    		$file_id = $file[result][file_id];
    		$file_size = $file[result][file_size];
    		$file_path = $file[result][file_path];
    		
    		$A=rand(1,999999999);
  		$code = $chat_id + $A;
  		$type = 'getDlike';
  		
    		registercode($chat_id,$code,$file_id,'no capiton');
    		sendpreview('sendDocument',$chat_id,$file_id,'no caption');
    		sendpostcode($chat_id,$code,$file_id,$type);

  			
   	
    }  else if (isset($message['photo']['0']['file_id'])){
    		
    		
    		$caption = $message['caption'];
    		$token = "271681195:AAEHWpI0vJUN0_TyfXeNNcWnPaUwOenPfLM";
    		$url = 'https://api.telegram.org/bot'.$token.'/getFile?file_id='.$Pfile_id;
    		$content = file_get_contents($url);
    		$file = json_decode($content,true);
    		//file_put_contents('17.txt',var_export($file,true));
    		
    		$file_id = $file[result][file_id];
    		$file_size = $file[result][file_size];
    		$file_path = $file[result][file_path];
    		
    		$A    = rand(1,999999999);
  		$code = $chat_id + $A;
  		registercode($chat_id,$code,$file_id,$caption);
  		
  		$selectedmenu = lastselectedm();
  		
  		if ($selectedmenu == 'ساخت پست با دکمه های لایک'){
  			$type = 'getPlike';
  			sendpreview('sendPhoto',$chat_id,$file_id,$caption);
    			sendpostcode($chat_id,$code,$file_id,$type);
  		}else if ($selectedmenu == 'ساخت نظر سنجی'){
  			$type = 'getpoll';
  			
  			$token = "271681195:AAEHWpI0vJUN0_TyfXeNNcWnPaUwOenPfLM";
	
			$request = curl_init('https://api.telegram.org/bot'.$token.'/sendMessage?chat_id='.$chat_id);
			curl_setopt($request,CURLOPT_POST,true);
    			curl_setopt($request,CURLOPT_POSTFIELDS,array('text' => 'لطفا دکمه ها را به ترتیب وارد بفرمایید'));
    			curl_exec($request);
  			
  			
  			$variable ='سلام';
  			while ($variable != 'اتمام دکمه های نظر سنجی'){
  			
  				askpolls($file_id);
  				//submitpollinfo($file_id);
  				
  				$variable ='اتمام دکمه های نظر سنجی';
  			
  			}  			
  			
  		}
  		
  				
   	
    }  
    }
    
    function lastselectedm(){
    	$result = mysql_query("SELECT * FROM selectedmenu ORDER BY id DESC LIMIT 1 " );
    $row = mysql_fetch_assoc($result);
    $selectedmenu = $row['selectedmenu'];
    return $selectedmenu;
    }
    
    function askpolls($file_id){
    	
    	$pollnum == getpollnum($file_id);
    	
    	$request = curl_init('https://api.telegram.org/bot'.$token.'/sendMessage?chat_id='.$chat_id);
			curl_setopt($request,CURLOPT_POST,true);
    			curl_setopt($request,CURLOPT_POSTFIELDS,array('text' => 'دکمه' . $pollnum . ' را وارد بفرمایید '));
    			curl_exec($request);
    }
    
    function getpollnum($file_id){
   	 $sql = mysql_query("SELECT * FROM postcode WHERE code = '$code'" );
   	 
	$result = mysql_num_rows($sql) ;
  	
  	if ($result<1){
  		return 0 ;
  	} else return $result;
    }
    
    function submitpollinfo($file_id){
    	$token = "271681195:AAEHWpI0vJUN0_TyfXeNNcWnPaUwOenPfLM";
	
	$request = curl_init('https://api.telegram.org/bot'.$token.'/sendMessage?chat_id='.$chat_id);
    curl_setopt($request,CURLOPT_POST,true);
    curl_setopt($request,CURLOPT_POSTFIELDS,array('text' => ' دکمه اول را وارد کنید'));
    curl_exec($request);
    
   
    }
    
    
    function processinlinequery($message) {
  // process incoming message
  $inline_query_id = $message['id'];
  $chat_id = $message['from']['id'];
  $first_name = $message['from']['first_name'];
  $username = $message['from']['username']; 
  $mainquery= $message['query'];
  $offset= $message['offset'];
  
  $query = explode(' ',$mainquery);
  
  if ($query[0] == 'getPlike'){ 
  	$code = $query[1];
  	$file_id = getfileid($code);
  	$caption = getcaption($code);
  	$photo_url = $file_id;
            
        $results =array(                
                array('type' =>'photo','id' => 'ارسال پست همراه لایک','photo_file_id' => $photo_url ,'title' => 'ارسال پست صوتی همراه لایک ','description' => 'بخش مربوط به توضیحات می باشد' ,'caption' => $caption,'reply_markup' =>array('inline_keyboard'=>array(
                
                array(array('text' =>'❌ دوست ندارم','callback_data' => 'دوست ندارم'),array('text' =>'✅ دوست دارم','callback_data' => 'دوست دارم')),
                array(array('text' =>'هزینه استفاده فقط 5 تا صلواة','callback_data' => '4'))
            ) )));     
               apiRequestWebhook("answerInlineQuery", array('inline_query_id' => $inline_query_id, "results" => $results ) );
  
  }else if ($query[0] == 'getAlike'){ 
  	$code = $query[1];
  	$file_id = getfileid($code);
  	$audio_url = $file_id;
            
        $results =array(                
                array('type' =>'audio','id' => 'ارسال پست همراه لایک','audio_url' => $audio_url,'title' => 'ارسال پست صوتی همراه لایک ','reply_markup' =>array('inline_keyboard'=>array(
                
                array(array('text' =>'❌ دوست ندارم','callback_data' => 'دوست ندارم'),array('text' =>'✅ دوست دارم','callback_data' => 'دوست دارم')),
                array(array('text' =>'هزینه استفاده فقط 5 تا صلواة','callback_data' => '4'))
            ) )));
                 
               apiRequestWebhook("answerInlineQuery", array('inline_query_id' => $inline_query_id, "results" => $results ) );
  
  }else if ($query[0] == 'getVOlike'){ 
  	$code = $query[1];
  	$file_id = getfileid($code);
  	$voice_file_id = $file_id;
            
        $results =array(                
                array('type' =>'voice','id' => 'ارسال پست همراه لایک','voice_file_id' => $voice_file_id,'title' => 'ارسال پست صوتی همراه لایک ','reply_markup' =>array('inline_keyboard'=>array(
                
                array(array('text' =>'❌ دوست ندارم','callback_data' => 'دوست ندارم'),array('text' =>'✅ دوست دارم','callback_data' => 'دوست دارم')),
                array(array('text' =>'هزینه استفاده فقط 5 تا صلواة','callback_data' => '4'))
            ) )));
                 
               apiRequestWebhook("answerInlineQuery", array('inline_query_id' => $inline_query_id, "results" => $results ) );
  
  }else if ($query[0] == 'getVlike'){ 
  	$code = $query[1];
  	$file_id = getfileid($code);
  	$video_file_id = $file_id;
        
        $results =array(                
                array('type' =>'video','id' => 'ارسال پست همراه لایک','video_file_id' => $video_file_id,'title' => 'ارسال پست صوتی همراه لایک ','reply_markup' =>array('inline_keyboard'=>array(
                
                array(array('text' =>'❌ دوست ندارم','callback_data' => 'دوست ندارم'),array('text' =>'✅ دوست دارم','callback_data' => 'دوست دارم')),
                array(array('text' =>'هزینه استفاده فقط 5 تا صلواة','callback_data' => '4'))
            ) )));    
        
                
               apiRequestWebhook("answerInlineQuery", array('inline_query_id' => $inline_query_id, "results" => $results ) );
  
  }else if ($query[0] == 'getDlike'){ 
  	$code = $query[1];
  	$file_id = getfileid($code);
  	$document_file_id = $file_id;
            
        $results =array(                
                array('type' =>'document','id' => 'ارسال پست همراه لایک','title' => 'ارسال پست صوتی همراه لایک ','document_file_id' => $document_file_id,'reply_markup' =>array('inline_keyboard'=>array(
                
                array(array('text' =>'❌ دوست ندارم','callback_data' => 'دوست ندارم'),array('text' =>'✅ دوست دارم','callback_data' => 'دوست دارم')),
                array(array('text' =>'هزینه استفاده فقط 5 تا صلواة','callback_data' => '4'))
            ) ))); 
                
               apiRequestWebhook("answerInlineQuery", array('inline_query_id' => $inline_query_id, "results" => $results ) );
  
  }else {
  	$results =array(                
                array('type' =>'article','id' => 'ارسال پست همراه لایک','title' => 'ارسال پست متنی همراه لایک ','input_message_content' =>array( 'message_text' => $mainquery),'reply_markup' =>array('inline_keyboard'=>array(
                
                array(array('text' =>'❌ دوست ندارم','callback_data' => 'دوست ندارم'),array('text' =>'✅ دوست دارم','callback_data' => 'دوست دارم')),
                array(array('text' =>'هزینه استفاده فقط 5 تا صلواة','callback_data' => '4'))
            ) )));     
               apiRequestWebhook("answerInlineQuery", array('inline_query_id' => $inline_query_id, "results" => $results ) ); 
  }
  
  

  
  }
  
  function registervoteinfo($chat_id,$username,$inline_message_id,$voted){
  	
  	$sql = mysql_query("INSERT INTO vote VALUES(
    NULL,
    '$chat_id',
    '$username',
    '$inline_message_id',
    '$voted'
    )");
  
  }
  
  function checkvote($chat_id,$inline_message_id){
  	 $sql = mysql_query("SELECT * FROM vote WHERE message_id='$inline_message_id' AND chat_id='$chat_id' ");

 if (mysql_num_rows($sql) >= 1){
 	
 	$result = 'yes' ;
 	return $result;
 }else {
 	$result = 'no' ;
 	return $result;
 }
 
 
  }
  
  function  getlikenum($inline_message_id){
  	$sql = mysql_query("SELECT * FROM vote WHERE message_id='$inline_message_id' AND voted='دوست دارم' ");
  	$result = mysql_num_rows($sql) ;
  	
  	if ($result<1){
  		return 0 ;
  	} else return $result;
  	
  }
  
  function  getunlikenum($inline_message_id){
  	$sql = mysql_query("SELECT * FROM vote WHERE message_id='$inline_message_id' AND voted='دوست ندارم' ");
  	$result = mysql_num_rows($sql) ;
  	if ($result<1){
  		return 0 ;
  	} else return $result;
  }

  
  
  function processcallback($message) {
  // process incoming message
  $chat_id = $message['from']['id'];
  $first_name = $message['from']['first_name'];
  $username = $message['from']['username']; 
  $inline_message_id= $message['inline_message_id'];
  $data= $message['data'];
  $callback_query_id= $message['id'];
  
  $checkvote = checkvote($chat_id,$inline_message_id);
  
  if($checkvote == 'no'	){
  
  	 if ($data == 'دوست دارم'){
  
  	$voted = $data;
  	registervoteinfo($chat_id,$username,$inline_message_id,$voted);
  	
  	
  	
  	$x = getlikenum($inline_message_id);
  	$y = getunlikenum($inline_message_id); 
  	
  	$like = $x . ' ✅  دوست دارم '  ;
  	$unlike =  $y  . ' ❌  دوست ندارم ' ;
  	$reply=array(
            'inline_keyboard'=>array(
                array(array('text' =>$unlike ,'callback_data' => 'دوست ندارم'),array('text' =>$like,'callback_data' => 'دوست دارم')),
                array(array('text' =>'هزینه استفاده فقط 5 تا صلواة','callback_data' => '4'))
            )
            
        ) ;
  
  	//apiRequestWebhook("editMessageReplyMarkup", array('inline_message_id' => $inline_message_id,'reply_markup' => json_encode($reply)));
  	
  	
  	$tokena = "271681195:AAEHWpI0vJUN0_TyfXeNNcWnPaUwOenPfLM"; 
    
    $request = curl_init('https://api.telegram.org/bot'.$tokena.'/editMessageReplyMarkup?inline_message_id='.$inline_message_id);
    curl_setopt($request,CURLOPT_POST,true);
    curl_setopt($request,CURLOPT_POSTFIELDS,array('reply_markup' => json_encode($reply)));
    curl_exec($request);  	
  }else  if ($data == 'دوست ندارم'){
  
  	$voted = $data;
  	registervoteinfo($chat_id,$username,$inline_message_id,$voted);
  
  	$x = getlikenum($inline_message_id);
  	$y = getunlikenum($inline_message_id);
  	
  	$like = $x . ' ✅  دوست دارم '  ;
  	$unlike =  $y  . ' ❌  دوست ندارم ' ;
  	$reply=array(
            'inline_keyboard'=>array(
                array(array('text' =>$unlike ,'callback_data' => 'دوست ندارم'),array('text' =>$like,'callback_data' => 'دوست دارم')),
                array(array('text' =>'هزینه استفاده فقط 5 تا صلواة','callback_data' => '4'))
            )
            
        ) ;
  
  	//apiRequestWebhook("editMessageReplyMarkup", array('inline_message_id' => $inline_message_id,'reply_markup' => json_encode($reply)));
  	
  	
  	$tokena = "271681195:AAEHWpI0vJUN0_TyfXeNNcWnPaUwOenPfLM"; 
    
    $request = curl_init('https://api.telegram.org/bot'.$tokena.'/editMessageReplyMarkup?inline_message_id='.$inline_message_id);
    curl_setopt($request,CURLOPT_POST,true);
    curl_setopt($request,CURLOPT_POSTFIELDS,array('reply_markup' => json_encode($reply)));
    curl_exec($request);  	
  
  
  }
  
  } 
 
  
 } 

$content = file_get_contents("php://input");

$update = json_decode($content, true);
file_put_contents('17.txt',var_export(json_decode($content),true));
if (!$update) {
  // receive wrong update, must not happen
  exit;
}

if (isset($update["message"])) {
  processMessage($update["message"]);
}else if (isset($update["inline_query"])) {
  processinlinequery($update["inline_query"]);
}else if (isset($update["callback_query"])) {
  processcallback($update["callback_query"]);
}
?>
