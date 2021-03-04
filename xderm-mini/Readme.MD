* xderm-mini GUI 1.8
```
wget -O xderm-mini-gui-1.8 https://raw.githubusercontent.com/portalssh/openwrt/main/xderm-mini/xderm-mini-gui-1.8 && chmod +x xderm-mini-gui-1.8 && ./xderm-mini-gui-1.8
```

* Edit Config Uhttpd openwrt
```
wget -O /etc/config/uhttpd https://raw.githubusercontent.com/portalssh/openwrt/main/xderm-mini/uhttpd && /etc/init.d/uhttpd restart
```

* Edit Config Redsocks openwrt
--------
```
wget -O /etc/redsocks.conf https://raw.githubusercontent.com/portalssh/openwrt/main/xderm-mini/redsocks
```

* Create Config Gproxy OpenWrt
--------
```
wget -O /usr/bin/gproxy https://raw.githubusercontent.com/portalssh/openwrt/main/xderm-mini/gproxy && chmod +x /usr/bin/gproxy
```

