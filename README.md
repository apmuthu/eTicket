## What is eTicket?
PHP / MySQL based help desk ticketing application

## Why this repo?
* This project envisages the development of [eTicket](http://www.eticketsupport.com) in the public domain and is retaining it's schema so that migration-less switch is possible.
* The last released version of eTicket (v1.7.3) dates back to 2008-10-23 and further development of a v2.0 was slated to be in progress in their [community forum announcement on 2013-08-30](http://www.eticketsupport.com/announcements/eticket-update/msg33310/?topicseen#new). There is a [screenshot](http://oi42.tinypic.com/6eojt2.jpg) of it but no code publicly available as yet.

## To do
* The code will be minified to the extent possible without affecting readability and development.
* There will be no upgrade path provided and only the last released version's schema will be supported.
* Code changes to accommodate latest PHP versions will be incorporated.

## What is broken?
* The various CAPTCHAs are either broken or are outdated
* [MathGuard](http://www.codegravity.com/projects/mathguard) is at
* QuestCHA uses a dead link: http://thissitekicksass.net/incoming.php to get it's question and answer sets
* [Securimage](http://www.phpcaptcha.org/) is at v1.0.3.1 dated 2008-03-24
* [MathGuard](http://www.codegravity.com/projects/mathguard) is old too.
* All DIRECTORY_SEPARATOR are now forward slashes since PHP 5.3 onwards uses them for web urls.

## Licence

This code is licenced under GPL v2.0.
