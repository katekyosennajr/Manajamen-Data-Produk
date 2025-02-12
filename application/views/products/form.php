<?php if(validation_errors()): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo validation_errors(); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0"><?php echo $title; ?></h5>
    </div>
    <div class="card-body">
        <form action="<?php echo $action; ?>" method="post" class="needs-validation" novalidate>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                    <input type="text" class="form-control <?php echo form_error('name') ? 'is-invalid' : ''; ?>" 
                           id="name" name="name" 
                           value="<?php echo set_value('name', isset($product) ? $product->name : ''); ?>" 
                           required minlength="3" maxlength="255">
                    <div class="invalid-feedback">
                        Nama produk harus diisi (3-255 karakter)
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="price" class="form-label">Harga Produk <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control <?php echo form_error('price') ? 'is-invalid' : ''; ?>" 
                               id="price" name="price" 
                               value="<?php echo set_value('price', isset($product) ? $product->price : ''); ?>" 
                               required min="0">
                        <div class="invalid-feedback">
                            Harga produk harus diisi dengan angka positif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="stock" class="form-label">Jumlah Stok <span class="text-danger">*</span></label>
                    <input type="number" class="form-control <?php echo form_error('stock') ? 'is-invalid' : ''; ?>" 
                           id="stock" name="stock" 
                           value="<?php echo set_value('stock', isset($product) ? $product->stock : ''); ?>" 
                           required min="0">
                    <div class="invalid-feedback">
                        Jumlah stok harus diisi dengan angka positif
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label d-block">Status Produk</label>
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="is_sell" name="is_sell" value="1" 
                               <?php echo set_checkbox('is_sell', '1', isset($product) && $product->is_sell); ?>>
                        <label class="form-check-label" for="is_sell">Dijual</label>
                    </div>
                </div>
            </div>

            <hr>

            <div class="d-flex justify-content-between">
                <a href="<?php echo site_url('products'); ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Bootstrap form validation
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})()
</script>
