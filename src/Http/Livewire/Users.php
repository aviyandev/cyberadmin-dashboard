<?php

namespace CyberAdmin\Dashboard\Http\Livewire;

use Livewire\Component;
use App\Models\User;

class Users extends Component
{
    public function render()
    {
        $users = User::paginate(10);
        return view('cyberadmin::pages.users', compact('users'));
    }
}
