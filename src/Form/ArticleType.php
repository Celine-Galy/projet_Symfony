<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Article;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('title')
        ->add('content', CKEditorType::class)
        ->add('images', FileType::class,[
            'label' => 'Image', 
            'multiple' => true,
            'mapped' => false,
            'required'=> false
        ])
        ->add('category', EntityType::class,[
            // looks for choices from this entity
            'class' => Category::class,       
            // uses the User.username property as the visible option string
            'choice_label' => 'name',
            
            // used to render a select box, check boxes or radios
            // 'multiple' => true,
            // 'expanded' => true,
        ])
        ->add('author', EntityType::class,[
            // looks for choices from this entity
            'class' => User::class,       
            // uses the User.username property as the visible option string
            'choice_label' => 'name',
            
            // used to render a select box, check boxes or radios
            // 'multiple' => true,
            // 'expanded' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
