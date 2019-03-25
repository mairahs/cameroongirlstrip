<?php

namespace App\Form;

use App\Entity\Trip;
use App\Entity\User;
use App\Entity\TripBooking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AdminTripBookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numberPlaces', IntegerType::class, ['attr' =>
                ['min' => 1,
                'max' => 5,
                'step'=> 1
                ]
            ])
            ->add('comment', TextareaType::class)
            ->add('tripBooker', EntityType::class, [
                    'class'       => User::class,
                    'choice_label'=> function($user)
                {
                    return $user->getFirstName().' '.\strtoupper($user->getLastName());
                }
            ])
            ->add('trip', EntityType::class, [
                  'class'        => Trip::class,
                  'choice_label' => function($trip)
                  {
                      return $trip->getDeparture().'-'. $trip->getArrival();
                  }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TripBooking::class,
        ]);
    }
}
