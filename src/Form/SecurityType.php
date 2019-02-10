<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SecurityType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, $this->getConfiguration('Ton prénom', 'Modifie ton prénom'))
            ->add('lastName',  TextType::class, $this->getConfiguration('Ton nom', 'Modifie ton nom'))
            ->add('email',  EmailType::class, $this->getConfiguration('Ton email', 'Modifie ton adresse email'))
            ->add('picture', UrlType::class, $this->getConfiguration('Modifie ton avatar', 'Renseigne l\'url de ta photo de profil'))
            ->add('introduction', TextType::class, $this->getConfiguration('Qui es tu ?', 'Modifie ta petite présentation'))
            ->add('description', TextareaType::class, $this->getConfiguration('Et dans le détail ?', 'Modifie ta présentation détaillée'))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
