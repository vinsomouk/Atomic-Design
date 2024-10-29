<?php

namespace App\Controller\API;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserController extends AbstractController
{
    #[Route('/api/me', name: 'api_me')]
    #[IsGranted("ROLE_USER")]
    public function me(): JsonResponse
    {
        // Retrieve the authenticated user
        $user = $this->getUser();

        if (!$user instanceof UserInterface) {
            return new JsonResponse(['error' => 'Unauthorized'], 401);
        }

        return new JsonResponse([
            'roles' => $user->getRoles(),
            'email' =>  $user->getUserIdentifier()
        ]);
    }
}
