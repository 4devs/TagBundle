<?php

namespace FDevs\TagBundle\Sonata\Admin;

use FDevs\Tag\Form\Type\TagType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use FDevs\Tag\TagManagerInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class TagAdmin extends AbstractAdmin
{
    /** @var string */
    private $tagForm = TagType::class;

    /** @var string */
    protected $baseRouteName = 'sonata_admin_tag';

    /** @var string */
    protected $baseRoutePattern = 'tag';

    /** @var TagManagerInterface */
    private $tagManager;

    /**
     * {@inheritdoc}
     */
    public function getNewInstance()
    {
        return $this->tagManager->createTag();
    }


    /**
     * {@inheritdoc}
     */
    public function create($object)
    {
        $this->tagManager->updateTag($object);

        return parent::create($object);
    }

    /**
     * {@inheritdoc}
     */
    public function update($object)
    {
        $this->tagManager->updateTag($object);

        return parent::update($object);
    }


    /**
     * @param TagManagerInterface $manager
     *
     * @return $this
     */
    public function setTagManager(TagManagerInterface $manager)
    {
        $this->tagManager = $manager;

        return $this;
    }

    /**
     * set Tag form
     *
     * @param string $tagForm
     *
     * @return $this
     */
    public function setTagForm($tagForm)
    {
        $this->tagForm = $tagForm;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('form.edit_tags', ['translation_domain' => 'FDevsTagBundle'])
                ->add('tags', $this->tagForm, ['inherit_data' => true, 'label' => false, 'translation_domain' => 'FDevsTagBundle'])
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('name')
            ->add('type')
            ->add('slug');
    }
}
