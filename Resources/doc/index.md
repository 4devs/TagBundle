Getting Started With Tag Bundle
===============================

## Installation and usage

Installation and usage is a quick:

1. Download bundle using composer
2. Enable the bundle
3. Use the bundle
4. Use with Rest bundle
5. Create Event


### Step 1: Download Locale bundle using composer

Add Locale bundle in your composer.json:

```json
{
    "require": {
        "fdevs/tag-bundle": "*"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update fdevs/tag-bundle
```

Composer will install the bundle to your project's `vendor/fdevs` directory.


### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new FDevs\TagBundle\FDevsTagBundle(),
    );
}
```

### Step 3: Use the bundle


### Step 4: Use with Rest bundle

1. install [FosRestBundle](https://github.com/FriendsOfSymfony/FOSRestBundle/blob/master/Resources/doc/1-setting_up_the_bundle.md) and [NelmioApiDocBundle](https://github.com/nelmio/NelmioApiDocBundle/blob/master/Resources/doc/index.md)
2. add routing

```yaml
f_devs_tag:
    resource: "@FDevsTagBundle/Resources/config/routing.xml"
    type:         rest
```

### Step 5: Create Event

create event

``` php

<?php
// src/AppBundle/EventListener/TagListener.php

<?php

namespace AppBundle\EventListener;

use FDevs\Tag\Event\TagEvent;
use FDevs\Tag\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TagListener implements EventSubscriberInterface
{
    public function postPersist(TagEvent $event)
    {
        //....
    }

    public static function getSubscribedEvents()
    {
        return [
            Events::TAG_POST_PERSIST => 'postPersist',
//            Events::TAG_CREATE => 'create',
//            Events::TAG_PRE_PERSIST => 'prePersist',
        ];
    }

}

```

add event to service container

``` xml

<?xml version="1.0" encoding="UTF-8" ?>
<container xmlns="http://symfony.com/schema/dic/services"
           xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
           xsi:schemaLocation="http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd">

    <parameters>
        <parameter key="app.listener.tag.class">AppBundle\EventListener\TagListener</parameter>
        <!--...-->
    </parameters>

    <services>
        <service id="app.listener.tag" class="%app.listener.tag.class%">
            <tag name="kernel.event_subscriber"/>
        </service>
        <!--...-->
    </services>
</container>

```
