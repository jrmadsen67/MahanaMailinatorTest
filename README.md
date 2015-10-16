# MahanaMailinatorTest

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://github.com/brnlbs/mailinator/blob/master/LICENSE)

A PHPUnit extension for testing emails via the Mailinator API

## Requirements
You need to have the [cURL](http://php.net/manual/en/book.curl.php)-extension installed on your server. [PHP](http://www.php.net) 5.4 will suffice.

Mahana Mailinator Test depends on the Mahana Mailinator API library (will install with composer, or can be found here: https://github.com/jrmadsen67/MahanaMailinatorAPI)

## Installation
`composer require jrmadsen67/mahana-mailinator-test`

## Usage
Mahana Mailinator Test is a PHPUnit extension used for functional email testing against the Mailintor API. You will need to get an api token at [https://www.mailinator.com/settings.jsp](https://www.mailinator.com/settings.jsp).

In your tests, create a Mahana Mailinator API object with your token, then pass that object to your Mahana Mailinator Test object:

```php
use jrmadsen67\MahanaMailinatorAPI\MahanaMailinatorAPI;
use jrmadsen67\MahanaMailinatorAPI\MahanaMailinatorTest;

$mahanaMailinatorAPI = new MahanaMailinatorAPI($token);
$mahanaMailinatorTest = new MahanaMailinatorTest($mahanaMailinatorAPI);
```

IMPORTANT! You need to *send* emails via your own mail library. This library will only retreive and test the contents.

Examples:

```php
// inbox value does not require "@mailinator.com" for the API to retrieve.
$inbox = 'mytestbox@mailinator.com';  

//psuedo-code to send an email:
mail_send([
    'to'=>$inbox, 
    'subject' => 'My test subject', 
    'from'=> 'me@test.com', 
    'body' => 'blah, blah, blah', 
]);


// get the email you just sent. this is an array.
$email = $mahanaMailinatorTest->getLastMessage($inbox); 

//start testing
$mahanaMailinatorTest->assertEmailSubjectContains('test', $email);
$mahanaMailinatorTest->assertEmailSubjectEquals('My test subject', $email);
$mahanaMailinatorTest->assertEmailTextContains('blah', $email);
```

Please read the library source for a full set of functions. (Better specs on the way, I promise!)