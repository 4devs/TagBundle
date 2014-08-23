<?php

namespace FDevs\TagBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TagType extends AbstractType
{
    private $types = [];

    /**
     * init
     *
     * @param array $types
     */
    public function __construct(array $types)
    {
        $this->types = $types;
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'text')
            ->add('name', 'translatable')
            ->add('type', 'choice', ['choices' => array_combine($this->types, $this->types)]);
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            ['data_class' => 'FDevs\TagBundle\Model\Tag']
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'fdevs_tag';
    }

}
