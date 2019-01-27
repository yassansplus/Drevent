<?php
 
namespace AppBundle\DataFixtures;


use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
class LoadFixtures  extends AbstractFixture implements OrderedFixtureInterface
{
    private $password = "123";
    public function load(ObjectManager $manager)
    {
        $row = 1;

        $monFichier = dirname(__DIR__) . "\DataFixtures\dependencieFiles\prenom.csv";//.'/web/dependencieFiles/Prenoms.csv';
        if (($handle = fopen($monFichier, "r")) !== FALSE) {
            $i = 0;
            while ((($data = fgetcsv($handle, 1000, ",") )  ) !== FALSE) {
                $row++;
                $email =utf8_encode( "".$data[0]."@gmail.com");
                $name = utf8_encode( "".$data[0]);
                $user = new User();
                $user->setUsername($email);

                $user->setEmail($email);
                $user->setEnabled(true);
                $user->setPassword($this->password);
                $user->setEmailCanonical($email);
                $user->setPlainPassword($this->password);
                $user->setName($name);
                $user->setSurname($name);
              if ($i%2 == 0){
                  $user->setRoles(["ROLE_ASSOC"]);
              }else{
                  $user->setRoles(["ROLE_STUD"]);
              }
                if ($i>75){
                    break;
                }
                else{
                    $i++;
                }
                $manager->persist($user);
                $manager->flush();

            }
            fclose($handle);
        }
    }


    public function getOrder()
    {
        return 1; // number in which order to load fixtures
    }

}
