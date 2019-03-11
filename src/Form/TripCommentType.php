<?php

namespace App\Form;

use App\Entity\TripComment;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TripCommentType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           
            ->add('rating', IntegerType::class, ['attr' => 
                [
                'min' => 0,
                'max' => 5,
                'step' => 1
                ]
            ], $this->getConfiguration('Note sur 5', 'GirlTripeuse, GirlTripeuse, note le voyage auquel tu as participé entre 0 et 5'))
            
            ->add('content', TextareaType::class, $this->getConfiguration('Ton avis/témoignage', 'N\'hésite pas à être très précise, cela aidera nos futures voyageuses')) ;  
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TripComment::class,
        ]);
    }
}
