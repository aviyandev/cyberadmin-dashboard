<?php

namespace CyberAdmin\Dashboard\Http\Livewire;

use Livewire\Component;

class ThemeSwitcher extends Component
{
    public $theme;

    public function mount()
    {
        $this->theme = session('theme', 'dark');
    }

    public function toggleTheme()
    {
        $this->theme = $this->theme === 'dark' ? 'light' : 'dark';
        session(['theme' => $this->theme]);
        $this->dispatch('theme-changed', theme: $this->theme);
    }

    public function render()
    {
        return view('cyberadmin::components.theme-switcher');
    }
}
