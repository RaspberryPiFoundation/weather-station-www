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
  
1. Download the flot JavaScript plotting library. 

  ```
  cd js
  wget http://www.flotcharts.org/downloads/flot-0.8.3.zip
  unzip flot-0.8.3.zip
  ```
