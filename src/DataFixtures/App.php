<?php

namespace App\DataFixtures;
use App\Entity\User;
use App\Entity\Equipment;

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
