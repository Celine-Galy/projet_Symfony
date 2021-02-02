<?php

namespace App\Form;

use App\Entity\Console;
use App\Entity\Constructor;
use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class ConsoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('releaseYear')
            ->add('images', FileType::class,[
                'label' => 'Image', 
                'multiple' => true,
                'mapped' => false,
                'required'=> false
            ])
            ->add('games', EntityType::class,[
                // looks for choices from this entity
                'class' => Game::class,       
                // uses the User.username property as the visible option string
                'choice_label' => 'name',
                'required'=> false,
                // used to render a select box, check boxes or radios
                'multiple' => true,
                // 'expanded' => true,
            ])
            ->add('constructor', EntityType::class,[
                // looks for choices from this entity
                'class' => Constructor::class,       
                // uses the User.username property as the visible option string
                'choice_label' => 'name',
                'required'=> false,
                // used to render a select box, check boxes or radios
                'multiple' => false,
                // 'expanded' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Console::class,
        ]);
    }
}
