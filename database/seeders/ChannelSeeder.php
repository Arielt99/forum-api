<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Channel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('channels')->delete();

        $file = "database/data/channels.json";
        
        if (File::exists($file)){
            $json = File::get($file);
            $data = json_decode($json);
            foreach($data as $obj){
                Channel::create(array(
                    'title' => $obj->title,
                    'slug' => Str::slug($obj->title),
                    'description' => $obj->description,
                ));
            }
        }else{
            Channel::factory(10)->create();
        }
    }
}
