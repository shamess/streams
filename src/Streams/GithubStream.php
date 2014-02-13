<?php

namespace Shane\Streams\Streams;

require __DIR__ . '/../../vendor/autoload.php';

class GithubStream extends SimpleStream implements Stream {
    public function __construct($username) {
        parent::__construct('https://github.com/' . $username . '.atom');
    }

    protected function getStreamImage() {
        return 'images/github.jpg';
    }

    protected function getStreamName() {
        return 'github';
    }
}

