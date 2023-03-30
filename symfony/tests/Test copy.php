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

class Test extends KernelTestCase
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

    
    
}
?>