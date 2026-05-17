<div class="language-switcher" style="display: flex; gap: 0.5rem; align-items: center;">
  <i class="ph ph-translate" style="color: var(--primary); font-size: 1.5rem;"></i>
  <select wire:change="changeLocale($event.target.value)" class="cyber-input" style="width: auto; padding: 0.5rem;">
    @foreach($languages as $code => $name)
      <option value="{{ $code }}" {{ $locale === $code ? 'selected' : '' }}>
        {{ __("tactical::tactical.{$name}") }}
      </option>
    @endforeach
  </select>
</div>
