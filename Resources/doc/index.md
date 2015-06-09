Getting Started With Tag Bundle
===============================

## Installation and usage

Installation and usage is a quick:

1. Download bundle using composer
2. Enable the bundle
3. Use the bundle
4. Use with Rest bundle
5. Create Event
6. Use with [SonataAdminBundle](https://github.com/sonata-project/SonataAdminBundle)


### Step 1: Download Tag bundle using composer

Add Tag bundle in your composer.json:

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
        new FDevs\LocaleBundle\FDevsLocaleBundle(),
        new FDevs\TagBundle\FDevsTagBundle(),
    );
}
```

add type tags

```yaml
#app/config/config.yml
f_devs_tag:
    type_list:
        skill: 'Skill'
```

### Step 3: Basic usage the bundle

add tag your model

``` php
<?php
///src/FDevs/CatalogBundle/Model/Item.php
namespace FDevs\CatalogBundle\Model;

use FDevs\Tag\TagInterface;
use Doctrine\Common\Collections\Collection;

class Item
{
//....

    /**
     * @var array|Collection|TagInterface[]
     */
    protected $tags = [];

    /**
     * Add tag
     *
     * @param TagInterface $tag
     */
    public function addTag(TagInterface $tag)
    {
        $this->tags[] = $tag;
    }

    /**
     * Remove tag
     *
     * @param TagInterface $tag
     */
    public function removeTag(TagInterface $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return array|Collection|TagInterface $tags
     */
    public function getTags()
    {
        return $this->tags;
    }
}
```

add tags to doctrine mongodb

``` xml
<!--src/FDevs/CatalogBundle/Resources/config/doctrine/model/Item.mongodb.xml-->
<?xml version="1.0" encoding="UTF-8"?>
<doctrine-mongo-mapping xmlns="http://doctrine-project.org/schemas/odm/doctrine-mongo-mapping"
                        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                        xsi:schemaLocation="http://doctrine-project.org/schemas/odm/doctrine-mongo-mapping
                        http://doctrine-project.org/schemas/odm/doctrine-mongo-mapping.xsd">

    <document name="FDevs\CatalogBundle\Model\Item" collection="items">

        <reference-many target-document="FDevs\Tag\Model\Tag" field="tags"/>

    </document>

</doctrine-mongo-mapping>

```

add tag edit your form

``` php
<?php
//src/FDevs/CatalogBundle/Form/Type/ItemType.php

namespace FDevs\CatalogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ItemType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tags', 'document', ['multiple' => true])
        ;
    }
}
```


### Step 4: Use with Rest bundle

1. install [FosRestBundle](https://github.com/FriendsOfSymfony/FOSRestBundle/blob/master/Resources/doc/1-setting_up_the_bundle.md) and [NelmioApiDocBundle](https://github.com/nelmio/NelmioApiDocBundle/blob/master/Resources/doc/index.md)
2. add routing

```yaml
#app/config/routing.yml
f_devs_tag:
    resource: "@FDevsTagBundle/Resources/config/routing.xml"
    type:         rest
```

### Step 5: Create Event

create event

``` php
<?php
// src/AppBundle/EventListener/TagListener.php

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

### Step 5: Use with SonataAdminBundle

1. install [SonataAdminBundle](https://github.com/sonata-project/SonataAdminBundle)
2. enable sonata

```yaml
#app/config/config.yml
f_devs_tag:
    //.....
    admin_driver: "sonata"
    
sonata_admin:
    dashboard:
        groups:
            label.tags:
                label_catalogue: FDevsTagBundle
                items: [f_devs_tag.admin.tag]
```
