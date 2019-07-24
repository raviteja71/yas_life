# Yas Life

This project is a Php application, executable from console.
There are two types of function supports in this project
	By giving country name as parameter it will output
		Country code and 
		Countries list who uses the Similar langugage
	By giving 2 country names as parameters it will output
		Whether the countries having any same language in there languagge list 
		

## Getting Started

https://github.com/raviteja71/yas_life

### Prerequisites

PHP 7.2
PHPunit
curl


```
In Ubuntu:
	php: sudo apt-get install php libapache2-mod-php
	curl: sudo apt-get install php-curl
	php unit :  composer require --dev phpunit/phpunit
```

### Installing

Make Sure You have already installed XAMPP or LAMP stack before working with the code.
Download the source code of the project from Github.
Place it anywhere in your system and configure the path.

THe project will be ready


```
To run the Code.

open the console and type 
	ex1: php -f index.php Spain or
	ex2: php -f index.php Spain England
	
```


You must able to get output like

	Country language code: es
	Spain speaks same language with these countries: Argentina, Belize, Bolivia (Plurinational State of), Chile, Colombia, Costa Rica, Cuba, Dominican Republic, Ecuador, El Salvador, Equatorial Guinea, Guam, Guatemala, Honduras, Mexico, Nicaragua, Panama, Paraguay, Peru, Puerto Rico, Spain, Uruguay, Venezuela (Bolivarian Republic of), Western Sahara

	or for ex2
	
	Spain and England do speak the same language
	
## Running the tests

 To run all the automated test cases please use below command
```
in project directory --> ./vendor/bin/phpunit UnitTestFiles/Test/
```

### Break down into end to end tests

This testcases will test the two major functionalities of the project

## Versioning

We use [GIT](https://github.com) for versioning. For the versions available, see the [tags on this repository](https://github.com/raviteja71/yas_life/tags). 

## Authors

* **Ravi Teja Muchintala** - *Initial work* - [Yas_life](https://github.com/raviteja71/yas_life)
