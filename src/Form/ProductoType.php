<?php

namespace App\Form;

use App\Entity\Producto;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProductoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('imagen',  FileType::class, [
                'label'=>'Imagen (JPG o PNG)',
                'label_attr'=>['class'=>'etiqueta'],
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
            ->add('precio')
            ->add('precioAntiguo')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Producto::class,
        ]);
    }
}
