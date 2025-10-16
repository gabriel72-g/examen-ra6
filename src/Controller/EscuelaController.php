<?php

namespace App\Controller;

use App\Entity\Instrumento;
use App\Entity\Matricula;
use App\Form\AlumnoformType;
use App\Form\InstrumentoformType;
use App\Form\ProfesorInstrumentoformType;
use App\Repository\InstrumentoRepository;
use App\Repository\MatriculaRepository;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Proxies\__CG__\App\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
final class EscuelaController extends AbstractController
{
    #[Route('/escuela', name: 'app_escuela')]
    public function index(): Response
    {
        if($this->getUser()->isProfesor()){
            return $this->redirectToRoute('app_profesor');
        }else{
            return $this->redirectToRoute('app_alumno');
        }
    }

    #[Route('/escuela/alumno', name: 'app_alumno')]
    public function alumnos():Response
    {
        $usuario = $this->getUser();

        $matriculas = $usuario->getMatriculas();
        return $this->render('escuela/alumno.html.twig',[
            'matricula'=>$matriculas
        ]);
    }
    

    #[Route('/escuela/profesor', name: 'app_profesor')]
    public function mostrar(Request $request):Response
    {
                // Crear el formulario
                $form = $this->createForm(ProfesorInstrumentoformType::class);

                // Procesar la solicitud
                $form->handleRequest($request);
        
                // Si el formulario fue enviado y es válido
                if ($form->isSubmitted() && $form->isValid()) {
                    // Obtener los datos enviados
                    $data = $form->getData();
        
                    // Aquí puedes hacer algo con el dato seleccionado
                    $idInstrumentoSeleccionado = $data['instrumento']; // el ID del instrumento
        
                    // Por ejemplo, podrías redirigir o hacer alguna acción
                    $this->addFlash('success', 'Instrumento seleccionado: ' . $idInstrumentoSeleccionado);
        
                    return $this->redirectToRoute('seleccionar_instrumento');
                }
        
        
        return $this->render('escuela/profesor.html.twig',[
            'formulario' => $form->createView(),
        ]);
    }
    #[Route('/escuela/profesor/alumnos', name: 'app_mostrar_alumnos')]
    
    public function mostrar_alumnos(UsuarioRepository $usuariorepository, Request $request,  EntityManagerInterface $em):Response
    {
        $matricula = new Matricula();
        $form = $this->createForm(AlumnoformType::class, $matricula);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($matricula);
            $em->flush();

            return $this->redirectToRoute('app_mostrar_alumnos');
        }
        
        $alumnos = $usuariorepository->findBy(['profesor'=>false]);
        return $this->render('escuela/alumnos.html.twig',[
            'alumnos'=>$alumnos,
            'formulario' => $form->createView(),
        ]);
    }
    #[Route('/escuela/alumnos/{id}/instrumentos', name: 'app_matricula_alumno')]
    public function matriculadealumnos(int $id, MatriculaRepository $matriculaRepository ):Response
    {

        $matricula = $matriculaRepository->findBy(['alumnoMatricula' => $id]);

        return $this->render('escuela/matriculaalumnos.html.twig',[
            'titulo' => 'Alumnos',
            'matri'=>$matricula
        ]);
    }


    #[Route('/escuela/alumno', name: 'app_alumnos_del_profesor')]
    public function mostraralumnos():Response
    {
        return $this->render('Profesor.html.twig');
    }
    #[Route('/escuela/instrumento', name: 'app_instrumento')]
    public function instrumento(Request $request, EntityManagerInterface $em):Response
    {
        $instrumento = new Instrumento();
        $form = $this->createForm(InstrumentoformType::class, $instrumento);
        $form ->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($instrumento);
            $em->flush();
        }
        $instrumento = $em->getRepository(Instrumento::class)->findAll();
        return $this->render('escuela/instrumento.html.twig',[
            'instrumentos'=>$instrumento,
            'form'=>$form
        ]);
    }

    #[Route('/escuela/instrumentomatricula/{id}/instrumatri', name: 'app_instrumento_matricula')]
    public function alumnosmatriculadosInstru(int $id, MatriculaRepository $matricularepository ):Response
    {

        $matricula = $matricularepository->findBy(['instrumentoMatricula' => $id]);

        return $this->render('escuela/alumnosmatri.html.twig',[
            'titulo' => 'Alumnos',
            'matri'=>$matricula
        ]);
    }
}
