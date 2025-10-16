<?php

namespace App\Form;

use App\Entity\Instrumento;
use App\Entity\Matricula;
use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AlumnoformType extends AbstractType
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('alumnoMatricula', EntityType::class, [
                'class' => Usuario::class,
                'choice_label' => 'nombre_apellidos',
                'placeholder' => 'Seleccione un alumno',
                'query_builder' => function ($repo) {
                    return $repo->createQueryBuilder('u')
                        ->where('u.profesor = false'); // Solo alumnos, no profesores
                },
            ])
            ->add('instrumentoMatricula', EntityType::class, [
                'class' => Instrumento::class,
                'choice_label' => 'nombre',
                'placeholder' => 'Seleccione un instrumento',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Matricula::class,
        ]);
    }
}