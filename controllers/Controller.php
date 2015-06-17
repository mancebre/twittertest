<?php
namespace controllers;

use models\Model;
use models\TwitterAPI;

/**
 * Base Controller
 *
 *
 * @author Djordje Mancovic <dj.mancovic@gmail.com>
 */
class Controller {

    /**
     * @var
     */
    public $twitterAPI;
    /**
     * @var
     */
    public $howItWorks;

    /**
     *
     */
    public function __construct () {
        $this->model = new Model();
        if (isset($_SERVER['argv'][1])) {
            $this->howItWorks = "terminal";
        } else {
            $this->howItWorks = "web";
        }
    }

    /**
     *
     */
    public function homePage () {
        $tweetsRaw = $this->model->getTweets();
        $tweets = array();
        $now = date("Y-m-d H:i:s", time());

        if ($tweetsRaw) {
            foreach ($tweetsRaw as $tweet) {
                $tweet['created'] = $this->getDateDiff($tweet['created'], $now, 1) . " ago";
                $tweet['profileImageUrl'] = empty($tweet['profileImageUrl']) ? "css/images/default.png" : urldecode($tweet['profileImageUrl']);

                $tweets[] = $tweet;
            }
        }


        include("views/home.php");
    }

    /**
     *
     */
    public function handleRequest() {
        if (isset($_GET['action'])) {
            $action = filter_input(INPUT_GET, 'action');
            $this->execute($action);
        } elseif (isset($_SERVER['argv'][1]) && $_SERVER['argv'][1] == 'cron') {
            $action = trim($_SERVER['argv'][1]);
            $this->execute($action);
        } else {
            $this->homePage();
        }
    }

    /**
     * @param $action
     * @return bool
     */
    protected function execute($action) {
        if ($action) {
            switch ($action) {
                case 'cron':
                    $time_start = microtime(true);

                    if (isset($_GET['howManyTweets'])) {
                        $howManyTweets = (int) filter_input(INPUT_GET, 'howManyTweets');
                    } elseif (isset($_SERVER['argv'][2])) {
                        $howManyTweets = (int) $_SERVER['argv'][2];
                    } else {
                        $howManyTweets = 20;
                    }

                    if ($howManyTweets > 200) { // 200 is Twitter API limit (Twitter will limit this any way).
                        $howManyTweets = 200;
                    }

                    $tweets = $this->getTweets($howManyTweets);

                    $updatedTweetsCount = $this->model->updateTweets($tweets);

                    $time_end = microtime(true);

                    $execution_time = ($time_end - $time_start);

                    if (isset($this->howItWorks)) {
                        if ($this->howItWorks == 'terminal') {
                            echo "Tweets updated: $updatedTweetsCount \n";
                            echo "Execution time: $execution_time seconds \n";

                        } elseif($this->howItWorks == 'web') { //TODO Put this in view.
                            echo "Tweets updated: $updatedTweetsCount <br>";
                            echo "Execution time: $execution_time seconds <br>";

                        }
                    }
                    break;

                default : /* If the request is not recognized redirect to the home page. */
                    header("Location: " . $_SERVER['SERVER_NAME']);
                    die();
                    break;
            }

        }

    }

    /**
     * @param int $howManyTweets
     * @return array
     */
    protected function getTweets ($howManyTweets = 20) {
        $defaultTwitterAccount = 'ekomi';
        $data = array();

        /* Fetch Twitter data */
        $this->twitterAPI = new TwitterAPI($defaultTwitterAccount, (int) $howManyTweets);
        $twitterUser = $this->twitterAPI->getTwitterData();

        /* Map only data that we need to multidimensional array */
        $postId = 0;
        foreach ($twitterUser as $tweet) {
            $data[$postId]['created'] = date("Y-m-d H:i:s", strtotime($tweet->created_at));
            $data[$postId]['text'] = $tweet->text;
            $data[$postId]['tweetId'] = $tweet->id;
            $data[$postId]['profileImageUrl'] = isset($tweet->retweeted_status->user->profile_image_url) ? urlencode($tweet->retweeted_status->user->profile_image_url) : null;

            $postId++;
        }

        return $data;
    }

    /**
     * @param $time1
     * @param $time2
     * @param int $precision
     * @return string
     */
    public function getDateDiff( $time1, $time2, $precision = 2 ) {
        // If not numeric then convert timestamps
        if( !is_int( $time1 ) ) {
            $time1 = strtotime( $time1 );
        }
        if( !is_int( $time2 ) ) {
            $time2 = strtotime( $time2 );
        }

        // If time1 > time2 then swap the 2 values
        if( $time1 > $time2 ) {
            list( $time1, $time2 ) = array( $time2, $time1 );
        }

        // Set up intervals and diffs arrays
        $intervals = array( 'year', 'month', 'day', 'hour', 'minute', 'second' );
        $diffs = array();

        foreach( $intervals as $interval ) {
            // Create temp time from time1 and interval
            $ttime = strtotime( '+1 ' . $interval, $time1 );
            // Set initial values
            $add = 1;
            $looped = 0;
            // Loop until temp time is smaller than time2
            while ( $time2 >= $ttime ) {
                // Create new temp time from time1 and interval
                $add++;
                $ttime = strtotime( "+" . $add . " " . $interval, $time1 );
                $looped++;
            }

            $time1 = strtotime( "+" . $looped . " " . $interval, $time1 );
            $diffs[ $interval ] = $looped;
        }

        $count = 0;
        $times = array();
        foreach( $diffs as $interval => $value ) {
            // Break if we have needed precission
            if( $count >= $precision ) {
                break;
            }
            // Add value and interval if value is bigger than 0
            if( $value > 0 ) {
                if( $value != 1 ){
                    $interval .= "s";
                }
                // Add value and interval to times array
                $times[] = $value . " " . $interval;
                $count++;
            }
        }

        // Return string with times
        return implode( ", ", $times );
    }
}