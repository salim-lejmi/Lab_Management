<?php
namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class PublicationRepository extends EntityRepository
{
   public function search(string $query): array
   {
       return $this->createQueryBuilder('p')
           ->where('p.title LIKE :query')
           ->setParameter('query', '%' . $query . '%')
           ->getQuery()
           ->getResult();
   }
}
