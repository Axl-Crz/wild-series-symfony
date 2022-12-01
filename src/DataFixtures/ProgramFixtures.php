<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public const PROGRAMLIST = [
        [
            "Title" => "Walking dead",
            "Synopsis" => "Des zombies envahissent la terre",
            "Category" => "category_Action"
        ],
        [
            "Title" => "The Rings of Power",
            "Synopsis" => "L'histoire se déroule sept mille ans avant les événements racontés dans Le Hobbit. La paix semble revenue après que Galadriel ait vaincu Morgoth. Mais Sauron prépare sa vengeance aux quatre coins de la Terre du Milieu.",
            "Category" => "category_Aventure"
        ],
        [
            "Title" => "House of the Dragon",
            "Synopsis" => "200 ans avant les événements de Game Of Thrones, retour sur les origines de la Maison Targaryen avec le roi Viserys I Targaryen",
            "Category" => "category_Fantastique"
        ],
        [
            "Title" => "Wednesday",
            "Synopsis" => "A présent étudiante à la singulière Nevermore Academy, Wednesday Addams tente de s'adapter auprès des autres élèves tout en enquêtant à la suite d'une série de meurtres qui terrorise la ville...",
            "Category" => "category_Horreur"
        ],
        [
            "Title" => "The Croods",
            "Synopsis" => "Suite aux événements du long métrage THE CROODS: A NEW AGE, deux familles très différentes unissent leurs forces pour créer une nouvelle communauté, une coopérative d'hommes des cavernes nous contre le monde dans la ferme la plus étonnante de l'histoire de la préhistoire !",
            "Category" => "category_Animation"
        ],
    ];
    public function load(ObjectManager $manager)
    {

        foreach (self::PROGRAMLIST as $key => $ProgramInfo) {
            $program = new Program();
            $program->setTitle($ProgramInfo["Title"]);
            $program->setSynopsis($ProgramInfo["Synopsis"]);
            $program->setCategory($this->getReference($ProgramInfo["Category"]));
            $manager->persist($program);
            $this->addReference('program_' . $key, $program);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
          CategoryFixtures::class,
        ];
    }


}