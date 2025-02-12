<?php if($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        <?php echo $this->session->flashdata('success'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <?php echo $this->session->flashdata('error'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <a href="<?php echo site_url('products/add'); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Tambah Produk Baru
                </a>
            </div>
            <div class="col-md-6">
                <form action="<?php echo site_url('products'); ?>" method="get" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Cari produk..." value="<?php echo $search; ?>">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 25%;">
                            Nama Produk
                            <a href="<?php echo site_url('products?sort_by=name&sort_order=' . ($sort_by == 'name' && $sort_order == 'asc' ? 'desc' : 'asc') . ($search ? '&search='.$search : '')); ?>" class="text-decoration-none">
                                <i class="bi bi-arrow-<?php echo ($sort_by == 'name' ? ($sort_order == 'asc' ? 'down' : 'up') : 'down-up'); ?>"></i>
                            </a>
                        </th>
                        <th style="width: 20%;">
                            Harga
                            <a href="<?php echo site_url('products?sort_by=price&sort_order=' . ($sort_by == 'price' && $sort_order == 'asc' ? 'desc' : 'asc') . ($search ? '&search='.$search : '')); ?>" class="text-decoration-none">
                                <i class="bi bi-arrow-<?php echo ($sort_by == 'price' ? ($sort_order == 'asc' ? 'down' : 'up') : 'down-up'); ?>"></i>
                            </a>
                        </th>
                        <th style="width: 15%;">
                            Stok
                            <a href="<?php echo site_url('products?sort_by=stock&sort_order=' . ($sort_by == 'stock' && $sort_order == 'asc' ? 'desc' : 'asc') . ($search ? '&search='.$search : '')); ?>" class="text-decoration-none">
                                <i class="bi bi-arrow-<?php echo ($sort_by == 'stock' ? ($sort_order == 'asc' ? 'down' : 'up') : 'down-up'); ?>"></i>
                            </a>
                        </th>
                        <th style="width: 15%;">Status</th>
                        <th style="width: 20%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    foreach ($products as $product): ?>
                    <tr>
                        <td class="text-center"><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($product->name); ?></td>
                        <td class="text-end">Rp <?php echo number_format($product->price, 0, ',', '.'); ?></td>
                        <td class="text-center"><?php echo number_format($product->stock, 0, ',', '.'); ?></td>
                        <td class="text-center">
                            <?php if($product->is_sell): ?>
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle me-1"></i> Dijual
                                </span>
                            <?php else: ?>
                                <span class="badge bg-danger">
                                    <i class="bi bi-x-circle me-1"></i> Tidak Dijual
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <a href="<?php echo site_url('products/edit/'.$product->id); ?>" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(<?php echo $product->id; ?>, '<?php echo htmlspecialchars($product->name); ?>')">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(empty($products)): ?>
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
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
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>
                    Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Apakah Anda yakin ingin menghapus produk <strong><span id="productName"></span></strong>?</p>
                <small class="text-danger">
                    <i class="bi bi-exclamation-circle"></i>
                    Tindakan ini tidak dapat dibatalkan
                </small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg"></i> Batal
                </button>
                <a href="#" id="deleteButton" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Hapus
                </a>
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
