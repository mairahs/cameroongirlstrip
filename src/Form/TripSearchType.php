<?php

namespace App\Form;

use App\Entity\TripOption;
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
                'label'    => 'Date de départ',
                'html5'    => false
            ])
            ->add('arrival',  TextType::class, [
                'required' => false,
                'label'    => 'Destination'
            ])
            ->add('price', MoneyType::class, [
                'required' => false,
                'label'    => 'Budget maximum',
                'currency' => 'XAF'
            ])
            ->add('tripOptions', EntityType::class,[
                'required'     => false,
                'label'        => 'Sélectionne une ou des options',
                'class'        => TripOption::class,
                'choice_label' => 'name',
                'multiple'     => true
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

    public function getBlockPrefix()
    {
        return '';
    }
}
