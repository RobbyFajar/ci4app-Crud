<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="p-5 mb-4 bg-light rounded-3">
                <div class="container-fluid py-5">
                    <h1 class="display-5 fw-bold">Hello World!</h1>
                    <p class="col-md-8 fs-4">This my first app website using codeigniter 4</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>