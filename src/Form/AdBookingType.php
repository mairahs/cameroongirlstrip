<?php

namespace App\Form;

use App\Entity\AdBooking;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\DataTransformer\FrenchToDateTimeTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;                        

class AdBookingType extends ApplicationType
{
    private $transformer;

    public function __construct(FrenchToDateTimeTransformer $transformer)
    {
        $this->transformer = $transformer;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('startDate', TextType::class,$this->getConfiguration('Date d\'arrivée', 'Date à laquelle tu comptes arriver sur les lieux'))
        ->add('endDate', TextType::class,$this->getConfiguration('Date de départ', 'Date à laquelle tu comptes en partir'))
        ->add('comment', TextareaType::class, ['required' => false], $this->getConfiguration(false, 'Si tu as un commentaire ou une info à rajouter, n\'hésites pas...')); 
        $builder->get('startDate')->addModelTransformer($this->transformer);
        $builder->get('endDate')->addModelTransformer($this->transformer);     
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AdBooking::class,
        ]);
    }
}

