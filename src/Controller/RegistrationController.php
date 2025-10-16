<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\UsuarioformType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Doctrine\ORM\EntityManagerInterface;
final class RegistrationController extends AbstractController
{
    #[Route('/registro', name: 'app_registration')]
    public function registrar(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager): Response
    {
        $user = new Usuario();
        $form = $this->createForm(UsuarioformType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
        /** @var string $plainPassword */
        $plainPassword = $form->get('plainPassword')->getData();

        // encode the plain password
        $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

        $entityManager->persist($user);
        $entityManager->flush();

        // do anything else you need here, like send an email

        return $security->login($user, 'form_login', 'main');
    }
        return $this->render('registration/index.html.twig', [
            'registrationForm' => $form,
        ]);
    }
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
