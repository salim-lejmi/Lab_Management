<?php

namespace App\DataFixtures;
use App\Entity\User;
use App\Entity\Equipment;
use App\Entity\Publication;
use App\Entity\Project;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class App extends Fixture
{
    private $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $admin = new User();
        $admin->setEmail('admin@gmail.com');
        $admin->setUsername('admin');
        $admin->setRoles('admin');
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin'));

        $manager->persist($admin);


        $user1 = new User();
        $user1->setUsername('AliceChen');
        $user1->setEmail('alice@gmail.com');
        $user1->setRoles('user');
        $user1->setChercheur('chercheur principal');
        $user1->setPassword($this->passwordHasher->hashPassword($user1, '0000'));

        $user2 = new User();
        $user2->setUsername('BrianWilliams');
        $user2->setEmail('brian@gmail.com');
        $user2->setRoles('user');
        $user2->setChercheur('collaborateur');
        $user2->setPassword($this->passwordHasher->hashPassword($user2, '0000'));

        $manager->persist($user1);
        $manager->persist($user2);
        $this->addReference('user-1', $user1);
        $this->addReference('user-2', $user2);
        $publication = new Publication();
        $publication->setTitle('Enhanced Biodegradation of Crude Oil');
        $publication->setContent('This study demonstrated that genetically modified bacteria expressing cold-adapted xylanases exhibited significantly higher crude oil degradation activity at low temperatures, offering a potential solution for oil spill cleanup in cold environments.');
        $publication->setAuthor($this->getReference('user-1'));

        $manager->persist($publication);
        $this->addReference('publication-1', $publication);
        $project = new Project();
        $project->setTitle('Bioremediation of Oil Spills in Cold Marine Ecosystems using Engineered Microbes');
        $project->setDescription('This laboratory project investigated the potential of engineered bacteria to degrade crude oil in cold marine environments, aiming to develop a sustainable and efficient bioremediation approach for oil spills.');
        $project->setStartDate(new \DateTime('2020-07-01'));
        $project->setEndDate(new \DateTime('2023-12-31'));
        $project->setAuthor($this->getReference('user-1'));
        $project->addPublication($this->getReference('publication-1'));

        $manager->persist($project);


        $equipment1 = new Equipment();
        $equipment1->setName('AGITATEUR VORTEX');
        $equipment1->setDescription("Vortex robuste pour une agitation stable et fiable. Il commence à agiter lorsque la tête en coupelle est enfoncée. La vitesse en réglée à 2500 tours/min pour fournir un mélange vigoureux des échantillons.");
        $equipment1->setPhotoUrl('https://www.humeau.com/media/catalog/product/cache/1/image/730x/b6c53eefddb148171814c2f11aa0d200/7/3/73310010000_20230901033001/humeau.com-agitateur-vortex-vitesse-fixe-ohaus-2500t-min-orbite-4-9mm-73310010000-252243-30.jpg');
 
        $equipment2 = new Equipment();
        $equipment2->setName('ANEMOMETRE TESTO 410-1');
        $equipment2->setDescription("L'anémomètre à hélice testo 410-1 convainc par son format de poche pratique et convient parfaitement pour des mesures de contrôle rapides.");
        $equipment2->setPhotoUrl('https://www.humeau.com/media/catalog/product/cache/1/image/730x/b6c53eefddb148171814c2f11aa0d200/1/5/15901093008_20230901033001/humeau.com-anemometre-testo-410-1-a-helice-avec-mesure-ctn-15901093008-214485-30.jpg');
 
        $equipment3 = new Equipment();
        $equipment3->setName('CHLORUREMETRE SHERWOOD 926');
        $equipment3->setDescription("Le chloruremètre Sherwood 926 permet le dosage rapide des chlorures par coulométrie.");
        $equipment3->setPhotoUrl('https://www.humeau.com/media/catalog/product/cache/1/image/730x/b6c53eefddb148171814c2f11aa0d200/0/4/04803710102_20231012130103/humeau.com-chloruremetre-sherwood-926-complet-203623-203623-30.jpg');
 
        $manager->persist($equipment1);
        $manager->persist($equipment2);
        $manager->persist($equipment3);
        $manager->flush();
        $manager->flush();
    }
}
