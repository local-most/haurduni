<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;

use App\Models\Kategori;

class HomeComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {   
        $social = \App\Models\Feature::getByName('social-media');
        $about = \App\Models\Feature::getByName('about-us');

        $view->with('social', $social);
        $view->with('about', $about);
    }
}