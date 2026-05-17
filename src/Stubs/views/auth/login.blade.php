<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login | CyberAdmin</title>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700;900&family=Rajdhani:wght@400;500;600;700&display=swap');
      :root {
        --bg-color: #050510;
        --surface-color: rgba(10, 10, 30, 0.7);
        --border-color: rgba(0, 255, 255, 0.2);
        --primary: #00ffff;
        --text-main: #e0e0e0;
        --text-muted: #8888aa;
        --font-heading: 'Orbitron', sans-serif;
        --font-body: 'Rajdhani', sans-serif;
      }
      * { margin: 0; padding: 0; box-sizing: border-box; }
      body {
        background: var(--bg-color);
        color: var(--text-main);
        font-family: var(--font-body);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background-image:
          radial-gradient(circle at 15% 50%, rgba(0,255,255,0.08), transparent 25%),
          radial-gradient(circle at 85% 30%, rgba(255,0,255,0.08), transparent 25%);
      }
      .cyber-card {
        background: var(--surface-color);
        border: 1px solid var(--border-color);
        padding: 2rem;
        width: 100%;
        max-width: 450px;
        backdrop-filter: blur(10px);
        clip-path: polygon(12px 0, 100% 0, 100% calc(100% - 12px), calc(100% - 12px) 100%, 0 100%, 0 12px);
      }
      .cyber-input-group {
        margin-bottom: 1.5rem;
      }
      .cyber-input-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: var(--text-muted);
        font-weight: 600;
        font-family: var(--font-heading);
        letter-spacing: 1px;
      }
      .cyber-input {
        width: 100%;
        background: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-main);
        padding: 0.7rem 1rem;
        font-family: var(--font-body);
        font-size: 1rem;
        outline: none;
      }
      .cyber-input:focus { border-color: var(--primary); }
      .cyber-btn {
        background: transparent;
        color: var(--primary);
        border: 1px solid var(--primary);
        padding: 0.6rem 1.5rem;
        font-family: var(--font-heading);
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        width: 100%;
      }
      .cyber-btn:hover { background: var(--primary); color: var(--bg-color); }
      a { color: var(--primary); text-decoration: none; }
      a:hover { text-shadow: 0 0 8px var(--primary); }
    </style>
  </head>
  <body>
    <div class="cyber-card">
      <h1 style="font-family: var(--font-heading); color: var(--primary); margin-bottom: 1.5rem; text-align: center;">CYBER_ADMIN</h1>
      <h2 style="font-family: var(--font-heading); font-size: 1.2rem; margin-bottom: 1.5rem;">LOGIN</h2>
      
      <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <div class="cyber-input-group">
          <label>Email</label>
          <input type="email" name="email" class="cyber-input" value="{{ old('email') }}" required autofocus />
        </div>
        
        <div class="cyber-input-group">
          <label>Password</label>
          <input type="password" name="password" class="cyber-input" required />
        </div>
        
        <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
          <label style="display: flex; align-items: center; gap: 0.5rem; font-family: var(--font-body); color: var(--text-muted);">
            <input type="checkbox" name="remember"> Remember me
          </label>
          <a href="{{ route('password.request') }}">Forgot password?</a>
        </div>
        
        <button type="submit" class="cyber-btn">
          <i class="ph ph-sign-in"></i> Login
        </button>
      </form>
      
      @if (Route::has('register'))
        <div style="text-align: center; margin-top: 1.5rem;">
          Don't have an account? <a href="{{ route('register') }}">Register</a>
        </div>
      @endif
    </div>
  </body>
</html>
