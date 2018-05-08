# Installation

The ORM CLI relies on PHP >= 7.1.3, sqlite, and php-curl.

## Prerequisites

### macOS Install

For macOS it's best to use the [Homebrew](https://brew.sh) package manager.

```shell
brew install php71
```

### Ubuntu 14.04 - 16.10 Install

On Ubuntu utilize apt to get our prerequisites.

```shell
sudo apt-get install software-properties-common
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
apt-get install php7.1 php7.1-curl php7.1-sqlite3
```

### Debian >= v8 (Jessie and later) Install

On Debian utilize apt to get our prerequisites.

```shell
apt-get install apt-transport-https lsb-release ca-certificates
wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list
apt-get update
apt-get install php7.1 php7.1-curl php7.1-sqlite3
```

###### Note: PHP 7.1 can be compiled from source for Debian 7 (Wheezey), but that is outside the scope of these directions.

### Windows Install 

To install php 7.1 on Windows utilize [Chocolatey](https://chocolatey.org/).

Install php

```shell
choco install php --version 7.1.17 -y
choco pin add -n=php --version 7.1.17
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

## Installation

Download the latest orm binary from the [releases](https://github.com/OpenResourceManager/orm-cli/releases/) page.

### Step 1 (Unix like system macOS/Linux):

Make the binary executable:

```bash
chmod +x orm;
```

Move the downloaded binary to somewhere in your system path:

```bash
mv orm /usr/local/bin/orm;
```

### Step 1 (Windows): 

Make a folder at `C:\Program Files\ORM\bin\` and copy the downloaded binary to that folder.

Make a new file called `C:\Program Files\ORM\orm.bat` with this content:

```bat
@echo off
"%SystemDrive%\tools\php71\php.exe" "%ProgramFiles%\ORM\bin\orm" %*
```

Add the following folder to your system path: `C:\Program Files\ORM`

You should now be able to run the `orm` command from cmd and PowerShell.

### Step 2 (All OS's):

Next you'll need to migrate the database tables.

The command to do this is:

```bash
orm migrate --force
```

Then you'll need to store your ORM API credentials:

```bash
orm profile:store
```

Follow the prompts and enter the required information.

You can verify the information with the profile show command:

```bash
orm profile:show
+----+--------+-------------------+-----------------+------+-------------+---------+---------------------------+---------------------------+
| id | active | email             | host            | port | api version | use ssl | created                   | updated                   |
+----+--------+-------------------+-----------------+------+-------------+---------+---------------------------+---------------------------+
| 1  | Yes    | email@example.com | orm.example.com | 443  | 1           | Yes     | 2018-01-18 05:19:59 (UTC) | 2018-01-18 05:19:59 (UTC) |
+----+--------+-------------------+-----------------+------+-------------+---------+---------------------------+---------------------------+
```

## Moving on

At this point the ORM CLI is installed and configured.
