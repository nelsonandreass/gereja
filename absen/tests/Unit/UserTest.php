<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\User;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function testLoginPage(){
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function testLoginRequest(){
        $user1 = User::make([
            'name' => "test",
            'email' => "test@gmail.com"
        ]);
        $user2 = User::make([
            'name' => "test1",
            'email' => "test2@gmail.com"
        ]);
        $this->assertTrue($user1->name != $user2->name);
    }

    public function testLoginReq(){
        $response = $this->post('/login', [
            'email' => 'superadmin@gmail.com',
            'password' => 'password'
        ]);
        $response->assertStatus(200);
    }
    
}
