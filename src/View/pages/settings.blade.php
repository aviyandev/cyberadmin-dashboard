@extends('cyberadmin::layouts.app')

@section('title', __('tactical::tactical.settings'))

@section('content')
  <div class="page-header">
    <h1 class="page-title glitch-hover">{{ strtoupper(__('tactical::tactical.settings')) }}</h1>
  </div>

  <div class="grid-cards">
    <div class="cyber-card">
      <h3>{{ strtoupper(__('tactical::tactical.theme')) }}</h3>
      <div style="margin-top: 1rem;">
        <livewire:theme-switcher />
      </div>
    </div>

    <div class="cyber-card">
      <h3>{{ strtoupper(__('tactical::tactical.language')) }}</h3>
      <div style="margin-top: 1rem;">
        <livewire:language-switcher />
      </div>
    </div>
  </div>
@endsection
