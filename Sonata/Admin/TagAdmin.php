<?php

namespace FDevs\TagBundle\Sonata\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class TagAdmin extends Admin
{
    /** @var string */
    private $tagForm = 'fdevs_tag';

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
}
