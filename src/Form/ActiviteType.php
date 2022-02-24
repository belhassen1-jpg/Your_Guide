<?php

namespace App\Form;

use App\Entity\Activite;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;



class ActiviteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_act')
            ->add('desc_act')
            ->add('lieu')
            ->add('type', EntityType::class,[
                'class'=>Type::class,
                'choice_label'=>'nom_type'
            ])
            ->add('image',FileType::class,[
                'required'=>false,'mapped'=>false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Activite::class,
        ]);
    }
}
