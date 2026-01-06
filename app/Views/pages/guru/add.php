<?php $this->extend('layout/main_layout') ?>

<?php $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah Guru</h3>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        <form action="<?= base_url('guru/addpost') ?>" method="post">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" class="form-control <?= session('errname') ? 'is-invalid' : '' ?>" id="name" name="name" value="<?= old('name') ?>" required>
                <?php if (session('errname')): ?>
                    <div class="invalid-feedback">
                        <?= session('errname') ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control <?= session('errusername') ? 'is-invalid' : '' ?>" id="username" name="username" value="<?= old('username') ?>" required>
                <?php if (session('errusername')): ?>
                    <div class="invalid-feedback">
                        <?= session('errusername') ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control <?= session('errpassword') ? 'is-invalid' : '' ?>" id="password" name="password" required>
                <?php if (session('errpassword')): ?>
                    <div class="invalid-feedback">
                        <?= session('errpassword') ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label>Kelas yang Dikelola</label>
                <div class="row">
                    <?php foreach ($categories as $category): ?>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="categories[]" value="<?= $category['id'] ?>" id="category_<?= $category['id'] ?>">
                            <label class="form-check-label" for="category_<?= $category['id'] ?>">
                                <?= $category['name'] ?>
                            </label>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php if (session('errcategories')): ?>
                    <div class="text-danger">
                        <?= session('errcategories') ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('guru') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?php $this->endSection() ?>