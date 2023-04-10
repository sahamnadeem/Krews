<?php

namespace Tests\Unit;

use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    
    public function test_register(){
        $response = $this->postJson('api/register', [
            'name' => 'Saham Nadeem',
            'email' => 'test.user4@krews.com',
            'password' => 'KrewsTestingPassword.?@99',
            'password_confirmation'=>'KrewsTestingPassword.?@99'
       ]);
   
       $response->assertStatus(200);
       $responseData = json_decode($response->getContent(), true);
       $this->assertTrue(isset($responseData['token']));
       $this->assertTrue(isset($responseData['user']));
    }

    public function test_login(){
        $response = $this->postJson('api/login', [
            'email' => 'admin@krews.com',
            'password' => '123456789'
       ]);
   
       $response->assertStatus(200);
       $responseData = json_decode($response->getContent(), true);
       $this->assertTrue(isset($responseData['token']));
       $this->assertTrue(isset($responseData['user']));

    }
}
