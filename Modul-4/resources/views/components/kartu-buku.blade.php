<div class="kartu-buku">
    <div class="kartu-cover">{{ mb_strtoupper(mb_substr($judul, 0, 1)) }}</div>

    <div class="kartu-body">
        <div class="kartu-extra">{{ $tambahan ?? '' }}</div>

        <h3>{{ $judul }}</h3>
        <p class="meta"><span>Penulis</span>{{ $penulis }}</p>
        <p class="meta"><span>Tahun Terbit</span>{{ $tahun }}</p>

        <div class="kartu-aksi">{{ $slot }}</div>
    </div>
</div>