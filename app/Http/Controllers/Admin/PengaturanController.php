<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feature;

class PengaturanController extends Controller
{
	public function index()
	{
		$aboutus = Feature::getByName('about-us');

		if (!$aboutus)
		{
			Feature::create([
				'name'=>'about-us',
				'value' => json_encode([
					'description'=>'',
					'images'=>[]
				])
			]);
			$aboutus = Feature::getByName('aboutus');
		}
		$aboutus = $aboutus ? $aboutus->value : [];

		$social = Feature::getByName('social-media');
		if (!$social)
		{
			Feature::create([
				'name'=>'social-media',
				'value' => json_encode([
					'facebook'=>[
						'link'=>'',
						'icon'=>'fa fa-facebook'
					],
					'twitter'=>[
						'link'=>'',
						'icon'=>'fa fa-twitter'
					],
					'instagram'=>[
						'link'=>'',
						'icon'=>'fa fa-instagram'
					],
					'youtube'=>[
						'link'=>'',
						'icon'=>'fa fa-youtube'
					]
				])
			]);
			$social = Feature::getByName('social-media');
		}
		$social = $social ? $social->value : [];

		return view('admin.pengaturan.index', compact('aboutus','social'));
	}

	public function update(Request $request)
	{
		$this->validate($request, [
			'description' => 'required|string'
		]);

		$aboutus = Feature::getByName('about-us')->value;
		$aboutus->description = $request->description;

		if ($request->file('image'))
		{

			$image = $request->file('image');
			$imageName = uniqid() . '-' .time() . '.' . $image->getClientOriginalExtension();
			$image->move('images/about-us', $imageName);
			$imageUrl = 'images/about-us/'. $imageName;

			$aboutus->images = $imageUrl;
		}

		Feature::where('name', 'about-us')->update([
			'value' => json_encode($aboutus)
		]);

		$social = Feature::getByName('social-media')->value;

		Feature::where('name','social-media')->update([
			'value' => json_encode([
				'facebook'=>[
					'link'=> $request->link_facebook ? $request->link_facebook : 'https://facebook.com',
					'icon'=> 'fa fa-facebook'
				],
				'twitter'=>[
					'link'=> $request->link_twitter ? $request->link_twitter : 'https://twitter.com',
					'icon'=> 'fa fa-twitter'
				],
				'instagram'=>[
					'link'=> $request->link_instagram ? $request->link_instagram : 'https://instagram.com',
					'icon'=> 'fa fa-instagram'
				],
				'youtube'=>[
					'link'=> $request->link_youtube ? $request->link_youtube : 'https://youtube.com',
					'icon'=> 'fa fa-youtube'
				]
			])
		]);

		return response()->json(['status' => true]);
	}

	public function destroy(Request $request)
	{
		$aboutus = Feature::getByName('about-us')->value;
		if (isset($aboutus->images[$request->key]))
		{
			if (file_exists(public_path($aboutus->images[$request->key])))
			{
				unlink(public_path($aboutus->images[$request->key]));
			}
			unset($aboutus->images[$request->key]);
			$aboutus->images = array_values($aboutus->images);
			Feature::where('name', 'about-us')->update([
				'value' => json_encode($aboutus)
			]);
		}
		return response()->json(['status' => true]);
	}

	public function upload(Request $request)
	{
		$this->validate($request, [
			'image' => 'image|required'
		]);
		if ($request->file('image'))
		{
			$aboutus = Feature::getByName('about-us')->value;

			$image = $request->file('image');
			$imageName = uniqid() . '-' .time() . '.' . $image->getClientOriginalExtension();
			$image->move('images/about-us', $imageName);
			$imageUrl = 'images/about-us/'. $imageName;

			array_push($aboutus->images, $imageUrl);
			Feature::where('name', 'about-us')->update([
				'value' => json_encode($aboutus)
			]);
			return response()->json(['status' => true]);
		}
		return response()->json(['status' => false]);
	}
}
