<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class HotelsControllerTest extends TestCase
{
    public function test_successful_search()
    {
        $response = $this->get('/api/hotels?city=dubai&price_range=100:150');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     '*' => [
                         'city',
                         'name',
                         'price',
                         'availability'
                     ]
                 ]);
    }
    public function test_failed_fetching_hotels()
{
    // Mock a failure when fetching hotels
    Http::fake([
        'https://api.npoint.io/dd85ed11b9d8646c5709' => Http::response([], 500),
    ]);

    $response = $this->get('/api/hotels');

    $response->assertStatus(500)
             ->assertJson(['error' => 'Failed to fetch hotels']);
}

public function test_filter_by_name()
{
    $response = $this->get('/api/hotels?name=Novotel Hotel');

    $response->assertStatus(200)
             ->assertJsonCount(1)
             ->assertJsonFragment(['name' => 'Novotel Hotel']);
}

public function test_filter_by_city()
{
    $response = $this->get('/api/hotels?city=paris');

    $response->assertStatus(200)
             ->assertJsonCount(1)
             ->assertJsonFragment(['city' => 'paris']);
}



public function test_sort_by_name()
{
    $response = $this->get('/api/hotels?sort_by=name');

    $response->assertStatus(200)
             ->assertJson(function ($json) {
                 $names = collect($json)->pluck('name')->values();
                 $sortedNames = $names->sort();
                 $this->assertEquals($names, $sortedNames);
             });
}



}
