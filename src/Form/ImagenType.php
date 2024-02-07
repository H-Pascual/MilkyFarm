<?php

namespace App\Form;

use App\Entity\Imagen;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Categoria;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ImagenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre',  FileType::class, [
                'label' => 'Imagen (JPG o PNG)',
                'label_attr' => ['class' => 'etiqueta'],
                'data_class' => null,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Por favor, seleccione un archivo jpg o png',
                    ])
                ]
            ])
            ->add('descripcion', TextType::class, ['label' => 'Descripción', 'label_attr' => ['class' => 'etiqueta']])
            ->add('fecha', DateType::class, ['widget' => 'single_text'])
            ->add('categoria', EntityType::class, [
                'class' => Categoria::class
            ])
            ->add('numVisualizaciones', NumberType::class, ['label' => 'Número de visualizaciones:', 'label_attr' => ['class' => 'etiqueta']])
            ->add('numLikes', NumberType::class, ['label' => 'Número de likes:', 'label_attr' => ['class' => 'etiqueta']])
            ->add('numDownloads', NumberType::class, ['label' => 'Número de downloads:', 'label_attr' => ['class' => 'etiqueta']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Imagen::class,
        ]);
    }
}
