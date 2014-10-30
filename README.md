Weather Station Demo Website
========================

Demo display website for the Raspberry Pi Weather Station HAT

## Instructions to deploy

1. First deploy the weather station data logging code from [here](https://github.com/raspberrypi/weather-station).

1. Drop into root on the weather station's command prompt:

  `sudo -s`
1. Change to the www folder:

  `cd /var/www`
1. Clone this github repository into a folder named `demo`:

  `git clone https://github.com/raspberrypi/weather-station-www.git demo`
  
1. Download the flot JavaScript plotting library from [here](http://www.flotcharts.org/):

  ```
  cd demo/js
  wget http://www.flotcharts.org/downloads/flot-0.8.3.zip
  unzip flot-0.8.3.zip
  ```
1. Return to the demo site root.

  `cd ..`
  
  You should now be in `/var/www/demo`
  
1. Update the the php script with the MySQL database credentials that you chose during the deployment of the data logging code.

  `nano data.php`
  
  Find the line: `$con=mysqli_connect("localhost","root","raspberry","weather");`
  
  Update `raspberry` to the password that you chose.
  
  Press `Ctrl - O` then `Enter` to save and `Ctrl - X` to quit nano.

1. Find the weather station's ip address:

  `ifconfig`
  
  The IP address will be on the second line just after `inet addr:`
1. Enter this IP address into the browser of another computer on the network followed by `/demo`:

  For example: `http://192.168.0.10/demo`
  
  A page should load showing various graphs. Note that wind direction is not shown.
  The site will not work in Midori on the Raspberry Pi but it will work in [Epiphany](http://www.raspberrypi.org/web-browser-released/).
