<?php

namespace App\Form;

use App\Entity\TripBooking;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TripBookingType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numberPlaces', IntegerType::class, $this->getConfiguration('Nombre de places', 'Pour combien de personnes fais-tu la réservation ?'))
            ->add('comment',  TextareaType::class, $this->getConfiguration( false , 'Si tu as un commentaire ou une info à rajouter, n\'hésites pas...')); 
        ; 
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TripBooking::class,
        ]);
    }
}
