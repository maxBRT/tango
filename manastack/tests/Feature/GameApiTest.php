<?php

namespace Tests\Feature;

use App\Models\Game;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GameApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_lists_all_games(): void
    {
        Game::factory()->count(4)->create();

        $response = $this->getJson('/api/games');

        $response->assertStatus(200)->assertJsonCount(4, 'data');
    }

    public function test_index_returns_empty_list(): void
    {
        $response = $this->getJson('/api/games');

        $response->assertStatus(200)->assertJsonCount(0, 'data');
    }

    public function test_show_returns_a_game(): void
    {
        $game = Game::factory()->create(['title' => 'Zelda']);

        $response = $this->getJson("/api/games/{$game->id}");

        $response->assertStatus(200)->assertJson([
            'data' => [
                'id' => $game->id,
                'title' => 'Zelda',
            ],
        ]);
    }

    public function test_show_returns_404_for_invalid_id(): void
    {
        $response = $this->getJson('/api/games/nonexistent-id');

        $response->assertStatus(404);
    }

    public function test_store_creates_a_game(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/games', ['title' => 'Dark Souls', 'user_id' => $user->id]);

        $response->assertStatus(201)->assertJson([
            'data' => [
                'title' => 'Dark Souls',
            ],
        ]);

        $this->assertDatabaseHas('games', ['title' => 'Dark Souls', 'user_id' => $user->id]);
    }

    public function test_store_requires_a_title(): void
    {
        $response = $this->postJson('/api/games', []);

        $response->assertStatus(422)->assertJsonValidationErrors('title');
    }

    public function test_update_modifies_a_game(): void
    {
        $game = Game::factory()->create(['title' => 'Old Title']);

        $response = $this->putJson("/api/games/{$game->id}", ['title' => 'New Title']);

        $response->assertStatus(200)->assertJson([
            'data' => [
                'id' => $game->id,
                'title' => 'New Title',
            ],
        ]);

        $this->assertDatabaseHas('games', ['id' => $game->id, 'title' => 'New Title']);
    }

    public function test_update_requires_a_title(): void
    {
        $game = Game::factory()->create();

        $response = $this->putJson("/api/games/{$game->id}", []);

        $response->assertStatus(422)->assertJsonValidationErrors('title');
    }

    public function test_update_returns_404_for_invalid_id(): void
    {
        $response = $this->putJson('/api/games/nonexistent-id', ['title' => 'Whatever']);

        $response->assertStatus(404);
    }

    public function test_destroy_deletes_a_game(): void
    {
        $game = Game::factory()->create();

        $response = $this->deleteJson("/api/games/{$game->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('games', ['id' => $game->id]);
    }

    public function test_destroy_returns_404_for_invalid_id(): void
    {
        $response = $this->deleteJson('/api/games/nonexistent-id');

        $response->assertStatus(404);
    }
}
