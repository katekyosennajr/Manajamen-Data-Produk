<div class="row mb-3">
    <div class="col">
        <a href="<?php echo site_url('products/add'); ?>" class="btn btn-primary">Tambah Produk Baru</a>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            foreach ($products as $product): ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($product->name); ?></td>
                <td>Rp <?php echo number_format($product->price, 0, ',', '.'); ?></td>
                <td><?php echo $product->stock; ?></td>
                <td>
                    <?php if($product->is_sell): ?>
                        <span class="badge bg-success">Dijual</span>
                    <?php else: ?>
                        <span class="badge bg-danger">Tidak Dijual</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?php echo site_url('products/edit/'.$product->id); ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="<?php echo site_url('products/delete/'.$product->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if(empty($products)): ?>
            <tr>
                <td colspan="6" class="text-center">Tidak ada data produk</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
