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
                        <th style="width: 20%;" class="text-end">
                            Harga
                            <a href="<?php echo site_url('products?sort_by=price&sort_order=' . ($sort_by == 'price' && $sort_order == 'asc' ? 'desc' : 'asc') . ($search ? '&search='.$search : '')); ?>" class="text-decoration-none">
                                <i class="bi bi-arrow-<?php echo ($sort_by == 'price' ? ($sort_order == 'asc' ? 'down' : 'up') : 'down-up'); ?>"></i>
                            </a>
                        </th>
                        <th style="width: 15%;" class="text-center">
                            Stok
                            <a href="<?php echo site_url('products?sort_by=stock&sort_order=' . ($sort_by == 'stock' && $sort_order == 'asc' ? 'desc' : 'asc') . ($search ? '&search='.$search : '')); ?>" class="text-decoration-none">
                                <i class="bi bi-arrow-<?php echo ($sort_by == 'stock' ? ($sort_order == 'asc' ? 'down' : 'up') : 'down-up'); ?>"></i>
                            </a>
                        </th>
                        <th style="width: 15%;" class="text-center">Status</th>
                        <th style="width: 20%;" class="text-center">Aksi</th>
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
                            <div class="form-check form-switch d-flex justify-content-center">
                                <input type="checkbox" class="form-check-input status-toggle" 
                                       data-id="<?php echo $product->id; ?>"
                                       <?php echo $product->is_sell ? 'checked' : ''; ?>>
                                <span class="status-text ms-2 <?php echo $product->is_sell ? 'text-success' : 'text-danger'; ?>">
                                    <?php echo $product->is_sell ? 'Dijual' : 'Tidak Dijual'; ?>
                                </span>
                            </div>
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

<!-- Toast Notifikasi -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="statusToast" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-info-circle me-2"></i>
                <span id="toastMessage"></span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<script>
// Konfirmasi Hapus
function confirmDelete(id, name) {
    document.getElementById('productName').textContent = name;
    document.getElementById('deleteButton').href = '<?php echo site_url('products/delete/'); ?>' + id;
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

// Update Status
document.addEventListener('DOMContentLoaded', function() {
    const statusToggles = document.querySelectorAll('.status-toggle');
    const toast = new bootstrap.Toast(document.getElementById('statusToast'));
    
    statusToggles.forEach(toggle => {
        toggle.addEventListener('change', function() {
            const productId = this.dataset.id;
            const isChecked = this.checked;
            const statusText = this.parentElement.querySelector('.status-text');
            
            // Simpan elemen yang digunakan
            const toggleElement = this;
            const originalChecked = !isChecked;
            
            // Kirim permintaan AJAX
            fetch('<?php echo site_url('products/update_status'); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + productId + '&is_sell=' + (isChecked ? 1 : 0)
            })
            .then(response => response.json())
            .then(data => {
                const toastElement = document.getElementById('statusToast');
                const toastMessage = document.getElementById('toastMessage');
                
                if (data.success) {
                    // Update tampilan
                    statusText.textContent = isChecked ? 'Dijual' : 'Tidak Dijual';
                    statusText.className = 'status-text ms-2 ' + (isChecked ? 'text-success' : 'text-danger');
                    
                    // Tampilkan toast sukses
                    toastElement.classList.remove('bg-danger');
                    toastElement.classList.add('bg-success');
                    toastMessage.textContent = data.message;
                } else {
                    // Kembalikan toggle ke posisi semula
                    toggleElement.checked = originalChecked;
                    
                    // Tampilkan toast error
                    toastElement.classList.remove('bg-success');
                    toastElement.classList.add('bg-danger');
                    toastMessage.textContent = data.message;
                }
                
                toast.show();
            })
            .catch(error => {
                // Kembalikan toggle ke posisi semula
                toggleElement.checked = originalChecked;
                
                // Tampilkan toast error
                const toastElement = document.getElementById('statusToast');
                const toastMessage = document.getElementById('toastMessage');
                toastElement.classList.remove('bg-success');
                toastElement.classList.add('bg-danger');
                toastMessage.textContent = 'Terjadi kesalahan saat memperbarui status';
                toast.show();
            });
        });
    });
});
</script>
