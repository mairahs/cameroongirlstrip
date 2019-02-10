<?php

namespace App\Form;

use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class PasswordUpdateType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class, $this->getConfiguration('Ton ancien mot de passe', 'Renseigne ton ancien mot de passe') )
            ->add('newPassword', PasswordType::class, $this->getConfiguration('Ton nouveau mot de passe', 'Renseigne ton nouveau mot de passe') )
            ->add('confirmPassword', PasswordType::class, $this->getConfiguration('Confirme ton nouveau mot de passe', 'Renseigne encore ton nouveau mot de passe') )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
