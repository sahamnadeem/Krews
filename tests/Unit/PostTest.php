<?php

namespace Tests\Unit;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    private $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNmYyYjFjYzg4ZTY2Nzk5Mzk3YmYxYzU1MDc1ZGY5Zjc1MDRlYTRhZGZmMGYxMWYzYjhmMDE5ZGYzNDM0OTAxOTIzOWM1MThjOTRkZTJjOGIiLCJpYXQiOjE2ODExMzU4NjIuNjAxMzMsIm5iZiI6MTY4MTEzNTg2Mi42MDEzMzMsImV4cCI6MTcxMjc1ODI2MS44ODQ0MTgsInN1YiI6IjIiLCJzY29wZXMiOltdfQ.oSXOVKeLJ1V9WV9rXNCmgK_JD_7zV0AZCv7c2M90aKpWtrwH3wwx8lSviI2xYXS2HfUS5JVXQWo4ixeyKYIfMUW9OSk17CfRmyGX2DldcAE8Hjg3ekuCfLLNocWYIi8pV8n9FvdMyxeMpFQZUQjvxtePiKYdPorrPUwlsAmVEhksgf-qEjEu6gz8CJ0CHYhGE-Nzik52DfG03YDZeLSiQA6C0T4jrYbRBjatwf_OyH4QaCuNIjUPabPOL27ZfqtOe86qidPVSJsoYaBxVQGtiM7Im8AkeuKMaiBilC8ZsqahEaIoUvNXSoNRqrINiCQes_vJmxhDYNUKCXbGA_pixJ9F3BavdpOG7cnyalcI-bIl_H7X6GjQkPsS43laCpLpXwHjYX7Zr06KQb0UwkPl9tue6Eckox1nLsBkZGNcmT2_FM2_DoLomjyHdCTsHjxWvZ790-rXBbEIBTBOLjVxRiXa2KhXttJYtJH0AchjU309euQqkSsp9cMn-Nn_FUcpG9rk6n2Rc2KHn165L9V3nHh0w8G4Tl0X-gcgHGNfgUum0kP7Wb6O_d8ocX82nrmugkYH7kOqH3bauGjHAXCPlfzh8-EisZcxhYx1kpcrdFBE4b_aMDaBMMZ4ekQGzMC6qDPXHhvWXKd1sVHHI6Zh8npl56IMwIN1ZYm4bkjfarE';
    private $user_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYTYyNTM4MzI0NzNkMGFmNGRhYTVlZTcxZjEwOTFkMjE5MzY1YWQwODgzZTliYjYzMGMwMDJhZDExMzQyMTNhNDY3ODZjMTRhNGExZGUxZDEiLCJpYXQiOjE2ODExMzU3MzEuNTMwODQ0LCJuYmYiOjE2ODExMzU3MzEuNTMwODQ3LCJleHAiOjE3MTI3NTgxMzAuOTE5NDIzLCJzdWIiOiIzIiwic2NvcGVzIjpbXX0.aYSye3OrJNk7W6_LZZgyhLNv8TsEmrTDw3I2OE71RNp0NQDEdeAYO5RkbrCyfy82rF16qM94MBRH6kchPuNAd3H99b98gzRhglk0vkLxjU1T_xeGlzaKZM4u0_KEUPtBmob8TbmDFXLrmiTiGJORC1F7ea_0D0LPhNMxEpLEVqiur2vPN7HD5iMoI25L3ljeVhRVQVskba2KyPFh4liHMhWywBhoBcpuX0UUwjornNpDZt8UywKkHOXxcANGoS2DIWMtHMMZu5_E__X44LVmWvsd57NV-2AmO7XggNK-1TEULSO5mp4jcF_cl2Fw39dQQb01iXnYhEwUXpJmW0qkxkVXpGoHGhEHYNd4s93-MefTcX9H9Gmy5TzsctWuEolwjPtdLsD0B8Z9Qh3GztgPwc5qfwcLxXwqtTQOXxq4psuLU0WCYdze3lBsJX3TF_Me8smzJZpOfU6UsJ7d_DTCYOpDF0V0KvFyj_jj5Hi72z09Xdi63WEFJBKomWdGednKTAw4AFVoIAM62VP-HGpI0dp7fxMvGUOVZmx4K83Fq0qJNP1K_LwwMqXCF8h5wYBeI56jHmPoPEDzRtmBaSjfxZGQVVS4T1TQORlsBkhd7nwH0K-nezv-EB-qyaDW6xFSZyfN-jv9Vva-21t0WQZ_LEPIDGtZBcawtQlgGBYMMdA';
    private $admin_post;
    private $user_post;
    

    public function test_create_post(){
        $file = UploadedFile::fake()->image('avatar.jpg');
        $file2 = UploadedFile::fake()->image('avatar2.jpg');
        $response = $this->postJson('/api/post', [
            'title'=>'test title',
            'content'=>'test content',
            'images'=>[$file,$file2],
        ],[
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->token,
        ]);
 
        $response
            ->assertStatus(200);
        $responseData = json_decode($response->getContent(), true);
        Storage::disk('s3')->exists($file->hashName());
        return $responseData['post']['id'];
    }

     /**
      * @depends test_create_post
      */

    public function test_edit_post($id){
        $response = $this->putJson('/api/post/'.$id, [
            'title'=>'test title updated',
            'content'=>'test content updated'
        ],[
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->token,
        ]);
 
        $response
            ->assertStatus(200);
    }

    /**
      * @depends test_create_post
      */
    public function test_user_can_not_delete_others_post($id){
        $response = $this->deleteJson('/api/post/'.$id,[],[
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->user_token,
        ]);
 
        $response
            ->assertStatus(412);
    }

    public function test_create_user_post(){
        $file = UploadedFile::fake()->image('avatar.jpg');
        $file2 = UploadedFile::fake()->image('avatar2.jpg');
        $response = $this->postJson('/api/post', [
            'title'=>'test title',
            'content'=>'test content',
            'images'=>[$file,$file2],
        ],[
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->user_token,
        ]);
 
        $response
            ->assertStatus(200);
        $responseData = json_decode($response->getContent(), true);
        Storage::disk('s3')->exists($file->hashName());
        return $responseData['post']['id'];
    }

    /**
      * @depends test_create_user_post
      */
    public function test_admin_can_delete_others_post($id){
        $response = $this->deleteJson('/api/post/'.$id,[],[
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->user_token,
        ]);
 
        $response
            ->assertStatus(200);
    }
}
