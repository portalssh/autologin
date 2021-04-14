* installasi GUI AutoLogin WMS Venue Update 15-04-2021
```
$ wget --no-check-certificate https://raw.githubusercontent.com/portalssh/autologin/main/wms/auto_wms && chmod 755 ./auto_wms && ./auto_wms install
$ mkdir -p /www/image
$ cd /www/image
$ wget --no-check-certificate https://github.com/portalssh/autologin/raw/main/wms/config/logo3.png
$ wget --no-check-certificate https://github.com/portalssh/autologin/raw/main/wms/config/favicon.png
$ cd
$ /etc/init.d/uhttpd restart
```

* Tampilan GUI AutoLogin "http://ip_router/cgi-bin/autowms"

<div  align="center">    
  <img src="./wms/config/GUI-wms.png" width = "1200" alt="curl bash" align=center />
</div>

```
```
* contoh curl bash login page untuk mendapatkan ID WMS

<div  align="center">    
  <img src="./wms/config/curl-bash-id-wms.png" width = "1200" alt="curl bash" align=center />
</div>

```
```
* Edit config AutoLogin via putty ketik "nano auto_wms" dan sesuaikan dengan ID WMS anda

<div  align="center">    
  <img src="./wms/config/edit-cfg-wms.png" width = "1200" alt="curl bash" align=center />
</div>

```
```
* CLI AutoLogin WMS Venue Update 15-04-2021
```
$ wget --no-check-certificate https://raw.githubusercontent.com/portalssh/autologin/main/wms/config/wms_sh
```
* CLI AutoLogin WIFI.ID Update 15-04-2021
```
$ wget --no-check-certificate https://raw.githubusercontent.com/portalssh/autologin/main/wms/config/wifi_id
```
