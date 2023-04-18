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
            	'description'=>'<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsam hic incidunt exercitationem, odit non dolorum repellat expedita atque tempore vero recusandae. Earum, voluptates amet porro commodi voluptatem ducimus explicabo doloribus?</p><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using Content here, content here, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for lorem ipsum will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>',
            	'images'=> null
            ])
        ]);
    }
}
