# Incomplete

This is incomplete, hang tight!


### macOS Install

```shell
brew install php71
```

### Ubuntu 14.04 - 16.10 Install

```shell
sudo apt-get install software-properties-common
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
apt-get install php7.1 php7.1-curl
```

### Debian >= v8 (Jessie and later) Install

Note: PHP 7.1 can be compiled from source for Debian 7 (Wheezey), but that is outside the scope of these directions.

```shell
apt-get install apt-transport-https lsb-release ca-certificates
wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list
apt-get update
apt-get install php7.1 php7.1-curl
```

### Windows Install 

Have not tested this on Windows, and I will not be supporting it anytime soon... use at your own peril.

Install php

```shell
choco install php -y
```

Enable extensions:

uncomment the following lines in `C:\tools\php71\php.ini`

* `extension=php_curl.dll` - curl
* `extension=php_pdo_sqlite.dll` - sqlite pdo

Example:

```ini
...
;extension=php_bz2.dll
extension=php_curl.dll
;extension=php_fileinfo.dll
...
;extension=php_pdo_pgsql.dll
extension=php_pdo_sqlite.dll
;extension=php_pgsql.dll
...
```