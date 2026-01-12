<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\FavoriteMovie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoriteMovieTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate(): User
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum');

        return $user;
    }

    /** @test */
    public function authenticated_user_can_add_a_movie_to_favorites()
    {
        $this->authenticate();

        $payload = [
            'tmdb_movie_id' => 1000837,
            'title' => 'Ainda Estou Aqui',
            'poster_path' => '/gZnsMbhCvhzAQlKaVpeFRHYjGyb.jpg',
        ];

        $response = $this->postJson('/api/favorites', $payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('favorite_movies', [
            'tmdb_movie_id' => 1000837,
            'title' => 'Ainda Estou Aqui',
        ]);
    }

    /** @test */
    public function authenticated_user_can_list_their_favorite_movies()
    {
        $user = $this->authenticate();

        FavoriteMovie::create([
            'user_id' => $user->id,
            'tmdb_movie_id' => 10096,
            'title' => 'De Repente 30',
            'poster_path' => '/wTIZLDE1tXAl8jTm8CuvjHDUwgi.jpg',
        ]);

        $response = $this->getJson('/api/favorites');

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'tmdb_movie_id' => 10096,
                'title' => 'De Repente 30',
            ]);
    }

    /** @test */
    public function authenticated_user_can_remove_a_favorite_movie()
    {
        $user = $this->authenticate();

        $favorite = FavoriteMovie::create([
            'user_id' => $user->id,
            'tmdb_movie_id' => 540,
            'title' => 'D.E.B.S',
            'poster_path' => '/78mnEEftCn4RBz68VRCRIgb1o3o.jpg',
        ]);

        $response = $this->deleteJson("/api/favorites/{$favorite->tmdb_movie_id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('favorite_movies', [
            'id' => $favorite->id,
        ]);
    }

    /** @test */
    public function unauthenticated_user_cannot_access_favorites()
    {
        $response = $this->getJson('/api/favorites');

        $response->assertStatus(401);
    }
}
