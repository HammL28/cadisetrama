

<?php $__env->startSection('title', 'Sistem Kasir (POS)'); ?>

<?php $__env->startSection('content'); ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* Palette & Base Styling - Purple Gradient Theme */
    :root {
        --purple-deep: #6366f1;
        --purple-main: #8b5cf6;
        --purple-light: #a855f7;
        --purple-bright: #c084fc;
        --pink-accent: #e879f9;
        --bg-slate: #f5f3ff;
    }

    body {
        background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 50%, #f3e8ff 100%) !important;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* Banner Gradient POS Header */
    .banner-purple-gradient {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 25%, #a855f7 50%, #c084fc 75%, #e879f9 100%) !important;
        color: #ffffff !important;
    }

    /* Card Styling */
    .custom-card {
        border: 1px solid rgba(139, 92, 246, 0.2) !important;
        box-shadow: 0 4px 16px rgba(139, 92, 246, 0.1);
    }

    .bg-table-head {
        background-color: #f8fafc !important;
    }

    .table-head-text {
        color: #6b7280 !important;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    /* Interactive Product Items */
    .product-select-btn {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
    }

    .product-select-btn:hover {
        border-color: #a855f7;
        background-color: #faf5ff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.12);
    }

    /* Search Box Focus State */
    .bg-search {
        background-color: #f1f5f9 !important;
        border-color: #e2e8f0 !important;
        transition: all 0.2s ease;
    }

    .search-box:focus-within .bg-search {
        background-color: #ffffff !important;
        border-color: var(--purple-main) !important;
    }

    /* Badges & Soft Color Elements */
    .badge-soft-purple {
        background-color: #f3e8ff !important;
        color: #6d28d9 !important;
        border: 1px solid #ddd6fe !important;
    }

    /* Action Delete Soft */
    .btn-action-delete {
        background-color: #fee2e2 !important;
        color: #dc2626 !important;
        border: none !important;
        transition: all 0.2s ease;
    }
    .btn-action-delete:hover {
        background-color: #dc2626 !important;
        color: #ffffff !important;
        transform: scale(1.08);
    }

    /* Checkout Banner / Receipt Box */
    .total-receipt-box {
        background: linear-gradient(135deg, #f3e8ff 0%, #fae8ff 100%);
        border: 1px dashed #c084fc;
        border-radius: 12px;
    }

    /* QRIS Custom Box */
    .qris-card {
        background: #ffffff;
        border: 2px dashed #a855f7;
        border-radius: 16px;
    }
</style>

<div class="container py-4">

    
    <?php if(session('errors')): ?>
        <div class="alert alert-danger rounded-3 shadow-sm mb-4 border-0 border-start border-4 border-danger">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                <div>
                    <?php if(is_object(session('errors')) && method_exists(session('errors'), 'all')): ?>
                        <?php $__currentLoopData = session('errors')->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div><?php echo e($error); ?></div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <?php echo e(session('errors')); ?>

                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success rounded-3 shadow-sm mb-4 border-0 border-start border-4 border-success">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill fs-5"></i>
                <div><?php echo e(session('success')); ?></div>
            </div>
        </div>
    <?php endif; ?>

    
    <div class="banner-purple-gradient p-4 p-md-5 rounded-4 mb-4 position-relative overflow-hidden shadow-sm">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 position-relative" style="z-index: 1;">
            <div>
                <h2 class="fw-bold mb-1 text-white d-flex align-items-center gap-2">
                    <i class="bi bi-calculator-fill fs-2"></i> Transaksi Kasir (POS)
                </h2>
                <p class="text-white opacity-75 small mb-0">Pilih item barang di sebelah kiri dan kelola keranjang belanja di sebelah kanan.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="<?php echo e(route('penjualan.index')); ?>" class="btn btn-light rounded-pill px-4 shadow-sm fw-semibold d-inline-flex align-items-center gap-2" style="color: #7c3aed !important;">
                    <i class="bi bi-arrow-left"></i>
                    <span>Riwayat Transaksi</span>
                </a>
            </div>
        </div>
        
        <div class="position-absolute end-0 bottom-0 opacity-25 pe-4 pb-2 d-none d-md-block">
            <i class="bi bi-cart-check-fill text-white" style="font-size: 5rem;"></i>
        </div>
    </div>

    <div class="row g-4">

        
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 custom-card h-100">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                            <i class="bi bi-grid-fill" style="color: #7c3aed;"></i> Katalog Produk
                        </h5>
                        <span class="badge badge-soft-purple px-2.5 py-1 rounded-pill small">
                            <?php echo e(count($products)); ?> Barang
                        </span>
                    </div>

                    
                    <div class="input-group search-box">
                        <span class="input-group-text border-end-0 text-muted rounded-start-pill ps-3 bg-search">
                            <i class="bi bi-search" style="color: #7c3aed;"></i>
                        </span>
                        <input
                            type="text"
                            id="searchInput"
                            value="<?php echo e(request('search')); ?>"
                            class="form-control border-start-0 rounded-end-pill ps-0 bg-search shadow-none"
                            placeholder="Cari nama produk..."
                            onkeyup="filterProducts()"
                        >
                    </div>
                </div>

                <div class="card-body px-4 pb-4" style="max-height: 65vh; overflow-y: auto;">
                    <div class="d-flex flex-column gap-2" id="productList">
                        <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="product-item" data-name="<?php echo e(strtolower($product->nama)); ?>">
                                <form method="POST" action="<?php echo e(route('itempenjualan.store')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                                    <input type="hidden" name="sale_id" value="<?php echo e($sale->id); ?>">

                                    <div class="p-2 rounded-3 product-select-btn">
                                        <div class="row align-items-center g-2">
                                            <div class="col-7 col-sm-7">
                                                <div class="d-flex align-items-center gap-3">
                                                    <?php if(isset($product->foto) && $product->foto): ?>
                                                        <img src="<?php echo e(asset('storage/'.$product->foto)); ?>"
                                                             alt="<?php echo e($product->nama); ?>"
                                                             class="rounded-3 shadow-sm border"
                                                             style="width:48px; height:48px; object-fit:cover;">
                                                    <?php else: ?>
                                                        <div class="rounded-3 shadow-sm d-flex align-items-center justify-content-center bg-light fw-bold" style="width:48px; height:48px; color: #7c3aed;">
                                                            <i class="bi bi-box-seam fs-5"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="text-truncate">
                                                        <div class="fw-bold text-dark text-truncate"><?php echo e($product->nama); ?></div>
                                                        <div class="fw-semibold small" style="color: #7c3aed;">Rp <?php echo e(number_format($product->harga_jual, 0, ',', '.')); ?></div>
                                                        <?php if(isset($product->stok)): ?>
                                                            <div class="text-muted" style="font-size: 0.75rem;">Stok: <?php echo e($product->stok); ?></div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-3 col-sm-3">
                                                <input type="number"
                                                       name="quantity"
                                                       value="1"
                                                       min="1"
                                                       <?php if(isset($product->stok)): ?> max="<?php echo e($product->stok); ?>" <?php endif; ?>
                                                       class="form-control form-control-sm text-center border-1 shadow-none rounded-pill"
                                                       style="background-color: #f8fafc;"
                                                       <?php echo e($sale->status === 'COMPLETED' || (isset($product->stok) && $product->stok <= 0) ? 'disabled' : ''); ?>>
                                            </div>

                                            <div class="col-2 col-sm-2 text-end">
                                                <button type="submit" 
                                                        class="btn btn-sm text-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm <?php echo e($sale->status === 'COMPLETED' || (isset($product->stok) && $product->stok <= 0) ? 'disabled' : ''); ?>" 
                                                        style="width: 36px; height: 36px; background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);" 
                                                        title="<?php echo e((isset($product->stok) && $product->stok <= 0) ? 'Stok Habis' : 'Tambah ke Keranjang'); ?>">
                                                    <i class="bi bi-plus-lg fw-bold"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-box-seam text-secondary fs-1 d-block mb-2"></i>
                                <span>Produk tidak ditemukan.</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 custom-card h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                <i class="bi bi-cart3" style="color: #7c3aed;"></i> Keranjang
                                <span class="badge rounded-pill bg-danger fs-6 fw-normal px-2" style="font-size: 0.75rem !important;">
                                    <?php echo e($sale->itemPenjualan ? $sale->itemPenjualan->sum('kuantitas') : 0); ?> Item
                                </span>
                            </h5>
                            <span class="badge badge-soft-purple px-3 py-1 rounded-pill fw-semibold">
                                Transaksi #<?php echo e($sale->id); ?>

                            </span>
                        </div>
                    </div>

                    
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 custom-table">
                            <thead class="bg-table-head border-0">
                                <tr class="table-head-text small">
                                    <th class="ps-4">PRODUK</th>
                                    <th>HARGA</th>
                                    <th style="width: 18%;">QTY</th>
                                    <th>SUBTOTAL</th>
                                    <th class="pe-4 text-end" style="width: 10%;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $sale->itemPenjualan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="ps-4">
                                        <span class="fw-semibold text-dark small d-block"><?php echo e($item->produk->nama); ?></span>
                                    </td>
                                    <td class="text-muted small">
                                        Rp <?php echo e(number_format($item->produk->harga_jual, 0, ',', '.')); ?>

                                    </td>
                                    <td>
                                        <form method="POST" action="<?php echo e(route('itempenjualan.update', $item->id)); ?>">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <input type="number"
                                                   name="quantity"
                                                   value="<?php echo e($item->kuantitas); ?>"
                                                   min="1"
                                                   onchange="this.form.submit()"
                                                   class="form-control form-control-sm text-center border-1 shadow-none rounded-2"
                                                   style="background-color: #f8fafc;"
                                                   <?php echo e($sale->status === 'COMPLETED' ? 'disabled' : ''); ?>>
                                        </form>
                                    </td>
                                    <td class="fw-bold small" style="color: #7c3aed;">
                                        Rp <?php echo e(number_format($item->subtotal, 0, ',', '.')); ?>

                                    </td>
                                    <td class="pe-4 text-end">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete', $item)): ?>
                                        <form method="POST" action="<?php echo e(route('itempenjualan.destroy', $item->id)); ?>">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" 
                                                    class="btn btn-action-delete rounded-circle d-inline-flex align-items-center justify-content-center" 
                                                    style="width: 32px; height: 32px;" 
                                                    title="Hapus Item" 
                                                    <?php echo e($sale->status === 'COMPLETED' ? 'disabled' : ''); ?>>
                                                <i class="bi bi-trash-fill small"></i>
                                            </button>
                                        </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-cart-x text-secondary fs-1 d-block mb-2"></i>
                                        <span>Keranjang belanja masih kosong.</span>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                
                <div class="card-footer bg-white border-0 p-4 border-top">
                    <div class="total-receipt-box p-3 mb-3 text-center">
                        <span class="text-muted small text-uppercase fw-semibold d-block mb-1">Total Pembayaran</span>
                        <h2 class="fw-bold mb-0" style="color: #6d28d9;">
                            Rp <?php echo e(number_format($sale->total_pembayaran, 0, ',', '.')); ?>

                        </h2>
                    </div>

                    
                    <form id="checkoutForm" method="POST" action="<?php echo e(route('penjualan.update', $sale->id)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="mb-3">
                            <select id="paymentMethodSelect" name="payment_method" class="form-select border-1 rounded-pill px-3 shadow-none bg-light" required <?php echo e($sale->status === 'COMPLETED' ? 'disabled' : ''); ?>>
                                <option value="">-- Pilih Metode Pembayaran --</option>
                                <option value="CASH">Cash / Tunai</option>
                                <option value="QRIS">QRIS (Scan Barcode)</option>
                                <option value="TRANSFER">Transfer Bank</option>
                            </select>
                        </div>

                        <button type="button" onclick="handleCheckout()" class="btn btn-success w-100 rounded-pill py-2.5 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2 <?php echo e($sale->status === 'COMPLETED' ? 'disabled' : ''); ?>" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border: none;">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Selesaikan & Checkout</span>
                        </button>
                    </form>

                    
                    <?php if($sale->status === 'COMPLETED'): ?>
                        <a href="javascript:window.print()" class="btn btn-dark w-100 rounded-pill py-2 mt-2 fw-semibold d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-printer-fill"></i>
                            <span>Cetak Struk Pembayaran</span>
                        </a>
                    <?php endif; ?>

                    
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete', $sale)): ?>
                    <form id="cancelTransactionForm" action="<?php echo e(route('penjualan.destroy', $sale->id)); ?>" method="POST" class="mt-2">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>

                        <button type="button" onclick="confirmCancelTransaction()" class="btn btn-outline-danger w-100 rounded-pill py-2 border-0 small fw-semibold d-flex align-items-center justify-content-center gap-1 <?php echo e($sale->status === 'COMPLETED' ? 'disabled' : ''); ?>">
                            <i class="bi bi-x-circle"></i>
                            <span>Batalkan Transaksi</span>
                        </button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>

</div>


<div class="modal fade" id="qrisModal" tabindex="-1" aria-labelledby="qrisModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
            <div class="modal-header text-white border-0 py-3" style="background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2" id="qrisModalLabel">
                    <i class="bi bi-qr-code-scan"></i> Pembayaran QRIS
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <p class="text-muted small mb-3">Scan QR Code menggunakan aplikasi E-Wallet / Mobile Banking Anda.</p>
                
                
                <div class="qris-card p-4 d-inline-block shadow-sm mb-3">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=POS-TRX-<?php echo e($sale->id); ?>-TOTAL-<?php echo e($sale->total_pembayaran); ?>" 
                         alt="QRIS Barcode" 
                         class="img-fluid rounded-3 mb-2">
                    <div class="d-flex align-items-center justify-content-center gap-2 text-muted small fw-bold">
                        <i class="bi bi-shield-check text-success"></i> QRIS NATIONAL STANDARD
                    </div>
                </div>

                <div class="text-dark fw-bold fs-4 mb-1" style="color: #6d28d9 !important;">
                    Rp <?php echo e(number_format($sale->total_pembayaran, 0, ',', '.')); ?>

                </div>
                
                <div class="badge bg-warning text-dark px-3 py-2 rounded-pill small mb-3">
                    <i class="bi bi-clock"></i> Sisa Waktu: <span id="qrisTimer">05:00</span>
                </div>

                <div class="d-grid gap-2">
                    <button type="button" onclick="submitFinalCheckout()" class="btn text-white fw-bold rounded-pill py-2.5 shadow-sm" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border: none;">
                        <i class="bi bi-check2-circle"></i> Selesaikan Pembayaran
                    </button>
                    <button type="button" class="btn btn-light rounded-pill text-muted border py-2" data-bs-dismiss="modal">
                        Batal / Ganti Metode
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    // Filtering Katalog Produk Real-time
    function filterProducts() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const items = document.querySelectorAll('.product-item');

        items.forEach(item => {
            const name = item.getAttribute('data-name');
            if (name.includes(input)) {
                item.style.display = "";
            } else {
                item.style.display = "none";
            }
        });
    }

    // Modal QRIS & Checkout Handler
    let timerInterval;

    function handleCheckout() {
        const paymentMethod = document.getElementById('paymentMethodSelect').value;
        const totalAmount = Number(<?php echo e((float) $sale->total_pembayaran); ?>);

        // Validasi 1: Metode pembayaran belum dipilih
        if (!paymentMethod) {
            Swal.fire({
                icon: 'warning',
                title: 'Pilih Metode Pembayaran',
                text: 'Silakan pilih metode pembayaran terlebih dahulu!',
                confirmButtonColor: '#7c3aed',
                customClass: { popup: 'rounded-4' }
            });
            return;
        }

        // Validasi 2: Total pembayaran nol / keranjang kosong
        if (totalAmount <= 0) {
            Swal.fire({
                icon: 'error',
                title: 'Keranjang Kosong',
                text: 'Silakan pilih minimal 1 barang sebelum checkout!',
                confirmButtonColor: '#7c3aed',
                customClass: { popup: 'rounded-4' }
            });
            return;
        }

        // Jalur QRIS
        if (paymentMethod === 'QRIS') {
            const qrisModalEl = document.getElementById('qrisModal');
            const qrisModal = new bootstrap.Modal(qrisModalEl);
            qrisModal.show();
            startQrisTimer(300); // 5 Menit

            qrisModalEl.addEventListener('hidden.bs.modal', function () {
                clearInterval(timerInterval);
            });
        } 
        // Jalur Non-QRIS (Cash / Transfer Bank)
        else {
            Swal.fire({
                title: 'Konfirmasi Transaksi',
                text: `Selesaikan transaksi menggunakan metode ${paymentMethod}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="bi bi-check-lg"></i> Ya, Selesaikan',
                cancelButtonText: 'Batal',
                customClass: { popup: 'rounded-4' }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('checkoutForm').submit();
                }
            });
        }
    }

    // Timer QRIS
    function startQrisTimer(duration) {
        let timer = duration, minutes, seconds;
        clearInterval(timerInterval);
        
        timerInterval = setInterval(function () {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            const timerEl = document.getElementById('qrisTimer');
            if (timerEl) {
                timerEl.textContent = minutes + ":" + seconds;
            }

            if (--timer < 0) {
                clearInterval(timerInterval);
                const qrisModalEl = document.getElementById('qrisModal');
                const modal = bootstrap.Modal.getInstance(qrisModalEl);
                if (modal) modal.hide();

                Swal.fire({
                    icon: 'error',
                    title: 'Waktu Habis',
                    text: 'Sisa waktu pembayaran QRIS telah berakhir.',
                    confirmButtonColor: '#7c3aed',
                    customClass: { popup: 'rounded-4' }
                });
            }
        }, 1000);
    }

    // Final Checkout QRIS
    function submitFinalCheckout() {
        document.getElementById('checkoutForm').submit();
    }

    // Konfirmasi Pembatalan Transaksi
    function confirmCancelTransaction() {
        Swal.fire({
            title: 'Batalkan Transaksi?',
            text: 'Seluruh item di keranjang akan dihapus!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Batalkan',
            cancelButtonText: 'Kembali',
            customClass: { popup: 'rounded-4' }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('cancelTransactionForm').submit();
            }
        });
    }
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\cadisetramadiR\resources\views/penjualan/pos.blade.php ENDPATH**/ ?>