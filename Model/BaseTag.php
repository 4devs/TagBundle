<?php

namespace FDevs\TagBundle\Model;

/**
 * FDevs\TagBundle\Model\Tag
 */
abstract class BaseTag
{
    /**
     * @var \MongoId $id
     */
    protected $id;

    /**
     * @var \DateTime $createdAt
     */
    protected $createdAt;

    /**
     * @var string $type
     */
    protected $type;

    /**
     * @var \FDevs\PageBundle\Model\LocaleText
     */
    protected $name = [];

    public function __construct()
    {
        $this->name = new \Doctrine\Common\Collections\ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id ?: 'new';
    }

    /**
     * Get id
     *
     * @return string $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id
     *
     * @param string $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set createdAt
     *
     * @param date $createdAt
     *
     * @return self
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return date $createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add name
     *
     * @param \FDevs\PageBundle\Model\LocaleText $name
     */
    public function addName(\FDevs\PageBundle\Model\LocaleText $name)
    {
        $this->name[] = $name;
    }

    /**
     * Remove name
     *
     * @param \FDevs\PageBundle\Model\LocaleText $name
     */
    public function removeName(\FDevs\PageBundle\Model\LocaleText $name)
    {
        $this->name->removeElement($name);
    }

    /**
     * Get name
     *
     * @return \Doctrine\Common\Collections\Collection $name
     */
    public function getName()
    {
        return $this->name;
    }

}
