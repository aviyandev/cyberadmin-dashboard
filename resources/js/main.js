document.addEventListener('DOMContentLoaded', () => {
  // Sidebar Toggle
  const toggleBtn = document.getElementById('toggle-sidebar');
  const sidebar = document.getElementById('sidebar');

  if (toggleBtn && sidebar) {
    toggleBtn.addEventListener('click', () => {
      sidebar.classList.toggle('collapsed');
    });
  }

  // Setup Toast Container
  if (!document.getElementById('toast-container')) {
    const toastContainer = document.createElement('div');
    toastContainer.id = 'toast-container';
    document.body.appendChild(toastContainer);
  }

  // Livewire event listeners
  document.addEventListener('toast', (event) => {
    showToast(event.detail[0].message, event.detail[0].type);
  });

  document.addEventListener('theme-changed', (event) => {
    const theme = event.detail.theme;
    document.documentElement.setAttribute('data-theme', theme);
  });
});

/**
 * Shows a cyber-themed toast notification
 * @param {string} message - The message to display
 * @param {string} type - 'info', 'success', 'error', 'warning'
 */
function showToast(message, type = 'info') {
  const container = document.getElementById('toast-container');
  if (!container) return;

  const toast = document.createElement('div');
  toast.className = `cyber-toast ${type}`;
  
  let icon = 'ph-info';
  if (type === 'success') icon = 'ph-check-circle';
  if (type === 'error') icon = 'ph-warning-circle';
  if (type === 'warning') icon = 'ph-warning';

  toast.innerHTML = `
    <div style="display: flex; align-items: center; gap: 10px;">
      <i class="ph ${icon}" style="font-size: 1.5rem;"></i>
      <span>${message}</span>
    </div>
    <i class="ph ph-x toast-close"></i>
  `;

  container.appendChild(toast);

  const closeBtn = toast.querySelector('.toast-close');
  closeBtn.addEventListener('click', () => {
    toast.style.animation = 'fadeOut 0.3s forwards';
    setTimeout(() => toast.remove(), 300);
  });

  // Auto remove after 5 seconds
  setTimeout(() => {
    if (toast.parentElement) {
      toast.remove();
    }
  }, 5000);
}

// Global modal close on outside click
document.addEventListener('click', (e) => {
  if (e.target.classList.contains('modal-overlay')) {
    e.target.classList.remove('active');
  }
});
