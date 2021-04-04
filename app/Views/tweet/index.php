<?= $this->extend('layout/template') ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col-auto mr-auto">
            <h1 class="mt-2">Daftar Tweet</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-6 mr-auto">
            <form action="" method="get">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Masukkan username .." name="keyword">
                    <a href="/tweet" class="btn btn-default">Reset</a>
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
                            <th scope="col">Username</th>
                            <th scope="col">Waktu Tweet</th>
                            <th scope="col">Tweet</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1 + (10 * ($currentPage - 1)); ?>
                        <?php foreach ($tweet as $t) : ?>
                            <tr>
                                <th scope="row" width="1%"><?= $i++ ?></th>
                                <td><?= $t['username']; ?></td>
                                <td width="16%"><?= $t['created_at']; ?></td>
                                <td><?= $t['full_text']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="row-md">
                    <div class="col">
                        <?= $pager->links('tweet', 'tweet_pagination') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>