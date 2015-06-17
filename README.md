# PHP Test #


### Requirements ###

* PHP 5.3 or newer
* MySQL 5.0.3 or newer
* php pdo
* php curl

### Guidelines ###

Cron for getting twitter data can be run from both terminal or http.

**Terminal:**
php /path/to/project/twittertest/index.php cron 200
The first argument "cron" is mandatory.
Second argument integer 200 must be integer from 1 to 200, default is 20.

**http:**
http://localhost/twittertest/index.php?action=cron&howManyTweets=1
This is pretty much the same. Parameter action is mandatory and it must be "cron".
Second parameter "howManyTweets" is not mandatory and can be between 1 and 200, default is 20. This parameter indicates the number of tweets that we request from API.

**index.php**
All tweets from database are shown on home page, it's possible to answer, retweet and favorite each one.