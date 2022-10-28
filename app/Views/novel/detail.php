<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h2 class="mb-3">Detail Light Novel</h2>
            <div class="card text-bg-light border-dark mb-3" style="max-width: 540px;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="/img/<?= $novel['sampul']; ?>" class="img-fluid rounded-start" alt="sampul">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title mb-3"><b><?= $novel['judul']; ?></b></h5>
                            <p class="card-text"><b>Karya ini ditulis oleh : </b><?= $novel['penulis']; ?></p>
                            <p class="card-text "><small class="text-muted"><b>Diterbikan oleh : </b><?= $novel['penerbit']; ?></small></p>
                            <!-- edit novel -->
                            <a href="/novel/edit/<?= $novel['slug']; ?>" class="btn btn-warning ">Edit</a>
                            <!-- DELETE novel -->
                            <form action="/novel/<?= $novel['id']; ?>" method="post" class="d-inline">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('apakah anda yakin');">Delete</button>
                            </form>
                            <!-- kembali ke daftar novel -->
                            <br><br>
                            <a href="/novel" class="btn btn-primary mt-1">Kembali Ke daftar Novel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>