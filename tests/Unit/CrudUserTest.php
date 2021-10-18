<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class CrudUserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected function authenticate(){
        $user = User::create([
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => Hash::make('secret1234'),
        ]);
        $token = $user->createToken('LaravelAuthApp')->accessToken;

        return $token;
    }

    public function test_create()
    {
        //Get token
        $token = $this->authenticate();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('POST',url('api/user'),[
            'name' => 'Jollof Rice',
            'email' => 'an@gmail.com',
            'password' => Hash::make('secret1234'),
        ]);
        User::where('email','test@gmail.com')->delete();
        $response->assertStatus(200);
        User::where('email','an@gmail.com')->delete();
    }

    public function test_delete(){
        $token = $this->authenticate();
        $user = User::create([
            'name' => 'Jollof Rice',
            'email' => 'an@gmail.com',
            'password' => Hash::make('secret1234'),
        ]);        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json("DELETE",url('api/user/'.$user->id,));
        User::where('email','test@gmail.com')->delete();
        $response->assertStatus(200);
    }

    public function test_getalldata(){
        //Authenticate and attach recipe to user
        $token = $this->authenticate();
        $user = User::create([
            'name' => 'Jollof Rice',
            'email' => 'an@gmail.com',
            'password' => Hash::make('secret1234'),
        ]);
        //call route and assert response
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET',url('api/user/'));
        User::where('email','test@gmail.com')->delete();
        $response->assertStatus(200);
        User::where('email','an@gmail.com')->delete();
    }
    public function test_showdata(){
        $token = $this->authenticate();
        $user = User::create([
            'name' => 'Jollof Rice',
            'email' => 'an@gmail.com',
            'password' => Hash::make('secret1234'),
        ]);
        //call route and assert response
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET',url('api/user/'.$user->id));
        User::where('email','test@gmail.com')->delete();
        $response->assertStatus(200);
        User::where('email','an@gmail.com')->delete();
    }

    public function testUpdate(){
        $token = $this->authenticate();
        $user = User::create([
            'name' => 'Jollof Rice',
            'email' => 'an@gmail.com',
            'password' => Hash::make('secret1234'),
        ]);
        //call route and assert response
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('PUT',url('api/user/'.$user->id),[
            'name' => 'Rice',
        ]);
        User::where('email','test@gmail.com')->delete();
        $response->assertStatus(200);
        User::where('email','an@gmail.com')->delete();
    }


    //Test the delete route
    
    
}
