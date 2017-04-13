<VirtualHost *:80>
	ServerAdmin mark2002david@hotmail.com
	ServerName wyewoodcustomcabinets.com
	ServerAlias www.wyewoodcustomcabinets.com
	DocumentRoot /srv/www/wyewoodcustomcabinets.com/public_html
	ErrorLog /srv/www/wyewoodcustomcabinets.com/logs/error.log
	CustomLog /srv/www/wyewoodcustomcabinets.com/logs/access.log combined
</VirtualHost>
