<?php $this->extend('layout/main_layout') ?>

<?php $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Guru</h3>
    </div>
    <div class="card-body">
        <form action="<?= base_url('guru/editpost/' . $guru['id']) ?>" method="post">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" class="form-control <?= session('errname') ? 'is-invalid' : '' ?>" id="name" name="name" value="<?= old('name', $guru['name']) ?>" required>
                <?php if (session('errname')): ?>
                    <div class="invalid-feedback">
                        <?= session('errname') ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control <?= session('errusername') ? 'is-invalid' : '' ?>" id="username" name="username" value="<?= old('username', $guru['username']) ?>" required>
                <?php if (session('errusername')): ?>
                    <div class="invalid-feedback">
                        <?= session('errusername') ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="password">Password (Kosongkan jika tidak ingin mengubah)</label>
                <input type="password" class="form-control <?= session('errpassword') ? 'is-invalid' : '' ?>" id="password" name="password">
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
                            <input class="form-check-input" type="checkbox" name="categories[]" value="<?= $category['id'] ?>" id="category_<?= $category['id'] ?>" 
                                <?= in_array($category['id'], $assigned_categories) ? 'checked' : '' ?>>
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
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="<?= base_url('guru') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?php $this->endSection() ?>