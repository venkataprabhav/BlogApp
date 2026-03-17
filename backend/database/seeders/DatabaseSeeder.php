<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $users = collect([
            ['name' => 'Alice Johnson', 'email' => 'alice@example.com'],
            ['name' => 'Bob Smith',     'email' => 'bob@example.com'],
            ['name' => 'Carol White',   'email' => 'carol@example.com'],
            ['name' => 'David Brown',   'email' => 'david@example.com'],
            ['name' => 'Test User',     'email' => 'test@example.com'],
        ])->map(fn ($data) => User::factory()->create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt('pass123.'),
        ]));

        Post::factory(50)->create([
            'user_id' => fn () => $users->random()->id,
        ]);
    }
}
