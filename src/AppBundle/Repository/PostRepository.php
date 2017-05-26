<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 7/03/17
 * Time: 21:05
 */

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;


class PostRepository extends EntityRepository
{
    public function postSearch($search){
        return $this->createQueryBuilder('p')
            ->andWhere('p.mensaje LIKE :search OR p.titulo LIKE :search')
            ->setParameter('search', '%'.$search.'%')
            ->getQuery()
            ->getResult();
    }
}