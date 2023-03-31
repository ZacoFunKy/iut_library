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

class LivreTest extends KernelTestCase
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
    
    function testBookCount(): void
    {

        $bookCount = $this->entityManager->getRepository(Livre::class)->count([]);

        $this->assertGreaterThanOrEqual(200, $bookCount);
    }

    function testEstEmprunte(){
        $existeDateRendu=false;
        $sql = "SELECT date_rendu FROM test_emprunt";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) { 
                if ($row["date_rendu"]!=NULL){
                    $existeDateRendu=true;
                }      
            }
        } catch(PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
        $this->assertEquals($existeDateRendu, true);
    }

    function testLivreAuteurNotNull(){
        $LivreAuteurNonNull=true;
        $sql = "SELECT * FROM test_livre_auteur";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) { 
                if ($row["livre_id"]==NULL || $row["auteur_id"]==NULL){
                    $LivreAuteurNonNull=false;
                }
            }
        } catch(PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
        $this->assertEquals($LivreAuteurNonNull, true);
    }

    function testLivreAAuteur(){
        $unLivreAUnAuteur=true;
        $sql = "SELECT livre_id as 'id' FROM test_livre_auteur";
        $sql2 = "SELECT id FROM test_livre";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $stmt2 = $this->pdo->prepare($sql2);
            $stmt2->execute();
            $result = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            $result2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) { 
                $aUnAuteur=false;
                foreach($result2 as $livre_avec_auteur){
                    if (!$aUnAuteur && $row["id"]==$livre_avec_auteur["id"]){
                        $aUnAuteur=true;
                    }  
                }              
                if ($aUnAuteur==false){
                    var_dump($row);
                    $unLivreAUnAuteur=false;
                }                
            }
        } catch(PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
        $this->assertEquals($unLivreAUnAuteur, true);
    }

    function testAjoutLivre(){
        $sql = "SELECT * FROM test_livre";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $countAvantAjout=count($result);
        } catch(PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
        $sql = "INSERT INTO test_livre (titre, date_acquisition) VALUES ('TESTTESTTEST', '2021-12-09 06:12:17')";
        try {
            $stmt = $this->pdo->query($sql);    
        } catch(PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
        $sql = "SELECT * FROM test_livre";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $countApresAjout=count($result);
        } catch(PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
        $sql = "DELETE FROM `test_livre` WHERE titre='TESTTESTTEST'";
        try {
            $stmt = $this->pdo->query($sql);    
        } catch(PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
        
        $this->assertEquals($countAvantAjout, $countApresAjout-1);
    }
}
?>