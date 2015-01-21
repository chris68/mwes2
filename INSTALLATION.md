## Foreign ppa ##
For Ubuntu 12.04 you must use foreign ppas. In order to install them easily via ``add-apt-repository`` you must install it first.
### Install  ``add-apt-repository`` ###
``add-apt-repository`` resides in package ``python-software-properties``. Install it via:
```
sudo apt-get install python-software-properties
```
With Ubuntu >= 12.10 it will be (see http://stackoverflow.com/questions/13018626/add-apt-repository-not-found):
```
sudo apt-get install software-properties-common
```
## Usage ##
Before you install things from a foreign ppa it make sense to update the system before to the an up-to-date level via
```
sudo apt-get update
sudo apt-get dist-upgrade
```
## Php ##
### Install PHP 5.4 ###
To use Yii2 for Ubuntu 12.04 you must first install PHP 5.4 manually since Ubuntu 12.04 only comes with PHP 5.3.

PHP 5.4 is packaged in the ppa https://launchpad.net/~ondrej/+archive/ubuntu/php5-oldstable. Install it via:
```
sudo add-apt-repository ppa:ondrej/php5
sudo apt-get update
sudo apt-get dist-upgrade
```

Restart the apache server via ``sudo service apache restart``
### Kill superfluous xcache.ini ###
There might exist a second and superflous file ``/etc/php/apache2/conf.d/xcache.ini``, parallel to the correct ``20-xcache.ini``. Delete it since otherwise you get constant errors about a wrong ``xcache.so`` file.

## Postgres ##

## Postfix ##

### Sqlgrey ###
We use http://sqlgrey.sourceforge.net/ as greylisting policy server.