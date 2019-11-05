<?php

namespace Tests\Unit;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testBasic(){
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function testFileUpload()
    {
        $user = User::find(1);
        Storage::fake('public');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->actingAs($user)
            ->json('POST', '/api/file/upload', [
                'photos' => $file,
            ]);
        Storage::disk('public')->assertExists($user->id."/".$file->hashName());

    }

    public function testFileList()
    {
        $user = User::find(1);

        $response = $this->actingAs($user)
            ->json('GET', '/api/file/list');
        // Assert the file was stored...
        $response->assertStatus(200)
            ->assertJsonStructure(array(array("url")));

    }

    public function testFileDelete()
    {
        $user = User::find(1);
        Storage::fake('public');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->actingAs($user)
            ->json('POST', '/api/file/upload', [
                'photos' => $file,
            ]);
        // Assert the file was stored...
        Storage::disk('public')->assertExists($user->id."/".$file->hashName());


        $response = $this->actingAs($user)
            ->json('DELETE', '/api/file/delete/'.$file->hashName());
        $response->assertStatus(200);

    }
}
