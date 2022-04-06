<?php

namespace App\Form;

use App\Entity\ActionLog;
use App\Entity\DataTable;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Doctrine\ORM\EntityRepository;

class ActionLogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rownumber', TextType::class,['label' => 'Row'])
            ->add('timestamp', DateType::class,['label' => 'Timestamp'])
            ->add('action', TextType::class,['label' => 'Action'])
            ->add('datatable', EntityType::class,['class' => DataTable::class, 'query_builder' => function (EntityRepository $er) {return $er->createQueryBuilder('u');}, 'choice_label' => 'name', 'label' => 'Table'])
            ->add('user', EntityType::class,['class' => User::class, 'query_builder' => function (EntityRepository $er) {return $er->createQueryBuilder('u')->andWhere('u.decommissioned is NULL or u.decommissioned = 0');}, 'choice_label' => 'name', 'label' => 'User'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ActionLog::class,
        ]);
    }
}
