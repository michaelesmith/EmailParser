[![Build Status](https://secure.travis-ci.org/michaelesmith/msEmailParser.png)](http://secure.travis-ci.org/michaelesmith/msEmailParser)

README
======

What is msEmailParser?
-------------------

A utility to parse incoming emails into an object representation. This uses some of the tests from
https://github.com/plancake/official-library-php-email-parser and is heavily inspired by
https://github.com/juji/EmailParserPHP

Installation
------------

### Use Composer (*recommended*)

The recommended way to install msDateTime is through composer.

If you don't have Composer yet, download it following the instructions on
http://getcomposer.org/ or just run the following command:

    curl -s http://getcomposer.org/installer | php

Just create a `composer.json` file for your project:

``` json
{
    "require": {
        "michaelesmith/email-parser": "*"
    }
}
```

For more info on composer see https://github.com/composer/composer

Examples
--------

###Basic

    $d = new msDateTime('2/5/1980 18:53:37'); //any string you could use with php's native DateTime
    var_dump($d->format('l F j @ g:ia')); //any formating accepted by php's date()
    // string(27) "Tuesday February 5 @ 6:53pm"
    var_dump($d->dump()); //show current timestamp human readable for debugging
    // string(31) "Tue, 05 Feb 1980 18:53:37 -0600"

###Convenience methods example

    $d = new msDateTime();
    var_dump($d->modify('-1 year +3 days')->dump());
    // string(31) "Thu, 19 Aug 2010 22:38:39 -0500"
    var_dump($d->finalDayOfQuarter()->endOfDay()->dump());
    // string(31) "Thu, 30 Sep 2010 23:59:59 -0500"
    var_dump($d->reset()->dump()); //internal timestamp can be reset to initial
    // string(31) "Tue, 16 Aug 2011 22:38:39 -0500"

Complete list of methods
------------------------

###Update
* public function beginningOfDay()
* public function endOfDay()
* public function firstDayOfWeek()  //Sets to Sunday
* public function finalDayOfWeek()  //Sets to Saturday
* public function firstDayOfMonth()
* public function finalDayOfMonth()
* public function firstDayOfQuarter()
* public function finalDayOfQuarter()
* public function isFinalDayOfQuarter()

###Tests
* public function isBeginningOfDay()
* public function isEndOfDay()
* public function isFirstDayOfWeek()  //Returns true for Sunday
* public function isFinalDayOfWeek()  //Returns true for Saturday
* public function isFirstDayOfMonth()
* public function isFinalDayOfMonth()
* public function isFirstDayOfQuarter()

###Tests around now
* public function isToday()
* public function isTomorrow()
* public function isYesterday()
* public function isCurrentWeek()  //Uses ISO-8601 weeks Monday - Sunday
* public function isCurrentMonth()
* public function isCurrentYear()

###Miscellaneous
* public static function create($time = null, $object = null)  //Creates a new msDateTime object inline to preserve fluid calls
* public function  __toString()  //Returns the current timestamp in "Y-m-d H:i:s" format
* public function copy()
* public function compare($msDateTime2)  //Compares this object to $msDateTime2 by returning the difference in seconds
* public function dump()  //Outputs the current timestamp in a general format. Should only be used for debugging.
* public function getQuarter()


Examples can be found in docs/examples.php and can be run with "php docs/examples.php"
