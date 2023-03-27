<?php
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use App\Entity\Livre;
use App\Entity\Lecteur;
use App\Entity\Editeur;
use App\Entity\Auteur;
use App\Entity\Categorie;
use App\Entity\Langue;
use App\Entity\Emprunt;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductRepositoryTest extends KernelTestCase
{
    protected $pdo;
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
        $username = 'ztanji';
        $password = 'J9SwdTBV';

        $this->pdo = new PDO("mysql:host=info-titania;port=3306;dbname=etu_ztanji", $username, $password);
    }

    public function testConnection()
    {
        $this->assertNotNull($this->pdo);
    }
    
    function testBookCount(): void
    {

        $bookCount = $this->entityManager->getRepository(Livre::class)->count([]);

        $this->assertGreaterThanOrEqual(200000, $bookCount);
    }

    function testUserCount()
    {
        $userCount = $this->entityManager->getRepository(Lecteur::class)->count([]);

        $this->assertGreaterThanOrEqual(100, $userCount);
    }

    function testAuthorCount()
    {
        $authorCount = $this->entityManager->getRepository(Auteur::class)->count([]);
        $this->assertGreaterThan(50, $authorCount);
    }
    
    function testDifferentMailForAllUsers(){
        $repository = $this->entityManager->getRepository(Lecteur::class);
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
    function testAddUser(){
        $userCount = $this->entityManager->getRepository(Lecteur::class)->count([]);
        $repository = $this->entityManager->getRepository(Lecteur::class);
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