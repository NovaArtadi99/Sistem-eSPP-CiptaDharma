@extends('admin.admin-layout')
@section('content')
    <form action="{{ route('biaya.update', $biaya->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')


        <div class="py-2 pb-4">
            <div class="mb-3">
                <label for="">Nama Biaya</label>
                <input type="text" name="nama_biaya" id="stok_sekarang" class="form-control"
                    value="{{ $biaya->nama_biaya }}">
            </div>


            <div class="mb-3">
                <label for="">Nominal</label>
                <input type="number" name="nominal" class="form-control" value="{{ $biaya->nominal }}">
            </div>



            <div class="mb-3">
                <label for="">Nama Nominal</label>
                <input type="text" name="nama_nominal" id="stok_sekarang" class="form-control"
                    value="{{ $biaya->nama_nominal }}">
            </div>


            <div class="mb-3">
                <label for="">Tahun</label>
                <input type="number" name="tahun" class="form-control" value="{{ $biaya->tahun }}">
            </div>



            <div class="mb-3">
                <label for="">Bulan</label>
                <select name="bulan" id="" class="form-control">
                    <option value="Januari" {{ $biaya->bulan == 'Januari' ? 'selected' : '' }}>Januari</option>
                    <option value="Februari" {{ $biaya->bulan == 'Februari' ? 'selected' : '' }}>Februari</option>
                    <option value="Maret" {{ $biaya->bulan == 'Maret' ? 'selected' : '' }}>Maret</option>
                    <option value="April" {{ $biaya->bulan == 'April' ? 'selected' : '' }}>April</option>
                    <option value="Mei" {{ $biaya->bulan == 'Mei' ? 'selected' : '' }}>Mei</option>
                    <option value="Juni" {{ $biaya->bulan == 'Juni' ? 'selected' : '' }}>Juni</option>
                    <option value="Juli" {{ $biaya->bulan == 'Juli' ? 'selected' : '' }}>Juli</option>
                    <option value="Agustus" {{ $biaya->bulan == 'Agustus' ? 'selected' : '' }}>Agustus</option>
                    <option value="September" {{ $biaya->bulan == 'September' ? 'selected' : '' }}>September</option>
                    <option value="Oktober" {{ $biaya->bulan == 'Oktober' ? 'selected' : '' }}>Oktober</option>
                    <option value="November" {{ $biaya->bulan == 'November' ? 'selected' : '' }}>November</option>
                    <option value="Desember" {{ $biaya->bulan == 'Desember' ? 'selected' : '' }}>Desember</option>
                </select>
            </div>

            {{-- <div class="mb-3">
                <label for="">Level</label>
                <select name="level" id="" class="form-control" autocomplete="on"
                    value="{{ old('level', '') }}">
                    @for ($level = 1; $level <= 6; $level++)
                        @foreach (range('A', 'E') as $huruf)
                            <option value="{{ $level . $huruf }}"
                                {{ old('level', '') == $level . $huruf ? 'selected' : '' }}>{{ $level . ' - ' . $huruf }}
                            </option>
                        @endforeach
                    @endfor
                </select>
            </div> --}}
            <div class="mb-3 d-flex justify-content-start gap-2">
                <button type="submit" class="btn btn-success">Kirim</button>
                <a href="{{ route('biaya.index') }}" class="btn btn-primary">Batal</a>
            </div>
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
