@extends('admin.admin-layout')
@section('content')
    <ul class="nav nav-tabs my-3" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#tata-cara-pane" type="button"
                role="tab" aria-controls="profile-tab-pane" aria-selected="false">Tata Cara Pembayaran</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link " id="home-tab" data-bs-toggle="tab" data-bs-target="#pembayaran-pane" type="button"
                role="tab" aria-controls="pembayaran-pane" aria-selected="true">Form Pembayaran</button>
        </li>

    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="tata-cara-pane" role="tabpanel" aria-labelledby="tata-cara-tab" tabindex="0">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Petunjuk</h5>
                </div>
                <div class="card-body">
                    <h4>Cara Pembayaran</h4>
                    <ol class="list-group list-group-numbered mt-3">
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div>Transfer Uang Ke Rekening BCA: 33292282</div>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div>Screenshot dan Simpan Bukti Pembayaran</div>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div>Upload Bukti Pembayaran Pada Kolom Upload</div>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div>Buatkan Cara Upload ya!</div>
                            </div>
                        </li>
                        {{-- <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div>...............</div>
                            </div>
                        </li> --}}
                    </ol>
                </div>
            </div>
        </div>
        <div class="tab-pane fade " id="pembayaran-pane" role="tabpanel" aria-labelledby="pembayaran-pane"
            tabindex="0">
            <form action="{{ route('pelunasan.lunasi', $tagihan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-12">
                        {{-- @if ($tagihan->bukti_pelunasan) --}}
                        @if ($tagihan->bukti_pelunasan == null)
                            <div class="mb-3">

                                <!-- tambahan a -->
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTvX7ghSY75PvK5S-RvhkFxNz88MWEALSBDvA&s"
                        id="preview" width="100%" alt="">
                @else
                    <img src="{{ asset('bukti-pelunasan/' . $tagihan->bukti_pelunasan) }}" id="preview" width="100%"
                        alt="" class="img-thumbnail shadow">
                @endif
                <!-- tambahan b -->


                                {{-- <img src="{{ asset('bukti-pelunasan/' . $tagihan->bukti_pelunasan) }}" id="preview"
                                    width="100%" alt=""> --}}

                            </div>
                        {{-- @else
                            <div class="mb-3">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTvX7ghSY75PvK5S-RvhkFxNz88MWEALSBDvA&s"
                                    id="preview" width="100%" alt="">

                            </div>
                            <input type="file" class="form-control" name="bukti_pelunasan" accept="image/*"
                                id="selectImage" required>
                        @endif --}}

                    </div>

                    <div class="col-xxl-8 col-xl-8 col-lg-8 col-12">
                        <div class="mb-3">
                            <label for="nama_invoice">Nama Invoice</label>
                            <input type="text" id="nama_invoice" name="nama_invoice" class="form-control" value="{{ $tagihan->no_invoice ?? '' }}" readonly>
                        </div>

                        {{-- <div class="mb-3">
                            <label for="total_bayar">Total Bayar</label>
                            <input type="text" id="total_bayar" name="total_bayar" class="form-control" value="{{ $tagihan->biaya->nominal ?? '' }}" readonly>
                        </div> --}}

                        {{-- <div class="mb-3">
                            <label for="total_bayar">Total Bayar</label>
                            @if ($tagihan->status=="Kurang")
                                <input type="text" id="total_bayar" name="total_bayar" class="form-control" value="{{ $tagihan->nominal ?? '' }}">
                            @else
                                <input type="text" id="total_bayar" name="total_bayar" class="form-control">
                            @endif
                        </div> --}}

                        <div class="mb-3">
                            <label for="total_bayar">Total Bayar</label>
                            <input type="text"
                                   id="total_bayar"
                                   name="total_bayar"
                                   class="form-control"
                                   @if ($tagihan->status == "Kurang")
                                       value="{{ $tagihan->nominal ?? '' }}"
                                   @else
                                       value="{{ $tagihan->biaya->nominal ?? '' }}"
                                   @endif
                                   readonly>
                        </div>


                        <div class="mb-3">
                            <label for="bukti_pembayaran">Upload Bukti</label>
                            <div class="upload-area border border-dashed p-4 text-center bg-light">
                                <div class="upload-icon mb-2">
                                    <img src="{{ asset('images/upload-icon.svg') }}" id="preview" alt="Upload" width="100%">
                                </div>
                                <p>Drag & drop files or <a href="javascript:void(0)" class="text-primary" onclick="document.getElementById('selectImage').click()">Browse</a></p>
                                <p class="small text-muted">Supported formats: PDF,  DOCX</p>
                                <input type="file" id="selectImage" name="bukti_pembayaran" class="d-none" accept="application/pdf, image/*">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="catatan">Catatan</label>
                            <input type="text" id="catatan" name="catatan" class="form-control">
                        </div>


                        @if ($tagihan->status == 'Belum Lunas' || $tagihan->status == 'Kurang')
                            <button type="submit" class="btn btn-primary my-3">Submit</button>
                        @else
                        <button type="submit" class="btn btn-primary my-3 disabled">Submit</button>

                            <a href="{{ url()->previous() }}" class="btn btn-secondary my-3">Kembali</a>
                        @endif

                    </div>
                </div>

            </form>
        </div>


    </div>



    <script type="text/javascript">
        selectImage.onchange = evt => {
            preview = document.getElementById('preview');
            preview.style.display = 'block';
            const [file] = selectImage.files
            if (file) {
                preview.src = URL.createObjectURL(file)
            }
        }
    </script>
@endsection
