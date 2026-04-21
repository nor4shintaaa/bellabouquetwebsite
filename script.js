// Data dan State
let inventory = JSON.parse(localStorage.getItem('bella_inventory')) || [];
let editMode = false;
let editIdx = null;
let imageBase64 = ""; // Variabel baru untuk menyimpan teks gambar
let searchQuery = ""; // Variabel untuk query pencarian
let selectedCategory = ""; // Variabel untuk kategori terpilih

const form = document.getElementById('inventory-form');
const tableBody = document.getElementById('product-table-body');
const modal = document.getElementById('product-modal');
const searchInput = document.getElementById('search-input');
const categoryFilter = document.getElementById('category-filter');

// ================= 1. TAB NAVIGATION =================
window.switchTab = (tabName) => {
    // Sembunyikan semua view
    document.getElementById('view-beranda').style.display = 'none';
    document.getElementById('view-produk').style.display = 'none';
    
    // Hapus class active di menu
    document.getElementById('menu-beranda').classList.remove('active');
    document.getElementById('menu-produk').classList.remove('active');
    
    // Tampilkan yang dipilih
    document.getElementById(`view-${tabName}`).style.display = 'block';
    document.getElementById(`menu-${tabName}`).classList.add('active');
};

// ================= 2. MODAL LOGIC =================
window.openModal = () => {
    modal.classList.add('active');
    if(!editMode) {
        document.getElementById('form-title').innerText = "Tambah Produk Baru";
        form.reset();
    }
};

window.closeModal = () => {
    modal.classList.remove('active');
    editMode = false;
    form.reset();
};

// ================= 3. RENDER TABEL & DASHBOARD =================
const renderApp = (dataToRender = inventory) => {
    tableBody.innerHTML = '';
    const gridContainer = document.getElementById('beranda-product-grid');
    gridContainer.innerHTML = ''; // Kosongkan grid sebelum re-render
    
    let totalNilai = 0;
    let stokMenipis = 0;
    
    // Jika inventaris kosong
    if (dataToRender.length === 0) {
        gridContainer.innerHTML = '<p style="grid-column: 1/-1; text-align: center; color: #888;">Belum ada produk. Silakan tambah produk di menu Daftar Produk.</p>';
    }

    dataToRender.forEach((item, index) => {
        // Kalkulasi Statistik
        totalNilai += (item.harga * item.stok);
        if (item.stok < 5) stokMenipis++; // Hitung jika stok di bawah 5
        
        // Cek Gambar (Bisa link dari internet atau lokal)
        const imgSrc = item.gambar ? item.gambar : 'https://via.placeholder.com/150?text=No+Img';
        
        // Temukan index asli di inventory untuk button edit/delete
        const originalIndex = inventory.findIndex(inv => inv.kode === item.kode);

        // --- A. Render Tabel (Halaman Produk) ---
        const row = document.createElement('tr');
        row.innerHTML = `
            <td><img src="${imgSrc}" class="product-img" alt="Produk"></td>
            <td>${item.kode}</td>
            <td>${item.nama}</td>
            <td>${item.kategori}</td>
            <td>${item.stok}</td>
            <td>Rp${parseInt(item.harga).toLocaleString()}</td>
            <td>
                <button onclick="editItem(${originalIndex})" style="background:#ffc107; color:#000;">Edit</button>
                <button onclick="deleteItem(${originalIndex})" style="background:#dc3545; color:#fff;">Hapus</button>
            </td>
        `;
        tableBody.appendChild(row);

        // --- B. Render Card Grid (Halaman Beranda) ---
        const isLowStock = item.stok < 5 ? 'low' : '';
        const card = document.createElement('div');
        card.className = 'product-card';
        card.innerHTML = `
            <img src="${imgSrc}" alt="${item.nama}">
            <h4>${item.nama}</h4>
            <p>${item.kode} • ${item.kategori}</p>
            <div class="price">Rp ${parseInt(item.harga).toLocaleString()}</div>
            <div class="stock-badge ${isLowStock}">Stok: ${item.stok}</div>
        `;
        gridContainer.appendChild(card);
    });

    // Update Angka Statistik di DOM Beranda
    document.getElementById('dash-total-item').innerText = dataToRender.length;
    document.getElementById('dash-total-value').innerText = `Rp ${totalNilai.toLocaleString()}`;
    document.getElementById('dash-low-stock').innerText = stokMenipis;
};

// ================= 4. FUNGSI PENCARIAN & FILTER =================
window.performSearch = () => {
    const query = searchInput.value.toLowerCase().trim();
    searchQuery = query;
    applyFilters();
};

window.performCategoryFilter = () => {
    selectedCategory = categoryFilter.value;
    applyFilters();
};

const applyFilters = () => {
    let filteredData = inventory;
    
    // Filter berdasarkan kategori
    if (selectedCategory !== "") {
        filteredData = filteredData.filter(item => item.kategori === selectedCategory);
    }
    
    // Filter berdasarkan pencarian
    if (searchQuery !== "") {
        filteredData = filteredData.filter(item =>
            item.nama.toLowerCase().includes(searchQuery) ||
            item.kode.toLowerCase().includes(searchQuery) ||
            item.kategori.toLowerCase().includes(searchQuery)
        );
    }
    
    renderApp(filteredData);
};

// ================= EVENT LISTENER PENCARIAN & FILTER =================
if (searchInput) {
    searchInput.addEventListener('input', performSearch);
}

if (categoryFilter) {
    categoryFilter.addEventListener('change', performCategoryFilter);
}

// ================= LOGIKA UPLOAD GAMBAR =================
const fileInput = document.getElementById('gambar');
fileInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    
    if (file) {
        // Cek ukuran file (Maksimal 1 MB / 1024 KB) agar localstorage tidak cepat penuh
        if(file.size > 1024 * 1024) {
            alert('Ukuran gambar terlalu besar! Maksimal 1MB.');
            fileInput.value = ''; // Reset input
            return;
        }

        const reader = new FileReader();
        reader.onload = function(event) {
            imageBase64 = event.target.result; // Simpan hasil convert Base64
            document.getElementById('gambar-info').innerText = "Gambar siap diunggah!";
        };
        reader.readAsDataURL(file); // Proses konversi dimulai
    }
});

// ================= UPDATE LOGIKA CRUD (SIMPAN DATA) =================
form.addEventListener('submit', (e) => {
    e.preventDefault();
    
    const newItem = {
        gambar: imageBase64, // Gunakan variabel yang sudah diconvert
        kode: document.getElementById('kode').value,
        nama: document.getElementById('nama').value,
        kategori: document.getElementById('kategori').value,
        stok: parseInt(document.getElementById('stok').value),
        harga: parseInt(document.getElementById('harga').value)
    };

    if (editMode) {
        // Jika sedang edit tapi tidak upload gambar baru, pakai gambar lama
        if(imageBase64 === "") {
            newItem.gambar = inventory[editIdx].gambar; 
        }
        inventory[editIdx] = newItem;
    } else {
        // Validasi jika gambar belum dipilih saat tambah baru
        if(imageBase64 === "") {
            alert("Harap upload gambar produk!");
            return;
        }
        inventory.push(newItem);
    }

    // Blok try-catch untuk menangani jika localstorage penuh
    try {
        localStorage.setItem('bella_inventory', JSON.stringify(inventory));
        closeModal();
        searchInput.value = ""; // Clear search
        categoryFilter.value = ""; // Clear category filter
        searchQuery = ""; // Reset search query
        selectedCategory = ""; // Reset category
        renderApp(inventory); // Tampilkan semua data setelah tambah/edit
    } catch (error) {
        alert("Gagal menyimpan! Memori LocalStorage penuh. Hapus beberapa produk atau gunakan gambar berukuran lebih kecil.");
    }
});

// ================= UPDATE LOGIKA EDIT & CLOSE MODAL =================
window.editItem = (index) => {
    editMode = true;
    editIdx = index;
    const item = inventory[index];
    
    // Reset file input dan siapkan gambar lama
    document.getElementById('gambar').value = ''; 
    imageBase64 = ""; // Reset variabel
    document.getElementById('gambar-info').innerText = "Biarkan kosong jika tidak ingin mengubah gambar.";
    
    document.getElementById('kode').value = item.kode;
    document.getElementById('nama').value = item.nama;
    document.getElementById('kategori').value = item.kategori;
    document.getElementById('stok').value = item.stok;
    document.getElementById('harga').value = item.harga;
    
    document.getElementById('form-title').innerText = "Edit Produk";
    openModal();
};

window.closeModal = () => {
    modal.classList.remove('active');
    editMode = false;
    form.reset();
    imageBase64 = ""; // Bersihkan variabel gambar saat modal ditutup
    document.getElementById('gambar-info').innerText = "";
};

window.deleteItem = (index) => {
    if (confirm('Yakin ingin menghapus produk ini?')) {
        inventory.splice(index, 1);
        localStorage.setItem('bella_inventory', JSON.stringify(inventory));
        searchInput.value = ""; // Clear search
        categoryFilter.value = ""; // Clear category filter
        searchQuery = ""; // Reset search query
        selectedCategory = ""; // Reset category
        renderApp(inventory); // Tampilkan semua data setelah hapus
    }
};

// Jalankan pertama kali
renderApp();