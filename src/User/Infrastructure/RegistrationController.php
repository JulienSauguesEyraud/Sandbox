<?php

namespace App\User\Infrastructure;

use App\User\Application\RegisterUser;
use App\User\Domain\Input\RegisterUserDTO;
use App\User\Domain\Repository\UserRepository;
use App\User\Infrastructure\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, RegisterUser $registerUser, UserRepository $userRepository): Response
    {
        $userDTO = new RegisterUserDTO();
        $form = $this->createForm(RegistrationFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $userDTO->email = $form->get('email')->getData();
            $userDTO->plainPassword = $form->get('plainPassword')->getData();
            $userDTO->agreeTerms = $form->get('agreeTerms')->getData();

            return $registerUser->execute($userDTO);
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
