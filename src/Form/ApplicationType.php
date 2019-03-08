<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;


class ApplicationType extends AbstractType
{
    /**
     * Avoid to get the basic configuration of a field
     *
     * @param string $label
     * @param string $placeholder
     * @return array
     */
    protected function getConfiguration($label, $placeholder)
    {
        return [ 
            'label' => $label,
             'attr' => [
                 'placeholder' => $placeholder           
             ]
        ];
    }

    /**
     * Avoid to get the basic configuration of a field with currency
     *
     * @param string $label
     * @param string $placeholder
     * @param string $currency
     * @return array
     */

    protected function getConfigurationBis($label, $placeholder, $currency)
    {
        return [ 
            'label' => $label,
             'attr' => [
                 'placeholder' => $placeholder           
             ],
            'currency' => $currency           
        ];
    }
}