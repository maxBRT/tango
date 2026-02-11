<?php

namespace Tests\Unit\Services;

use App\Models\Game;
use App\Models\User;
use App\Services\GameService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class GameServiceTest extends TestCase
{
    use RefreshDatabase;

    private GameService $gameService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->gameService = new GameService;
    }

    public function test_list_returns_all_games(): void
    {
        Game::factory()->count(3)->create();

        $games = $this->gameService->list();

        $this->assertCount(3, $games);
    }

    public function test_list_returns_empty_collection_when_no_games(): void
    {
        $games = $this->gameService->list();

        $this->assertCount(0, $games);
    }

    public function test_find_returns_game_by_id(): void
    {
        $game = Game::factory()->create(['title' => 'Zelda']);

        $found = $this->gameService->find($game->id);

        $this->assertEquals($game->id, $found->id);
        $this->assertEquals('Zelda', $found->title);
    }

    public function test_find_throws_exception_for_invalid_id(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->gameService->find('nonexistent-id');
    }

    public function test_create_persists_a_game(): void
    {
        $user = User::factory()->create();

        $game = $this->gameService->create(['title' => 'Dark Souls', 'user_id' => $user->id]);

        $this->assertDatabaseHas('games', ['id' => $game->id, 'title' => 'Dark Souls', 'user_id' => $user->id]);
        $this->assertEquals('Dark Souls', $game->title);
        $this->assertEquals($user->id, $game->user_id);
    }

    public function test_create_fails_without_title(): void
    {
        $user = User::factory()->create();

        $this->expectException(ValidationException::class);

        $this->gameService->create(['user_id' => $user->id]);
    }

    public function test_create_fails_without_user_id(): void
    {
        $this->expectException(ValidationException::class);

        $this->gameService->create(['title' => 'Dark Souls']);
    }

    public function test_update_modifies_a_game(): void
    {
        $game = Game::factory()->create(['title' => 'Old Title']);

        $updated = $this->gameService->update($game->id, ['title' => 'New Title']);

        $this->assertEquals('New Title', $updated->title);
        $this->assertDatabaseHas('games', ['id' => $game->id, 'title' => 'New Title']);
    }

    public function test_update_fails_without_title(): void
    {
        $game = Game::factory()->create();

        $this->expectException(ValidationException::class);

        $this->gameService->update($game->id, []);
    }

    public function test_update_throws_exception_for_invalid_id(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->gameService->update('nonexistent-id', ['title' => 'Whatever']);
    }

    public function test_delete_removes_a_game(): void
    {
        $game = Game::factory()->create();

        $this->gameService->delete($game->id);

        $this->assertDatabaseMissing('games', ['id' => $game->id]);
    }

    public function test_delete_throws_exception_for_invalid_id(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->gameService->delete('nonexistent-id');
    }
}
