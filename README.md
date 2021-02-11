# Speedrunner CMS
Speedrunner CMS, based on Yii2 framework, aims to speed up and simplify development of small/medium web-projects.

## Requirements
* PHP version >= PHP 7.4
* MySQL version >= 5.7

## Installation

**Downloading**
Clone repository by using
```
git clone https://github.com/sr-projects/speedrunner-cms.git <your-folder>
```
or download as [zip file](https://github.com/sr-projects/speedrunner-cms/archive/master.zip).

**Creating DB**
Create database and fill config in `/common/config/main-local.php`.
Run console command
```
yii speedrunner/db/import main.sql
```
or import SQL file `/console/db/main.sql` using MySQL manager.

## Running
Use following urls to get application you need:
* `<your-domain>/api` for **api**
* `<your-domain>/admin` for **backend** (login: admin, password: admin123)
* `<your-domain>/` for **frontend**

## Documentation
In progress...

## Reporting
Let me know about **bugs to fix** and **feautures (or ideas) you want to see to discuss**.