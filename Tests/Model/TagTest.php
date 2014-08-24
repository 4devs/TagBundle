<?php

namespace FDevs\TagBundle\Tests\Model;

use FDevs\TagBundle\Model\Tag;
use FDevs\PageBundle\Model\LocaleText;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TagTest extends WebTestCase
{

    public function testCreatedAt()
    {
        $model = $this->createModel();
        $created = new \DateTime('yesterday');

        $this->assertInstanceOf('DateTime', $model->getCreatedAt());

        $model->setCreatedAt($created);
        $this->assertInstanceOf('DateTime', $model->getCreatedAt());
        $this->assertEquals($created, $model->getCreatedAt());
    }

    public function testType()
    {
        $model = $this->createModel();
        $type = 'base';
        $this->assertNull($model->getType());

        $model->setType($type);
        $this->assertEquals($type, $model->getType());

    }

    public function testId()
    {
        $model = $this->createModel();
        $id = 'base';
        $this->assertNull($model->getId());

        $model->setId($id);
        $this->assertEquals($id, $model->getId());
    }

    public function testName()
    {
        $model = $this->createModel();
        $name = new LocaleText();
        $this->assertInstanceOf('\Doctrine\Common\Collections\Collection', $model->getName());

        $model->addName($name);
        $this->assertEquals($name, $model->getName()->first());
        $this->assertCount(1, $model->getName());
    }


    protected function createModel()
    {
        return new Tag();
    }
}
 