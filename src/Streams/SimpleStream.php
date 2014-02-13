<?php

namespace Shane\Streams\Streams;

require __DIR__ . '/../../vendor/autoload.php';

abstract class SimpleStream {
    private $feedUrl, $itemLimit;

    public function __construct($feedUrl, $itemLimit = 5) {
        $this->feedUrl = $feedUrl;
        $this->itemLimit = $itemLimit;
    }

    public function getItems() {
        $items = array();

        $feed = $this->getFeedReader();

        foreach($feed->get_items() as $post) {
            if (count($items) >= $this->itemLimit) return $items;

            $item = new StreamItem();
            $item->setDate($post->get_date('U'));
            $item->setContent($this->getItemTitle($post));
            $item->setLink($post->get_link());
            $item->setImage($this->getStreamImage());
            $item->setStreamName($this->getStreamName());

            $items[] = $item;
        }

        return $items;
    }

    private function getFeedReader() {
        $feed = new \SimplePie();
        $feed->set_cache_duration(300);
        $feed->set_feed_url($this->feedUrl);
        $feed->init();
        $feed->handle_content_type();

        return $feed;
    }

    protected function getItemTitle(\SimplePie_Item $item) {
        return $item->get_title();
    }

    abstract protected function getStreamImage();
    abstract protected function getStreamName();
}
