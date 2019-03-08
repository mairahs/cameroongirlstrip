<?php

namespace App\Form;

use App\Entity\Ad;
use App\Form\ImageType;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AnnonceType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration('Titre de l\'annonce', 'Renseigne un titre accrocheur pour ton annonce'))
            ->add('location', TextType::class, $this->getConfiguration('Localisation du bien', 'Renseigne la ville dans laquelle se situe ton bien'))
            ->add('introduction', TextType::class, $this->getConfiguration('Introduction', 'Renseigne une description sommaire de ton bien (type, localisation..)'))
            ->add('content', TextareaType::class, $this->getConfiguration('Description détaillée', 'Donne une description complète et attractive de ton bien'))
            ->add('coverImage', TextType::class, $this->getConfiguration('Image de couverture', 'Télécharge une illustration attractive pour ton bien.'))
            ->add('rooms', IntegerType::class, $this->getConfiguration('Nombre de chambre', 'Renseigne le nombre de chambre disponible'))
            ->add('price', MoneyType::class, $this->getConfigurationBis('Prix par nuit', 'Renseigne un tarif pour la nuit','XAF'))
            ->add('images', CollectionType::class, [
                'entry_type' => ImageType::class,
                'allow_add'  => true,
                'allow_delete'  => true
            ])
            ;
                 
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }

}
