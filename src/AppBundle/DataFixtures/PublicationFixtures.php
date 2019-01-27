<?php
 
namespace AppBundle\DataFixtures;


use AppBundle\Entity\Association;
use AppBundle\Entity\Publication;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Faker;

class PublicationFixtures extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {

        $users = $manager->getRepository(User::class)->findAll();;
        $assocs = [];
        foreach ($users as $user) {

            if ($user->getRoles("ROLE_ASSOC")) {
                array_push($assocs, $user);
            }
        }
        $this->createPublication($assocs, $manager);


    }

    public function createPublication($assocs, $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        foreach ($assocs as $assoc) {
            for ($i = 0; $i < 8; $i++) {
                $description = $faker->text;
                $name = $faker->word . "" . $faker->word . "" . $faker->word;
                $publication = new Publication();
                $publication->setTitle($name);
                $publication->setAssociation($assoc->getAssociation());
                $publication->setDescription($description);
                $manager->persist($publication);
                $manager->flush();
            }

        }


    }

    public function getOrder()
    {
        return 4; // number in which order to load fixtures
    }


}
