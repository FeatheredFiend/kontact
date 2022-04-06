<?php

namespace App\Form;

use App\Entity\DiseaseSymptom;
use App\Entity\Symptom;
use App\Entity\Disease;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;

class DiseaseSymptomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('disease', EntityType::class,['class' => Disease::class, 'query_builder' => function (EntityRepository $er) {return $er->createQueryBuilder('u');}, 'choice_label' => 'name', 'label' => 'Disease'])
            ->add('symptom', EntityType::class,['class' => Symptom::class, 'query_builder' => function (EntityRepository $er) {return $er->createQueryBuilder('u');}, 'choice_label' => 'name', 'label' => 'Symptom'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DiseaseSymptom::class,
        ]);
    }
}
