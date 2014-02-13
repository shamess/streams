<?php

namespace Shane\Streams\Streams;

require __DIR__ . '/../../vendor/autoload.php';

class FlickrStream extends SimpleStream implements Stream {
    /**
     * Constructor.
     *
     * The user ID looks like "23667787@N00", with that weird @N00 at the end (possibly).
     *
     * @param string $userId
     */
    public function __construct($userId) {
        parent::__construct('http://www.flickr.com/services/feeds/photos_public.gne?id='.$userId.'&format=rss_200');
    }

    protected function getStreamImage() {
        return 'images/flickr.png';
    }

    protected function getStreamName() {
        return 'Flickr';
    }
}

