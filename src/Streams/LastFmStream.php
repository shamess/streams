<?php

namespace Shane\Streams\Streams;

require __DIR__ . '/../../vendor/autoload.php';

class LastFmStream implements Stream {
    public function __construct($apiKey, $username, $count = 1) {
        $this->apiKey = $apiKey;
        $this->username = $username;
        $this->count = $count;
    }

    public function getItems() {
        $apiResponse = file_get_contents('http://ws.audioscrobbler.com/2.0/?method=user.getrecenttracks&user=' . $this->username . '&api_key=' . $this->apiKey . '&format=json&limit=' . $this->count);
        $response = json_decode($apiResponse, true);

        // when there's only one song it'll return the one track. otherwise returns a collection
        if (array_key_exists('artist', $response['recenttracks']['track'])) {
            return array($this->getItemByTrack($response['recenttracks']['track']));
        }

        $tracks = array();

        foreach ($response['recenttracks']['track'] as $track) {
            if (count($tracks) === $this->count) break;

            $tracks[] = $this->getItemByTrack($track);
        }

        return $tracks;
    }

    private function getItemByTrack($track) {
        $item = new StreamItem();
        $item->setLink($track['url']);
        $item->setImage($track['image'][2]['#text']);
        $item->setStreamName('lastfm');

        if ($this->isTrackPlayingNow($track)) {
            $item->setContent("Listening to " . $this->getItemTitle($track));
            $item->setDate(time());
        } else {
            $item->setContent("Recently listened to " . $this->getItemTitle($track));
            $item->setDate($track['date']['uts']);
        }

        return $item;
    }

    private function getItemTitle(array $track) {
        return $track['name'] . " by " . $track['artist']['#text'];
    }

    private function isTrackPlayingNOw(array $track) {
        return array_key_exists('@attr', $track) && array_key_exists('nowplaying', $track['@attr']) && $track['@attr']['nowplaying'];
    }
}

