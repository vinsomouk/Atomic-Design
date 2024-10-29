<?php

namespace App\Controller\API;

use App\Entity\Module;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
class ModuleController extends AbstractController
{
    #[Route('/modules', name: 'app_module')]
    public function index(EntityManagerInterface $em): JsonResponse
    {

        $modules = $em->getRepository(Module::class)->findAll();

        return $this->json([
            'modules' => $modules
        ]);
    }
}
