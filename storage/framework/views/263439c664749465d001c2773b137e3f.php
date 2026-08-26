

<?php $__env->startSection('title', __('sales_history') . ' - POS ILHAM'); ?>

<?php $__env->startSection('content'); ?>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* ==========================================
       CSS VARIABLES (HIERARCHY & PURPLE THEME)
       ========================================== */
    :root {
        /* Gradient Banner */
        --primary-gradient: linear-gradient(135deg, #5b21b6 0%, #7c3aed 50%, #9333ea 100%);
        
        /* Background & Surface */
        --bg-slate: #f5f3ff;
        --card-bg: #ffffff;
        --card-border: #e9d5ff;

        /* HIERARCHY WARNA TEKS */
        --text-heading: #2e1065;   /* Level 1: Judul Utama & Angka Penting */
        --text-body: #4c1d95;      /* Level 2: Teks Isian & Nama Produk */
        --text-muted: #6b21a8;     /* Level 3: Label, Subtitle & Keterangan */
        --text-light: #9333ea;     /* Level 4: Aksesori & Elemen Pendukung */

        /* Ikon & Accent */
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

    /* HEADER BANNER */
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

    /* TYPOGRAPHY */
    .h-title-main {
        color: var(--text-heading) !important;
        font-size: 1.35rem;
        font-weight: 800;
        letter-spacing: -0.02em;
    }

    .h-title-sub {
        color: var(--text-muted) !important;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .h-metric-label {
        color: var(--text-muted) !important;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .h-metric-value {
        color: var(--text-heading) !important;
        font-size: 1.85rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        line-height: 1.2;
    }

    /* IKON CONTAINER */
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

    .dashboard-card:hover .icon-box-modern {
        transform: scale(1.08);
        background-color: #7e22ce !important;
        color: #ffffff !important;
    }

    .dashboard-card:hover .icon-box-modern i {
        color: #ffffff !important;
    }

    /* BADGES */
    .badge-purple {
        background-color: #f3e8ff !important;
        color: #6b21a8 !important;
        border: 1px solid #e9d5ff;
        font-weight: 600;
    }

    /* CARDS */
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

    /* TABLES */
    .table-custom {
        margin-bottom: 0;
    }

    .table-custom thead {
        background-color: var(--table-head-bg) !important;
        border-bottom: 1px solid var(--card-border) !important;
    }

    .table-custom th {
        color: var(--text-muted) !important;
        font-size: 0.725rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-weight: 700;
        padding: 0.875rem 1.25rem;
        border: none;
    }

    .table-custom td {
        padding: 1rem 1.25rem;
        color: var(--text-body) !important;
        border-bottom: 1px solid var(--card-border) !important;
        font-size: 0.9rem;
    }

    .table-custom tbody tr:hover {
        background-color: var(--table-hover-bg) !important;
    }

    .table-custom tbody tr:last-child td {
        border-bottom: none !important;
    }

    /* ACTION BUTTONS */
    .btn-icon-action {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: var(--transition);
    }

    .btn-action-view {
        background-color: #f3e8ff;
        color: #7c3aed;
    }
    .btn-action-view:hover {
        background-color: #7c3aed;
        color: #ffffff;
    }

    .btn-action-edit {
        background-color: #fef3c7;
        color: #d97706;
    }
    .btn-action-edit:hover {
        background-color: #d97706;
        color: #ffffff;
    }

    .btn-action-delete {
        background-color: #ffe4e6;
        color: #e11d48;
    }
    .btn-action-delete:hover {
        background-color: #e11d48;
        color: #ffffff;
    }

    /* INPUT & SELECT */
    .input-pill {
        border-radius: 50rem !important;
        border: 1px solid #e2e8f0;
        padding-left: 1rem;
        font-size: 0.875rem;
    }

    .select-pill {
        border-radius: 50rem !important;
        border: 1px solid #e2e8f0;
        font-size: 0.85rem;
        color: #475569;
    }

    .bg-search {
        background-color: #ffffff !important;
        border: 1px solid #ddd6fe !important;
        transition: var(--transition);
    }

    .search-box:focus-within .bg-search {
        border-color: var(--icon-color) !important;
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.15) !important;
    }

    /* SWEETALERT */
    .swal2-popup {
        border-radius: 20px !important;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
    }

    /* PAGINATION */
    .pagination-modern {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .pagination-modern .page-item {
        margin: 0;
    }

    .pagination-modern .page-link {
        border: 1px solid var(--card-border) !important;
        background-color: var(--card-bg) !important;
        color: var(--text-body) !important;
        border-radius: 10px !important;
        padding: 0.5rem 1rem;
        font-weight: 600;
        font-size: 0.875rem;
        transition: var(--transition);
        min-width: 40px;
        text-align: center;
    }

    .pagination-modern .page-link:hover {
        background-color: var(--icon-bg) !important;
        border-color: var(--icon-color) !important;
        color: var(--icon-color) !important;
        transform: translateY(-2px);
    }

    .pagination-modern .page-item.active .page-link {
        background-color: var(--icon-color) !important;
        border-color: var(--icon-color) !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
    }

    .pagination-modern .page-item.disabled .page-link {
        background-color: #f8fafc !important;
        border-color: #e2e8f0 !important;
        color: #94a3b8 !important;
        cursor: not-allowed;
    }

    .pagination-info {
        color: var(--text-muted) !important;
        font-size: 0.875rem;
        font-weight: 500;
    }
</style>

<div class="container py-4" style="padding-top: 5rem;">

    
    <div class="dashboard-header-banner mb-4">
        <div class="row align-items-center g-3 position-relative" style="z-index: 1;">
            <div class="col-lg-7">
                <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                    <div class="date-badge">
                        <i class="bi bi-receipt"></i>
                        <span><?php echo e(__('sales_management')); ?></span>
                    </div>
                </div>
                <h1 class="fw-bold text-white mb-2 fs-2">
                    <?php echo e(__('sales_history')); ?>

                </h1>
                <p class="text-white-50 mb-0 fs-6"><?php echo e(__('sales_management_subtitle')); ?></p>
            </div>
            <div class="col-lg-5 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <button onclick="window.print()" class="btn btn-outline-light rounded-pill px-3 shadow-sm fw-semibold d-inline-flex align-items-center gap-2">
                        <i class="bi bi-printer-fill"></i>
                        <span><?php echo e(__('print_data')); ?></span>
                    </button>

                    <a href="<?php echo e(route('penjualan.create')); ?>" class="btn btn-light rounded-pill px-4 shadow-sm fw-bold d-inline-flex align-items-center gap-2" style="color: var(--text-heading) !important;">
                        <i class="bi bi-plus-circle-fill" style="color: var(--icon-color);"></i>
                        <span><?php echo e(__('add_new_sale')); ?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="d-flex align-items-center">
            <div class="icon-box-modern me-3 shadow-sm">
                <i class="bi bi-graph-up-arrow"></i>
            </div>
            <div>
                <h2 class="h-title-main mb-0"><?php echo e(__('sales_summary_title')); ?></h2>
                <span class="h-title-sub"><?php echo e(__('sales_summary_subtitle')); ?></span>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        
        <div class="col-md-6 col-xl-3">
            <div class="card dashboard-card h-100 p-3">
                <div class="card-top-accent"></div>
                <div class="card-body p-0">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="h-metric-label"><?php echo e(__('total_transactions_summary')); ?></span>
                        <div class="icon-box-modern">
                            <i class="bi bi-box-seam"></i>
                        </div>
                    </div>
                    <div class="h-metric-value"><?php echo e(method_exists($sales, 'total') ? $sales->total() : count($sales)); ?></div>
                </div>
            </div>
        </div>

        
        <div class="col-md-6 col-xl-3">
            <div class="card dashboard-card h-100 p-3">
                <div class="card-top-accent"></div>
                <div class="card-body p-0">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="h-metric-label"><?php echo e(__('total_revenue_summary')); ?></span>
                        <div class="icon-box-modern">
                            <i class="bi bi-layers-fill"></i>
                        </div>
                    </div>
                    <div class="h-metric-value">Rp <?php echo e(number_format($sales->sum('total_pembayaran'), 0, ',', '.')); ?></div>
                </div>
            </div>
        </div>

        
        <div class="col-md-6 col-xl-3">
            <div class="card dashboard-card h-100 p-3">
                <div class="card-top-accent"></div>
                <div class="card-body p-0">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="h-metric-label"><?php echo e(__('non_cash_summary')); ?></span>
                        <div class="icon-box-modern" style="background-color: #fef3c7 !important; color: #d97706 !important; border-color: #fde68a !important;">
                            <i class="bi bi-exclamation-triangle-fill" style="color: #d97706 !important;"></i>
                        </div>
                    </div>
                    <div class="h-metric-value" style="color: #d97706 !important;">
                        <?php echo e($sales->filter(fn($item) => in_array(strtolower($item->metode_pembayaran), ['qris', 'transfer']))->count()); ?>

                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-md-6 col-xl-3">
            <div class="card dashboard-card h-100 p-3">
                <div class="card-top-accent"></div>
                <div class="card-body p-0">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="h-metric-label"><?php echo e(__('cash_payment_summary')); ?></span>
                        <div class="icon-box-modern" style="background-color: #ffe4e6 !important; color: #e11d48 !important; border-color: #fca5a5 !important;">
                            <i class="bi bi-x-circle-fill" style="color: #e11d48 !important;"></i>
                        </div>
                    </div>
                    <div class="h-metric-value" style="color: #e11d48 !important;">
                        <?php echo e($sales->filter(fn($item) => in_array(strtolower($item->metode_pembayaran), ['tunai', 'cash']))->count()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="card dashboard-card mb-4">
        
        
        <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
            <form action="<?php echo e(route('penjualan.index')); ?>" method="GET">
                <div class="row g-2 align-items-center justify-content-between">
                    
                    <div class="col-12 col-md-4">
                        <div class="position-relative search-box">
                            <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3" style="color: var(--icon-color);"></i>
                            <input type="text" name="search" value="<?php echo e(request('search')); ?>" class="form-control input-pill ps-5 py-2 bg-search" placeholder="<?php echo e(__('search_transaction')); ?>" style="border-color: #ddd6fe;">
                        </div>
                    </div>

                    <div class="col-12 col-md-8 d-flex flex-wrap align-items-center justify-content-md-end gap-2">
                        <select name="status" class="form-select select-pill w-auto py-2 px-3 bg-search" onchange="this.form.submit()" style="border-color: #ddd6fe; color: var(--text-body);">
                            <option value=""><?php echo e(__('all_status')); ?></option>
                            <option value="open" <?php echo e(request('status') == 'open' ? 'selected' : ''); ?>><?php echo e(__('open')); ?></option>
                            <option value="complete" <?php echo e(request('status') == 'complete' ? 'selected' : ''); ?>><?php echo e(__('completed_status')); ?></option>
                        </select>

                        <select name="metode" class="form-select select-pill w-auto py-2 px-3 bg-search" onchange="this.form.submit()" style="border-color: #ddd6fe; color: var(--text-body);">
                            <option value=""><?php echo e(__('all_methods')); ?></option>
                            <option value="tunai" <?php echo e(request('metode') == 'tunai' ? 'selected' : ''); ?>><?php echo e(__('cash_method')); ?></option>
                            <option value="qris" <?php echo e(request('metode') == 'qris' ? 'selected' : ''); ?>><?php echo e(__('qris_method')); ?></option>
                            <option value="transfer" <?php echo e(request('metode') == 'transfer' ? 'selected' : ''); ?>><?php echo e(__('transfer_method')); ?></option>
                        </select>

                        <?php if(request('search') || request('metode') || request('status')): ?>
                            <a href="<?php echo e(route('penjualan.index')); ?>" class="btn btn-sm btn-light rounded-pill px-3 py-2 border-0 d-inline-flex align-items-center gap-1" style="color: var(--icon-color); background: var(--icon-bg);">
                                <i class="bi bi-x-circle"></i> <?php echo e(__('reset_filter')); ?>

                            </a>
                        <?php endif; ?>
                    </div>

                </div>
            </form>
        </div>

        
        <div class="card-body p-0 mt-2">
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4" style="width: 5%;"><?php echo e(__('no')); ?></th>
                            <th style="width: 15%;"><?php echo e(__('date_time_header')); ?></th>
                            <th style="width: 12%;"><?php echo e(__('cashier_header')); ?></th>
                            <th style="width: 20%;"><?php echo e(__('products_purchased')); ?></th>
                            <th style="width: 12%;"><?php echo e(__('total_payment')); ?></th>
                            <th style="width: 10%;"><?php echo e(__('method_header')); ?></th>
                            <th style="width: 10%;"><?php echo e(__('status_header')); ?></th>
                            <th class="pe-4 text-center" style="width: 10%;"><?php echo e(__('action_header')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="ps-4 text-muted fs-7 fw-medium">
                                <?php echo e(method_exists($sales, 'firstItem') ? $sales->firstItem() + $loop->index : $loop->iteration); ?>

                            </td>

                            <td>
                                <?php if($sale->created_at): ?>
                                    <?php $waktuLokal = $sale->created_at->setTimezone('Asia/Jakarta'); ?>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold" style="color: var(--text-heading); font-size: 0.85rem;"><?php echo e($waktuLokal->translatedFormat('d/m/Y')); ?></span>
                                        <span class="text-muted small" style="font-size: 0.75rem;">
                                            <i class="bi bi-clock me-1" style="color: var(--icon-color);"></i><?php echo e($waktuLokal->format('H:i')); ?> WIB
                                        </span>
                                    </div>
                                <?php else: ?>
                                    <span class="text-muted small">-</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <span class="badge badge-purple d-inline-flex align-items-center gap-1.5 fs-7">
                                    <i class="bi bi-person-fill"></i>
                                    <span><?php echo e($sale->user->name ?? __('cashier_default')); ?></span>
                                </span>
                            </td>

                            <td>
                                <?php if($sale->itemPenjualan && $sale->itemPenjualan->count() > 0): ?>
                                    <div class="d-flex flex-wrap gap-1">
                                        <?php $__currentLoopData = $sale->itemPenjualan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="badge bg-light text-dark border px-2 py-1 rounded-2 fs-7 fw-normal">
                                                <strong><?php echo e($item->produk->nama ?? __('product_default')); ?></strong>
                                                <span class="ms-1" style="color: var(--icon-color);">x<?php echo e($item->kuantitas); ?></span>
                                            </span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php else: ?>
                                    <span class="text-muted small"><em>-</em></span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <span class="fw-bold fs-7" style="color: var(--text-heading) !important;">Rp <?php echo e(number_format($sale->total_pembayaran, 0, ',', '.')); ?></span>
                            </td>

                            <td>
                                <?php $metode = strtolower($sale->metode_pembayaran); ?>
                                <?php if(in_array($metode, ['qris', 'transfer'])): ?>
                                    <span class="badge badge-purple d-inline-flex align-items-center gap-1 fs-7">
                                        <i class="bi bi-qr-code-scan"></i> <?php echo e(strtoupper($sale->metode_pembayaran)); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-purple d-inline-flex align-items-center gap-1 fs-7">
                                        <i class="bi bi-cash-stack"></i> <?php echo e(ucfirst($sale->metode_pembayaran)); ?>

                                    </span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php $status = isset($sale->status) ? strtoupper($sale->status) : 'COMPLETED'; ?>
                                <?php if($status === 'COMPLETED'): ?>
                                    <span class="badge badge-purple px-3 py-1.5 rounded-pill fw-bold">
                                        <i class="bi bi-check-circle-fill me-1"></i> Complete
                                    </span>
                                <?php elseif($status === 'OPEN'): ?>
                                    <span class="badge badge-purple px-3 py-1.5 rounded-pill fw-bold">
                                        <i class="bi bi-clock-fill me-1"></i> Open
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-purple px-3 py-1.5 rounded-pill fw-bold">
                                        <?php echo e($status); ?>

                                    </span>
                                <?php endif; ?>
                            </td>

                            <td class="pe-4 text-center">
                                <div class="d-flex align-items-center justify-content-center gap-1">
                                    <?php $status = isset($sale->status) ? strtoupper($sale->status) : 'COMPLETED'; ?>

                                    <?php if($status === 'OPEN'): ?>
                                        <?php if(Auth::user()->role->name === 'admin' || Auth::id() === $sale->user_id): ?>
                                        <a href="<?php echo e(route('penjualan.edit', $sale)); ?>" class="btn-icon-action btn-action-edit" title="Edit Transaksi">
                                            <i class="bi bi-pencil-fill fs-6"></i>
                                        </a>
                                        <?php endif; ?>

                                        <?php if(Auth::user()->role->name === 'admin' || Auth::id() === $sale->user_id): ?>
                                        <button type="button" class="btn-icon-action btn-action-delete" title="Hapus Transaksi" onclick="triggerDeleteSale('<?php echo e(route('penjualan.destroy', $sale)); ?>')">
                                            <i class="bi bi-trash-fill fs-6"></i>
                                        </button>
                                        <?php endif; ?>

                                    <?php elseif($status === 'COMPLETED'): ?>
                                        <a href="<?php echo e(route('penjualan.show', $sale)); ?>" class="btn-icon-action btn-action-view" title="Lihat Detail">
                                            <i class="bi bi-eye-fill fs-6"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox text-secondary fs-1 d-block mb-2"></i>
                                <span>Tidak ada data penjualan yang ditemukan.</span>
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            
            <?php if(method_exists($sales, 'hasPages') && $sales->hasPages()): ?>
                <div class="card-footer bg-white border-0 px-4 py-3 border-top" style="background-color: var(--card-bg) !important; border-color: var(--card-border) !important;">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
                        <span class="pagination-info">
                            Menampilkan <strong><?php echo e($sales->firstItem()); ?></strong> - <strong><?php echo e($sales->lastItem()); ?></strong> dari <strong><?php echo e($sales->total()); ?></strong> data
                        </span>
                        <nav>
                            <ul class="pagination-modern">
                                
                                <?php if($sales->onFirstPage()): ?>
                                    <li class="page-item disabled">
                                        <span class="page-link"><i class="bi bi-chevron-left"></i></span>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?php echo e($sales->appends(request()->query())->previousPageUrl()); ?>">
                                            <i class="bi bi-chevron-left"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                
                                <?php
                                    $startPage = max(1, $sales->currentPage() - 2);
                                    $endPage = min($sales->lastPage(), $sales->currentPage() + 2);
                                ?>
                                <?php for($i = $startPage; $i <= $endPage; $i++): ?>
                                    <?php if($i == $sales->currentPage()): ?>
                                        <li class="page-item active">
                                            <span class="page-link"><?php echo e($i); ?></span>
                                        </li>
                                    <?php else: ?>
                                        <li class="page-item">
                                            <a class="page-link" href="<?php echo e($sales->appends(request()->query())->url($i)); ?>"><?php echo e($i); ?></a>
                                        </li>
                                    <?php endif; ?>
                                <?php endfor; ?>

                                
                                <?php if($sales->hasMorePages()): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?php echo e($sales->appends(request()->query())->nextPageUrl()); ?>">
                                            <i class="bi bi-chevron-right"></i>
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item disabled">
                                        <span class="page-link"><i class="bi bi-chevron-right"></i></span>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            <?php endif; ?>
        </div>

    </div>

</div>

<form id="globalDeleteSaleForm" method="POST" style="display: none;">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
</form>

<script>
    function triggerDeleteSale(deleteUrl) {
        Swal.fire({
            title: 'Hapus Penjualan?',
            text: 'Data transaksi ini akan dihapus secara permanen.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-4'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('globalDeleteSaleForm');
                form.action = deleteUrl;
                form.submit();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        <?php if(session('errors') || session('error')): ?>
            Swal.fire({
                title: 'Gagal!',
                text: "<?php echo e(session('errors') ? session('errors')->first() : session('error')); ?>",
                icon: 'error',
                confirmButtonColor: '#7c3aed'
            });
        <?php endif; ?>

        <?php if(session('success')): ?>
            Swal.fire({
                title: 'Berhasil!',
                text: "<?php echo e(session('success')); ?>",
                icon: 'success',
                confirmButtonColor: '#7c3aed'
            });
        <?php endif; ?>
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\cadisetramadiR\resources\views/penjualan/index.blade.php ENDPATH**/ ?>