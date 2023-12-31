<?php

namespace App\Form;
use App\Entity\Equipment;
use App\Entity\Publication;

use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('username', null, ['label' => 'Chercheurs de projets'])
            ->add('description')
            ->add('startDate')
            ->add('endDate')
            ->add('equipments', EntityType::class, [
                'class' => Equipment::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true, // Add this line
                'by_reference' => false,

            ])
            ->add('publications', EntityType::class, [
                'class' => Publication::class,
                'choice_label' => 'title',
                'multiple' => true,
                'expanded' => true, // render as checkboxes
                'by_reference' => false,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
            'form_theme' => 'equipmentCreate.html.twig',

        ]);
    }
}