<?php

namespace Shane\Streams\Streams;

require __DIR__ . '/../../vendor/autoload.php';

class TwitterStreamItem extends StreamItem {
    public function getStreamName() {
        return 'twitter';
    }

    public function getImage() {
        return 'images/twitter-blue-background.png';
    }

    public function setContent($content, $urls) {
        // change all the urls to links
        $tweetText = preg_replace ("!http://(\\S+)!i", "<a href=\"http://$1\">http://$1</a>", $content);
        // @usernames
        $tweetText = preg_replace ("/@(\\w+)/", "<a href=\"http://twitter.com/$1\">@$1</a>", $tweetText);
        // #hashtags too
        $this->content = preg_replace ("/#(\\w+)/", "<a href=\"http://twitter.com/search?q=$1\">#$1</a>", $tweetText);

        foreach ($urls as $url) {
            $this->content = str_replace('"'.$url->url, '"'.$url->expanded_url, $this->content);
            $this->content = str_replace($url->url, $url->display_url, $this->content);
        }
    }
}
