// Dummy Report Data Generation
const generateData = (count) => {
    const data = [];
    const statuses = ['Pending', 'Verified', 'Dismissed'];
    const reporters = ['cipher_k', 'op_delta', 'agent_smith', 'anon_049', 'SYS_ADMIN'];
    const textSamples = [
        "Suspicious activity observed near the main power relay.",
        "Unauthorized vehicle breached perimeter fence sector 7.",
        "Communication lines down in the northern quadrant. Possible tampering.",
        "Routine patrol completed. No anomalies detected.",
        "Unknown drone flying over restricted airspace."
    ];

    for (let i = 1; i <= count; i++) {
        const hasImage = Math.random() > 0.5;
        const hasVideo = Math.random() > 0.8;
        const hasAudio = Math.random() > 0.7;
        const hasLocation = Math.random() > 0.4;

        const date = new Date();
        date.setHours(date.getHours() - Math.floor(Math.random() * 168));

        data.push({
            id: `RPT-${i.toString().padStart(4, '0')}`,
            reporter: reporters[Math.floor(Math.random() * reporters.length)],
            media: {
                text: true,
                image: hasImage,
                video: hasVideo,
                audio: hasAudio,
                location: hasLocation
            },
            text: textSamples[Math.floor(Math.random() * textSamples.length)],
            status: statuses[Math.floor(Math.random() * statuses.length)],
            timestamp: date.toISOString().slice(0, 16).replace('T', ' ')
        });
    }
    return data.sort((a, b) => new Date(b.timestamp) - new Date(a.timestamp));
};

let tableData = generateData(45);
let filteredData = [...tableData];
let currentPage = 1;
let pageSize = 10;
let sortColumn = 'timestamp';
let sortDesc = true;

const tbody = document.getElementById('tableBody');
const searchInput = document.getElementById('searchInput');
const pageSizeSelect = document.getElementById('pageSize');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');
const pageInfo = document.getElementById('pageInfo');
const pageNumbersContainer = document.getElementById('pageNumbers');
const headers = document.querySelectorAll('th[data-sort]');

function getMediaIcons(media) {
    let html = '';
    if (media.text) html += '<i class="ph ph-text-t media-icon" title="Text"></i>';
    if (media.image) html += '<i class="ph ph-image media-icon" title="Image"></i>';
    if (media.video) html += '<i class="ph ph-video-camera media-icon" title="Video"></i>';
    if (media.audio) html += '<i class="ph ph-speaker-high media-icon" title="Audio"></i>';
    if (media.location) html += '<i class="ph ph-map-pin media-icon" title="Location"></i>';
    return html;
}

function renderTable() {
    tbody.innerHTML = '';

    filteredData.sort((a, b) => {
        let valA = a[sortColumn];
        let valB = b[sortColumn];
        if (valA < valB) return sortDesc ? 1 : -1;
        if (valA > valB) return sortDesc ? -1 : 1;
        return 0;
    });

    const start = (currentPage - 1) * pageSize;
    const end = start + pageSize;
    const paginatedData = filteredData.slice(start, end);

    paginatedData.forEach(row => {
        const tr = document.createElement('tr');

        let statusColor = 'var(--text-main)';
        if (row.status === 'Verified') statusColor = 'var(--accent)';
        if (row.status === 'Pending') statusColor = '#ffcc00';
        if (row.status === 'Dismissed') statusColor = 'var(--danger)';

        tr.innerHTML = `
      <td style="font-family: var(--font-heading); color: var(--primary);">${row.id}</td>
      <td>${row.reporter}</td>
      <td>${getMediaIcons(row.media)}</td>
      <td style="color: ${statusColor}; font-weight: bold;">[ ${row.status.toUpperCase()} ]</td>
      <td style="color: var(--text-muted);">${row.timestamp}</td>
      <td>
        <button class="cyber-btn sm" onclick="viewReport('${row.id}')">
          <i class="ph ph-eye"></i> VIEW
        </button>
      </td>
    `;
        tbody.appendChild(tr);
    });

    updatePagination();
}

function updatePagination() {
    const totalPages = Math.ceil(filteredData.length / pageSize);

    prevBtn.disabled = currentPage === 1;
    nextBtn.disabled = currentPage === totalPages || totalPages === 0;

    const start = filteredData.length === 0 ? 0 : (currentPage - 1) * pageSize + 1;
    const end = Math.min(currentPage * pageSize, filteredData.length);

    pageInfo.innerHTML = `<span style="color: var(--primary); opacity: 0.5;">//</span> Records synced: <span style="color: var(--primary);">${end}</span> out of <span style="color: var(--secondary);">${filteredData.length}</span>`;

    const prevPageItem = document.getElementById('prevPageItem');
    const nextPageItem = document.getElementById('nextPageItem');

    if (prevPageItem) {
        prevPageItem.classList.toggle('disabled', currentPage === 1);
    }
    if (nextPageItem) {
        nextPageItem.classList.toggle('disabled', currentPage === totalPages || totalPages === 0);
    }

    pageNumbersContainer.innerHTML = '';

    const maxVisiblePages = 5;
    let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
    let endPage = startPage + maxVisiblePages - 1;

    if (endPage > totalPages) {
        endPage = totalPages;
        startPage = Math.max(1, endPage - maxVisiblePages + 1);
    }

    if (startPage > 1) {
        const li = document.createElement('li');
        li.className = 'page-item';

        const btn = document.createElement('button');
        btn.className = 'page-link';
        btn.textContent = '1';
        btn.addEventListener('click', () => goToPage(1));

        li.appendChild(btn);
        pageNumbersContainer.appendChild(li);

        if (startPage > 2) {
            const dotsLi = document.createElement('li');
            const dots = document.createElement('span');
            dots.textContent = '...';
            dots.style.padding = '0 0.5rem';
            dots.style.color = 'var(--text-muted)';
            dots.style.fontFamily = 'var(--font-heading)';
            dotsLi.appendChild(dots);
            pageNumbersContainer.appendChild(dotsLi);
        }
    }

    for (let i = startPage; i <= endPage; i++) {
        const li = document.createElement('li');
        li.className = `page-item ${i === currentPage ? 'active' : ''}`;

        const btn = document.createElement('button');
        btn.className = 'page-link';
        btn.textContent = i;
        btn.addEventListener('click', () => goToPage(i));

        li.appendChild(btn);
        pageNumbersContainer.appendChild(li);
    }

    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            const dotsLi = document.createElement('li');
            const dots = document.createElement('span');
            dots.textContent = '...';
            dots.style.padding = '0 0.5rem';
            dots.style.color = 'var(--text-muted)';
            dots.style.fontFamily = 'var(--font-heading)';
            dotsLi.appendChild(dots);
            pageNumbersContainer.appendChild(dotsLi);
        }

        const li = document.createElement('li');
        li.className = 'page-item';

        const btn = document.createElement('button');
        btn.className = 'page-link';
        btn.textContent = totalPages;
        btn.addEventListener('click', () => goToPage(totalPages));

        li.appendChild(btn);
        pageNumbersContainer.appendChild(li);
    }
}

function goToPage(page) {
    if (page !== currentPage) {
        currentPage = page;
        renderTable();
    }
}

let currentViewingReportId = null;

function viewReport(id) {
    const report = tableData.find(r => r.id === id);
    if (!report) return;

    currentViewingReportId = id;

    document.getElementById('modalReportId').textContent = `REPORT: ${report.id}`;
    document.getElementById('modalReporter').textContent = report.reporter;
    document.getElementById('modalTimestamp').textContent = report.timestamp;
    document.getElementById('modalText').textContent = report.text;

    const mediaContainer = document.getElementById('modalMediaContainer');
    mediaContainer.innerHTML = '';

    let hasExtraMedia = false;

    if (report.media.image) {
        hasExtraMedia = true;
        mediaContainer.innerHTML += `
      <div style="width: 100%; border: 1px dashed var(--primary); padding: 2rem; text-align: center; color: var(--primary);">
        <i class="ph ph-image" style="font-size: 3rem; margin-bottom: 0.5rem; display: block;"></i>
        [ ENCRYPTED IMAGE ATTACHMENT ]
      </div>`;
    }
    if (report.media.video) {
        hasExtraMedia = true;
        mediaContainer.innerHTML += `
      <div style="width: 100%; border: 1px dashed var(--secondary); padding: 2rem; text-align: center; color: var(--secondary);">
        <i class="ph ph-video-camera" style="font-size: 3rem; margin-bottom: 0.5rem; display: block;"></i>
        [ SECURE VIDEO STREAM LINK ]
      </div>`;
    }
    if (report.media.audio) {
        hasExtraMedia = true;
        mediaContainer.innerHTML += `
      <div style="width: 100%; border: 1px dashed var(--accent); padding: 1rem; text-align: center; color: var(--accent); display: flex; align-items: center; justify-content: center; gap: 1rem;">
        <i class="ph ph-play-circle" style="font-size: 2rem;"></i>
        ------------------------------------ (0:45)
      </div>`;
    }
    if (report.media.location) {
        hasExtraMedia = true;
        mediaContainer.innerHTML += `
      <div style="width: 100%; border: 1px dashed #ffcc00; padding: 2rem; text-align: center; color: #ffcc00;">
        <i class="ph ph-map-pin" style="font-size: 3rem; margin-bottom: 0.5rem; display: block;"></i>
        [ LAT: 34.0522, LNG: -118.2437 ]
      </div>`;
    }

    if (!hasExtraMedia) {
        mediaContainer.innerHTML = '<span>NO ADDITIONAL MEDIA ATTACHED</span>';
    }

    document.getElementById('reportModal').classList.add('active');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('active');
    currentViewingReportId = null;
}

function updateReportStatus(newStatus) {
    if (!currentViewingReportId) return;
    const report = tableData.find(r => r.id === currentViewingReportId);
    if (report) {
        report.status = newStatus;
        renderTable();
        showToast(`Report ${report.id} marked as ${newStatus}.`, newStatus === 'Verified' ? 'success' : 'warning');
        closeModal('reportModal');
    }
}

searchInput.addEventListener('input', (e) => {
    const term = e.target.value.toLowerCase();
    filteredData = tableData.filter(row =>
        row.id.toLowerCase().includes(term) ||
        row.reporter.toLowerCase().includes(term) ||
        row.text.toLowerCase().includes(term) ||
        row.status.toLowerCase().includes(term)
    );
    currentPage = 1;
    renderTable();
});

pageSizeSelect.addEventListener('change', (e) => {
    pageSize = parseInt(e.target.value);
    currentPage = 1;
    renderTable();
});

prevBtn.addEventListener('click', () => {
    if (currentPage > 1) {
        currentPage--;
        renderTable();
    }
});

nextBtn.addEventListener('click', () => {
    const totalPages = Math.ceil(filteredData.length / pageSize);
    if (currentPage < totalPages) {
        currentPage++;
        renderTable();
    }
});

headers.forEach(header => {
    header.addEventListener('click', () => {
        const col = header.getAttribute('data-sort');
        if (sortColumn === col) {
            sortDesc = !sortDesc;
        } else {
            sortColumn = col;
            sortDesc = false;
        }

        headers.forEach(h => {
            const icon = h.querySelector('.sort-icon');
            icon.className = 'ph ph-caret-up sort-icon';
            icon.style.opacity = '0.3';
        });
        const currentIcon = header.querySelector('.sort-icon');
        currentIcon.style.opacity = '1';
        currentIcon.className = sortDesc ? 'ph ph-caret-down sort-icon' : 'ph ph-caret-up sort-icon';

        renderTable();
    });
});

document.addEventListener('DOMContentLoaded', () => {
    headers.forEach(h => {
        if (h.getAttribute('data-sort') !== sortColumn) {
            h.querySelector('.sort-icon').style.opacity = '0.3';
        } else {
            h.querySelector('.sort-icon').className = sortDesc ? 'ph ph-caret-down sort-icon' : 'ph ph-caret-up sort-icon';
        }
    });
    renderTable();
});
