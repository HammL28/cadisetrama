

<?php $__env->startSection('title', 'Pengaturan Resto & Pesanan - POS System'); ?>

<?php $__env->startSection('content'); ?>

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #5b21b6 0%, #7c3aed 50%, #9333ea 100%);
        --bg-slate: #f5f3ff;
        --card-bg: #ffffff;
        --card-border: #e9d5ff;

        --text-heading: #2e1065;
        --text-body: #4c1d95;
        --text-muted: #6b21a8;
        --text-light: #9333ea;

        --icon-bg: #f3e8ff;
        --icon-color: #7e22ce;
        --table-head-bg: #f3e8ff;
        --table-hover-bg: #faf5ff;

        --radius-lg: 20px;
        --radius-md: 14px;
        --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%) !important;
        color: var(--text-body) !important;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .dashboard-header-banner {
        background: var(--primary-gradient) !important;
        border-radius: var(--radius-lg);
        padding: 2.5rem 2.25rem;
        color: #ffffff !important;
        box-shadow: 0 10px 25px -5px rgba(124, 58, 237, 0.35);
        position: relative;
        overflow: hidden;
    }

    .dashboard-header-banner::after {
        content: '';
        position: absolute;
        top: -40%;
        right: -8%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.12);
        border-radius: 50%;
        pointer-events: none;
    }

    .date-badge {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 50px;
        padding: 0.4rem 1rem;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .icon-box-modern {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
        transition: var(--transition);
        background-color: var(--icon-bg) !important;
        color: var(--icon-color) !important;
        border: 1px solid var(--card-border);
    }

    .icon-box-modern i {
        color: var(--icon-color) !important;
    }

    .dashboard-card {
        border-radius: var(--radius-md);
        border: 1px solid var(--card-border) !important;
        background: var(--card-bg) !important;
        transition: var(--transition);
        box-shadow: 0 4px 12px rgba(109, 40, 217, 0.04);
        position: relative;
        overflow: hidden;
    }

    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(124, 58, 237, 0.12);
        border-color: #a855f7 !important;
    }

    .card-top-accent {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--primary-gradient) !important;
    }

    .toggle-switch {
        position: relative;
        width: 56px;
        height: 30px;
        background: #e9d5ff;
        border-radius: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .toggle-switch.active {
        background: linear-gradient(135deg, #7c3aed 0%, #9333ea 100%);
    }

    .toggle-switch::after {
        content: '';
        position: absolute;
        top: 4px;
        left: 4px;
        width: 22px;
        height: 22px;
        background: #ffffff;
        border-radius: 50%;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .toggle-switch.active::after {
        left: 30px;
    }

    .btn-back {
        background: var(--primary-gradient) !important;
        color: #ffffff !important;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: var(--transition);
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
    }

    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(124, 58, 237, 0.4);
    }

    .form-label {
        color: var(--text-heading);
        font-weight: 600;
        font-size: 0.9rem;
    }

    .form-control, .form-select {
        border-color: var(--card-border) !important;
        padding: 0.75rem;
        border-radius: 10px;
        color: var(--text-body);
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--icon-color) !important;
        box-shadow: 0 0 0 0.2rem rgba(124, 58, 237, 0.25);
    }
</style>

<div class="container py-4" style="padding-top: 5rem;">

    
    <div class="dashboard-header-banner mb-4">
        <div class="row align-items-center g-3 position-relative" style="z-index: 1;">
            <div class="col-lg-7">
                <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                    <div class="date-badge">
                        <i class="bi bi-cup-hot"></i>
                        <span>Pengaturan Layanan Resto</span>
                    </div>
                </div>
                <h1 class="fw-bold text-white mb-2 fs-2">
                    Manajemen Dapur & Layanan
                </h1>
                <p class="text-white-50 mb-0 fs-6">Atur sistem manajemen meja, pesanan dapur/bar, biaya takeaway, dan notifikasi.</p>
            </div>
            <div class="col-lg-5 text-lg-end">
                <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-outline-light rounded-pill px-4 shadow-sm fw-semibold d-inline-flex align-items-center gap-2">
                    <i class="bi bi-arrow-left"></i>
                    <span>Kembali ke Dashboard</span>
                </a>
            </div>
        </div>
    </div>

    
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <strong class="d-block mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i> Gagal Menyimpan:</strong>
            <ul class="mb-0 ps-3">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    
    <form action="<?php echo e(route('settings.update')); ?>" method="POST" id="settingsForm">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="row g-4 mb-4">

            
            <div class="col-lg-6">
                <div class="card dashboard-card h-100">
                    <div class="card-top-accent"></div>
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="icon-box-modern me-3">
                                <i class="bi bi-grid-3x3-gap"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-0" style="color: var(--text-heading);">Manajemen Meja & Dine-In</h4>
                                <span class="text-muted small" style="color: var(--text-muted);">Pengaturan penataan area dan nomor meja</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="total_tables" class="form-label">Jumlah Total Meja</label>
                            <input type="number" min="1" name="total_tables" id="total_tables" class="form-control" placeholder="15" value="<?php echo e(old('total_tables', $user->total_tables ?? 10)); ?>">
                            <small class="text-muted d-block mt-1" style="color: var(--text-muted);">Membuat layout denah meja otomatis di aplikasi kasir.</small>
                        </div>

                        <div class="d-flex align-items-center justify-content-between py-3 px-3 rounded-3 mb-3" style="background: var(--icon-bg); border: 1px solid var(--card-border);">
                            <div class="flex-grow-1 me-2">
                                <div class="fw-semibold mb-1" style="color: var(--text-heading);">Wajibkan Pilih Nomor Meja</div>
                                <div class="small" style="color: var(--text-muted);">Kasir wajib memilih meja sebelum memproses pesanan Dine-In</div>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="toggle-switch <?php echo e(($user->require_table_number ?? true) ? 'active' : ''); ?>" onclick="toggleSwitch(this)">
                                    <input type="checkbox" name="require_table_number" value="1" <?php echo e(($user->require_table_number ?? true) ? 'checked' : ''); ?> hidden>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between py-3 px-3 rounded-3" style="background: var(--icon-bg); border: 1px solid var(--card-border);">
                            <div class="flex-grow-1 me-2">
                                <div class="fw-semibold mb-1" style="color: var(--text-heading);">Izinkan Gabung Meja (Merge Table)</div>
                                <div class="small" style="color: var(--text-muted);">Memungkinkan penggabungan tagihan beberapa meja</div>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="toggle-switch <?php echo e(($user->enable_table_merge ?? false) ? 'active' : ''); ?>" onclick="toggleSwitch(this)">
                                    <input type="checkbox" name="enable_table_merge" value="1" <?php echo e(($user->enable_table_merge ?? false) ? 'checked' : ''); ?> hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-lg-6">
                <div class="card dashboard-card h-100">
                    <div class="card-top-accent"></div>
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="icon-box-modern me-3">
                                <i class="bi bi-bag-check"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-0" style="color: var(--text-heading);">Bungkus / Takeaway</h4>
                                <span class="text-muted small" style="color: var(--text-muted);">Atur biaya kemasan dan opsi bawa pulang</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="takeaway_charge" class="form-label">Biaya Kemasan / Takeaway (Rp)</label>
                            <input type="number" name="takeaway_charge" id="takeaway_charge" class="form-control" placeholder="2000" value="<?php echo e(old('takeaway_charge', $user->takeaway_charge ?? 0)); ?>">
                            <small class="text-muted d-block mt-1" style="color: var(--text-muted);">Biaya tambahan otomatis untuk setiap porsi yang dibungkus.</small>
                        </div>

                        <div class="d-flex align-items-center justify-content-between py-3 px-3 rounded-3 mb-3" style="background: var(--icon-bg); border: 1px solid var(--card-border);">
                            <div class="flex-grow-1 me-2">
                                <div class="fw-semibold mb-1" style="color: var(--text-heading);">Sertakan Catatan Kustomisasi</div>
                                <div class="small" style="color: var(--text-muted);">Aktifkan input catatan makanan (misal: pedas, tanpa bawang)</div>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="toggle-switch <?php echo e(($user->enable_item_notes ?? true) ? 'active' : ''); ?>" onclick="toggleSwitch(this)">
                                    <input type="checkbox" name="enable_item_notes" value="1" <?php echo e(($user->enable_item_notes ?? true) ? 'checked' : ''); ?> hidden>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between py-3 px-3 rounded-3" style="background: var(--icon-bg); border: 1px solid var(--card-border);">
                            <div class="flex-grow-1 me-2">
                                <div class="fw-semibold mb-1" style="color: var(--text-heading);">Opsi Bayar Spil / Pisah Struk</div>
                                <div class="small" style="color: var(--text-muted);">Izinkan pelanggan memisah pembayaran per item/orang</div>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="toggle-switch <?php echo e(($user->enable_split_bill ?? false) ? 'active' : ''); ?>" onclick="toggleSwitch(this)">
                                    <input type="checkbox" name="enable_split_bill" value="1" <?php echo e(($user->enable_split_bill ?? false) ? 'checked' : ''); ?> hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-lg-6">
                <div class="card dashboard-card h-100">
                    <div class="card-top-accent"></div>
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="icon-box-modern me-3">
                                <i class="bi bi-printer-fill"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-0" style="color: var(--text-heading);">Printer Dapur & Bar</h4>
                                <span class="text-muted small" style="color: var(--text-muted);">Cetak tiket orderan langsung ke area masak/minuman</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between py-3 px-3 rounded-3 mb-3" style="background: var(--icon-bg); border: 1px solid var(--card-border);">
                            <div class="flex-grow-1 me-2">
                                <div class="fw-semibold mb-1" style="color: var(--text-heading);">Pisahkan Order Makanan & Minuman</div>
                                <div class="small" style="color: var(--text-muted);">Cetak tiket otomatis ke printer Dapur dan Bar secara terpisah</div>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="toggle-switch <?php echo e(($user->separate_kitchen_bar ?? false) ? 'active' : ''); ?>" onclick="toggleSwitch(this)">
                                    <input type="checkbox" name="separate_kitchen_bar" value="1" <?php echo e(($user->separate_kitchen_bar ?? false) ? 'checked' : ''); ?> hidden>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between py-3 px-3 rounded-3" style="background: var(--icon-bg); border: 1px solid var(--card-border);">
                            <div class="flex-grow-1 me-2">
                                <div class="fw-semibold mb-1" style="color: var(--text-heading);">Auto-Print Tiket Pesanan</div>
                                <div class="small" style="color: var(--text-muted);">Kirim ke dapur langsung saat kasir klik simpan order</div>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="toggle-switch <?php echo e(($user->auto_print_kitchen_ticket ?? true) ? 'active' : ''); ?>" onclick="toggleSwitch(this)">
                                    <input type="checkbox" name="auto_print_kitchen_ticket" value="1" <?php echo e(($user->auto_print_kitchen_ticket ?? true) ? 'checked' : ''); ?> hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-lg-6">
                <div class="card dashboard-card h-100">
                    <div class="card-top-accent"></div>
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="icon-box-modern me-3">
                                <i class="bi bi-bell-fill"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-0" style="color: var(--text-heading);">Pengaturan Notifikasi</h4>
                                <span class="text-muted small" style="color: var(--text-muted);">Atur pemicu peringatan dan lansiran sistem</span>
                            </div>
                        </div>

                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex align-items-center justify-content-between py-3 px-3 rounded-3" style="background: var(--icon-bg); border: 1px solid var(--card-border);">
                                <div class="flex-grow-1 me-2">
                                    <div class="fw-semibold mb-1" style="color: var(--text-heading);">Alarm Pesanan Masuk</div>
                                    <div class="small" style="color: var(--text-muted);">Suara peringatan di layar kasir ketika ada order baru</div>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="toggle-switch <?php echo e(($user->order_sound_alert ?? true) ? 'active' : ''); ?>" onclick="toggleSwitch(this)">
                                        <input type="checkbox" name="order_sound_alert" value="1" <?php echo e(($user->order_sound_alert ?? true) ? 'checked' : ''); ?> hidden>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between py-3 px-3 rounded-3" style="background: var(--icon-bg); border: 1px solid var(--card-border);">
                                <div class="flex-grow-1 me-2">
                                    <div class="fw-semibold mb-1" style="color: var(--text-heading);">Notifikasi Pesanan Lama (Overdue)</div>
                                    <div class="small" style="color: var(--text-muted);">Beri tanda merah jika hidangan belum disajikan >20 menit</div>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="toggle-switch <?php echo e(($user->overdue_order_alert ?? true) ? 'active' : ''); ?>" onclick="toggleSwitch(this)">
                                        <input type="checkbox" name="overdue_order_alert" value="1" <?php echo e(($user->overdue_order_alert ?? true) ? 'checked' : ''); ?> hidden>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between py-3 px-3 rounded-3" style="background: var(--icon-bg); border: 1px solid var(--card-border);">
                                <div class="flex-grow-1 me-2">
                                    <div class="fw-semibold mb-1" style="color: var(--text-heading);">Peringatan Stok Bahan Baku</div>
                                    <div class="small" style="color: var(--text-muted);">Peringatan jika persediaan bahan masak di dapur habis</div>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="toggle-switch <?php echo e(($user->ingredient_stock_alert ?? false) ? 'active' : ''); ?>" onclick="toggleSwitch(this)">
                                        <input type="checkbox" name="ingredient_stock_alert" value="1" <?php echo e(($user->ingredient_stock_alert ?? false) ? 'checked' : ''); ?> hidden>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-12">
                <div class="card dashboard-card p-4">
                    <div class="text-center mb-4">
                        <div class="icon-box-modern mx-auto mb-3" style="display: inline-flex;">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <h4 class="fw-bold mb-2" style="color: var(--text-heading);">Simpan Perubahan</h4>
                        <p class="text-muted mb-0" style="color: var(--text-muted);">Periksa kembali semua data sebelum menyimpan pengaturan.</p>
                    </div>

                    <button type="submit" class="btn btn-back w-100 py-3">
                        <i class="bi bi-check-circle-fill me-2"></i>Simpan Pengaturan Layanan
                    </button>
                </div>
            </div>

        </div>
    </form>

</div>

<script>
    function toggleSwitch(element) {
        element.classList.toggle('active');
        const checkbox = element.querySelector('input[type="checkbox"]');
        if (checkbox) {
            checkbox.checked = element.classList.contains('active');
        }
    }
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\cadisetramadiR\resources\views/settings/index.blade.php ENDPATH**/ ?>