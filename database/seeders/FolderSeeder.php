<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FolderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('folders')->upsert([
            [
                'id' => 1,
                'name' => 'folder_1',
                'parent_id' => null,
            ],
            [
                'id' => 2,
                'name' => 'folder_2',
                'parent_id' => null,
            ],
            [
                'id' => 3,
                'name' => 'folder_1_1',
                'parent_id' => 1,
            ],
            [
                'id' => 4,
                'name' => 'folder_1_1_1',
                'parent_id' => 3,
            ],
            [
                'id' => 5,
                'name' => 'folder_1_1_2',
                'parent_id' => 3,
            ],
            [
                'id' => 6,
                'name' => 'folder_1_2',
                'parent_id' => 1,
            ],
            [
                'id' => 7,
                'name' => 'folder_1_2_1',
                'parent_id' => 6,
            ],
            [
                'id' => 8,
                'name' => 'folder_1_2_2',
                'parent_id' => 6,
            ],
            [
                'id' => 9,
                'name' => 'folder_2_1',
                'parent_id' => 2,
            ],
            [
                'id' => 10,
                'name' => 'folder_2_1_1',
                'parent_id' => 9,
            ],
            [
                'id' => 11,
                'name' => 'folder_2_1_2',
                'parent_id' => 9,
            ],
            [
                'id' => 12,
                'name' => 'folder_2_2',
                'parent_id' => 2,
            ],
            [
                'id' => 13,
                'name' => 'folder_2_2_1',
                'parent_id' => 12,
            ],
            [
                'id' => 14,
                'name' => 'folder_2_2_2',
                'parent_id' => 12,
            ],
        ], 'id');
    }
}
