<?php

namespace App\Form;

use App\Entity\Tags;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\dataTransformer\TagsTransformer;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use App\Repository\TagsRepository;
use Doctrine\Common\Persistence\ObjectManager;

class TagType extends AbstractType
{
    /**
     * @var ObjectManager
     */
    private $manager;
    function __construct(ObjectManager $manager)
    {
        $this->manager = $manager; 
         
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new CollectionToArrayTransformer(),true)
                ->addModelTransformer(new TagsTransformer($this->manager),true)
                ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tags::class,
        ]);
    }
    public function getParent()
    {
        return TextType::class;
    }

}
