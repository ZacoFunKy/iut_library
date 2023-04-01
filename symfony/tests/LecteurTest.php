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

class LecteurTest extends KernelTestCase
{
    protected $pdo;
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
        $username = 'root';
        $password = 'lCRIkg5xD';

        $this->pdo = new PDO("mysql:host=185.212.226.191;port=6033;dbname=BD_E9", $username, $password);   
    }

    public function testConnection()
    {
        $this->assertNotNull($this->pdo);
    }
    
    function testUserCount()
    {
        $userCount = $this->entityManager->getRepository(Lecteur::class)->count([]);

        $this->assertGreaterThanOrEqual(100, $userCount);
    }

    function testAjoutEtRetraitAmi(){
        $existeDateRendu=false;
        $sql = "SELECT * FROM `test_lecteur_lecteur` WHERE lecteur_source='2' ";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->assertEquals(count($result),0);
        } catch(PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
        $sql = "INSERT INTO test_lecteur_lecteur (lecteur_source, lecteur_target) VALUES ('2', '5')";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        } catch(PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
        $sql = "SELECT * FROM `test_lecteur_lecteur` WHERE lecteur_source='2'";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->assertEquals(count($result),1);
        } catch(PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
        $sql = "INSERT INTO test_lecteur_lecteur (lecteur_source, lecteur_target) VALUES ('2', '6')";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        } catch(PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
        $sql = "SELECT * FROM `test_lecteur_lecteur` WHERE lecteur_source='2'";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->assertEquals(count($result),2);
        } catch(PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
        $sql = "DELETE FROM `test_lecteur_lecteur` WHERE lecteur_source='2'";
        try {
            $stmt = $this->pdo->query($sql);    
        } catch(PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
        $sql = "SELECT * FROM `test_lecteur_lecteur` WHERE lecteur_source='2' ";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->assertEquals(count($result), 0);
        } catch(PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
    }


    function testDifferentMailForAllUsers() 
    {
        $repository = $this->entityManager->getRepository(Lecteur::class);
        $queryBuilder = $repository->createQueryBuilder('u');

        $query = $queryBuilder
            ->select('COUNT(DISTINCT u.email) as email_count')
            ->getQuery();

        $emailCount = $query->getSingleScalarResult();

        $userCount = $repository->count([]);
        $this->assertEquals($emailCount, $userCount);
    }
    
    function testAddUser()
    {
        $userCount = $this->entityManager->getRepository(Lecteur::class)->count([]);
        $repository = $this->entityManager->getRepository(Lecteur::class);
        $queryBuilder = $repository->createQueryBuilder('u');

        $query = $queryBuilder
            ->select('COUNT(DISTINCT u.email) as email_count')
            ->getQuery();

        $emailCount = $query->getSingleScalarResult();

        $userCount = $repository->count([]);

        $this->assertEquals($emailCount, $userCount);
    }
}
?>