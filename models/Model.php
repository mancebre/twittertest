<?php
namespace models;

/**
 * Class Model
 * @package models
 * @author Djordje Mancovic <dj.mancovic@gmail.com>
 */
class Model extends DB {

    /**
     * @var DB
     */
    protected $db;

    /**
     *
     */
    function __construct() {
        $this->db = new DB ('localhost', 'root', '', 'twittertest');
    }

    /**
     * @param $tweets
     * @return bool
     */
    public function updateTweets($tweets) {
        if (isset($tweets) && is_array($tweets)) {
            return $this->db->insertIgnore('tweets', $tweets);
        } else {
            return false;
        }
    }

    /**
     * @param int $limit
     * @param string $orderBy
     * @param string $order
     * @return bool|mixed
     */
    public function getTweets($limit = 1000, $orderBy = "created", $order = "DESC") {
        $tweets = $this->db->fetch('tweets', $limit, $orderBy, $order);

        return empty($tweets) ? false : $tweets;
    }

}
