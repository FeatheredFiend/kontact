<?php

namespace App\Form;

use App\Entity\TestHistory;
use App\Entity\TestCategory;
use App\Entity\TestLocation;
use App\Entity\Client;
use App\Entity\Laboratory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;

class TestHistoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('testdate', DateType::class,['label' => 'Test Date'])
            ->add('testcategory', EntityType::class,['class' => TestCategory::class, 'query_builder' => function (EntityRepository $er) {return $er->createQueryBuilder('u');}, 'choice_label' => 'name', 'label' => 'Test Category'])
            ->add('client', EntityType::class,['class' => Client::class, 'query_builder' => function (EntityRepository $er) {return $er->createQueryBuilder('u');}, 'choice_label' => 'name', 'label' => 'Client'])
            ->add('testlocation', EntityType::class,['class' => TestLocation::class, 'query_builder' => function (EntityRepository $er) {return $er->createQueryBuilder('u');}, 'choice_label' => 'name', 'label' => 'Test Location'])
            ->add('laboratory', EntityType::class,['class' => Laboratory::class, 'query_builder' => function (EntityRepository $er) {return $er->createQueryBuilder('u');}, 'choice_label' => 'name', 'label' => 'Laboratory'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TestHistory::class,
        ]);
    }
}
