<?php

namespace App\Repository;

use App\Entity\Filesystem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;
use Exception;

/**
 * @method Filesystem|null find($id, $lockMode = null, $lockVersion = null)
 * @method Filesystem|null findOneBy(array $criteria, array $orderBy = null)
 * @method Filesystem[]    findAll()
 * @method Filesystem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FilesystemRepository extends ServiceEntityRepository
{
    const BASE_RECURSIVE_QUERY = 'WITH RECURSIVE file_path (id, title, path) AS ( SELECT id, title, title as path FROM filesystem WHERE parent_id IS NULL UNION ALL SELECT c.id, c.title, CONCAT(cp.path, \'/\', c.title) FROM file_path AS cp JOIN filesystem AS c ON cp.id = c.parent_id ) ';

    /**
     * FilesystemRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Filesystem::class);
    }

    public function getAllBySearchTerm($term)
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('id', 'id');
        $rsm->addScalarResult('title', 'title');
        $rsm->addScalarResult('path', 'path');

        $query = $this->getEntityManager()->createNativeQuery(self::BASE_RECURSIVE_QUERY . 'SELECT id, title, path FROM file_path WHERE path LIKE ?', $rsm);
        $query->setParameter(1,'%' . $term . '%');
        return $query->getResult();
    }

    /**
     * @param string $dirname
     * @return bool
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function pathExists(string $dirname)
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('count', 'count');

        $query = $this->getEntityManager()->createNativeQuery( self::BASE_RECURSIVE_QUERY . "SELECT count(*) as count FROM file_path WHERE path = ?;" , $rsm);
        $query->setParameter(1, $dirname);
        return intval($query->getSingleScalarResult()) > 0;

    }

    /**
     * @param string $dirname
     * @return bool|int
     */
    public function getPathId(string $dirname)
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('id', 'id');

        $query = $this->getEntityManager()->createNativeQuery( self::BASE_RECURSIVE_QUERY . "SELECT id FROM file_path WHERE path = ?;" , $rsm);
        $query->setParameter(1, $dirname);
        try {
            return intval($query->getSingleScalarResult());
        } catch (Exception $e) {
        }
        return false;
    }

    /**
     * @param Filesystem $file
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Filesystem $file)
    {;
        $this->_em->persist($file);
        $this->_em->flush();
    }
}
