<?php

namespace App\Form;

use App\Entity\Trip;
use App\Entity\Category;
use App\Entity\TripOption;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use App\Form\DataTransformer\FrenchToDateTimeTransformer;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TripType extends ApplicationType
{
    private $transformer;

    public function __construct(FrenchToDateTimeTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('departure', TextType::class, $this->getConfiguration('Ville de départ', 'Renseigne la ville de départ'))
            ->add('arrival',  TextType::class, $this->getConfiguration('Ville d\'arrivée', 'Renseigne la ville de destination'))
            ->add('departureDate', TextType::class, $this->getConfiguration('Date de ton départ', 'Renseigne la date de ton départ'))
            ->add('tripHour', TimeType::class, $this->getConfiguration('Heure de départ du voyage', 'Renseigne l\'horaire de départ'))
            ->add('returnDate', TextType::class, $this->getConfiguration('Date de ton retour', 'Renseigne la date de ton retour'))
            ->add('description', TextareaType::class, $this->getConfiguration('Description détaillée du voyage', 'Donne une description complète et attractive du voyage que tu proposes'))
            ->add('fixedNumberPersons', IntegerType::class, ['attr' => 
                [
                'min'  => 2,
                'max'  => 5,
                'step' => 1
                ]
            ], $this->getConfiguration('Nombre de personnes attendu', 'Indique le nombre de personnes que tu souhaites pour ce voyage...'))
            ->add('price', MoneyType::class, $this->getConfigurationBis('Prix du voyage', 'Renseigne un prix global pour le voyage','XAF'))
            ->add('imageFile', FileType::class, [
                'required' => false
            ] )
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name']
            )
            ->add('tripOptions', EntityType::class,[
                'class'        => TripOption::class,
                'choice_label' => 'name',
                'multiple'     => true
            ])
            ->add('lat', HiddenType::class)
            ->add('lng', HiddenType::class); 
            
        $builder->get('departureDate')->addModelTransformer($this->transformer);
        $builder->get('returnDate')->addModelTransformer($this->transformer);        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trip::class,
        ]);
    }
}
