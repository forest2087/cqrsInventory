<?php

use Illuminate\Database\Seeder;

use Webpatser\Uuid\Uuid;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $same_uuid = Uuid::generate();
        DB::table('items')->insert([
            'itemID' => Uuid::generate(),
            'label' => 'cat',
            'type' => 'animal',
            'event' => 'add',
            'expire_at' => new DateTime('2016-03-01'),
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);

        DB::table('items')->insert([
            'itemID' => Uuid::generate(),
            'label' => 'dog',
            'type' => 'animal',
            'event' => 'add',
            'expire_at' => new DateTime('2016-03-02'),
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);

        DB::table('items')->insert([
            'itemID' => Uuid::generate(),
            'label' => 'dog',
            'type' => 'animal',
            'event' => 'add',
            'expire_at' => new DateTime('2016-03-02'),
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);

        DB::table('items')->insert([
            'itemID' => Uuid::generate(),
            'label' => 'dog',
            'type' => 'animal',
            'event' => 'add',
            'expire_at' => new DateTime('2015-03-02'),
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);


        DB::table('items')->insert([
            'itemID' => $same_uuid,
            'label' => 'turtle',
            'type' => 'animal',
            'event' => 'add',
            'expire_at' => new DateTime('2016-03-02'),
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);

        DB::table('items')->insert([
            'itemID' => $same_uuid,
            'label' => 'turtle',
            'type' => 'animal',
            'event' => 'remove',
            'expire_at' => new DateTime('2016-03-02'),
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);



    }
}
