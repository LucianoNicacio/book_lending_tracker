<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Friend;
use App\Models\Lending;

class LendingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = Book::all();
        $friends = Friend::all();

        if ($books->isEmpty() || $friends->isEmpty()) {
            // Ensure there is data to link to
            $this->command->warn('No books or friends found. Run BookSeeder and FriendSeeder first.');
            return;
        }

        Lending::factory()
            ->count(100)
            ->make() // create in memory so we can assign IDs first
            ->each(function ($lending) use ($books, $friends) {
                $lending->book_id = $books->random()->id;
                $lending->friend_id = $friends->random()->id;
                $lending->save();
            });
    }
}
