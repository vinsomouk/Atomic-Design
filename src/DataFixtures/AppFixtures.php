<?php

namespace App\DataFixtures;

use App\Entity\Module;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {
        // Create modules
        $count = 1;
        $name = 'module';
        $modules = [];
        foreach ($this->modules() as $module) {
            ${$name . $count} = new Module;
            ${$name . $count}->setTitle($module['title']);
            ${$name . $count}->setDescription($module['description']);
            ${$name . $count}->setCreatedAt(new \DateTimeImmutable( $module['creation_date'] ) );
            $manager->persist(${$name . $count});
            $modules[] = ${$name . $count};
            $count++;
        }

        $generateModules = function () use ($modules) {

            $keys = array_rand($modules, rand(1, count($this->modules())));

            return array_map(function ($key) use ($modules) {
                return $modules[$key];
            }, $keys);
        };

        // Create users and associate them with modules
        $this->createUser($manager, 'alan@alan.fr', 'Alan', 'pass_1234', $generateModules());
        $this->createUser($manager, 'alice@example.com', 'Alice', 'pass_1234', $generateModules());
        $this->createUser($manager, 'bob@example.com', 'Bob', 'pass_5678', $generateModules());
        $this->createUser($manager, 'charlie@example.com', 'Charlie', 'pass_9012', $generateModules());

        $manager->flush();
    }

    private function createUser(ObjectManager $manager, string $email, string $firstName, string $plainPassword, array $modules): void
    {
        $user = new User();
        $user->setEmail($email);
        $user->setFirstName($firstName);
        $user->setRoles(['ROLE_USER']);

        $password = $this->hasher->hashPassword($user, $plainPassword);
        $user->setPassword($password);

        // Associate the user with the given modules
        foreach ($modules as $module) {
            $user->addModule($module);
        }

        $manager->persist($user);
    }

    private function modules(): array
    {

        return

            [
                [
                    "title" => "Programmation Orientée Objet (POO)",
                    "description" => "Introduction aux concepts fondamentaux de la POO, y compris les classes, les objets, l’héritage et le polymorphisme. Études de cas et exercices en Java.",
                    "creation_date" => "2023-02-01  00:00:00"
                ],
                [
                    "title" => "Développement Web Frontend",
                    "description" => "Ce module couvre les bases du HTML, CSS et JavaScript pour la création de sites Web réactifs et interactifs. Initiation à des frameworks comme Bootstrap et Tailwind.",
                    "creation_date" => "2023-05-15  00:00:00"
                ],
                [
                    "title" => "Bases de Données et SQL",
                    "description" => "Apprendre à concevoir, manipuler et interroger des bases de données relationnelles avec SQL. Utilisation de MySQL pour les exercices pratiques.",
                    "creation_date" => "2023-08-20  00:00:00"
                ],
                [
                    "title" => "Introduction à l’Algorithmique",
                    "description" => "Étude des principes de l’algorithmique et résolution de problèmes à l’aide de pseudocode et de langages de programmation.",
                    "creation_date" => "2022-11-10 00:00:00"  
                ],
                [
                    "title" => "Conception et Architecture Logicielle",
                    "description" => "Présentation des principes de conception logicielle, y compris les concepts de modularité, de patrons de conception et de Clean Architecture.",
                    "creation_date" => "2024-01-05 00:00:00"
                ],
                [
                    "title" => "Frameworks Backend avec Symfony",
                    "description" => "Découverte du framework Symfony pour le développement d'applications backend robustes. Utilisation de services, de routes et de la gestion des entités.",
                    "creation_date" => "2023-09-01 00:00:00"
                ],
                [
                    "title" => "Introduction aux API RESTful",
                    "description" => "Créer des API RESTful en utilisant des frameworks comme Express.js. Gestion des requêtes, réponses et authentification API.",
                    "creation_date" => "2023-06-18 00:00:00"
                ],
                [
                    "title" => "Sécurité Informatique de Base",
                    "description" => "Cours de sensibilisation aux principales menaces de sécurité et bonnes pratiques pour protéger les systèmes et les données.",
                    "creation_date" => "2023-04-12 00:00:00"
                ],
                [
                    "title" => "Méthodologies Agiles et Scrum",
                    "description" => "Présentation des méthodes agiles avec un focus sur le framework Scrum. Gestion de projet, rôles, sprints et cérémonies.",
                    "creation_date" => "2023-03-07 00:00:00"
                ],
                [
                    "title" => "Machine Learning Introduction",
                    "description" => "Introduction aux concepts fondamentaux du machine learning, avec des applications pratiques en Python à l’aide de bibliothèques comme Scikit-Learn.",
                    "creation_date" => "2024-02-10 00:00:00"
                ]
            ];
    }
}
