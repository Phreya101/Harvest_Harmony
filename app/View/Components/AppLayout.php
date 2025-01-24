<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

use Auth;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {

        // dito ung part na kulang ka 
        // specify mo dito ung per user na mag login at kung 
        // anong layout app ang gagamitin nya 
        // ung app kasi is may kanya kanyang navigation sila 

        
        // this check the role of the user and returns the appropriate layout for its blade 
        if (Auth::user()->roles[0]->name == "admin")
        {
            return view('layouts.Admin.app');
        }

        // kaya ng add ako ng para sa experts 
        // then yun na 
        else if (Auth::user()->roles[0]->name == "experts")
        {
            return view('layouts.Experts.app');
        }
        else 
        {
            return view('layouts.Users.app');
        }
    }
}
