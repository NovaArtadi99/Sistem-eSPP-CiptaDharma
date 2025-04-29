<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Export Panduan Pembayaran</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        .html2pdf__page-break {
            page-break-before: always;
        }
        img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div id="exportContent">
        <h3>Cara melakukan pembayaran</h3>
        <p>Pembayaran dapat dilakukan melalui transfer bank ke rekening sekolah. Setelah melakukan pembayaran, simpan bukti transfer dan unggah melalui portal sekolah atau serahkan langsung ke bagian administrasi.</p>

        <p><strong>1. Buka menu pembayaran.</strong></p>
        <img src="{{ asset('panduan/langkah1.png') }}" alt="Langkah 1">

        <div class="html2pdf__page-break"></div>

        <p><strong>2. Pilih invoice yang ingin dibayarkan, kemudian Tekan Bayar.</strong></p>
        <img src="{{ asset('panduan/langkah2.png') }}" alt="Langkah 2">

        <div class="html2pdf__page-break"></div>

        <p><strong>3. Tekan Submit setelah mengisi form yang telah disediakan.</strong></p>
        <img src="{{ asset('panduan/langkah3.png') }}" alt="Langkah 3">
    </div>

    <script>
        window.onload = () => {
            window.print();
        };
    
        window.onafterprint = () => {
            window.close();
        };
    </script>    

</body>
</html>
