@extends('cyberadmin::layouts.app')

@section('title', __('tactical::tactical.reports'))

@section('content')
  <div class="page-header">
    <h1 class="page-title glitch-hover">{{ strtoupper(__('tactical::tactical.reports')) }}</h1>
  </div>

  <div class="cyber-card">
    <h3>{{ __('tactical::tactical.recent_reports') }}</h3>
    <div class="cyber-table-container">
      <table class="cyber-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Reporter</th>
            <th>Status</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>{{ __('tactical::tactical.sector_4_disturbance') }}</td>
            <td>cipher_k</td>
            <td><span style="color: var(--accent);">Active</span></td>
            <td>{{ now()->subMinutes(2)->format('Y-m-d H:i') }}</td>
          </tr>
          <tr>
            <td>2</td>
            <td>{{ __('tactical::tactical.unauthorized_access') }}</td>
            <td>SYS_ADMIN</td>
            <td><span style="color: var(--danger);">Critical</span></td>
            <td>{{ now()->subMinutes(15)->format('Y-m-d H:i') }}</td>
          </tr>
          <tr>
            <td>3</td>
            <td>{{ __('tactical::tactical.suspicious_package_location') }}</td>
            <td>op_delta</td>
            <td><span style="color: var(--primary);">Pending</span></td>
            <td>{{ now()->subHour()->format('Y-m-d H:i') }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
@endsection
