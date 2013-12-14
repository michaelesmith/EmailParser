[![Build Status](https://travis-ci.org/michaelesmith/EmailParser.png?branch=master)](https://travis-ci.org/michaelesmith/EmailParser)

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

    $parser = new \MS\Email\Parser\Parser();
    $message = $parser->parse($email);

    // address object
    $message->getFrom();

    // email address
    $message->getFrom()->getAddress();

    // name if given
    $message->getFrom()->getName();

    // date sent
    $message->getDate()

    // date sent as DateTime object (PHP 5.3+)
    $message->getDateAsDateTime()

    // string
    $message->getSubject();

    // decoded plain text part
    $message->getTextBody();

    // decoded html body part
    $message->getHtmlBody();

    // attachments
    $attachments = $message->getAttachments();
    // attachment object
    $attachments[0]
    // methods
    $attachments[0]->getFilename();
    $attachments[0]->getMimeType();
    // decoded attachment content
    $attachments[0]->getContent();

###Encodings supported

    * base64
    * quoted-printable
    * 7bit
    * 8bit

More usage can be found in the tests
