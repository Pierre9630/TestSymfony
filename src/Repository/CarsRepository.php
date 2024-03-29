<?php

namespace App\Repository;

use App\Entity\Cars;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Cars>
 *
 * @method Cars|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cars|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cars[]    findAll()
 * @method Cars[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cars::class);
    }

    public function save(Cars $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Cars $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findBySearch(SearchData $searchData): PaginationInterface
    {
        $cars = $this->createQueryBuilder('p')
            ->where('p.brand LIKE :brand')
            ->setParameter('brand',$searchData['brand'])
            ->orWhere('p.model LIKE :model')
            ->setParameter('model',$searchData['model'])
            ->orWhere('p.description LIKE :description')
            ->setParameter('description',$searchData['description'])
            ->orWhere('p.TypeFuel LIKE :TypeFuel')
            ->setParameter('TypeFuel',$searchData['TypeFuel'])
            ->orWhere('p.Year LIKE :Year')
            ->setParameter('Year',$searchData['Year'])
            ->orWhere('p.kilometers LIKE :kilometers')
            ->setParameter('kilometers',$searchData['kilometers']);

    }

    public function paginateCars(){
        return $this->createQueryBuilder('a')
            ->orderBy('a.id', 'ASC')
            ->getQuery();
    }
//    /**
//     * @return Cars[] Returns an array of Cars objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Cars
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
