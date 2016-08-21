<?php

namespace FDevs\TagBundle\Form\Type;

use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\Options;

class TagListType extends AbstractType
{
    /** @var string */
    private $parentForm;

    /** @var string */
    private $class;

    /**
     * TagListType constructor.
     *
     * @param string $parentForm
     * @param string $class
     */
    public function __construct($parentForm, $class)
    {
        $this->parentForm = $parentForm;
        $this->class = $class;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'fdevs_tag_list';
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'class' => $this->class,
                'multiple' => true,
                'tag_type' => null,
            ])
            ->setDefined(['tag_type'])
            ->setAllowedTypes('tag_type', ['string', 'null'])
            ->setNormalizer('choices', function (Options $options, $choices) {
                /** @var ObjectRepository $repo */
                $repo = $options['em']->getRepository($options['class']);
                if ($options['tag_type']) {
                    $choices = $repo->findBy(['type' => $options['tag_type']]);
                }

                return $choices;
            });
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return $this->parentForm;
    }
}
