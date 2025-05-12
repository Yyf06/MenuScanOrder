<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<main>

    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item ms-3 mt-2"><a href="#">Home</a></li>
            <li class="breadcrumb-item ms-3 mt-2" aria-current="page">QR code</li>
        </ol>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4">Generate QR Code for Table</h2>
        <div class="form-group">
            <form id="qr-generation-form">
                <label class="mb-2" for="tableNumber">Enter Table Number:</label><br>
                <input type="text"
                    name="table-number"
                    id="table-number"
                    value=""
                    placeholder="Enter table number"
                    autocomplete="off" />
                <br>
                <input type="submit" class="btn btn-primary mt-5"
                    value="Generate QR Code" />
            </form><br />
        </div>
        <div id="qr-code"></div>
    </div>
    <!-- <?php
    $businessowner_id = $businessowner_id ?? null;
    ?> -->

</main>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
     let tableNumberInput = document.getElementById("table-number");
    let qrGenerationForm = document.getElementById("qr-generation-form");
    let qrCode;

    function generateQrCode(tableNumber, businessowner_id) {
        let qrContent = `<?= base_url() ?>${tableNumber}/${businessowner_id}`;
        return new QRCode("qr-code", {
            text: qrContent,
            width: 256,
            height: 256,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H,
        });
    }

        qrGenerationForm.addEventListener("submit", function (event) {
            event.preventDefault(); 
            let tableNumber = tableNumberInput.value;
            let businessOwnerId = <?= session()->get('businessowner_id') ?>;
            if (qrCode == null) {
                qrCode = generateQrCode(tableNumber, businessOwnerId); 
            } else {
            qrCode.makeCode(`<?= base_url() ?>${tableNumber}/${businessOwnerId}`);

            }
});

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<?= $this->endSection() ?>
