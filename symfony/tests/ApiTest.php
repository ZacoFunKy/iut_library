<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use GuzzleHttp\Client; 

class ApiTest extends WebTestCase
{ 
    public function testConnexion()
    {
        $client = new Client([
            'base_uri' => 'http://127.0.0.1:8000/api/books/research/',
            'verify' => false,
        ]);

        $response = $client->request('GET', '?name=re');
        $content = $response->getBody()->getContents();
        $content = json_decode($content, true);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(count($content)-1, $content[count($content)-1]["TotalResponse"]);

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