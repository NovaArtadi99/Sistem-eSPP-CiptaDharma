@extends('admin.admin-layout')
@section('content')
    <form action="{{ route('pelunasan.lunasi', $tagihan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <p>
        </p>
        <div class="row">
            <div class="col-xxl-4 col-xl-4 col-lg-4 col-12">
                <div class="mb-3">
                    <img src="{{asset('bukti-pelunasan/'.$tagihan->bukti_pelunasan)}}"
                        id="preview" width="100%" alt="" class="img-thumbnail shadow">

                </div>
            </div>

            <div class="col-xxl-8 col-xl-8 col-lg-8 col-12">
                <div class="mb-3">
                    <label for="">Identitas Siswa</label>
                    <input type="text" value="{{ $tagihan->siswa->nama }}" class="form-control" readonly>
                </div>

                <div class="mb-3">
                    <label for="">Nama Tagihan</label>
                    <input type="text" name="nama_tagihan" class="form-control" value="{{ $tagihan->keterangan }}"
                        readonly>
                </div>

                <div class="mb-3">
                    <label for="">Biaya</label>
                    <input type="text" name="nama_tagihan" class="form-control" value="{{ $tagihan->biaya->nominal }}"
                        readonly>

                </div>


                <div class="mb-3">
                    <label for="">Tanggal Terbit</label>
                    <input type="date" name="tanggal_terbit" class="form-control"
                        value="{{ $tagihan->tanggal_terbit ?? date('Y-m-d') }}" readonly>
                    <label> Jika dikosongi otomatis di isi hari ini </label>
                </div>

                <div class="mb-3">
                    <label for="">Tanggal Lunas</label>
                    <input type="date" name="tanggal_lunas" class="form-control" value="{{ $tagihan->tanggal_lunas }}"
                        readonly>
                    <label> Boleh dikosongi </label>
                </div>


                <div class="mb-3">
                    <label for="">Status Pelunasan</label>
                    <select type="date" name="status" class="form-control" value="{{ $tagihan->status }}"
                        @readonly(true)>
                        <option value="Lunas" {{ $tagihan->status == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="Belum Lunas" {{ $tagihan->status == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas
                        </option>

                    </select>
                </div>

            </div>
        </div>

    </form>


    {{-- <script type="text/javascript">
        selectImage.onchange = evt => {
            preview = document.getElementById('preview');
            preview.style.display = 'block';
            const [file] = selectImage.files
            if (file) {
                preview.src = URL.createObjectURL(file)
            }
        }
    </script> --}}

@endsection
