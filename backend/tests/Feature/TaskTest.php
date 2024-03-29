<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;
use App\Http\Requests\CreateTask;
use App\User;

class TaskTest extends TestCase
{
    /**
     * 各テストメソッドの実行前に呼ばれる
     */
    public function setUp() :void
    {
        parent::setUp();

        // テストケース実行前にフォルダデータを作成する
        $this->seed('FoldersTableSeeder');
    }

    /**
     * 期限日が日付ではない場合はバリデーションエラー
     * @test
     */
    public function due_date_should_be_date()
    {
        $response = $this
            ->actingAs(User::find(1))
            ->post('/folders/1/tasks/create', [
                'title' => 'Sample task',
                'due_date' => 123,
            ]);


        $response->assertSessionHasErrors([
            'due_date' => '期限日 には日付を入力してください。',
        ]);
    }

    /**
     * 期限日が過去日付の場合はバリデーションエラー
     * @test
     */
    public function due_date_should_not_be_past()
    {
        $response = $this
            ->actingAs(User::find(1))
            ->post('/folders/1/tasks/create', [
                'title' => 'Sample task',
                'due_date' => Carbon::yesterday()->format('Y/m/d'), // 不正なデータ（昨日の日付）
            ]);

        $response->assertSessionHasErrors([
            'due_date' => '期限日 には今日以降の日付を入力してください。',
        ]);
    }

    /**
     * 状態が定義された値ではない場合はバリデーションエラー
     * @test
     */
    public function status_should_be_within_defind_numbers()
    {
        $response = $this
            ->actingAs(User::find(1))
            ->post('/folders/1/tasks/1/edit', [
                'title' => 'Sample test',
                'due_datae' => Carbon::today()->format('Y/m/d'),
                'status' => 999,
            ]);

        $response->assertSessionHasErrors([
            'status' => '状態 には未着手、着手中、完了のいずれかを指定してください。'
        ]);
    }
}
