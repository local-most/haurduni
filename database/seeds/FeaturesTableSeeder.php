<?php

use Illuminate\Database\Seeder;

class FeaturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // social media
        DB::table('features')->insert([
            'name' => 'social-media',
            'value' => json_encode([
            	'facebook'=>[
            		'link'=>'facebook.com',
            		'icon'=>'fa fa-facebook'
            	],
            	'twitter'=>[
            		'link'=>'twitter.com',
            		'icon'=>'fa fa-twitter'
            	],
            	'instagram'=>[
            		'link'=>'instagram.com',
            		'icon'=>'fa fa-instagram'
            	],
            	'youtube'=>[
            		'link'=>'youtube.com',
            		'icon'=>'fa fa-youtube'
            	]
            ])
        ]);

        if(!File::exists(public_path('images/about-us')))
    	{
		    File::makeDirectory(public_path('images/about-us'), 0775, true);
		}

        DB::table('features')->insert([
            'name' => 'about-us',
            'value' => json_encode([
            	'description'=>'<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsam hic incidunt exercitationem, odit non dolorum repellat expedita atque tempore vero recusandae.</p>',
            	'images'=> null
            ])
        ]);
    }
}
