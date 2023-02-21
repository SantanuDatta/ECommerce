<?php

namespace App\Http\View\Composers;

use App\Models\Flash;
use Illuminate\View\View;

class FlashComposer
{
    public function compose(View $view)
    {
        $view->with('flashes', Flash::where('status', '1')->get());
    }
}
