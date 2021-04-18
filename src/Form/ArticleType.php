<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\User;
use App\Entity\Article;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('title',TextType::class,[
            'label'=>'Titre'
        ])
        ->add('content', CKEditorType::class,[
            'label'=>'Contenu'
        ])
        ->add('images', FileType::class,[
            'label' => 'Image', 
            'multiple' => true,
            'mapped' => false,
            'required'=> false
        ])
        ->add('game', EntityType::class,[
            'class' => Game::class,
            'choice_label' => 'name',
            'label' => 'Jeu'
        ])
        ->add('category', EntityType::class,[
            // looks for choices from this entity
            'class' => Category::class,       
            // uses the User.username property as the visible option string
            'choice_label' => 'name',
            'label' => 'Catégorie'
            
            // used to render a select box, check boxes or radios
            // 'multiple' => true,
            // 'expanded' => true,
        ])
        ->add('author', EntityType::class,[
            // looks for choices from this entity
            'class' => User::class,       
            // uses the User.username property as the visible option string
            'choice_label' => 'pseudo',
            'label' => 'Pseudo'
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
