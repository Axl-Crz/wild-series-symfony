<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public static int $actorIndex=0;
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i=1; $i <= 15; $i++) {
            $nbPrograms = rand(2, 6);
            $actor = new Actor();
            $actor->setFirstname($faker->firstName());
            $actor->setLastname($faker->lastName());
            $actor->setBirthDate($faker->dateTime('-18 years'));
            for ($j=0; $j<= $nbPrograms; $j++) {
                $actor->addProgram($this->getReference('program_' . $faker->numberBetween(0, ProgramFixtures::$programIndex-1)));
            }
            // $faker->unique(true);

            $manager->persist($actor);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
            ProgramFixtures::class,
        ];
    }


}