<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Friend;
use App\Models\Lending;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LendBookTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_cannot_lend_a_book_that_is_already_lent_out()
    {
        // 1. Arrange: create a book and a friend
        $book   = Book::factory()->create();
        $friend = Friend::factory()->create();

        // 2. Arrange: create an existing lending for this book with no return_at
        Lending::factory()->create([
            'book_id'   => $book->id,
            'friend_id' => $friend->id,
            'lent_at'   => now()->subDays(2)->format('Y-m-d'),
            'due_at'    => now()->addDays(5)->format('Y-m-d'),
            'return_at' => null, // still out
        ]);

        // 3. Act: try to lend the same book again
        $response = $this->postJson('/api/lendings', [
            'book_id'   => $book->id,
            'friend_id' => $friend->id,
            'lent_at'   => now()->format('Y-m-d'),
            'due_at'    => now()->addDays(7)->format('Y-m-d'),
        ]);

        // 4. Assert: we get a 422 and the right message
        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'This book is already lent out.',
        ]);
    }
}
