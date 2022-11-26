<?php 

namespace App\Http\View\Composers;
use App\Models\Setting;
use Illuminate\View\View;

class SettingComposer{
    public function compose(View $view)
    {
        $view->with('settings', Setting::where('id', 1)->get());
    }
}
