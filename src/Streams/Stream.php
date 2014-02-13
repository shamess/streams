<?php

namespace Shane\Streams\Streams;

interface Stream {
    /**
     * @return StreamItem
     */
    public function getItems();
}
