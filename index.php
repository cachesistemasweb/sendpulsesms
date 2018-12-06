<?php 
if (($_SERVER['REQUEST_METHOD'] == 'POST')){
$phone = $_POST['phone'];
$name  = $_POST['name'];

$html = 'http://api.sendpulse.com/oauth/access_token';
$data = array('grant_type' => 'client_credentials', 
 'client_id' => 'my id', 
 'client_secret' => 'my secret');
 
 if($curl = curl_init()) {
    curl_setopt($curl, CURLOPT_URL, $html);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	$res = curl_exec($curl);
	$res = json_decode($res, true);
    curl_close($curl);
}

if($res) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.sendpulse.com/sms/numbers");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	"Authorization: " . $res['token_type'] . ' ' . $res['access_token'],
	));
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, array(
	'phones' => '{" '.$phone.' ":[[{"name":"'.$name.'","type":"string","value":" &#^$(*DY "}]]}',
    'addressBookId' => '2143090'
	));
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$xml = curl_exec($ch);
	curl_close($ch);
	var_dump (json_decode($xml));
}

}

?>
<form action="" method="POST">
Phone:<input name="phone" type="text"><br>

Name:<input name="name"  type="text"><br>
<input type="submit" value="enviar">

</form>
