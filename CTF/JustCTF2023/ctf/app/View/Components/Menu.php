<?php

namespace App\View\Components;
use App\Models\User;
use App\Models\Task;
use App\Models\UserFlag;
use App\Models\Flag;
use Illuminate\View\Component;

class Menu extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.menu',[			'title'=>"Challenges",		'menu' => Task::where('enabled',1)->where('track','default')->where('archived',FALSE)->orderBy('created_at', 'desc')->get()]);
    }
}
