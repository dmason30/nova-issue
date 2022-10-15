<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_query_count()
    {
        Artisan::call('db:seed');
        $this->actingAs(User::first());
        $queries = [];
        DB::listen(function ($query) use (&$count, &$queries) {
            $queries[] = Str::replaceArray('?', $query->bindings, $query->sql);
        });

        $this->getJson('/nova-api/profiles?search=&filters=W10%3D&orderBy=&perPage=25&trashed=&page=1&relationshipType')
            ->assertOk()
            ->assertJsonCount(4, 'resources');

        $this->assertSame([
            'select * from `profiles` order by `profiles`.`id` desc limit 26 offset 0',
            'select * from `users` where `users`.`id` in (1, 2, 3, 4)',
            'select count(*) as aggregate from `profiles`',
        ], $queries, 'Expected only 3 queries to be executed!');
    }
}
