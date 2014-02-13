<?php

namespace Shane\Streams;

require_once __DIR__ . '/../vendor/autoload.php';

use Shane\Streams\Streams\Stream;

class StreamCollection {
    private $items = array();

    public function addStream(Stream $stream) {
        $this->addItems($stream);
    }

    /**
     * Get the most recent (even if they're all from the same stream)
     */
    public function getRecentItems() {
        return array_slice($this->items, 0, 4);
    }

    /**
     * Gets just one of the items from each stream that wasn't shown in Recent.
     *
     * @return array
     */
    public function getOtherItems() {
        $other = array_slice($this->items, 3);

        $streamsAlreadyOutput = array();
        foreach ($this->getRecentItems() as $item) {
            if (false === in_array($item->getStreamName(), $streamsAlreadyOutput)) $streamsAlreadyOutput[] = $item->getStreamName();
        }

        $outputItems = array();
        foreach ($other as $item) {
            if (false === in_array($item->getStreamName(), $streamsAlreadyOutput)) {
                $streamsAlreadyOutput[] = $item->getStreamName();

                $outputItems[] = $item;
            }
        }

        return $outputItems;
    }

    private function addItems(Stream $stream) {
        $this->items = array_merge($this->items, $stream->getItems());

        usort($this->items, function ($a, $b) { return $a->getDate() < $b->getDate(); });
    }
}
