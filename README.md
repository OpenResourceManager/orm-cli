# Incomplete

This is incomplete, hang tight!

### macOS Install

```shell
brew install php71
```
### Ubuntu Install

```shell
apt-get install php71 php71-curl
```

### Windows Install 

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