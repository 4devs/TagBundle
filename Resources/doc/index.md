Getting Started With TagBundle
===========================================

## Installation and usage

Installation and usage is a quick:

1. Download TagBundle using composer
2. Enable the Bundle
3. Use the bundle with SonataAdminBundle
4. Use the bundle
5. Use with another form type and model


### Step 1: Download TagBundle using composer

Add TagBundle in your composer.json:

```js
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


### Step 3: Use the bundle with SonataAdminBundle

add config
``` yaml
# app/config/config.yml
sonata_admin:
    #.....
    dashboard:
        groups:
            label.tags:
                label_catalogue: FDevsTagBundle
                items:
                    - f_devs_tag.admin.tag
```

### Step 4: Use the bundle

``` php
$builder->add('tags', 'fdevs_tag');
```

### Step 5: Use with another form type and model

add custom Model

``` php
namespace Acme\DemoBundle\Model;

use FDevs\TagBundle\ModelBaseTag;
class MyTag extends BaseTag
{
    /**
     * @var string $type
     */
    protected $custom;
....

}
```

add custom form

``` php
namespace Acme\DemoBundle\Form\Type;;

use FDevs\TagBundle\Form\Type\TagType;
class MyFormType extends TagType
{
....
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('custom', 'text');
    }

    public function getParent()
    {
        return 'fdevs_tag';
    }
}
```

add config
``` yaml
# app/config/config.yml
f_devs_tag:
    #....
    model_class:  "Acme\DemoBundle\Model\MyTag"
    form_class:   "Acme\DemoBundle\Form\Type\MyFormTag"
```

