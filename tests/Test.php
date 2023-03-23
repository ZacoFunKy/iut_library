<?php
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Entity\Livre;
class Test extends TestCase{
    private $entityManager;
/*
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager=$entityManager;
    }*/

    function testBookCount(): void
    {
        //$em = $this->getDoctrine()->getManager();
        $bookCount = $this->entityManager->getRepository(Livre::class)->count([]);

        $this->assertGreaterThan(200, $bookCount);
    }

    function testUserCount()
    {
        //$em = $this->getDoctrine()->getManager();
        $userCount = $this->entityManager->getRepository(Lecteur::class)->count([]);

        $this->assertGreaterThan(100, $userCount);
    }

    function testAuthorCount()
    {
        $em = $this->getDoctrine()->getManager();
        $authorCount = $em->getRepository(Auteur::class)->count([]);

        $this->assertGreaterThan(50, $authorCount);
    }

    function testUniqueName(){
        $em = $this->getDoctrine()->getManager();
        $userCount = $em->getRepository(Lecteur::class);
    }

    function differentMailForAllUsers(){
        $repository = $this->getDoctrine()->getRepository(Lecteur::class);
        $queryBuilder = $repository->createQueryBuilder('u');

        $query = $queryBuilder
            ->select('COUNT(DISTINCT u.email) as email_count')
            ->getQuery();

        $emailCount = $query->getSingleScalarResult();

        $userCount = $repository->count([]);

        if ($emailCount == $userCount) {
            
        } else {
            throw new Exception('Same email');
        }
    }  
}
?>