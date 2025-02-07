<?php

namespace App\Form;

use App\Entity\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\FileType as ClassFileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File as FileContrain;

class FileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('file',   ClassFileType::class,
            [
                'mapped' => false,
                'constraints' =>[
                new FileContrain([
                    'maxSize' => '1024k',
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/png',
                                'image/gif',
                                'text/plain',
                            ],
                            'mimeTypesMessage' => 'Seuls les fichiers texte (.txt) et les images (.jpg, .jpeg, .png, .gif) sont autorisés.',
            
                    ]
                )]

            ])

            // ->add('path')
            // ->add('size')
            // ->add('date_upload', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('extension')
            // ->add('archiver')

            ->add('Submit', SubmitType::class, [
                'label' => '+ ajoute fichier'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => File::class,
        ]);
    }
}
