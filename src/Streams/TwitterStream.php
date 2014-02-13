<?php

namespace Shane\Streams\Streams;

require __DIR__ . '/../../vendor/autoload.php';

class TwitterStream implements Stream {
    private $username;

    public function __construct($username, array $oAuthOptions) {
        $this->username = $username;
        $this->oAuth = $oAuthOptions;
    }

    public function getItems() {
        $items = array();

        $tweets = $this->getTweets();

        foreach ($tweets as $tweet) {
            if (count($items) >= 5) return $items;

            $item = new TwitterStreamItem();
            $item->setDate(strtotime ($tweet->created_at));
            $item->setContent($tweet->text, $tweet->entities->urls);
            $item->setLink("http://twitter.com/".$this->username."/status/".$tweet->id_str);

            $items[] = $item;
        }

        return $items;
    }

    private function getTweets() {
        $twitter = new \tmhOAuth(array(
            'consumer_key'    => $this->oAuth['consumer_key'],
            'consumer_secret' => $this->oAuth['consumer_secret'],
            'token'           => $this->oAuth['token'],
            'secret'          => $this->oAuth['secret'],
            'bearer'          => $this->oAuth['bearer'],

            'user_agent'      => $this->oAuth['user_agent']
        ));

        $code = $twitter->apponly_request(array(
            'method' => 'GET',
            'url' => $twitter->url('1.1/statuses/user_timeline.json'),
            'params' => array(
                'screen_name' => $this->username,
                'count' => 5,
                'trim_user' => true,
                'include_rts' => false,
                'exclude_replies' => true,
            )
        ));

        if ($code == 200) {
            $tweets = json_decode($twitter->response['response']);
            return $tweets;
        }

        return array();
    }
}
