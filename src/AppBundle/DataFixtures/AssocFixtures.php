<?php
 
namespace AppBundle\DataFixtures;


use AppBundle\Entity\Association;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use AppBundle\Entity\Tag;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Faker;
class AssocFixtures extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {

        $users = $manager->getRepository(User::class)->findAll();;
        $assocs = [];
        foreach ($users as $user){

            if ( in_array("ROLE_ASSOC", $user->getRoles())){

                array_push($assocs, $user);
            }
    }
    $this->createAssoc($assocs, $manager);




    }
    public function createAssoc($assocs, $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        foreach ($assocs as $assoc) {
            $name = $faker->word . "" . $faker->word . "" . $faker->word;
            $Assoc = new Association();
            $Assoc->setName($name);
            $Assoc->setPlace($faker->address);
            $Assoc->setSchedule($faker->word);
            $Assoc->setUser($assoc);
            $manager->persist($Assoc);
            $manager->flush();

        }
    }

    public function getOrder()
    {
        return 2; // number in which order to load fixtures
    }


}
