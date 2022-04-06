<?php

namespace App\Form;

use App\Entity\InfectionSymptom;
use App\Entity\Symptom;
use App\Entity\Infection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;

class InfectionSymptomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('infection', EntityType::class,['class' => Infection::class, 'query_builder' => function (EntityRepository $er) {return $er->createQueryBuilder('u');}, 'choice_label' => 'id', 'label' => 'Infection'])
            ->add('symptom', EntityType::class,['class' => Symptom::class, 'query_builder' => function (EntityRepository $er) {return $er->createQueryBuilder('u');}, 'choice_label' => 'name', 'label' => 'Symptom'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InfectionSymptom::class,
        ]);
    }
}
