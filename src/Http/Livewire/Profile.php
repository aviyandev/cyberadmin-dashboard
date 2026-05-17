<?php

namespace CyberAdmin\Dashboard\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Profile extends Component
{
    public $name;
    public $email;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->save();

        $this->dispatch('toast', message: 'Profile updated successfully!', type: 'success');
    }

    public function render()
    {
        return view('cyberadmin::pages.profile');
    }
}
