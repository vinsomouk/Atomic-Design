<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\User\UserInterface;

class APIAuthenticator extends AbstractAuthenticator
{
    public function supports(Request $request): ?bool
    {
        return $request->headers->has('Authorization') && str_contains($request->headers->get('Authorization'), 'Bearer');
    }

    public function authenticate(Request $request): Passport
    {
        $identifier = trim(str_replace('Bearer', '', $request->headers->get('Authorization')));

        return new SelfValidatingPassport(new UserBadge($identifier));
    }

    public function createToken(Passport $passport, string $firewallName): TokenInterface
    {
        // Créez un token authentifié avec les informations du passeport
        return new PreAuthenticatedToken(
            $passport->getUser(),
            $firewallName,
            $passport->getUser()->getRoles()  // Assurez-vous que l'utilisateur a des rôles attribués
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $user = $token->getUser();

        // Vérifier si l'utilisateur est une instance de votre entité User
        if (!$user instanceof UserInterface) {
            return new JsonResponse(['message' => 'User not found.'], Response::HTTP_UNAUTHORIZED);
        }

        // Récupérer les informations de l'utilisateur
        $userData = [
            'roles' => $user->getRoles(), // obtenir les rôles
            // Ajoutez d'autres champs nécessaires ici
        ];

        // Si l'authentification réussit, vous pouvez rediriger l'utilisateur ou retourner une réponse JSON
        return new JsonResponse([
            'message' => 'Authentication successful.',
            'user' => $userData

        ], Response::HTTP_OK);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new JsonResponse([
            'message' => $exception->getMessage()
        ], Response::HTTP_UNAUTHORIZED);
    }
}
