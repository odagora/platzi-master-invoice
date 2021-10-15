<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ViewProductsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function it_can_view_all_products(){
        $product = \App\Models\Product::factory()->create();

        $this->get('/')
            ->assertSee($product->name);

    }
}
