# Speedrunner CMS
Yii 2 CMS aims to speed up and simplify development of small/medium web-projectsYii 2 CMS aims to speed up and simplify development of small/medium web-projects.
Yii 2 CMS aims to speed up and simplify development of small/medium web-projects.

## Requirements
* PHP version >= PHP 7.0
* MySQL version >= 5.6

## Installation

**Downloading**  
Clone repository by using
```
git clone https://github.com/sr-projects/speedrunner-cms.git
```
or download as [zip file](https://github.com/sr-projects/speedrunner-cms/archive/master.zip).

**Creating DB**  
Create database and fill config in `/common/config/main-local.php`.  
Run console command
```
yii speedrunner/db-import main.sql
```
or import SQL file `/console/db/main.sql` using MySQL manager.

## Important notes
* Do not use update command `composer update-all`, framework only (!) updating is allowed. Example: `composer update yiisoft/yii2`

## Documentation
In progress...

## Reporting
Let me know about **bugs to fix** and **feautures (or ideas) you want to see to discuss**.