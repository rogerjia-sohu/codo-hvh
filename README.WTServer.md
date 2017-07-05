WTServer - Nginx MariaDB Redis Php development stack for Windows
=========================================================================
A lightweight, fast and stable server stack for developing php mysql applications on windows, based on the excellent webserver Nginx. A lighter alternative to XAMPP and WAMP.

Copyright (C) 2013-2017 Dragos Alexandru Ionita
Copyright (C) 2013-2017 http://wtriple.com
All rights reserved.
http://wtserver.wtriple.com
https://sourceforge.net/projects/wtnmp
This software is a fork of nmp-server http://code.google.com/p/nmp-server/


Donation
--------
If you like WTServer, [please **donate** for a Code Signing SSL Certificate](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=4TLXFYSKDLBCQ)


Current Package contains:
-------------------------
- Nginx 1.13.1 web server
- MariaDB 10.2.6 database server, mysql 5.5.5 replacement (32/64bit)
- Redis 3.2 Cache/NoSql, memcached alternative (64bit)
- Php 5.6.30 & PHP 7.0.20 & PHP 7.1.6 scripting language (32/64bit)
- XDebug, GeoIP, Gender PHP Extensions
- WinSCP SFTP client
- HTTPS using free LetsEncrypt certificates
- Composer dependency manager for php
- Adminer web based database manager
- Reg.php regular expressions tester
- WTServer Manager (32/64bit), formerly known as *wt-nmp*


Features:
---------
- Easy to upgrade! Backups, configuration files, database data, included libraries and projects are persistent during upgrades (not overwritten)
- A single installer for both x86 and x64 systems, with  32bit and 64bit versions of MariaDB, PHP and WTServer Manager
- Lightning-fast web server. Optimized for best performance
- Command line tools: mysql client, php console, composer, acmePhp, putty
- PORTABLE: you can move it to a different location, configuration files are updated automatically
- For easy access, all configuration files are stored in one place: WTServer\conf and all log files are stored in one folder: WTServer\log
- Multiple PHP Versions and version switcher. Dynamic number of php-cgi processes
- The server manager runs minimized in the system tray and monitors, logs and restarts crashed servers, just like php-fpm on Linux
- Project setup, Local Virtual Servers for projects, Upload, Sync and Browse with WinSCP
- Optional database daily backups can be enabled with --backup. Up to 7 backup files will be created per database per weekday





Installing & Upgrading:
-----------------------
 - [Download the latest installer](http://wtserver.wtriple.com). The installer produces a portable folder.
 - Choose any installation folder you want or the previous install location.
 - Other PHP versions are available as [extra packages](http://sourceforge.net/projects/wtnmp/files/extras/)



WTServer Manager command line arguments:
--------------------------------------
example shortcut: `D:/Work/bin/WTServer.exe --debug --backup --phpCgiServers=2`

* -d	    --debug			Display debug messages
* -e	    --editor="notepad.exe"	Path to editor to be used to edit configuration files
* -s	    --startServers		Starts all the servers in background and minimizes to systray
* -k	    --killAll			Kills all running servers and exits
* -b        --backup			Enables automatic daily backups
* -l	    --latestPhp			Forces the use of the latest PHP version
* -p=n	    --phpCgiServers=n		Forces the number of PHP-CGI Servers, between 1 and 99
* -j	    --hideProjects		Hides Projects list at startup
* -n	    --noUpdates			Disables weekly Update checks
* -w	    --wwwDir="c:\Dir"		Custom WWW folder path for projects





Portability:
------------
WTServer is portable, but it is better if you run the installer once on each new machine:
- The installer fixes some windows networking issues that will make Nginx super fast and also allows faster connections to the Mysql server. Also installs *Visual C++ Redistributable* required by PHP
- The installer registers php, mysql and composer executables to PATH. If you move WTServer, those executables won`t be available globally anymore.
- So, if you need to copy/clone WTServer to a new machine, you should run the installer once, then overwrite the folder with the cloned folder




Issues:
------------
- **Nginx**: One of the reasons Nginx is so fast, it`s because it does not process .htaccess files. Therefore URL Rewriting and User Access must be set in nginx.conf.
- **MariaDb**: If it refuses to start and in log\mysql.log you find *[ERROR]  Table 'mysql.user' doesn't exist* , then run `c:\WTServer\bin\MySql\bin\mysql_install_db -d c:\WTServer\data` in order to recreate the table
- **Redis** is available only on 64bit systems
- **PHP** is configured in a very restrictive way, like on most hosting providers. Comment out `disable_functions`, `disable_classes`, `open_basedir` in conf/php.ini, if you need a more permissive PHP configuration.
- PHP Extensions: most of them are disabled by default, enable them in conf/php.ini (see src/defaults/php.ini for opcache, xdebug, xcache)
- PHP MySql extension is disabled by default and is deprecated as of PHP 5.5.0, and will be removed in the future. Instead, the MySQLi or PDO_MySQL extension should be used. If you really want to enable mysql extension, add or uncomment in conf/php.ini: `extension = php_mysql.dll`
- PHP: Starting only one PHP-CGI server with WTServer.exe --phpCgiServers=1 will result in slow ajax requests since Nginx will not be able to process PHP scripts simultaneous.




Great Articles:
---------------
* [WordPress in a nutshell: WT-NMP](http://wpkrauts.com/2014/wordpress-in-a-nutshell-wt-nmp/)
* [WTServer How-Tos](http://wtserver.wtriple.com/howtos.php)
* [How to enable HTTPS using free SSL Certificates from LetsEncrypt](http://wtserver.wtriple.com/howtoLetsEncrypt.php)







