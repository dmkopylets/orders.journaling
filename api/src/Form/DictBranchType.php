<?php

namespace App\Form;

use App\Entity\DictBranch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DictBranchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
//            ->add('id', null, [
//                'attr' => ['class' => 'form-control mb-1']
//            ])
            ->add('body', null, [
                'attr' => ['class' => 'form-control mb-1']
            ])
            ->add('prefix', null, [
                'attr' => ['class' => 'form-control mb-3']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DictBranch::class,
        ]);
    }
}
