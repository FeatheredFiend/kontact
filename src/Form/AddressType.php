<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('addressline1', TextType::class,['label' => 'Address Line 1'])
            ->add('addressline2', TextType::class,['label' => 'Address Line 2'])
            ->add('addressline3', TextType::class,['label' => 'Address Line 3'])
            ->add('addressline4', TextType::class,['label' => 'Address Line 4'])
            ->add('addressline5', TextType::class,['label' => 'Address Line 5'])
            ->add('addressline6', TextType::class,['label' => 'Address Line 6'])
            ->add('latitude', TextType::class,['label' => 'Latitude'])
            ->add('longitude', TextType::class,['label' => 'Longitude'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
