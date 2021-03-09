<?php
include 'theme.php';
ceklogin();
$pattern="/^[A-Za-z0-9 ._]+$/";
$show="home";
if ($_POST['edit']) {
	$profile = $_POST['profile'];
	if (preg_match($pattern, $profile)) {
		$file = fopen('/home/ab/pf', "w");
		$content = $profile;
		fwrite($file, $content);
		fclose($file);
		header( "refresh:0;url=edit_profile.php" );
	}
	else {
		echo "Invalid Info";
		exit();
	}
}
css();
if ($_POST['hapus']){
	$profile = $_POST['profile'];
	unlink('/home/ab/profiles/'.$profile);
	$status = "Profile $profile berhasil dihapus";
}
if ($_POST['upload']) {
	$uploaddir = '/tmp/';
	$uploadfile = $uploaddir . basename($_FILES['file']['name']);
	if($_FILES['file']['size'] > 5000) {
		$status = "Invalid Profile";
	}
	else {
		if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
			rename($uploadfile, '/home/ab/profiles/'.basename($_FILES['file']['name']));
			$check = file_get_contents('/home/ab/profiles/'.basename($_FILES['file']['name']));
			if (preg_match("/[$()`]/", $check)) {
				unlink('/home/ab/profiles/'.basename($_FILES['file']['name']));
				$status = "Invalid Profile";
			}
			else {
				$status = "Upload profile ".basename($_FILES['file']['name'])." sukses.\n";
			}
		}
		else {
			$status = "Upload failed";
		}
	}
}
if ($_POST['set-gsm-port']){
	$port = $_POST['gsm-port'];
	if ($port == 'ttyUSB0' || $port == 'ttyUSB1' || $port == 'ttyUSB2' || $port == 'ttyUSB3' || $port == 'cdc-wdm0' ||
		$port == 'usb0' || $port == 'usb1' || $port == 'usb2' || $port == 'usb3' || $port == 'usb4') {
		$file = file_get_contents('/home/ab/gsm');
		preg_match("/DEV '(.+?)'/", $file, $oldport);
		$file = str_replace("DEV '".$oldport[1]."'", "DEV '$port'", $file);
		file_put_contents('/home/ab/gsm', $file);
		$status = "Set GSM port sukses ($port)";
	}
	else {
		$status = "Invalid Port";
	}
}
if ($_POST['set-modem-device']){
	$port = $_POST['modem-device'];
	if ($port == 'ttyUSB0' || $port == 'ttyUSB1' || $port == 'ttyUSB2' || $port == 'wwan0' || $port == 'cdc-wdm0' ||
		$port == 'usb0' || $port == 'usb1' || $port == 'usb2' || $port == 'usb3' || $port == 'usb4') {
		exec("sudo uci set network.4g.device=/dev/".$port);
		exec('sudo uci commit network');
		$status = "Set modem device untuk interface 4g sukses ($port)";
	}
	else {
		$status = "Invalid Port";
	}
}
if ($_POST['set-iface']) {
	$interface = $_POST['iface-gsm'];
	if ($interface == 'eth2' || $interface == 'eth1' || $interface == '3g' || $interface == '4g' || $interface == 'usb0') {
		$file = file_get_contents('/home/ab/gsm');
		$pattern = "/IFACE '.*'/";
		preg_match($pattern, $file, $oldinterface);
		$oldinterface = str_replace('IFACE \'', '', $oldinterface);
		$oldinterface = str_replace('\'', '', $oldinterface);
		$file = str_replace($oldinterface, $interface, $file);
		file_put_contents('/home/ab/gsm', $file);
		$interface = str_replace('eth2', 'E3372 HiLink (eth2)', $interface);
		$interface = str_replace('eth1', 'E3372 HiLink (eth1)', $interface);
		$interface = str_replace('usb0', 'Tetring USB', $interface);
		$interface = str_replace('wwan0', '4G non hilink (wwan0)', $interface);
		$status = "Set interface modem sukses ($interface)";
	}
	else {
		$status = "Invalid interface";
	}
}
if ($show == "home") {
	$listprofile = scandir('/home/ab/profiles');
	$array = parse_ini_string(str_replace(' ', '=', file_get_contents('/home/ab/config')));
	echo '<form action="" method="post">';
	echo 'Profile : <select name="profile">';
	$x=0;
	while ($x<count($listprofile)) {
		if ($listprofile[$x] != "." && $listprofile[$x] != "..") {
			if ($array['profile'] == $listprofile[$x]) {
				echo "<option value=\"$listprofile[$x]\" selected>$listprofile[$x]</option>";
			}
			else {
				echo "<option value=\"$listprofile[$x]\">$listprofile[$x]</option>";
			}
		}
		$x++;
	}
	?>
	</select>
	<input type="submit" name="edit" value="Edit">
	<input type="submit" name="hapus" onclick="return confirm('Are you sure?');" value="Delete">
	</form>
	<br>
	<form action="" method="post" enctype="multipart/form-data">
	<label for="file">Upload profile:</label>
	<input type="file" name="file" id="file">
	<input type="submit" name="upload" value="Upload">
	</form>
	<br>
	<?php 
	exec('ls /dev |grep "usb\|ttyUSB"',$out);
	$portmodem = file_get_contents('/home/ab/gsm');
	$pattern = "/DEV '.*'/";
	preg_match($pattern, $portmodem, $currentport);
	$currentport = str_replace('DEV \'', '', $currentport);
	$currentport = str_replace('\'', '', $currentport);
	?>
	<form action="" method="post">
		GSM Port : 
		<select name="gsm-port">
			<?php
			$x=0;
			while ($x<count($out)) {
				if ($currentport[0] == $out[$x]) {
					echo "<option value=\"$out[$x]\" selected>$out[$x]</option>";
				}
				else {
					echo "<option value=\"$out[$x]\">$out[$x]</option>";
				}
				$x++;
			}
			?>
		</select>
		<input type="submit" name="set-gsm-port" value="Set GSM Port">
	</form>
	<?php 
	$interface = file_get_contents('/home/ab/gsm');
	$pattern = "/IFACE '.*'/";
	preg_match($pattern, $interface, $currentinterface);
	$currentinterface = str_replace('IFACE \'', '', $currentinterface);
	$currentinterface = str_replace('\'', '', $currentinterface);
	$iface = array("3g"=>"3g","4g"=>"4g", "E3372 HiLink (eth2)"=>"eth2", "E3372 HiLink (eth1)"=>"eth1", "Tetring USB"=>"usb0");
	?>
	<br>
	<form action="" method="post">
		Modem Interface :
		<select name="iface-gsm">
			<?php
			foreach($iface as $x => $x_value) {
				if ($currentinterface[0] == $x_value){
					echo "<option value=\"$x_value\" selected>$x</option>";
				}
				else{
					echo "<option value=\"$x_value\" >$x</option>";
				}
			}
		?>
		</select>
		<input type="submit" name="set-iface" value="Set Interface">
	</form>
	<?php
	exec('ls /dev | grep ttyUSB',$dev);
	exec('sudo uci get network.3g.device',$currentdev);
	$currentdev = str_replace("/dev/", "", $currentdev);
	?>
	<br>
	<form action="" method="post">
		Modem Device : 
		<select name="modem-device">
			<?php
			$x=0;
			while ($x<count($dev)) {
				if ($currentdev[0] == $dev[$x]) {
					echo "<option value=\"$dev[$x]\" selected>$dev[$x]</option>";
				}
				else {
					echo "<option value=\"$dev[$x]\">$dev[$x]</option>";
				}
				$x++;
			}
			?>
		</select>
		<input type="submit" name="set-modem-device" value="Set Modem Device">
	</form>
	<?php
	echo $status;
	print_r($matches[0]);
	echo '</div>';
	foot();
}
?>