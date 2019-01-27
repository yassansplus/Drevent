<?php
 
namespace AppBundle\DataFixtures;


use AppBundle\Entity\Association;
use AppBundle\Entity\Etudiant;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Faker;
use Faker\Provider\DateTime;
class EtudiantFixtures extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {

        $users = $manager->getRepository(User::class)->findAll();;
        $assocs_stud = [];
        foreach ($users as $user){

            if (  in_array("ROLE_STUD",$user->getRoles() )){
                array_push($assocs_stud, $user);
            }
    }
    $this->createAssoc($assocs_stud, $manager);




    }
    public function createAssoc($assocs_stud, $manager){
        $faker = Faker\Factory::create('fr_FR');
        foreach ($assocs_stud as $user) {
            $date = $faker->dateTimeBetween($startDate = '-25 years', $endDate = '-20 years', $timezone = null);
            $name = $faker->word."".$faker->word."".$faker->word;
            $stud = new Etudiant();
            $stud->setUser($user);
            $user->setName($faker->firstName);
            $user->setName($faker->lastName);
            $stud->setBirthday($date);
            $stud->setPromo("2022");
            $manager->persist($stud);
            $manager->flush();
        }


    }
    public function getOrder()
    {
        return 3; // number in which order to load fixtures
    }


}
