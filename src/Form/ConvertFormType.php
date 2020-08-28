<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class ConvertFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amountFrom', MoneyType::class, [
                'label' => false,
                'required' => false,
                'currency' => 'PLN',
                'invalid_message' => 'To nie jest prawidłowa wartość',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Nic nie wprowadzono',
                    ]),
                  ]
                ])
            ->add('Przelicz', SubmitType::class)
            ->add('amountTo', MoneyType::class, [
                'label' => 'Wynik: ',
                'required' => true,
                'currency' => 'EUR',
                'disabled' => true,
                ])
        ;
    }
}
