<?php

namespace App\Form;

use App\Entity\Trip;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TripType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('departure', TextType::class, $this->getConfiguration('Ville de départ', 'Renseigne la ville d\'où tu pas'))
            ->add('arrival',  TextType::class, $this->getConfiguration('Ville d\'arrivée', 'Renseigne la ville de destination'))
            ->add('departureDate', DateType::class, $this->getConfiguration('Date de départ', ''))
            ->add('returnDate', DateType::class, $this->getConfiguration('Date de départ', ''))
            ->add('description', TextareaType::class, $this->getConfiguration('Description détaillée du voyage', 'Donne une description complète et attractive du voyage que tu proposes'))
            ->add('numberPersons', IntegerType::class, $this->getConfiguration('Nombre de personnes attendu', 'Indique le nombre de personnes que tu souhaites pour ce voyage...'))
            ->add('coverImage', TextType::class, $this->getConfiguration('Ajoute une image', 'Télécharge une illustration attractive pour le voyage que tu proposes.'))
            ->add('category', EntityType::class, [
                'class' => 'App\Entity\Category',
                'choice_label' => 'name'], $this->getConfiguration('Sélectionne une catégorie de voyage', '')
            );        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trip::class,
        ]);
    }

     /**
     * Avoid to get the basic configuration of a field
     *
     * @param string $label
     * @param string $placeholder
     * @return array
     */
    private function getConfiguration($label, $placeholder)
    {
        return [ 
            'label' => $label,
             'attr' => [
                 'placeholder' => $placeholder           
             ]
        ];
    }
}
