<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\UserOption;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RegistrationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, $this->getConfiguration('Ton prénom', 'Renseigne ton prénom'))
            ->add('lastName', TextType::class, $this->getConfiguration('Ton nom', 'Renseigne ton nom de famille'))
            ->add('email', EmailType::class, $this->getConfiguration('Ton email', 'Renseigne ton adresse email') )
            ->add('avatarFile', FileType::class, [
                'required' => false
            ] )
            ->add('hash', PasswordType::class, $this->getConfiguration('Ton mot de passe', 'Renseigne ton mot de passe'))
            ->add('passwordConfirm', PasswordType::class, $this->getConfiguration('Confirme ton mot de passe', 'Renseigne à nouveau ton mot de passe'))
            ->add('introduction', TextType::class, $this->getConfiguration('Qui est tu ?', 'Présente toi en quelques mots aux autres GirlsTripeuses'))
            ->add('description', TextareaType::class, $this->getConfiguration('Et dans le détail ?', 'Dis nous en un peu plus sur toi... Quels sont tes hobbies ? tes passions ? tes coups de gueule ?') )
            ->add('userOptions', EntityType::class,[
                'class'        => UserOption::class,
                'label'        => 'Sélectionne ton/tes hobbies',
                'choice_label' => 'name',
                'multiple'     => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
