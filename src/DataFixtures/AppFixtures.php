<?php

namespace App\DataFixtures;

use App\Entity\Internaute;
use App\Entity\Question;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\JsonGenerator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use function Zenstruck\Foundry\faker;

class AppFixtures extends Fixture
{
    private UserPasswordEncoderInterface $passwordEncoder;
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder, JsonGenerator $jsonGenerator)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->jsonGenerator = $jsonGenerator;
    }

    /**
     * Création de 10 internautes ayant chacun posé entre 1 et 5 questions.
     * Création des fichiers JSON correspondant
     * Création d'un admin
     */
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $internaute = new Internaute();
            $name = faker()->lastName();
            $internaute->setName($name);
            $internaute->setEmail($name . "@gmail.com");

            for ($p = 1; $p <= rand(1, 5); $p++) {
                $question = new Question();
                $question->setContent(faker()->text(rand(150, 1000)));
                $question->setChecked(faker()->boolean());
                $internaute->addQuestion($question);

                $manager->persist($internaute);
                $manager->flush();

                $jsonGenerator = $this->jsonGenerator;
                $jsonGenerator->generateJsonFile("",$internaute->getEmail(), $internaute->getName(), $question->getContent(), $question->getId());
            }
        }

        $user = new User();
        $user->setEmail("admin@admin.fr");
        $passwordEncoder = $this->passwordEncoder;
        $userRepository = $this->userRepository;
        $user->setPassword($passwordEncoder->encodePassword($user, "admin"));
        $userRepository->add($user);

    }
}
