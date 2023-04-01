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

class AuteurTest extends KernelTestCase
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

    function testAuthorCount()
    {
        $authorCount = $this->entityManager->getRepository(Auteur::class)->count([]);
        $this->assertGreaterThan(50, $authorCount);
    }
}
?>