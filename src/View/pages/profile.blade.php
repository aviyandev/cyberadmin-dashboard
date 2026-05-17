@extends('cyberadmin::layouts.app')

@section('title', __('tactical::tactical.profile'))

@section('content')
  <div class="page-header">
    <h1 class="page-title glitch-hover">{{ strtoupper(__('tactical::tactical.profile')) }}</h1>
  </div>

  <div class="grid-cards">
    <div class="cyber-card">
      <form wire:submit="updateProfile">
        <div class="cyber-input-group">
          <label>Name</label>
          <input type="text" class="cyber-input" wire:model="name">
          @error('name') <span style="color: var(--danger);">{{ $message }}</span> @enderror
        </div>

        <div class="cyber-input-group">
          <label>Email</label>
          <input type="email" class="cyber-input" wire:model="email">
          @error('email') <span style="color: var(--danger);">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="cyber-btn">
          <i class="ph ph-save"></i> Save Changes
        </button>
      </form>
    </div>
  </div>
@endsection
