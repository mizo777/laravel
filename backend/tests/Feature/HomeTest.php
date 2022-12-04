<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class HomeTest extends TestCase
{
    /**
     * トップページ表示内容テスト
     *
     * @return void
     */
    public function testIndex()
    {
        $user = factory(User::class)->create();
        // $user = User::find(1);
        $response = $this
            ->actingAs($user)
            ->get('/');

        $response->assertStatus(200);
    }
}
