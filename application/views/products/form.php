<?php
$is_edit = isset($product);
$title = $is_edit ? 'Edit Produk' : 'Tambah Produk Baru';
?>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="bi bi-<?php echo $is_edit ? 'pencil' : 'plus-lg'; ?>"></i>
            <?php echo $title; ?>
        </h5>
    </div>
    <div class="card-body">
        <?php if(validation_errors()): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Error!</strong> Silakan perbaiki kesalahan berikut:
                <?php echo validation_errors(); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="<?php echo $action; ?>" method="post" id="productForm" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" 
                       value="<?php echo set_value('name', $is_edit ? $product->name : ''); ?>" 
                       required minlength="3" maxlength="255">
                <div class="invalid-feedback">
                    Nama produk harus diisi (minimal 3 karakter)
                </div>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Harga <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" class="form-control" id="price" name="price" 
                           value="<?php echo set_value('price', $is_edit ? $product->price : ''); ?>" 
                           required min="0">
                    <div class="invalid-feedback">
                        Harga harus diisi dengan angka positif
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="stock" class="form-label">Jumlah Stok <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="stock" name="stock" 
                       value="<?php echo set_value('stock', $is_edit ? $product->stock : ''); ?>" 
                       required min="0">
                <div class="invalid-feedback">
                    Stok harus diisi dengan angka positif
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label d-block">Status Produk</label>
                <div class="form-check form-switch">
                    <input type="checkbox" class="form-check-input" id="is_sell" name="is_sell" value="1"
                           <?php echo set_checkbox('is_sell', '1', $is_edit && $product->is_sell); ?>>
                    <label class="form-check-label" for="is_sell">
                        <span id="statusText">
                            <?php echo $is_edit && $product->is_sell ? 'Dijual' : 'Tidak Dijual'; ?>
                        </span>
                    </label>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="<?php echo site_url('products'); ?>" class="btn btn-secondary">
                    <i class="bi bi-x-lg"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
// Form validation
(function() {
    'use strict';
    
    const form = document.getElementById('productForm');
    
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    });
    
    // Update status text when toggle changes
    const statusToggle = document.getElementById('is_sell');
    const statusText = document.getElementById('statusText');
    
    statusToggle.addEventListener('change', function() {
        statusText.textContent = this.checked ? 'Dijual' : 'Tidak Dijual';
    });
    
    // Format harga saat input
    const priceInput = document.getElementById('price');
    priceInput.addEventListener('input', function() {
        if (this.value < 0) this.value = 0;
    });
    
    // Format stok saat input
    const stockInput = document.getElementById('stock');
    stockInput.addEventListener('input', function() {
        if (this.value < 0) this.value = 0;
        this.value = Math.floor(this.value); // Memastikan input berupa bilangan bulat
    });
})();
</script>
