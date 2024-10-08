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
            ->add('branch_id')
            ->add('body')
            ->add('in_group')
            ->add('branch', EntityType::class, [
                'class' => DictBranch::class,
        'choice_label' => 'id',
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
