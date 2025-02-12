<?php if($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $this->session->flashdata('success'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="row mb-3">
    <div class="col-md-6">
        <a href="<?php echo site_url('products/add'); ?>" class="btn btn-primary">Tambah Produk Baru</a>
    </div>
    <div class="col-md-6">
        <form action="<?php echo site_url('products'); ?>" method="get" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari produk..." value="<?php echo $search; ?>">
            <button type="submit" class="btn btn-outline-primary">Cari</button>
        </form>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>
                    Nama Produk
                    <a href="<?php echo site_url('products?sort_by=name&sort_order=' . ($sort_by == 'name' && $sort_order == 'asc' ? 'desc' : 'asc') . ($search ? '&search='.$search : '')); ?>" class="text-decoration-none">
                        <?php if($sort_by == 'name'): ?>
                            <?php echo $sort_order == 'asc' ? '↑' : '↓'; ?>
                        <?php else: ?>
                            ↕
                        <?php endif; ?>
                    </a>
                </th>
                <th>
                    Harga
                    <a href="<?php echo site_url('products?sort_by=price&sort_order=' . ($sort_by == 'price' && $sort_order == 'asc' ? 'desc' : 'asc') . ($search ? '&search='.$search : '')); ?>" class="text-decoration-none">
                        <?php if($sort_by == 'price'): ?>
                            <?php echo $sort_order == 'asc' ? '↑' : '↓'; ?>
                        <?php else: ?>
                            ↕
                        <?php endif; ?>
                    </a>
                </th>
                <th>
                    Stok
                    <a href="<?php echo site_url('products?sort_by=stock&sort_order=' . ($sort_by == 'stock' && $sort_order == 'asc' ? 'desc' : 'asc') . ($search ? '&search='.$search : '')); ?>" class="text-decoration-none">
                        <?php if($sort_by == 'stock'): ?>
                            <?php echo $sort_order == 'asc' ? '↑' : '↓'; ?>
                        <?php else: ?>
                            ↕
                        <?php endif; ?>
                    </a>
                </th>
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
                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(<?php echo $product->id; ?>, '<?php echo htmlspecialchars($product->name); ?>')">Hapus</button>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if(empty($products)): ?>
            <tr>
                <td colspan="6" class="text-center">
                    <?php if($search): ?>
                        Tidak ada produk yang cocok dengan pencarian "<?php echo htmlspecialchars($search); ?>"
                    <?php else: ?>
                        Tidak ada data produk
                    <?php endif; ?>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus produk <span id="productName"></span>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="#" id="deleteButton" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id, name) {
    document.getElementById('productName').textContent = name;
    document.getElementById('deleteButton').href = '<?php echo site_url('products/delete/'); ?>' + id;
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
</script>
