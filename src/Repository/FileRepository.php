<?php

namespace App\Repository;

use App\Entity\File;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * @extends ServiceEntityRepository<File>
 */
class FileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, File::class);
    }

    public function getTotalSizeAllStorage(){

        $resultat= $this->createQueryBuilder('f') // 'f' = alias pour File
        ->select('SUM(f.size) as sizeUse, stk.sizeAllow, stk.name
        ')
            ->join('f.id_user', 'u')   // Jointure avec User (alias 'u')
            ->join('u.storage', 'stk') // Jointure avec StorageCorps (alias 'stk')
            ->groupBy('stk.id')        // Regrouper par stockage
            ->getQuery()
            ->getResult();
        
        return array_map(function ($row) {
            $row['sizeUse'] = round($row['sizeUse'], 2);
            return $row;
        }, $resultat);
    }


    public function updateStorageSizeUse(int $userId) {
        
        $qb = $this->createQueryBuilder('f')
            ->select('SUM(f.size) as totalSize')
            ->where('f.id_user = :userId')
            ->andWhere('f.archiver != 1')
            ->setParameter('userId', $userId)
            ->getQuery();

        $result = $qb->getSingleResult();
        $totalSizeInKo = $result['totalSize'];
        $totalSizeInGo = round($totalSizeInKo / 1024, 2);

        $user = $this->getEntityManager()->getRepository(User::class)->find($userId);
        $storage=($user)? $user->getStorage(): null;


        if ($storage) {
            $storage->setSizeUse($totalSizeInGo);
            $this->getEntityManager()->flush();
        }
    }
    

    //    /**
    //     * @return File[] Returns an array of File objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?File
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
