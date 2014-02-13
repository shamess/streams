<?php

namespace Shane\Streams\Streams;

require __DIR__ . '/../../vendor/autoload.php';

class StreamItem {
    protected $date;
    protected $content;
    protected $link;
    protected $image;
    protected $streamName;

    public function __call($name, $arguments) {
        $methods = array('Date', 'Content', 'Link', 'Image', 'StreamName');

        if (substr($name, 0, 3) == "get" && in_array($var = substr($name, 3), $methods)) {
            $var = strtolower($var);

            return $this->$var;
        }

        if (substr($name, 0, 3) == "set" && in_array($var = substr($name, 3), $methods)) {
            $var = strtolower($var);
            $this->$var = $arguments[0];

            return;
        }

        throw new \BadMethodCallException();
    }
}

