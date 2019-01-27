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

class TagFixtures extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $monFichier = dirname(__DIR__) . "\DataFixtures\dependencieFiles\liste.txt";//.'/web/dependencieFiles/Prenoms.csv';
        if ($file = fopen($monFichier, "r")) {
            while (!feof($file)) {
                $line = fgets($file);
                $this->createTag($line,$manager);
                # do same stuff with the $line
            }
            fclose($file);
        }

    }


    public function createTag($name, $manager)
    {


        $tag = new Tag();
        $tag->setTag($name);
        $manager->persist($tag);
        $manager->flush();


    }


    public function getOrder()
    {
        return 5; // number in which order to load fixtures
    }


}
