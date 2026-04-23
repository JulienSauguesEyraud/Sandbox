<?php

namespace App\User\Infrastructure;

use App\Form\RegistrationFormType;
use App\User\Application\DTO\UserDTO;
use App\User\Application\RegisterUser;
use App\User\Domain\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, RegisterUser $registerUser, UserPasswordHasherInterface $hasher, UserRepository $userRepository, Security $security): Response
    {
        $userDTO = new UserDTO();
        $form = $this->createForm(RegistrationFormType::class, $userDTO);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $registerUser->execute($userDTO, $userRepository, $hasher, $security);
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
