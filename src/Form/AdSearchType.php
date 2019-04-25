<?php

namespace App\Form;

use App\Entity\AdOption;
use App\Entity\AdSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
                'label'    => 'Destination '
            ])
            ->add('price', MoneyType::class, [
                'required' => false,
                'label'    => 'Budget maximum ',
                'currency' => 'XAF'
            ])
            ->add('rooms', IntegerType::class, [
                'required' => false,
                'label'    => 'Nombre de chambre souhaité ',
                'attr' => 
                [
                    'min' => 1,
                    'max' => 5,
                    'step' => 1  
                ]
            ])
            ->add('adOptions', EntityType::class,[
                'required'     => false,
                'label'        => 'Sélectionne une ou des options',
                'class'        => AdOption::class,
                'choice_label' => 'name',
                'multiple'     => true
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

    public function getBlockPrefix()
    {
        return '';
    }
}
