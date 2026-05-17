@extends('cyberadmin::layouts.app')

@section('title', __('tactical::tactical.dashboard'))

@section('content')
<div class="page-header">
    <h1 class="page-title glitch-hover">{{ __('tactical::tactical.intelligence_overview') }}</h1>
    <button
        class="cyber-btn"
        onclick="showToast('{{ __('tactical::tactical.intel_report_generated') }}', 'info')">
        <i class="ph ph-download-simple"></i> {{ __('tactical::tactical.export') }}
    </button>
</div>

<div class="grid-cards">
    <div class="cyber-card stat-card">
        <div class="stat-icon"><i class="ph ph-file-text"></i></div>
        <div class="stat-details">
            <h3>{{ __('tactical::tactical.total_reports') }}</h3>
            <h2>1,402</h2>
        </div>
    </div>
    <div class="cyber-card stat-card secondary">
        <div class="stat-icon"><i class="ph ph-hourglass-high"></i></div>
        <div class="stat-details">
            <h3>{{ __('tactical::tactical.pending_verification') }}</h3>
            <h2>84</h2>
        </div>
    </div>
    <div class="cyber-card stat-card accent">
        <div class="stat-icon">
            <div style="display: flex; gap: 2px; font-size: 1rem">
                <i class="ph ph-image"></i>
                <i class="ph ph-video-camera"></i>
            </div>
        </div>
        <div class="stat-details">
            <h3>{{ __('tactical::tactical.media_uploads') }}</h3>
            <h2>530</h2>
        </div>
    </div>
    <div class="cyber-card stat-card danger">
        <div
            class="stat-icon"
            style="
          background: rgba(255, 0, 60, 0.1);
          border-color: var(--danger);
          color: var(--danger);
          box-shadow: inset 0 0 10px rgba(255, 0, 60, 0.2);
        ">
            <i class="ph ph-warning"></i>
        </div>
        <div class="stat-details">
            <h3>{{ __('tactical::tactical.critical_incidents') }}</h3>
            <h2>12</h2>
        </div>
    </div>
</div>

<div class="grid-cards" style="grid-template-columns: 2fr 1fr">
    <div class="cyber-card">
        <h3>{{ __('tactical::tactical.report_volume') }}</h3>
        <div
            style="
          height: 300px;
          display: flex;
          align-items: flex-end;
          gap: 10px;
          margin-top: 20px;
          padding-bottom: 20px;
          border-bottom: 1px solid var(--border-color);
        ">
            <!-- Simple pure CSS bars representing chart -->
            <div
                style="
            flex: 1;
            background: var(--primary);
            height: 40%;
            box-shadow: 0 0 10px var(--primary);
            transition: var(--transition);
          "
                onmouseover="this.style.height = '45%'"
                onmouseout="this.style.height = '40%'"></div>
            <div
                style="
            flex: 1;
            background: var(--secondary);
            height: 70%;
            box-shadow: 0 0 10px var(--secondary);
            transition: var(--transition);
          "
                onmouseover="this.style.height = '75%'"
                onmouseout="this.style.height = '70%'"></div>
            <div
                style="
            flex: 1;
            background: var(--primary);
            height: 30%;
            box-shadow: 0 0 10px var(--primary);
            transition: var(--transition);
          "
                onmouseover="this.style.height = '35%'"
                onmouseout="this.style.height = '30%'"></div>
            <div
                style="
            flex: 1;
            background: var(--accent);
            height: 90%;
            box-shadow: 0 0 10px var(--accent);
            transition: var(--transition);
          "
                onmouseover="this.style.height = '95%'"
                onmouseout="this.style.height = '90%'"></div>
            <div
                style="
            flex: 1;
            background: var(--primary);
            height: 50%;
            box-shadow: 0 0 10px var(--primary);
            transition: var(--transition);
          "
                onmouseover="this.style.height = '55%'"
                onmouseout="this.style.height = '50%'"></div>
            <div
                style="
            flex: 1;
            background: var(--secondary);
            height: 60%;
            box-shadow: 0 0 10px var(--secondary);
            transition: var(--transition);
          "
                onmouseover="this.style.height = '65%'"
                onmouseout="this.style.height = '60%'"></div>
            <div
                style="
            flex: 1;
            background: var(--primary);
            height: 80%;
            box-shadow: 0 0 10px var(--primary);
            transition: var(--transition);
          "
                onmouseover="this.style.height = '85%'"
                onmouseout="this.style.height = '80%'"></div>
        </div>
    </div>

    <div class="cyber-card">
        <h3>{{ __('tactical::tactical.recent_reports') }}</h3>
        <ul
            style="
          list-style: none;
          margin-top: 20px;
          display: flex;
          flex-direction: column;
          gap: 15px;
        ">
            <li
                style="
            display: flex;
            gap: 10px;
            align-items: flex-start;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
          ">
                <i
                    class="ph ph-video-camera"
                    style="color: var(--secondary); font-size: 1.2rem"></i>
                <div>
                    <div style="color: var(--text-main); font-weight: 500">
                        {{ __('tactical::tactical.sector_4_disturbance') }}
                    </div>
                    <div style="color: var(--text-muted); font-size: 0.8rem">
                        {{ __('tactical::tactical.reporter', ['reporter' => 'cipher_k', 'time' => '2 mins']) }}
                    </div>
                </div>
            </li>
            <li
                style="
            display: flex;
            gap: 10px;
            align-items: flex-start;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
          ">
                <i
                    class="ph ph-warning-circle"
                    style="color: var(--danger); font-size: 1.2rem"></i>
                <div>
                    <div style="color: var(--text-main); font-weight: 500">
                        {{ __('tactical::tactical.unauthorized_access') }}
                    </div>
                    <div style="color: var(--text-muted); font-size: 0.8rem">
                        {{ __('tactical::tactical.reporter', ['reporter' => 'SYS_ADMIN', 'time' => '15 mins']) }}
                    </div>
                </div>
            </li>
            <li style="display: flex; gap: 10px; align-items: flex-start">
                <i
                    class="ph ph-image"
                    style="color: var(--primary); font-size: 1.2rem"></i>
                <div>
                    <div style="color: var(--text-main); font-weight: 500">
                        {{ __('tactical::tactical.suspicious_package_location') }}
                    </div>
                    <div style="color: var(--text-muted); font-size: 0.8rem">
                        {{ __('tactical::tactical.reporter', ['reporter' => 'op_delta', 'time' => '1 hour']) }}
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
@endsection