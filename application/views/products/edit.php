<?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

<div class="card">
    <div class="card-body">
        <form action="<?php echo site_url('products/edit/'.$product->id); ?>" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Nama Produk</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name', $product->name); ?>" required>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Harga Produk</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" class="form-control" id="price" name="price" value="<?php echo set_value('price', $product->price); ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="stock" class="form-label">Jumlah Stok</label>
                <input type="number" class="form-control" id="stock" name="stock" value="<?php echo set_value('stock', $product->stock); ?>" required>
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="is_sell" name="is_sell" value="1" <?php echo set_checkbox('is_sell', '1', $product->is_sell); ?>>
                    <label class="form-check-label" for="is_sell">Status Produk (Dijual)</label>
                </div>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="<?php echo site_url('products'); ?>" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
