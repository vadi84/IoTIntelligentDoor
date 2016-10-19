<?php
//
// A very simple PHP example that sends a HTTP POST to a remote site
//


function update_db() {
	//system('gst-launch-0.10 -q filesrc location=bell.wav ! wavparse ! autoaudiosink &');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "tag=status&hidden=html&value=0&submit=Store \a \value");
		curl_setopt($ch, CURLOPT_URL,"http://vadistinydb.appspot.com/storeavalue");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
		curl_exec ($ch);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "tag=flag&hidden=html&value=0&submit=Store \a \value");
		curl_setopt($ch, CURLOPT_URL,"http://vadistinydb.appspot.com/storeavalue");
		curl_exec ($ch);
		curl_close ($ch);
}

function fetch_flag_from_db() {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "tag=flag&hidden=html&submit=Get\ value");
		curl_setopt($ch, CURLOPT_URL,"http://vadistinydb.appspot.com/getvalue");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$json = curl_exec ($ch);
		$decoded = json_decode($json, true);
		echo $decoded[2];
		curl_close ($ch);
		return $decoded[2];
}

while (1){
	
$flag = fetch_flag_from_db();
if ($flag) {
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,"http://vadistinydb.appspot.com/getvalue");
#curl_setopt($ch, CURLOPT_URL,"http://localhost:8080/getvalue");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "tag=status&hidden=html&submit=Get\ value");

// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$json = curl_exec ($ch);

$decoded = json_decode($json, true);
echo $decoded[2];
curl_close ($ch);

switch ($decoded[2]) {
    case 1:
        update_db();
        system('gst-launch-0.10 -q filesrc location=bell.wav ! wavparse ! autoaudiosink &');
		sleep(1);
		system('gst-launch-0.10 -q filesrc location=will_be_right_back.wav ! wavparse ! autoaudiosink &');
		sleep(1);
	    break;
    case 2:
        update_db();
        system('gst-launch-0.10 -q filesrc location=bell.wav ! wavparse ! autoaudiosink &');
		sleep(1);
		system('gst-launch-0.10 -q filesrc location=will_be_back_in_ten_min.wav ! wavparse ! autoaudiosink &');
		sleep(1);
		break;
    case 3:
        update_db();
        system('gst-launch-0.10 -q filesrc location=bell.wav ! wavparse ! autoaudiosink &');
		sleep(1);
		system('gst-launch-0.10 -q filesrc location=we_will_meet_later.wav ! wavparse ! autoaudiosink &');
		sleep(1);
        break;
	case 4:
        update_db();
        system('gst-launch-0.10 -q filesrc location=bell.wav ! wavparse ! autoaudiosink &');
		sleep(1);
		system('gst-launch-0.10 -q filesrc location=oof_meet_u_later.wav ! wavparse ! autoaudiosink &');
		sleep(1);
        break;
    case 5:
        update_db();
        system('gst-launch-0.10 -q filesrc location=bell.wav ! wavparse ! autoaudiosink &');
		sleep(1);
		system('gst-launch-0.10 -q filesrc location=on_leave.wav ! wavparse ! autoaudiosink &');
		sleep(1);
        break;
	}
}
	sleep(2);
}
?>




