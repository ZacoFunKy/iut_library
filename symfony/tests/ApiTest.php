<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use GuzzleHttp\Client; 

class ApiTest extends WebTestCase
{ 
    public function testEnregistrementConnexion()
    {                
        $client = new Client([
            'base_uri' => 'http://127.0.0.1:8000',
            'verify' => false,
        ]);

        $jsonData = json_encode([
            'email' => 'test@gmail.com',
            'prenomLecteur' => 'Test',
            'nomLecteur' => 'test',
            'password' => '000000',
        ]);

        $headers = [
            'Content-Type' => 'application/json',
            'Expect' => '100-continue',
        ];

        $response = $client->request('POST', '/api/register', [
            'headers' => $headers,
            'body' => $jsonData,
        ]);

        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        $this->assertEquals(200, $response->getStatusCode());

        $jsonData = json_encode([
            'username' => 'test@gmail.com',
            'password' => '000000',
        ]);

        $headers = [
            'Content-Type' => 'application/json',
            'Expect' => '100-continue',
        ];

        $response = $client->request('POST', '/api/login', [
            'headers' => $headers,
            'body' => $jsonData,
        ]);
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);
        if (isset($data["token"])){
            $this->assertTrue(true);
        }else{
            $this->assertTrue(false);
        }
    }

    public function testSearchBar()
    {
        $client = new Client([
            'base_uri' => 'http://127.0.0.1:8000/api/books/research/',
            'verify' => false,
        ]);

        $response = $client->request('GET', '?name= ');
        $content = $response->getBody()->getContents();
        $content = json_decode($content, true);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(count($content)-1, $content[count($content)-1]["TotalResponse"]);

        $response = $client->request('GET', '?name=re');
        $content = $response->getBody()->getContents();
        $content = json_decode($content, true);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(count($content)-1, $content[count($content)-1]["TotalResponse"]);

        $response = $client->request('GET', '?name=reijuibnfcyfdgbfgfffgffgffgctgfcxgfcxgfctxfctgcd');
        $content = $response->getBody()->getContents();
        $content = json_decode($content, true);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(count($content)-1, $content[count($content)-1]["TotalResponse"]);
    }
}