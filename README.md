streams
=======

An easy way to pull a few APIs and feeds together so that they can be output easily alongside each other.

Can add any number of "streams", which get merged together and list chronologically.

You can see this in use from my [homepage](http://shamess.info).

Quick example
=============

```php
use Shane\Streams\StreamCollection;
use Shane\Streams\Streams as Streams;

$stream = new StreamCollection();

$stream->addStream(new Streams\FlickrStream("23667787@N00"));
$stream->addStream(new Streams\RssStream('http://blog.shamess.info/feed/'));
$stream->addStream(new Streams\GithubStream("shamess"));
```

From that, you can loop over `getRecentObjects` for the latest items, and `getOtherItems` for
the rest.
