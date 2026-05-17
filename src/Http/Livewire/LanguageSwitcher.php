<?php

namespace CyberAdmin\Dashboard\Http\Livewire;

use Livewire\Component;

class LanguageSwitcher extends Component
{
    public $locale;

    public $languages = [
        'en' => 'English',
        'es' => 'Spanish',
        'fr' => 'French',
    ];

    public function mount()
    {
        $this->locale = app()->getLocale();
    }

    public function changeLocale($locale)
    {
        if (array_key_exists($locale, $this->languages)) {
            $this->locale = $locale;
            session(['locale' => $locale]);
            app()->setLocale($locale);
            $this->dispatch('locale-changed', locale: $locale);
        }
    }

    public function render()
    {
        return view('cyberadmin::components.language-switcher');
    }
}
