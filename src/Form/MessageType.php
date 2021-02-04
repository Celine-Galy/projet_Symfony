<?php

namespace App\Form;

use App\Entity\Message;
use App\Entity\Game;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subject', TextType::class,[
                'mapped' => false,
            ])
            ->add('content',CKEditorType::class)
            
            ->add('game', EntityType::class,[
                 // looks for choices from this entity
                'class' => Game::class,       
                'choice_label' => 'name',
                'placeholder' => 'choisir un jeu'
                 
                 // used to render a select box, check boxes or radios
                 // 'multiple' => true,
                 // 'expanded' => true,
            ])
            
            
        ;
    } 

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
