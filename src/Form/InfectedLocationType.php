<?php

namespace App\Form;

use App\Entity\InfectedLocation;
use App\Entity\Infection;
use App\Entity\ContactHistory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class InfectedLocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contacthistory', EntityType::class,['class' => ContactHistory::class, 'query_builder' => function (EntityRepository $er) {return $er->createQueryBuilder('u');}, 'choice_label' => 'id', 'label' => 'Contact History'])
            ->add('infection', EntityType::class,['class' => Infection::class, 'query_builder' => function (EntityRepository $er) {return $er->createQueryBuilder('u');}, 'choice_label' => 'id', 'label' => 'Infection'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InfectedLocation::class,
        ]);
    }
}
