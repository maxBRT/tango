<?php

namespace Tests\Feature;

use App\Models\ApiKey;
use App\Models\Game;
use App\Models\Player;
use App\Models\Save;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class SaveApiTest extends TestCase
{
    use RefreshDatabase;

    private Game $game;

    private Player $player;

    private string $plainTextKey;

    protected function setUp(): void
    {
        parent::setUp();

        $this->game = Game::factory()->create();
        $this->plainTextKey = Str::random(40);

        ApiKey::factory()->create([
            'game_id' => $this->game->id,
            'key' => hash('sha256', $this->plainTextKey),
        ]);

        $this->player = Player::factory()->create([
            'game_id' => $this->game->id,
        ]);
    }

    private function apiHeaders(): array
    {
        return ['X-API-Key' => $this->plainTextKey];
    }

    public function test_index_lists_saves_for_player(): void
    {
        Save::factory()->count(3)->create(['player_id' => $this->player->id]);

        $response = $this->getJson(
            "/api/players/{$this->player->id}/saves",
            $this->apiHeaders()
        );

        $response->assertStatus(200)->assertJsonCount(3, 'data');
    }

    public function test_index_returns_empty_list_when_no_saves(): void
    {
        $response = $this->getJson(
            "/api/players/{$this->player->id}/saves",
            $this->apiHeaders()
        );

        $response->assertStatus(200)->assertJsonCount(0, 'data');
    }

    public function test_store_creates_a_save(): void
    {
        $response = $this->postJson(
            "/api/players/{$this->player->id}/saves",
            ['name' => 'slot1', 'data' => ['level' => 5, 'hp' => 100]],
            $this->apiHeaders()
        );

        $response->assertStatus(201);
        $response->assertJsonPath('data.name', 'slot1');
        $response->assertJsonPath('data.save_data', ['level' => 5, 'hp' => 100]);
        $response->assertJsonPath('data.player_id', $this->player->id);

        $this->assertDatabaseHas('saves', [
            'player_id' => $this->player->id,
            'name' => 'slot1',
        ]);
    }

    public function test_store_requires_name_and_data(): void
    {
        $response = $this->postJson(
            "/api/players/{$this->player->id}/saves",
            [],
            $this->apiHeaders()
        );

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'data']);
    }

    public function test_show_returns_a_save(): void
    {
        $save = Save::factory()->create([
            'player_id' => $this->player->id,
            'name' => 'autosave',
            'data' => ['level' => 10],
        ]);

        $response = $this->getJson(
            "/api/players/{$this->player->id}/saves/{$save->id}",
            $this->apiHeaders()
        );

        $response->assertStatus(200);
        $response->assertJsonPath('data.id', $save->id);
        $response->assertJsonPath('data.name', 'autosave');
        $response->assertJsonPath('data.save_data', ['level' => 10]);
    }

    public function test_show_returns_404_for_save_of_different_player(): void
    {
        $otherPlayer = Player::factory()->create(['game_id' => $this->game->id]);
        $save = Save::factory()->create(['player_id' => $otherPlayer->id]);

        $response = $this->getJson(
            "/api/players/{$this->player->id}/saves/{$save->id}",
            $this->apiHeaders()
        );

        $response->assertStatus(404);
    }

    public function test_update_modifies_a_save(): void
    {
        $save = Save::factory()->create([
            'player_id' => $this->player->id,
            'name' => 'slot1',
            'data' => ['level' => 1],
        ]);

        $response = $this->putJson(
            "/api/players/{$this->player->id}/saves/{$save->id}",
            ['data' => ['level' => 50, 'hp' => 200]],
            $this->apiHeaders()
        );

        $response->assertStatus(200);
        $response->assertJsonPath('data.id', $save->id);
        $response->assertJsonPath('data.name', 'slot1');
        $response->assertJsonPath('data.save_data', ['level' => 50, 'hp' => 200]);
    }

    public function test_destroy_deletes_a_save(): void
    {
        $save = Save::factory()->create([
            'player_id' => $this->player->id,
        ]);

        $response = $this->deleteJson(
            "/api/players/{$this->player->id}/saves/{$save->id}",
            [],
            $this->apiHeaders()
        );

        $response->assertStatus(204);
        $this->assertDatabaseMissing('saves', ['id' => $save->id]);
    }

    public function test_destroy_returns_404_for_nonexistent_save(): void
    {
        $response = $this->deleteJson(
            "/api/players/{$this->player->id}/saves/nonexistent-id",
            [],
            $this->apiHeaders()
        );

        $response->assertStatus(404);
    }

    public function test_cannot_access_saves_for_player_from_different_game(): void
    {
        $otherGame = Game::factory()->create();
        $otherPlayer = Player::factory()->create(['game_id' => $otherGame->id]);

        $response = $this->getJson(
            "/api/players/{$otherPlayer->id}/saves",
            $this->apiHeaders()
        );

        $response->assertStatus(404);
    }
}
