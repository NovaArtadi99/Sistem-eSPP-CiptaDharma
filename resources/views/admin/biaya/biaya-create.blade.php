@extends('admin.admin-layout')
@section('content')
    <form action="{{ route('biaya.store') }}" method="POST" enctype="multipart/form-data">
        @csrf



        <div class="py-2 pb-4">
            <div class="mb-3">
                <label for="">Nama Biaya</label>
                <input type="text" name="nama_biaya" id="stok_sekarang" class="form-control">
            </div>


            <div class="mb-3">
                <label for="">Nominal</label>
                <input type="number" name="nominal" class="form-control">
            </div>



            <div class="mb-3">
                <label for="">Nama Nominal</label>
                <input type="text" name="nama_nominal" id="stok_sekarang" class="form-control">
            </div>


            <div class="mb-3">
                <label for="">Tahun</label>
                <input type="number" name="tahun" class="form-control">
            </div>



            <div class="mb-3">
                <label for="">Bulan</label>
                <select name="bulan" id="" class="form-control">
                    <option value="Januari">Januari</option>
                    <option value="Februari">Februari</option>
                    <option value="Maret">Maret</option>
                    <option value="April">April</option>
                    <option value="Mei">Mei</option>
                    <option value="Juni">Juni</option>
                    <option value="Juli">Juli</option>
                    <option value="Agustus">Agustus</option>
                    <option value="September">September</option>
                    <option value="Oktober">Oktober</option>
                    <option value="November">November</option>
                    <option value="Desember">Desember</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="">Kelas</label>
                <select name="level" id="" class="form-control" autocomplete="on" value="{{ old('kelas', '') }}">
                    @for ($kelas = 1; $kelas <= 6; $kelas++)
                        @foreach (range('A', 'E') as $huruf)
                            <option value="{{ $kelas . $huruf }}" {{ old('kelas', '') == $kelas . $huruf ? 'selected' : '' }}>{{ $kelas . ' - ' . $huruf }}</option>
                        @endforeach
                    @endfor
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>



    </form>
@endsection

@push('scrirpts')
    {{-- <script>
    document.getElementById('barang_id').addEventListener('change', function() {
        var barangId = this.value;

        // Lakukan request ke route untuk mendapatkan detail barang
        fetch('/barang-detail/' + barangId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            // Update form input berdasarkan data barang yang didapatkan
            document.getElementById('stok_sekarang').value = data.stok_sekarang;
            document.getElementById('stok_minimal').value = data.stok_minimal;
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script> --}}
@endpush
