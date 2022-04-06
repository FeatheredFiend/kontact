<?php

namespace App\Form;

use App\Entity\ContactHistory;
use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class ContactHistoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contactdatetime', DateTimeType::class,['label' => 'Timestamp'])
            ->add('latitude', TextType::class,['label' => 'Latitude'])
            ->add('longitude', TextType::class,['label' => 'Longitude'])
            ->add('client', EntityType::class,['class' => Client::class, 'query_builder' => function (EntityRepository $er) {return $er->createQueryBuilder('u')->andWhere('u.decommissioned is NULL or u.decommissioned = 0');}, 'choice_label' => 'name', 'label' => 'Client'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContactHistory::class,
        ]);
    }
}
