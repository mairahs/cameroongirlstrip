<?php

namespace App\Form;

use App\Entity\Ad;
use App\Entity\User;
use App\Entity\AdBooking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AdminAdBookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('endDate', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('comment', TextareaType::class)
            ->add('adBooker', EntityType::class, [
                'class'       => User::class,
                'choice_label'=> function($user)
                {
                    return $user->getFirstName().''.\strtoupper($user->getLastName());
                }
            ])
            ->add('ad', EntityType::class, [
                'class'  => Ad::class,
                'choice_label' => 'title'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AdBooking::class,
        ]);
    }
}
