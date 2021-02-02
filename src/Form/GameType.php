<?php

namespace App\Form;

use App\Entity\Console;
use App\Entity\Game;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('releaseYear')
            ->add('editor')
            ->add('console', EntityType::class,[
                // looks for choices from this entity
                'class' => Console::class,       
                // uses the User.username property as the visible option string
                'choice_label' => 'name',
                
                // used to render a select box, check boxes or radios
                  'multiple' => true,
                // 'expanded' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
