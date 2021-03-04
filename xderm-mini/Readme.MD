wget -O /etc/config/uhttpd https://raw.githubusercontent.com/portalssh/openwrt/main/xderm-mini/uhttpd && /etc/init.d/uhttpd restart

wget -O /etc/redsocks.conf https://raw.githubusercontent.com/portalssh/openwrt/main/xderm-mini/redsocks

wget -O /usr/bin/gproxy https://raw.githubusercontent.com/portalssh/openwrt/main/xderm-mini/gproxy && chmod +x /usr/bin/gproxy
