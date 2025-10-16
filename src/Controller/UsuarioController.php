<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
//Controlador de usuario, controla el logeo de los usuarios a la pagina
final class UsuarioController extends AbstractController
{
    
    #[Route('/', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $ultimoUsu = $authenticationUtils->getLastUsername();

        return $this->render('usuario/index.html.twig', [
            'utimousuario' =>$ultimoUsu,
            'error'=>$error,
        ]);
    }
}
