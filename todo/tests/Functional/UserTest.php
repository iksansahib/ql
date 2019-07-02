<?php

namespace Tests\Functional;

class UserTest extends BaseTestCase
{
    /**
     * Test that the index route returns a rendered response containing the text 'SlimFramework' but not a greeting
     */
    public function testRegister()
    {
        $digits = 3;
        $random = rand(pow(10, $digits-1), pow(10, $digits)-1);
        $response = $this->runApp('POST', '/api/v1/register', [
            "username"=>"iksantes".$random,
            "password"=>"iksantes123"
        ]);
        $obj = (array) json_decode($response->getBody());
        $this->assertEquals(['message'=>"Berhasil register"], $obj);        
    }

    public function testRegisterGagal()
    {
        $user["usernam"] = "iksantestes";
        $user["password"] = "iksantes123";
        $response = $this->runApp('POST', '/api/v1/register', $user);
        $obj = (array) json_decode($response->getBody());
        $this->assertEquals(['message'=>"Gagal register"], $obj);        
    }

    public function testRegisterGagalUserEksis()
    {
        $user["username"] = "iksantes";
        $user["password"] = "iksantes123";
        $response = $this->runApp('POST', '/api/v1/register', $user);
        $obj = (array) json_decode($response->getBody());
        $this->assertEquals(['message'=>"User eksis"], $obj);        
    }

    public function testLoginSukses()
    {
        $user["username"] = "iksantes";
        $user["password"] = "iksantes123";
        $response = $this->runApp('POST', '/api/v1/login', $user);
        $obj = (array) json_decode($response->getBody());
        $this->assertEquals(['message'=>"Login sukses"], $obj);        
    }

    public function testLoginGagal()
    {
        $user["usernam"] = "iksantes";
        $user["password"] = "iksantes123";
        $response = $this->runApp('POST', '/api/v1/login', $user);
        $obj = (array) json_decode($response->getBody());
        $this->assertEquals(['message'=>"Login gagal"], $obj);        
    }

    public function testLoginGagalPasswordOrUsernameSalah()
    {
        $user["username"] = "iksantes";
        $user["password"] = "passwordsalah";
        $response = $this->runApp('POST', '/api/v1/login', $user);
        $obj = (array) json_decode($response->getBody());
        $this->assertEquals(['message'=>"Login gagal"], $obj);        
    }

    public function testLogout()
    {
        $response = $this->runApp('POST', '/api/v1/logout');
        $obj = (array) json_decode($response->getBody());
        $this->assertEquals(['message'=>"Logout Sukses"], $obj);        
    }

}
