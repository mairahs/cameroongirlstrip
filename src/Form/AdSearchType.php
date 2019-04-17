<?php

namespace App\Form;

use App\Entity\AdSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class AdSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('location', TextType::class, [
                'required' => false,
                'label'    => false,
                'attr'     => [
                    'placeholder' => 'Où souhaites-tu louer ?'
                ]
            ])
            ->add('price', MoneyType::class, [
                'required' => false,
                'label'    => false,
                'currency' => 'XAF',
                'attr'     => [
                    'placeholder' => 'Quel est ton budget max ?'
                ]
            ])
            ->add('rooms', IntegerType::class, [
                'required' => false,
                'label'    => false,
                'attr' => 
                [
                    'min' => 1,
                    'max' => 5,
                    'step' => 1,
                    'placeholder' => 'Combien de chambres souhaites-tu ?'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => AdSearch::class,
            'method'          => 'get',
            'csrf_protection' => false
        ]);
    }
}
