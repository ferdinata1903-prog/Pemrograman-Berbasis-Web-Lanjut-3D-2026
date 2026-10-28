const apiBuku = '/api/buku';
const apiKategori = '/api/kategori';
let dataBukuSaatIni = [];

async function loadKategori() {
    try {
        const res = await fetch(apiKategori, { headers: { Accept: 'application/json' } });
        if (!res.ok) throw new Error('Gagal memuat kategori');
        const json = await res.json();

        const select = document.getElementById('kategori_id');
        json.data.forEach(k => {
            const opt = document.createElement('option');
            opt.value = k.id;
            opt.textContent = k.nama;
            select.appendChild(opt);
        });
    } catch (err) {
        console.error(err);
    }
}

async function loadBuku() {
    const tbody = document.getElementById('tabel-body');
    tbody.innerHTML = '<tr><td colspan="5">Memuat data...</td></tr>';

    try {
        const res = await fetch(apiBuku, { headers: { Accept: 'application/json' } });
        if (!res.ok) throw new Error('Gagal memuat data buku');

        const json = await res.json();
        dataBukuSaatIni = json.data;
        renderTable(dataBukuSaatIni);
    } catch (err) {
        tbody.innerHTML = `<tr><td colspan="5">Terjadi kesalahan: ${err.message}</td></tr>`;
    }
}

function renderTable(data) {
    const tbody = document.getElementById('tabel-body');

    if (data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5">Belum ada data buku.</td></tr>';
        return;
    }

    tbody.innerHTML = '';
    data.forEach(buku => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${buku.kategori ?? '-'}</td>
            <td>${buku.judul}</td>
            <td>${buku.penulis}</td>
            <td>${buku.tahun}</td>
            <td>
                <button type="button" class="btn-ubah" data-id="${buku.id}">Ubah</button>
                <button type="button" class="btn-hapus" data-id="${buku.id}">Hapus</button>
            </td>
        `;
        tbody.appendChild(tr);
    });

    document.querySelectorAll('.btn-ubah').forEach(btn => {
        btn.addEventListener('click', () => mulaiUbah(btn.dataset.id));
    });
    document.querySelectorAll('.btn-hapus').forEach(btn => {
        btn.addEventListener('click', () => hapusBuku(btn.dataset.id));
    });
}

function mulaiUbah(id) {
    const buku = dataBukuSaatIni.find(b => b.id == id);
    if (!buku) return;

    document.getElementById('buku_id').value = buku.id;
    document.getElementById('kategori_id').value = buku.kategori_id;
    document.getElementById('judul').value = buku.judul;
    document.getElementById('penulis').value = buku.penulis;
    document.getElementById('tahun_terbit').value = buku.tahun;

    document.getElementById('form-judul').textContent = 'Ubah Buku';
    document.getElementById('submit-btn').textContent = 'Simpan Perubahan';
    document.getElementById('batal-btn').style.display = 'inline-block';
}

function batalUbah() {
    document.getElementById('form-buku').reset();
    document.getElementById('buku_id').value = '';
    document.getElementById('form-judul').textContent = 'Tambah Buku';
    document.getElementById('submit-btn').textContent = 'Tambah';
    document.getElementById('batal-btn').style.display = 'none';
    document.getElementById('form-pesan').textContent = '';
}

document.getElementById('batal-btn').addEventListener('click', batalUbah);

document.getElementById('form-buku').addEventListener('submit', async function (e) {
    e.preventDefault();
    const pesan = document.getElementById('form-pesan');
    pesan.textContent = '';

    const id = document.getElementById('buku_id').value;
    const payload = {
        kategori_id: document.getElementById('kategori_id').value,
        judul: document.getElementById('judul').value,
        penulis: document.getElementById('penulis').value,
        tahun_terbit: document.getElementById('tahun_terbit').value,
    };

    const url = id ? `${apiBuku}/${id}` : apiBuku;
    const method = id ? 'PUT' : 'POST';

    try {
        const res = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
            },
            body: JSON.stringify(payload),
        });

        const json = await res.json();

        if (!res.ok) {
            if (res.status === 422) {
                pesan.textContent = Object.values(json.errors).flat().join(' ');
            } else {
                pesan.textContent = json.message || 'Terjadi kesalahan.';
            }
            return;
        }

        batalUbah();
        loadBuku();
    } catch (err) {
        pesan.textContent = 'Tidak dapat menghubungi server.';
    }
});

async function hapusBuku(id) {
    const yakin = confirm('Yakin ingin menghapus buku ini?');
    if (!yakin) return;

    try {
        const res = await fetch(`${apiBuku}/${id}`, {
            method: 'DELETE',
            headers: { Accept: 'application/json' },
        });
        const json = await res.json();

        if (!res.ok) {
            alert(json.message || 'Gagal menghapus data.');
            return;
        }

        loadBuku();
    } catch (err) {
        alert('Tidak dapat menghubungi server.');
    }
}

loadKategori();
loadBuku();