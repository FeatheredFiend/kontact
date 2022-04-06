<?php

namespace App\Form;

use App\Entity\Infection;
use App\Entity\Client;
use App\Entity\Disease;
use App\Entity\TestHistory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;

class EditInfectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('infectiondate', DateType::class,['label' => 'Infection Date'])
            ->add('recovereddate', DateType::class,['label' => 'Recovered Date'])
            ->add('client', EntityType::class,['class' => Client::class, 'query_builder' => function (EntityRepository $er) {return $er->createQueryBuilder('u');}, 'choice_label' => 'name', 'label' => 'Client'])
            ->add('disease', EntityType::class,['class' => Disease::class, 'query_builder' => function (EntityRepository $er) {return $er->createQueryBuilder('u');}, 'choice_label' => 'name', 'label' => 'Disease'])
            ->add('infectiontest', EntityType::class,['class' => TestHistory::class, 'query_builder' => function (EntityRepository $er) {return $er->createQueryBuilder('u');}, 'choice_label' => 'id', 'label' => 'Infection Test'])
            ->add('recoveredtest', EntityType::class,['class' => TestHistory::class, 'query_builder' => function (EntityRepository $er) {return $er->createQueryBuilder('u');}, 'choice_label' => 'id', 'label' => 'Recovered Test'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Infection::class,
        ]);
    }
}
