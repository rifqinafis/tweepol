<?= $this->extend('layout/template') ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col-6">
            <h1 class="mt-2">Daftar Author</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-6 mr-auto">
            <form action="" method="get">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Masukkan username .." name="keyword">
                    <a href="/author" class="btn btn-default">Reset</a>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Cari</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary" disabled>Total Record : <?php echo count($totalresult); ?></button>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Politisi</th>
                            <th scope="col">Username</th>
                            <th scope="col">Following</th>
                            <th scope="col">Followers</th>
                            <th scope="col">Jenis Kelamin</th>
                            <th scope="col">Umur</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1 + (7 * ($currentPage - 1)); ?>
                        <?php foreach ($author as $a) : ?>
                            <tr>
                                <th scope="row"><?= $i++ ?></th>
                                <td><?= $a['nama']; ?></td>
                                <td><?= $a['username']; ?></td>
                                <td><?= $a['following']; ?></td>
                                <td><?= $a['followers']; ?></td>
                                <td><?= $a['gender']; ?></td>
                                <td><?= $a['usia']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="row-md">
                    <div class="col">
                        <?= $pager->links('akun', 'author_pagination') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>