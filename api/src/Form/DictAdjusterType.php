<?php

namespace App\Form;

use App\Entity\DictAdjuster;
use App\Entity\DictBranch;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DictAdjusterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('body', null, [
                'label' => 'Name',
                'attr' => ['class' => 'form-control mb-1']
            ])
            ->add('inGroup', null, [
                'label' => 'Group',
                'attr' => ['class' => 'form-control mb-1']
            ])
            ->add('branch', EntityType::class, [
                'class' => DictBranch::class,
                'attr' => ['class' => 'form-control mb-3'],
                'choice_label' => 'body',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DictAdjuster::class,
        ]);
    }
}
