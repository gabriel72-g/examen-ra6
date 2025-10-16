<?php

namespace App\Form;

use App\Entity\instrumento;
use App\Entity\Usuario;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UsuarioformType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username',TextType::class,
            ['label'=>'','attr'=>['class'=>'form-control mt-3']]
            )
            ->add('nombre_apellidos',TextType::class,
            ['label'=>'','attr'=>['class'=>'form-control mt-3']]
            )
            ->add('plainPassword',PasswordType::class,
            ['attr' =>['class'=>'form-control mt-3','autocomplete'=>'new-password'],
            'mapped' => false,
            'label'=>'Contraseña',
            'constraints'=>[
                new NotBlank([
                    'message' =>'Please enter a password',
                ]),
                new Length([
                    'min' => 3,
                    'minMessage' => 'Your password should be at least {{ limit }} characters',
                    // max length allowed by Symfony for security reasons
                    'max' => 4096,
                ]),
            ],
            ])
            ->add('profesor', CheckboxType::class,
            ['label' => '¿Profesor?','attr'=>['class'=>'form-check-input'],'required'=>false])
            ->add('registrar', SubmitType::class, 
            ['label' => 'Registrarse', 
            'attr' =>['class' => 'btn btn-primary']])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}
