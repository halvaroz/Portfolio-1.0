<?php

$months = array('01'=>"janvier",'02'=>"février", '03'=>"mars", '04'=>"avril", '05'=>"mai",'06'=>"juin",
    '07'=>"juillet", '08'=>"août", '09'=>"septembre", '10'=>"octobre", '11'=>"novembre", '12'=>"décembre");

function normalize ($string) {
    $table = array(
        'à'=>'a', 'â'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
        'ê'=>'e', 'ë'=>'e', 'î'=>'i', 'ï'=>'i', 'ô'=>'o', 'ö'=>'o','ú'=>'u', 'û'=>'u',
    );
    
    return strtr($string, $table);
}

function sanitize($text){
		$text = htmlspecialchars(trim($text), ENT_QUOTES);
		if (1 === get_magic_quotes_gpc()){
			$text = stripslashes($text);
		}
 
		$text = nl2br($text);
		$text=strip_tags($text);
		return $text;
};

function readData(){
	$path = "../txt/data.txt";

	$content = file_get_contents($path);

	$arra = explode(' ', $content);
 	return $arra;
}

function updateData($data){
	$prevContent = readData();

	if ($data == 'play'){
		$prevContent[0]++;
	}
	if ($data == 'success'){
		$prevContent[1]++;
	}
	
	$newContent = $prevContent[0].' '.$prevContent[1]; 

	$file = fopen('../txt/data.txt', 'w+');
	
	fwrite($file,$newContent);
	fclose($file);
}

function isEmail($email){
		$value = preg_match('/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD', $email);
		if ($value === 0){
			return false;
		} elseif ($value === false) {
			return true;
		}
	}