<?php

namespace Shane\Streams\Streams;

require __DIR__ . '/../../vendor/autoload.php';

class RedditStream extends SimpleStream implements Stream {
    public function __construct($username) {
        parent::__construct('http://www.reddit.com/user/' . $username . '.xml');
    }

    protected function getItemTitle(\SimplePie_Item $item) {
        if ($item->get_category()) {
            $title = $item->get_title();
        } else {
            $title = "Commented on <em>".substr($item->get_title(), strlen('shamess on '))."</em>";
        }

        return $title;
    }

    protected function getStreamImage() {
        return 'images/reddit.png';
    }

    protected function getStreamName() {
        return 'reddit';
    }
}

