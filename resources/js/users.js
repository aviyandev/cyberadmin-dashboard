// Initial Users Data
let users = [
  { id: 1, username: 'neo_matrix', role: 'Administrator', status: 'Active' },
  { id: 2, username: 'trinity_01', role: 'Moderator', status: 'Active' },
  { id: 3, username: 'cipher_k', role: 'Field Reporter', status: 'Active' },
  { id: 4, username: 'op_delta', role: 'Field Reporter', status: 'Suspended' }
];

let currentEditId = null;

const tbody = document.getElementById('userTableBody');
const userForm = document.getElementById('userForm');
const modalTitle = document.getElementById('modalTitle');

function renderUsers() {
  tbody.innerHTML = '';
  users.forEach(user => {
    const tr = document.createElement('tr');
    
    let statusStyle = user.status === 'Active' ? 'color: var(--accent);' : 'color: var(--danger);';

    tr.innerHTML = `
      <td style="color: var(--text-muted);">#${user.id.toString().padStart(3, '0')}</td>
      <td style="font-weight: bold;">${user.username}</td>
      <td style="color: var(--primary);">${user.role}</td>
      <td style="${statusStyle}">[ ${user.status.toUpperCase()} ]</td>
      <td>
        <button class="cyber-btn sm" style="padding: 0.2rem 0.5rem;" onclick="editUser(${user.id})">
          <i class="ph ph-pencil-simple"></i>
        </button>
        <button class="cyber-btn sm danger" style="padding: 0.2rem 0.5rem;" onclick="deleteUser(${user.id})">
          <i class="ph ph-trash"></i>
        </button>
      </td>
    `;
    tbody.appendChild(tr);
  });
}

function openModal(id) {
  document.getElementById(id).classList.add('active');
}

function closeModal(id) {
  document.getElementById(id).classList.remove('active');
  userForm.reset();
  currentEditId = null;
  modalTitle.textContent = 'ADD_REPORTER';
}

function editUser(id) {
  const user = users.find(u => u.id === id);
  if (user) {
    currentEditId = id;
    document.getElementById('usernameInput').value = user.username;
    document.getElementById('roleInput').value = user.role;
    document.getElementById('statusInput').value = user.status;
    modalTitle.textContent = 'EDIT_REPORTER';
    openModal('userModal');
  }
}

function deleteUser(id) {
  if (confirm('WARNING: Are you sure you want to delete this reporter record?')) {
    users = users.filter(u => u.id !== id);
    renderUsers();
    showToast('Record deleted successfully.', 'error');
  }
}

userForm.addEventListener('submit', (e) => {
  e.preventDefault();
  
  const username = document.getElementById('usernameInput').value;
  const role = document.getElementById('roleInput').value;
  const status = document.getElementById('statusInput').value;

  if (currentEditId) {
    // Update
    const userIndex = users.findIndex(u => u.id === currentEditId);
    users[userIndex] = { ...users[userIndex], username, role, status };
    showToast('Record updated.', 'success');
  } else {
    // Create
    const newId = users.length > 0 ? Math.max(...users.map(u => u.id)) + 1 : 1;
    users.push({ id: newId, username, role, status });
    showToast('New record created.', 'success');
  }

  closeModal('userModal');
  renderUsers();
});

// Initialize
document.addEventListener('DOMContentLoaded', renderUsers);
