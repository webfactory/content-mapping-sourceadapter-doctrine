# content-mapping-sourceadapter-doctrine #

SourceAdapter for Doctrine entities in the [webfactory/content-mapping](https://github.com/webfactory/content-mapping)
mini framework.


## Installation ##

    composer require webfactory/content-mapping-sourceadapter-doctrine


## Usage ##

```php
use Webfactory\ContentMapping\Synchronizer;
use Webfactory\ContentMapping\SourceAdapter\Doctrine\GenericDoctrineSourceAdapter;

$repository = ...; // instance of your entity repository
$repositoryMethod = 'findForSynchronization';

$sourceAdapter = new GenericDoctrineSourceAdapter($repository, $repositoryMethod);

$synchronizer = new Synchronizer($sourceAdapter, $mapper, $destinationAdapter, $logger);
```


## Credits, Copyright and License ##

This project was started at webfactory GmbH, Bonn.

- <http://www.webfactory.de>
- <http://twitter.com/webfactory>

Copyright 2015 webfactory GmbH, Bonn. Code released under [the MIT license](LICENSE).
