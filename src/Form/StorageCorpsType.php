<?php

namespace App\Form;

use App\Entity\StorageCorps;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StorageCorpsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('sizeAllow', NumberType::class,[
                'data' => 20.00,
            'disabled' => true
            ])
            ->add('path')
            ->add('submit',SubmitType::class, [
                'label' => 'créer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StorageCorps::class,
        ]);
    }
}
