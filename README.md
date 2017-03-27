# lab4
markrogoyski/math-php

Powerful Modern Math Library for PHP

Math PHP is the only library you need to integrate mathematical functions into your applications.
It is a self-contained library in pure PHP with no external dependencies.
It has many complicated functions

Setup
Add the library to your composer.json file in your project:

{
  "require": {
      "markrogoyski/math-php": "0.*"
  }
}

Use composer to install the library:

$ php composer.phar install

Composer will install Math PHP inside your vendor folder. 

Then you can add the following to your .php files to use the library with Autoloading.

require_once(__DIR__ . '/vendor/autoload.php');


Minimum Requirements:
PHP 7
