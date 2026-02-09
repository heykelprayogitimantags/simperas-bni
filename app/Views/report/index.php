<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Generate Laporan Aset</h1>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Preview Laporan</h6>
            <button class="btn btn-danger btn-sm">
                <i class="fas fa-file-pdf"></i> Export ke PDF
            </button>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Kode Asset</th>
                        <th>Nama Asset</th>
                        <th>Tipe</th>
                        <th>Brand</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($assets as $a) : ?>
                    <tr>
                        <td><?= $a['kode_asset']; ?></td>
                        <td><?= $a['nama_asset']; ?></td>
                        <td><?= $a['tipe']; ?></td>
                        <td><?= $a['brand']; ?></td>
                        <td><?= $a['status']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>