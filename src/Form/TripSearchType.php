<?php

namespace App\Form;

use App\Entity\TripSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class TripSearchType extends AbstractType
{
        
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('departureDate', DateType::class, [
                'format'   => 'dd/MM/yyyy',
                'widget'   => 'single_text',
                'required' => false,
                'label'    => false,
                'html5'    => false,
                'attr'     => [
                    'placeholder' => 'Quand souhaites-tu partir ?'
                ]
            ])
            ->add('arrival',  TextType::class, [
                'required' => false,
                'label'    => false,
                'attr'     => [
                    'placeholder' => 'Où souhaites-tu aller ?'
                ]
            ])
            ->add('price', MoneyType::class, [
                'required' => false,
                'label'    => false,
                'currency' => 'XAF',
                'attr'     => [
                    'placeholder' => 'Quel est ton budget max ?'
                ]
            ]);
           
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => TripSearch::class,
            'method'          => 'get',
            'csrf_protection' => false
        ]);
    }
}
