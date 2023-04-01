<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use GuzzleHttp\Client; 

class ApiTest extends WebTestCase
{ 


    private $token_user;

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
            $this->token_user = $data["token"];
            $this->assertTrue(true);
        }else{
            $this->assertTrue(false);
        }
    }


    public function testListFriends(){
        $client = new Client([
            'base_uri' => 'http://127.0.0.1:8000/'
        ]);



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
        $json = json_encode([
            'token' => $data["token"],
        ]);

        var_dump($json);
        $headers = [
            'Content-Type' => 'application/json',
            'Expect' => '100-continue',
        ];
        $response = $client->request('POST', '/api/amis', [
            'headers' => $headers,
            'body' => $json,
        ]);
        $content = $response->getBody()->getContents();
        $content = json_decode($content, true);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testSearchBar()
    {
        $client = new Client([
            'base_uri' => 'http://127.0.0.1:8000/api/books/research/',
            'verify' => false,
        ]);
        $count=0;
        $response = $client->request('GET', '?name=&maxResults=500&startIndex=0');
        $content = $response->getBody()->getContents();
        $content = json_decode($content, true);
        $this->assertEquals(200, $response->getStatusCode());
        foreach ($content["livres"] as $book){
            $count+=1;
        }
        $this->assertEquals($count, $content["nbResults"]);

        $count=0;
        $response = $client->request('GET', '?name=re&maxResults=600&startIndex=0');
        $content = $response->getBody()->getContents();
        $content = json_decode($content, true);
        $this->assertEquals(200, $response->getStatusCode());
        foreach ($content["livres"] as $book){
            $count+=1;
        }
        $this->assertEquals($count, $content["nbResults"]);

    }
}