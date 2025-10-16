<?php

namespace App\Form;

use App\Entity\Instrumento;
use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfesorInstrumentoformType extends AbstractType
{ private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

          // Consulta a la base de datos para obtener las opciones
          $repository = $this->em->getRepository(Instrumento::class);
          $tuplas = $repository->findAll();
  
          // Transformar las tuplas en opciones para el select
          $instrumentos = [];
          foreach ($tuplas as $tupla) {
              $instrumentos[$tupla->getNombre()] = $tupla->getId(); 
          }
  
        $builder
            ->add('instrumento', ChoiceType::class, [
                'choices' => $instrumentos, // Opciones dinámicas
                'choice_label' => function ($value, $key, $index) {
                    return $key; // Devuelve el texto visible
                },
                'choice_value' => function ($value) {
                    return $value; // Devuelve el valor del option
                },
                'placeholder' => 'Seleccione una opción',
            ])
            ->add('seleccionar', SubmitType::class, ['label' => 'Añadir']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'instrumentos' => []
        ]);
    }
}

