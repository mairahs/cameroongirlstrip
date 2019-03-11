<?php

namespace App\Form;

use App\Entity\AdComment;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AdCommentType extends ApplicationType
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
            ], $this->getConfiguration('Note sur 5', 'GirlTripeuse, note le logement que tu as occupé de 0 à 5'))
            
            ->add('content', TextareaType::class, $this->getConfiguration('Ton avis/témoignage', 'N\'hésite pas à être très précise, cela aidera nos futures voyageuses')) ;  
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AdComment::class,
        ]);
    }
}
