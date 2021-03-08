<?php
include 'theme.php';
ceklogin();
$subm=0;
$pl = "Payload generator support untuk generate payload dari inject PC dan config HTTP Injector yang sudah di sniff, 
paste payloadnya kesini lalu klik Generate Payload";
if($_POST['Submit']){
	$profile=$_POST['profile'];
	$subm=1;
}
if($_POST['new']){
	css();
	$account = parse_ini_string(str_replace(' ', '=', file_get_contents('/home/ab/config')));
	preg_match("/[^#;]remote\s([0-9.]+)\s([0-9.]+)/", file_get_contents("/home/ab/crt/".$account['file_config']), $hostportvpn);
	preg_match("/Host:\s(.*)/", file_get_contents("/home/ab/gconf/".$account['ssh_account']), $hostssh);
	preg_match("/Port:\s(.*)/", file_get_contents("/home/ab/gconf/".$account['ssh_account']), $portssh);
	?>
	<script>
		function myFunction() {
			var menu = document.getElementById('ipqos');
			var val = menu.options[menu.selectedIndex].value;
			if (val == 'enable_iprule') {
				document.getElementById('ip').style.display = 'block';
				document.getElementById('qos').style.display = 'none';
			}
			else if (val == 'enable_qoshunter') {
				document.getElementById('qos').style.display = 'block';
				document.getElementById('ip').style.display = 'none';
			}
			else {
				document.getElementById('qos').style.display = 'none';
				document.getElementById('ip').style.display = 'none';
			}
		}
	function generate() {
		var hostvpn = '<?php echo "$hostportvpn[1]"; ?>';
		var portvpn = '<?php echo "$hostportvpn[2]"; ?>';
		var hostssh = '<?php echo "$hostssh[1]"; ?>';
		var portssh = '<?php echo "$portssh[1]"; ?>';
		var reqvpn = new RegExp("CONNECT " + hostvpn + ":" + portvpn,'g');
		var reqssh = new RegExp("CONNECT " + hostssh + ":" + portssh,'g');
		var hostvpn = new RegExp(hostvpn,'g');
		var hostssh = new RegExp(hostssh,'g');
		var portvpn = new RegExp(portvpn,'g');
		var portssh = new RegExp(portssh,'g');
		var str = document.getElementById("payload").value;
		var str = str.replace(reqssh, '^request^');
		var str = str.replace(reqvpn, '^request^');
		var str = str.replace(hostvpn, '^host^');
		var str = str.replace(hostssh, '^host^');
		var str = str.replace(portvpn, '^port^');
		var str = str.replace(portssh, '^port^');
		var str = str.replace(/(?:\r\n|\r|\n)/g, '#13#10');
		var str = str.replace(/\[raw\]/g, '^request^ HTTP\\1.0#13#10#13#10');
		var str = str.replace(/\[real_raw\]/g, '^request^ HTTP\\1.0#13#10#13#10');
		var str = str.replace(/\[method\]/g, 'CONNECT');
		var str = str.replace(/\[auth\]/g, '');
		var str = str.replace(/\[netData\]/g, '^request^ HTTP\\1.0');
		var str = str.replace(/CONNECT \[host_port\]/g, '^request^');
		var str = str.replace(/\[host_port\]/g, '^host^:^port^');
		var str = str.replace(/\[host\]/g, '^host^');
		var str = str.replace(/\[port\]/g, '^port^');
		var str = str.replace(/\[ssh\]/g, '^host^:^port^');
		var str = str.replace(/\[protocol\]/g, 'HTTP\\1.0');
		var str = str.replace(/\[cr\]/g, '#13');
		var str = str.replace(/\[lf\]/g, '#10');
		var str = str.replace(/\[crlf\]/g, '#13#10');
		var str = str.replace(/\[lfcr\]/g, '#10#13');
		var str = str.replace(/\[instant_split\]/g, '^s100^');
		var str = str.replace(/\[split\]/g, '^s500^');
		var str = str.replace(/\[delay_split\]/g, '^s1000^');
		var str = str.replace(/\[ua\]/g, 'Mozilla/5.0 (Android 4.4; Mobile; rv:41.0) Gecko/41.0 Firefox/41.0');
		var str = str.replace(/\[rotate=([^;\]]*)(?:;[^\]]*)?\]/g, '$1');
		document.getElementById("payload").value=str;
		if (str.indexOf("\[") >= 0 || str.indexOf("\]") >= 0) {
			alert("WARNING: There's an unsupported \"[\" or \"]\" character in your payload, your payload might not work properly");
		}
	}
	</script>
	<style>
	textarea {
		width: 100%;
		-webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
		-moz-box-sizing: border-box;    /* Firefox, other Gecko */
		box-sizing: border-box;         /* Opera/IE 8+ */
	}
	ul {
		list-style: inside;
		padding-left:0;
	}​
	input {
		float:right;
	}
	</style>
	<?php
	echo '<div style="width: 100%; display: table;">';
	echo '<div style="display: table-row">';
	echo '<div style="display: table-cell;text-align: left;">';
	echo '<form method="post">';
	echo '<ul style="list-style:none; display: inline; padding-left:0;">';
	echo "<li>Name :<input type=\"text\" name=\"profile\" value=\"\" width=\"100%\" autofocus/> </li>";
	echo "<li>APN :<input type=\"text\" name=\"apn\" width=\"100%\" value=\"internet\"width=\"100%\"/> </li>";
	echo "<li>Proxy :<input type=\"text\" name=\"proxy\" width=\"100%\"/></li>";
	echo "<li>Port :<input type=\"text\" name=\"port\" width=\"100%\" value=\"8080\"/></li>";
	echo "<li>Restart internet every:<input type=\"text\" name=\"restart-internet\" size=\"1\"/> minutes</li>";
	echo '<li><input type="checkbox" name="restart_ssh" value="yes" >Restart internet if ssh gets disconnected</li>';
	echo '<li><input type="checkbox" name="kodok" value="yes" >Auto Kodok <br><input type="checkbox" name="use_inject" value="yes" checked>Inject</li>';
	echo '<li><select name="metode">';
	echo '<option value="use_vpn">Use Openvpn';
	echo '<option value="use_ssh">Use SSH';
	echo '<option value="none" selected >None';
	echo '</select> ';

	echo '<select name="ipqos" id="ipqos" onchange="myFunction()">';
	echo '<option value="enable_iprule">Enable IP Rule';
	echo '<option value="enable_qoshunter">Enable QoS Hunter';
	echo '<option value="disable_all" selected>Disable All';
	echo '</select></li></ul>';
	echo "
		<div id=\"ip\" style=\"display:none;text-align:center;\">
		IP Rule :
		<br><textarea name=\"ip_rule\" rows=\"2\"/>$listx[1]</textarea>
		<br></div>
		<div id=\"qos\" style=\"display:none;text-align:center;\">
		QoS Target :
		<br><textarea name=\"qos_target\" rows=\"2\"/>$listx[1]</textarea>
		<br></div>";
	echo 'Profile info:<br>';
	echo "<textarea name=\"text-info\" rows=\"2\"></textarea>";
	echo '</div>';
	echo '<div style="display: table-cell;padding-left:10px;">Payload :<br>
	<textarea name="payload" id="payload" rows="15" cols="30" title="'.$pl.'"></textarea><br><br><button onclick="generate()" type="button">Generate Payload</button>
	</div></div></div><br><input name="update" type="submit" value="Save" /></form></div>';
	foot();
	echo '
	</div>
	</body>
	</div>
	</html>';
	exit;
}
if ($_POST['delete']) {
	$profile = $_POST['profile'];
	unlink('/home/ab/profiles/'.$profile);
	unlink('/home/ab/pf');
	touch('/home/ab/pf');
}
if($_POST['update']){
	$profile=$_POST['profile'];
	$file = fopen('/home/ab/pf', "w");
	$content = $profile;
	fwrite($file, $content);
	fclose($file);
	$payload=$_POST['payload'];
	$ip_rule=$_POST['ip_rule'];
	$qos_target=$_POST['qos_target'];
	$e_iprule=$_POST['e_iprule'];    
	$apn=$_POST['apn'];
	$kodok=$_POST['kodok'];
	$use_inject=$_POST['use_inject'];
	$proxy=$_POST['proxy'];
	$port=$_POST['port'];
	$restart_internet=$_POST['restart-internet'];
	$restart_ssh=$_POST['restart_ssh'];
	$text_info=$_POST['text-info'];
	$metode=$_POST['metode'];
	$ipqos=$_POST['ipqos'];
	if ($e_iprule != 'yes'){$e_iprule='no';}
	if ($kodok != 'yes') {$kodok='no';}
	if ($use_inject != 'yes'){$use_inject='no';}
	if ($ipqos == 'enable_iprule') {
		$enable_iprule = "yes";
		$enable_qoshunter = "no";
	}
	if ($ipqos == 'enable_qoshunter') {
		$enable_iprule = "no";
		$enable_qoshunter = "yes";
	}
	if ($ipqos == 'disable_all') {
		$enable_iprule = "no";
		$enable_qoshunter = "no";
	}
	if ($metode == 'use_vpn') {
		$use_vpn = "yes";
		$use_ssh = "no";
	}
	if ($metode == 'use_ssh') {
		$use_vpn = "no";
		$use_ssh = "yes";
	}
	if ($metode == 'none') {
		$use_vpn = "no";
		$use_ssh = "no";
	}
	$pattern="/(^[A-Za-z0-9 ._]+$|^$)/";
	$required_fields = array("profile", "ip_rule", "qos_target", "e_iprule", "apn", "kodok", "use_inject", "proxy", "port", "restart-internet", "text-info",
	"metode", "ipqos", "restart_ssh");
	$ket = array('');
	foreach ($required_fields as $field) {
		if (!preg_match($pattern, $_POST[$field])) {
			$error = "yes";
			array_push($ket, $field);
		}
		else if (preg_match("/[`]|(\$\()/", $_POST['payload'])) {
			$error = "yes";
			array_push($ket, 'payload');
		}
	}
	if ($error != "yes") {
		$content = "enable_iprule '$enable_iprule'
enable_qoshunter '$enable_qoshunter'
ip_rule '$ip_rule'
qos_target '$qos_target'
apn_modem '$apn'
auto_kodok '$kodok'
use_vpn '$use_vpn'
use_ssh '$use_ssh'
use_inject '$use_inject'
proxy_ip '$proxy'
proxy_port '$port'
restart_internet '$restart_internet'
restart_ssh '$restart_ssh'
payload_inject '$payload'
info '$text_info'";
		$openprofile = fopen("/home/ab/profiles/$profile", "w");
		fwrite($openprofile, "$content");
		fclose($openprofile);
		header( "refresh:0;url=edit_profile.php" );
		exit;
	}
	else {
		echo "Invalid info<br>";
		print_r($ket);
		exit;
	}
}
css();
$account = parse_ini_string(str_replace(' ', '=', file_get_contents('/home/ab/config')));
preg_match("/[^#;]remote\s([0-9.]+)\s([0-9.]+)/", file_get_contents("/home/ab/crt/".$account['file_config']), $hostportvpn);
preg_match("/Host:\s(.*)/", file_get_contents("/home/ab/gconf/".$account['ssh_account']), $hostssh);
preg_match("/Port:\s(.*)/", file_get_contents("/home/ab/gconf/".$account['ssh_account']), $portssh);
?>
<script>
	function myFunction() {
		var menu = document.getElementById('ipqos');
		var val = menu.options[menu.selectedIndex].value;
		if (val == 'enable_iprule') {
			document.getElementById('ip').style.display = 'block';
			document.getElementById('qos').style.display = 'none';
		}
		else if (val == 'enable_qoshunter') {
			document.getElementById('qos').style.display = 'block';
			document.getElementById('ip').style.display = 'none';
		}
		else {
			document.getElementById('qos').style.display = 'none';
			document.getElementById('ip').style.display = 'none';
		}
	}
	function generate() {
		var hostvpn = '<?php echo "$hostportvpn[1]"; ?>';
		var portvpn = '<?php echo "$hostportvpn[2]"; ?>';
		var hostssh = '<?php echo "$hostssh[1]"; ?>';
		var portssh = '<?php echo "$portssh[1]"; ?>';
		var reqvpn = new RegExp("CONNECT " + hostvpn + ":" + portvpn,'g');
		var reqssh = new RegExp("CONNECT " + hostssh + ":" + portssh,'g');
		var hostvpn = new RegExp(hostvpn,'g');
		var hostssh = new RegExp(hostssh,'g');
		var portvpn = new RegExp(portvpn,'g');
		var portssh = new RegExp(portssh,'g');
		var str = document.getElementById("payload").value;
		var str = str.replace(reqssh, '^request^');
		var str = str.replace(reqvpn, '^request^');
		var str = str.replace(hostvpn, '^host^');
		var str = str.replace(hostssh, '^host^');
		var str = str.replace(portvpn, '^port^');
		var str = str.replace(portssh, '^port^');
		var str = str.replace(/(?:\r\n|\r|\n)/g, '#13#10');
		var str = str.replace(/\[raw\]/g, '^request^ HTTP\\1.0#13#10#13#10');
		var str = str.replace(/\[real_raw\]/g, '^request^ HTTP\\1.0#13#10#13#10');
		var str = str.replace(/\[method\]/g, 'CONNECT');
		var str = str.replace(/\[auth\]/g, '');
		var str = str.replace(/\[netData\]/g, '^request^ HTTP\\1.0');
		var str = str.replace(/CONNECT \[host_port\]/g, '^request^');
		var str = str.replace(/\[host_port\]/g, '^host^:^port^');
		var str = str.replace(/\[host\]/g, '^host^');
		var str = str.replace(/\[port\]/g, '^port^');
		var str = str.replace(/\[ssh\]/g, '^host^:^port^');
		var str = str.replace(/\[protocol\]/g, 'HTTP\\1.0');
		var str = str.replace(/\[cr\]/g, '#13');
		var str = str.replace(/\[lf\]/g, '#10');
		var str = str.replace(/\[crlf\]/g, '#13#10');
		var str = str.replace(/\[lfcr\]/g, '#10#13');
		var str = str.replace(/\[instant_split\]/g, '^s100^');
		var str = str.replace(/\[split\]/g, '^s500^');
		var str = str.replace(/\[delay_split\]/g, '^s1000^');
		var str = str.replace(/\[ua\]/g, 'Mozilla/5.0 (Android 4.4; Mobile; rv:41.0) Gecko/41.0 Firefox/41.0');
		var str = str.replace(/\[rotate=([^;\]]*)(?:;[^\]]*)?\]/g, '$1');
		document.getElementById("payload").value=str;
		if (str.indexOf("\[") >= 0 || str.indexOf("\]") >= 0) {
			alert("WARNING: There's an unsupported \"[\" or \"]\" character in your payload, your payload might not work properly");
		}
	}
</script>
<style>
textarea {
	width: 100%;
	-webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
	-moz-box-sizing: border-box;    /* Firefox, other Gecko */
	box-sizing: border-box;         /* Opera/IE 8+ */
}
ul {
	list-style: inside;
	padding-left:0;
}​
</style>
<?php
if ($subm == 0){
	exec('cat /home/ab/pf',$o);
	$profile=$o[0];
}
$listprofile = scandir('/home/ab/profiles');
$infoprofile = parse_ini_string(preg_replace("/'.*?'(*SKIP)(*FAIL)|\h/","=", file_get_contents('/home/ab/profiles/'.$profile)));
echo "<form action=\"".$PHP_SELF."\" method=\"post\">";
echo 'Profile :<select name="profile">';
$x=0;
while ($x<count($listprofile)) {
	if ($listprofile[$x] != "." && $listprofile[$x] != "..") {
		if ($profile == $listprofile[$x]) {
			echo "<option value=\"$listprofile[$x]\" selected>$listprofile[$x]</option>";
		}
		else {
			echo "<option value=\"$listprofile[$x]\">$listprofile[$x]</option>";
		}
	}
	$x++;
}
echo "<input name=\"Submit\" type=\"submit\" value=\"Open\" />";
echo "<input name=\"new\" type=\"submit\" value=\"New profile\" />";
echo "<input name=\"delete\" type=\"submit\" onclick=\"return confirm('Are you sure?');\" value=\"Delete profile\" /><br><br>";
echo '<div style="width: 100%; display: table;">';
echo '<div style="display: table-row">';
echo '<div style="display: table-cell;text-align: left;">';
echo '<form method="post">';
echo '<ul style="list-style:none; display: inline; padding-left:0;">';
echo "<li>APN :<input type=\"text\" name=\"apn\" width=\"100%\" value=\"".$infoprofile['apn_modem']."\"/> </li>";
echo "<li>Proxy :<input type=\"text\" name=\"proxy\" width=\"100%\" value=\"".$infoprofile['proxy_ip']."\"/></li>";
echo "<li>Port :<input type=\"text\" name=\"port\" width=\"100%\" value=\"".$infoprofile['proxy_port']."\"/></li>";
echo "<li>Restart internet every :<input type=\"text\" name=\"restart-internet\" size=\"1\" value=\"".$infoprofile['restart_internet']."\"/> minutes</li>";
if ($infoprofile['restart_ssh'] == 'yes'){
	echo '<li><input type="checkbox" name="restart_ssh" value="yes" checked>Restart internet if ssh gets disconnected</li>';
}
else {
	echo '<li><input type="checkbox" name="restart_ssh" value="yes" >Restart internet if ssh gets disconnected</li>';
}
if ($infoprofile['auto_kodok'] == 'yes'){
	echo '<li><input type="checkbox" name="kodok" value="yes" checked>Auto Kodok</li>';
}
else {
	echo '<li><input type="checkbox" name="kodok" value="yes" >Auto Kodok </li>';
}
if ($infoprofile['use_inject'] == 'yes'){
	echo '<li><input type="checkbox" name="use_inject" value="yes" checked>Inject</li>';
}
else {
	echo '<li><input type="checkbox" name="use_inject" value="yes" >Inject</li>';
}
echo '<li><select name="metode">';
if ($infoprofile['use_vpn'] == 'yes') {
	echo '<li><option value="use_vpn" selected>Use Openvpn</li>';
}
else{
	echo '<li><option value="use_vpn" >Use Openvpn</li>';
}
if ($infoprofile['use_ssh'] == 'yes'){
	echo '<li><option value="use_ssh" selected>Use SSH</li>';
}
else{
	echo '<li><option value="use_ssh">Use SSH</li>';
}
if ($infoprofile['use_vpn'] == 'no' && $infoprofile['use_ssh'] == 'no'){
	echo '<li><option value="none" selected>None</li>';
}
else{
	echo '<li><option value="none">None</li>';
}
	echo '</select> ';
	echo '<select name="ipqos" id="ipqos" onchange="myFunction()">';
if ($infoprofile['enable_iprule'] == 'yes'){
	echo '<option value="enable_iprule" selected>Enable IP Rule';
}
else{
	echo '<option value="enable_iprule">Enable IP Rule';
}
if ($infoprofile['enable_qoshunter'] == 'yes'){
	echo '<option value="enable_qoshunter" selected>Enable QoS Hunter';
}
else{
	echo '<option value="enable_qoshunter">Enable QoS Hunter';
}
if ($infoprofile['enable_iprule'] == 'no' && $infoprofile['enable_qoshunter'] == 'no'){
	echo '<option value="disable_all" selected>Disable All';
}
else{
	echo '<option value="disable_all">Disable All';
}
echo '</select></li></ul>';
$eip=$infoprofile['enable_iprule'];
$eqh=$infoprofile['enable_qoshunter'];
echo "
	<div id=\"ip\" style=\"display:none;text-align:center;\">
	IP Rule :
	<br><textarea name=\"ip_rule\" rows=\"2\"/>".$infoprofile['ip_rule']."</textarea>
	<br></div>
	<div id=\"qos\" style=\"display:none;text-align:center;\">
	QoS Target :
	<br><textarea name=\"qos_target\" rows=\"2\"/>".$infoprofile['qos_target']."</textarea>
	<br></div>";
?>
	<script>
	var eip="<?php echo $eip; ?>";
	var eqh="<?php echo $eqh; ?>";
	if (eip == "yes") {
		document.getElementById('ip').style.display = 'block';
		document.getElementById('qos').style.display = 'none';
	}
	if (eqh == "yes") {
		document.getElementById('qos').style.display = 'block';
		document.getElementById('ip').style.display = 'none';
	}
	function myFunction() {
		var menu = document.getElementById('ipqos');
		var val = menu.options[menu.selectedIndex].value;
		if (val == 'enable_iprule') {
			document.getElementById('ip').style.display = 'block';
			document.getElementById('qos').style.display = 'none';
		}
		else if (val == 'enable_qoshunter') {
			document.getElementById('qos').style.display = 'block';
			document.getElementById('ip').style.display = 'none';
		}
		else {
			document.getElementById('qos').style.display = 'none';
			document.getElementById('ip').style.display = 'none';
		}
	}
	</script>
<?php
echo "Profile info:<br><textarea name=\"text-info\" rows=\"2\">";
echo $infoprofile['info'];
echo '</textarea>';
echo '</div>';
echo "<div style='display: table-cell;padding-left:10px;'>Payload :<br>
<textarea name='payload' id='payload' rows='15' cols='30' title='".$pl."'>".$infoprofile['payload_inject']."</textarea><br><br><button onclick='generate()' type='button'>Generate Payload</button>
</div></div></div><br><input name='update' type='submit' value='Save' /></form></div>";
foot();
echo '
</div>
</body>
</html>';
?>
