<?php

namespace Shane\Streams\Streams;

require __DIR__ . '/../../vendor/autoload.php';

class RssStream extends SimpleStream implements Stream {
    protected function getStreamImage() {
        return 'images/blog.png';
    }

    protected function getStreamName() {
        return 'rss';
    }
}

