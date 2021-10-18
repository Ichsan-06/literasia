<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Posts;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class CrudPostsTest extends TestCase
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
        ])->json('POST',url('api/posts'),[
            'user_id'   => 3000,
            'title' => 'test1',
            'content' => 'test1@gmail.com',
        ]);
        
        User::where('name','test')->delete();
        $response->assertStatus(200);
        Posts::where('title','test1')->delete();
    }

    public function test_delete(){
        $token = $this->authenticate();
        $posts = Posts::create([
            'user_id'   => 3000,
            'title' => 'test1',
            'content' => 'test1@gmail.com',
        ]);        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json("DELETE",url('api/posts/'.$posts->id,));

        User::where('name','test')->delete();
        $response->assertStatus(200);
    }

    public function test_getalldata(){
        //Authenticate and attach recipe to user
        $token = $this->authenticate();
        $posts = Posts::create([
            'user_id'   => 3000,
            'title' => 'test1',
            'content' => 'test1@gmail.com',
        ]);
        //call route and assert response
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET',url('api/posts/'));
       
        User::where('name','test')->delete();
        $response->assertStatus(200);
        Posts::where('title','test1')->delete();
    }
    public function test_showdata(){
        $token = $this->authenticate();
        $posts = Posts::create([
            'user_id'   => 3000,
            'title' => 'test1',
            'content' => 'test1@gmail.com',
        ]);
        //call route and assert response
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET',url('api/posts/'.$posts->id));


        User::where('name','test')->delete();
        $response->assertStatus(200);
        Posts::where('title','test1')->delete();
    }

    public function testUpdate(){
        $token = $this->authenticate();
        $posts = Posts::create([
            'user_id'   => 3000,
            'title' => 'test1',
            'content' => 'test1@gmail.com',
        ]);
        //call route and assert response
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('PUT',url('api/posts/'.$posts->id),[
            'title' => 'Rice',
        ]);
        User::where('name','test')->delete();
        $response->assertStatus(200);
        Posts::where('title','test1')->delete();
    }
}
