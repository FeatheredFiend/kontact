<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Address;
use App\Form\AddressType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;



class ClientType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,['label' => 'Name'])
            ->add('birthdate', BirthdayType::class,['label' => 'Date of Birth'])
            ->add('phonenumber', TextType::class,['label' => 'Phonenumber'])
            ->add('emailaddress', TextType::class,['label' => 'Email Address'])
            ->add('healthservice', TextType::class,['label' => 'Healthservice ID'])
            ->add('addressform', AddressType::class,['label' => "Address",'mapped' => false,'required' => false])
            ->add('address', EntityType::class,['class' => Address::class, 'query_builder' => function (EntityRepository $er) {return $er->createQueryBuilder('u');}, 'choice_label' => 'addressline1', 'label' => 'Address'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
