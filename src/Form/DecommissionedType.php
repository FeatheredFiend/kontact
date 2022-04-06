<?php

namespace App\Form;

use App\Entity\Decommissioned;
use App\Entity\DataTable;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class DecommissionedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rownumber', TextType::class,['label' => 'Row Number'])
            ->add('decommissioneddate', DateType::class,['label' => 'Decommissioned Date'])
            ->add('datatablename', EntityType::class,['class' => DataTable::class, 'query_builder' => function (EntityRepository $er) {return $er->createQueryBuilder('u');}, 'choice_label' => 'name', 'label' => 'Table Name'])
            ->add('user', EntityType::class,['class' => User::class, 'query_builder' => function (EntityRepository $er) {return $er->createQueryBuilder('u')->andWhere('u.decommissioned is NULL or u.decommissioned = 0');}, 'choice_label' => 'name', 'label' => 'Decommissioned By'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Decommissioned::class,
        ]);
    }
}
