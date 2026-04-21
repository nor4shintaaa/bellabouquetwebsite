// ================= 1. INISIALISASI DATA AWAL =================
const initialData = [
    { kode: "FLW-001", nama: "Bouquet Bunga", kategori: "Flower", stok: 15, harga: 150000, gambar: "https://i.pinimg.com/736x/4c/8c/32/4c8c3275664f6001181939f280524407.jpg" },
    { kode: "SNK-001", nama: "Bouquet Snack", kategori: "Snack", stok: 8, harga: 85000, gambar: "https://i.pinimg.com/1200x/02/c5/fa/02c5fa88d40a7365f786fcf7e84dec26.jpg" },
    { kode: "MNY-001", nama: "Bouquet Money", kategori: "Money", stok: 3, harga: 200000, gambar: "https://i.pinimg.com/1200x/cb/39/8f/cb398f2064770a8f8600e6518f0a27fb.jpg" },
    { kode: "DOL-001", nama: "Doll Bouquet", kategori: "Doll", stok: 12, harga: 95000, gambar: "https://i.pinimg.com/1200x/db/b2/67/dbb267d5924d25468fa433bed24b7c5f.jpg" },
    { kode: "FLW-002", nama: "Wedding flower", kategori: "Flower", stok: 4, harga: 180000, gambar: "https://i.pinimg.com/1200x/ec/7d/e9/ec7de95701c8ae66f64424bfd33bbd22.jpg" },
    { kode: "FLW-002", nama: "bouquet thumbelina", kategori: "Flower", stok: 20, harga: 110000, gambar: "https://i.pinimg.com/1200x/99/68/64/9968649ab1cbd608f6c1252ada1818fb.jpg" },
    { kode: "CAK-001", nama: "Cake and flowers", kategori: "Cake", stok: 2, harga: 150000, gambar: "https://i.pinimg.com/1200x/fb/79/ea/fb79ea58ba9be2ffe464a388fa9fbe38.jpg" },
    { kode: "DOL-002", nama: "Cute Bunny Bouquet", kategori: "Doll", stok: 10, harga: 75000, gambar: "https://i.pinimg.com/736x/6e/77/af/6e77af282a28e9a301a15357abff5cc9.jpg" }
];

let inventory = JSON.parse(localStorage.getItem('bella_inventory'));
if (!inventory || inventory.length === 0) {
    inventory = initialData;
    localStorage.setItem('bella_inventory', JSON.stringify(inventory));
}

// Variabel Global
let editMode = false;
let editIdx = null;
let imageBase64 = "";
let showAllDashboard = false; // <-- Variabel ini penting agar card muncul

// ================= 2. TAB NAVIGATION =================
window.switchTab = (tabName) => {
    document.getElementById('view-dashboard').style.display = 'none';
    document.getElementById('view-produk').style.display = 'none';
    document.getElementById('menu-dashboard').classList.remove('active');
    document.getElementById('menu-produk').classList.remove('active');
    
    document.getElementById(`view-${tabName}`).style.display = 'block';
    document.getElementById(`menu-${tabName}`).classList.add('active');
    
    if(tabName === 'dashboard') updateDashboard();
    if(tabName === 'produk') renderProduk();
};

window.toggleDashboardProducts = () => {
    showAllDashboard = true;
    updateDashboard(); 
};

// ================= 3. RENDER DASHBOARD (CARD 6 Awal) =================
window.updateDashboard = () => {
    let totalNilai = 0;
    let stokMenipis = 0;

    inventory.forEach((item) => {
        totalNilai += (item.harga * item.stok);
        if (item.stok < 5) stokMenipis++; 
    });

    document.getElementById('dash-total-item').innerText = inventory.length;
    document.getElementById('dash-total-value').innerText = `Rp ${totalNilai.toLocaleString('id-ID')}`;
    document.getElementById('dash-low-stock').innerText = stokMenipis;

    const gridContainer = document.getElementById('beranda-product-grid');
    if (!gridContainer) return; // Mencegah error jika elemen tidak ditemukan
    
    gridContainer.innerHTML = '';

    const limit = showAllDashboard ? inventory.length : Math.min(6, inventory.length);
    const displayedItems = inventory.slice(0, limit);

    displayedItems.forEach((item) => {
        const imgSrc = item.gambar || 'https://via.placeholder.com/150';
        const isLow = item.stok < 5;
        const statusText = isLow ? 'Menipis' : 'Tersedia';
        const badgeClass = isLow ? 'badge-low' : 'badge-ok';

        gridContainer.innerHTML += `
            <div class="prod-card">
                <div class="prod-header">
                    <span><i class="icon">🌸</i> ${item.kode}</span>
                    <span class="badge ${badgeClass}">${statusText}</span>
                </div>
                <div class="prod-body">
                    <img src="${imgSrc}" class="prod-img" alt="${item.nama}">
                    <div class="prod-info">
                        <strong>${item.nama}</strong>
                        <span>📍 Kat: ${item.kategori}</span>
                        <span>📦 Stok: ${item.stok} unit</span>
                    </div>
                </div>
                <div class="prod-footer" style="justify-content: center; background: #fffafb;">
                    <span class="prod-price">Rp ${item.harga.toLocaleString('id-ID')}</span>
                </div>
            </div>
        `;
    });

    const btnContainer = document.getElementById('btn-lihat-semua-container');
    if (btnContainer) {
        if (inventory.length > 6 && !showAllDashboard) {
            btnContainer.style.display = 'block';
        } else {
            btnContainer.style.display = 'none';
        }
    }
};

// ================= 4. RENDER HALAMAN PRODUK (CRUD & FILTER) =================
window.renderProduk = () => {
    const gridContainer = document.getElementById('produk-grid-container');
    const tableBody = document.getElementById('product-table-body');
    const searchInput = document.getElementById('search-input');
    
    if(!gridContainer || !tableBody) return;

    const searchTxt = searchInput ? searchInput.value.toLowerCase() : '';
    const checkedCategories = Array.from(document.querySelectorAll('.kat-filter:checked')).map(cb => cb.value);

    gridContainer.innerHTML = '';
    tableBody.innerHTML = '';
    
    let displayedCount = 0;

    inventory.forEach((item, index) => {
        const matchSearch = item.nama.toLowerCase().includes(searchTxt) || item.kode.toLowerCase().includes(searchTxt);
        const matchCategory = checkedCategories.length === 0 || checkedCategories.includes(item.kategori);

        if (matchSearch && matchCategory) {
            displayedCount++;
            
            const imgSrc = item.gambar || 'https://via.placeholder.com/150';
            const isLow = item.stok < 5;
            const statusText = isLow ? 'Menipis' : 'Tersedia';
            const badgeClass = isLow ? 'badge-low' : 'badge-ok';

            // Kartu Produk
            gridContainer.innerHTML += `
                <div class="prod-card">
                    <div class="prod-header">
                        <span><i class="icon">🌸</i> ${item.kode}</span>
                        <span class="badge ${badgeClass}">${statusText}</span>
                    </div>
                    <div class="prod-body">
                        <img src="${imgSrc}" class="prod-img" alt="${item.nama}">
                        <div class="prod-info">
                            <strong>${item.nama}</strong>
                            <span>📍 Kat: ${item.kategori}</span>
                            <span>📦 Stok: ${item.stok} unit</span>
                        </div>
                    </div>
                    <div class="prod-footer">
                        <span class="prod-price">Rp ${item.harga.toLocaleString('id-ID')}</span>
                        <div>
                            <button class="btn-action btn-edit" onclick="editItem(${index})">Edit</button>
                            <button class="btn-action btn-delete" onclick="deleteItem(${index})">Hapus</button>
                        </div>
                    </div>
                </div>
            `;

            // Tabel Produk
            tableBody.innerHTML += `
                <tr>
                    <td><strong>${item.kode}</strong></td>
                    <td>${item.nama}</td>
                    <td>${item.kategori}</td>
                    <td>${item.stok}</td>
                    <td>Rp ${item.harga.toLocaleString('id-ID')}</td>
                    <td><span class="badge ${badgeClass}">${statusText}</span></td>
                    <td>
                        <button class="btn-action btn-edit" onclick="editItem(${index})">Edit</button>
                        <button class="btn-action btn-delete" onclick="deleteItem(${index})">Hapus</button>
                    </td>
                </tr>
            `;
        }
    });

    const displayCountEl = document.getElementById('count-display');
    if(displayCountEl) displayCountEl.innerText = displayedCount;
};

// Event Listeners Pencarian & Filter
const searchInput = document.getElementById('search-input');
if(searchInput) searchInput.addEventListener('input', renderProduk);

document.querySelectorAll('.kat-filter').forEach(cb => {
    cb.addEventListener('change', renderProduk);
});

window.resetFilter = () => {
    if(searchInput) searchInput.value = '';
    document.querySelectorAll('.kat-filter').forEach(cb => cb.checked = false);
    renderProduk();
};

// ================= 5. MODAL LOGIC & UPLOAD GAMBAR =================
const modal = document.getElementById('product-modal');
const form = document.getElementById('inventory-form');

window.openModal = () => {
    if(!modal) return;
    modal.classList.add('active');
    if(!editMode) {
        document.getElementById('form-title').innerText = "Tambah Produk Baru";
        form.reset();
        imageBase64 = ""; 
        document.getElementById('gambar-info').innerText = "";
    }
};

window.closeModal = () => {
    if(!modal) return;
    modal.classList.remove('active');
    editMode = false;
    form.reset();
};

const gambarInput = document.getElementById('gambar');
if(gambarInput) {
    gambarInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if(file.size > 1024 * 1024) { alert('Ukuran gambar maksimal 1MB.'); this.value = ''; return; }
            const reader = new FileReader();
            reader.onload = function(event) {
                imageBase64 = event.target.result; 
                document.getElementById('gambar-info').innerText = "Gambar siap disimpan!";
            };
            reader.readAsDataURL(file); 
        }
    });
}

// ================= 6. CRUD LOGIC =================
if(form) {
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const newItem = {
            gambar: imageBase64, 
            kode: document.getElementById('kode').value,
            nama: document.getElementById('nama').value,
            kategori: document.getElementById('kategori').value,
            stok: parseInt(document.getElementById('stok').value),
            harga: parseInt(document.getElementById('harga').value)
        };

        if (editMode) {
            if(imageBase64 === "") newItem.gambar = inventory[editIdx].gambar; 
            inventory[editIdx] = newItem;
        } else {
            if(imageBase64 === "") { alert("Harap upload gambar!"); return; }
            inventory.push(newItem);
        }

        try {
            localStorage.setItem('bella_inventory', JSON.stringify(inventory));
            closeModal();
            renderProduk();
            updateDashboard();
        } catch (error) {
            alert("Gagal menyimpan! Memori penuh.");
        }
    });
}

window.editItem = (index) => {
    editMode = true;
    editIdx = index;
    const item = inventory[index];
    
    document.getElementById('gambar').value = ''; 
    imageBase64 = ""; 
    document.getElementById('gambar-info').innerText = "Biarkan kosong jika tidak mengubah gambar.";
    
    document.getElementById('kode').value = item.kode;
    document.getElementById('nama').value = item.nama;
    document.getElementById('kategori').value = item.kategori;
    document.getElementById('stok').value = item.stok;
    document.getElementById('harga').value = item.harga;
    
    document.getElementById('form-title').innerText = "Edit Produk";
    openModal();
};

window.deleteItem = (index) => {
    if (confirm('Yakin ingin menghapus produk ini?')) {
        inventory.splice(index, 1);
        localStorage.setItem('bella_inventory', JSON.stringify(inventory));
        renderProduk();
        updateDashboard();
    }
};

// ================= 7. RENDER SAAT PERTAMA KALI DIBUKA =================
updateDashboard();
renderProduk();