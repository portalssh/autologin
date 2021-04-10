* GUI AutoLogin WMS Venue Update 10-04-2021
```
$ wget https://raw.githubusercontent.com/portalssh/openwrt/main/wms/auto_wms && chmod 755 ./auto_wms && ./auto_wms install
$ mkdir -p /www/image
$ cd /www/image
$ wget https://github.com/portalssh/openwrt/raw/main/wms/config/logo3.png
$ wget https://github.com/portalssh/openwrt/raw/main/wms/config/favicon.png
```
* CLI AutoLogin WMS Venue Update 10-04-2021
```
$ wget -O /root/wms_sh "https://raw.githubusercontent.com/portalssh/openwrt/main/wms/config/wms_sh"
```
* CLI AutoLogin WIFI.ID Update 10-04-2021
```
$ wget -O /root/wifi_id "https://raw.githubusercontent.com/portalssh/openwrt/main/wms/config/wifi_id"
```
