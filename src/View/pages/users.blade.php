@extends('cyberadmin::layouts.app')

@section('title', __('tactical::tactical.users'))

@section('content')
  <div class="page-header">
    <h1 class="page-title glitch-hover">{{ strtoupper(__('tactical::tactical.users')) }}</h1>
  </div>

  <div class="cyber-card">
    <div class="cyber-table-container">
      <table class="cyber-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Created At</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $user)
            <tr>
              <td>{{ $user->id }}</td>
              <td>{{ $user->name }}</td>
              <td>{{ $user->email }}</td>
              <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="cyber-pagination-wrapper">
      {{ $users->links() }}
    </div>
  </div>
@endsection
