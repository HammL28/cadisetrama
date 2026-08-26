

<?php $__env->startSection('title', __('manage_products') . ' - POS ILHAM'); ?>

<?php $__env->startSection('content'); ?>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* ==========================================
       CSS VARIABLES (HIERARCHY & PURPLE THEME)
       ========================================== */
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

    /* IKON & BOX */
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

    /* BUTTONS */
    .btn-action-purple {
        background-color: #f3e8ff !important;
        color: var(--icon-color) !important;
        border: none !important;
        transition: var(--transition);
    }
    .btn-action-purple:hover {
        background-color: #7e22ce !important;
        color: #ffffff !important;
        transform: scale(1.1);
    }

    .btn-action-edit {
        background-color: #faf5ff !important;
        color: var(--icon-color) !important;
        border: 1px solid #e9d5ff !important;
        transition: var(--transition);
    }
    .btn-action-edit:hover {
        background-color: #7e22ce !important;
        color: #ffffff !important;
        transform: scale(1.1);
    }

    .btn-action-delete {
        background-color: #fff1f2 !important;
        color: #e11d48 !important;
        border: 1px solid #ffe4e6 !important;
        transition: var(--transition);
    }
    .btn-action-delete:hover {
        background-color: #e11d48 !important;
        color: #ffffff !important;
        transform: scale(1.1);
    }

    /* INPUTS & BADGES */
    .bg-search {
        background-color: #ffffff !important;
        border: 1px solid #ddd6fe !important;
        transition: var(--transition);
    }

    .search-box:focus-within .bg-search {
        border-color: var(--icon-color) !important;
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.15) !important;
    }

    .badge-soft-emerald {
        background-color: #dcfce7 !important;
        color: #15803d !important;
        border: 1px solid #a7f3d0 !important;
    }

    .badge-soft-amber {
        background-color: #fef3c7 !important;
        color: #b45309 !important;
        border: 1px solid #fde68a !important;
    }

    .badge-soft-danger {
        background-color: #fee2e2 !important;
        color: #b91c1c !important;
        border: 1px solid #fca5a5 !important;
    }

    .product-thumb {
        width: 44px;
        height: 44px;
        object-fit: cover;
        border-radius: 12px;
    }

    .product-thumb-placeholder {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background-color: var(--icon-bg);
        color: var(--icon-color);
    }

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
                        <i class="bi bi-box-seam"></i>
                        <span><?php echo e(__('product_management')); ?></span>
                    </div>
                </div>
                <h1 class="fw-bold text-white mb-2 fs-2">
                    <?php echo e(__('manage_products')); ?>

                </h1>
                <p class="text-white-50 mb-0 fs-6"><?php echo e(__('manage_products_subtitle')); ?></p>
            </div>
            <div class="col-lg-5 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <button onclick="window.print()" class="btn btn-outline-light rounded-pill px-3 shadow-sm fw-semibold d-inline-flex align-items-center gap-2">
                        <i class="bi bi-printer-fill"></i>
                        <span><?php echo e(__('print_data')); ?></span>
                    </button>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', App\Models\Produk::class)): ?>
                        <a href="<?php echo e(route('produk.create')); ?>" class="btn btn-light rounded-pill px-4 shadow-sm fw-bold d-inline-flex align-items-center gap-2" style="color: var(--text-heading) !important;">
                            <i class="bi bi-plus-circle-fill" style="color: var(--icon-color);"></i>
                            <span><?php echo e(__('add_product')); ?></span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="d-flex align-items-center">
            <div class="icon-box-modern me-3 shadow-sm">
                <i class="bi bi-boxes"></i>
            </div>
            <div>
                <h2 class="h-title-main mb-0"><?php echo e(__('product_summary')); ?></h2>
                <span class="h-title-sub"><?php echo e(__('product_summary_subtitle')); ?></span>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        
        <div class="col-md-6 col-xl-3">
            <div class="card dashboard-card h-100 p-3">
                <div class="card-top-accent"></div>
                <div class="card-body p-0">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="h-metric-label"><?php echo e(__('total_products')); ?></span>
                        <div class="icon-box-modern">
                            <i class="bi bi-boxes"></i>
                        </div>
                    </div>
                    <div class="h-metric-value"><?php echo e(method_exists($products, 'total') ? $products->total() : count($products)); ?></div>
                </div>
            </div>
        </div>
        
        
        <div class="col-md-6 col-xl-3">
            <div class="card dashboard-card h-100 p-3">
                <div class="card-top-accent"></div>
                <div class="card-body p-0">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="h-metric-label"><?php echo e(__('total_stock_items')); ?></span>
                        <div class="icon-box-modern">
                            <i class="bi bi-stack"></i>
                        </div>
                    </div>
                    <div class="h-metric-value"><?php echo e($products->sum('stok')); ?></div>
                </div>
            </div>
        </div>
        
        
        <div class="col-md-6 col-xl-3">
            <div class="card dashboard-card h-100 p-3">
                <div class="card-top-accent"></div>
                <div class="card-body p-0">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="h-metric-label"><?php echo e(__('critical_stock')); ?></span>
                        <div class="icon-box-modern" style="background-color: #fef3c7 !important; color: #b45309 !important; border-color: #fde68a !important;">
                            <i class="bi bi-exclamation-triangle-fill" style="color: #b45309 !important;"></i>
                        </div>
                    </div>
                    <div class="h-metric-value" style="color: #b45309 !important;"><?php echo e($products->where('stok', '<=', 10)->where('stok', '>', 0)->count()); ?></div>
                </div>
            </div>
        </div>
        
        
        <div class="col-md-6 col-xl-3">
            <div class="card dashboard-card h-100 p-3">
                <div class="card-top-accent"></div>
                <div class="card-body p-0">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="h-metric-label"><?php echo e(__('stock_empty')); ?></span>
                        <div class="icon-box-modern" style="background-color: #fee2e2 !important; color: #b91c1c !important; border-color: #fca5a5 !important;">
                            <i class="bi bi-x-circle-fill" style="color: #b91c1c !important;"></i>
                        </div>
                    </div>
                    <div class="h-metric-value" style="color: #b91c1c !important;"><?php echo e($products->where('stok', 0)->count()); ?></div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="card dashboard-card mb-4">
        
        
        <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
            <form action="<?php echo e(route('produk.index')); ?>" method="GET">
                <div class="row g-3 justify-content-between align-items-center">
                    
                    
                    <div class="col-md-5 col-lg-4">
                        <div class="input-group search-box">
                            <span class="input-group-text border-end-0 rounded-start-pill ps-3 bg-search">
                                <i class="bi bi-search" style="color: var(--icon-color);"></i>
                            </span>
                            <input
                                type="text"
                                name="search"
                                value="<?php echo e(request('search')); ?>"
                                class="form-control border-start-0 rounded-end-pill ps-0 bg-search shadow-none"
                                placeholder="<?php echo e(__('search_placeholder')); ?>"
                                id="fastSearchInput"
                            >
                        </div>
                    </div>

                    
                    <div class="col-md-7 col-lg-8 d-flex flex-wrap align-items-center justify-content-md-end gap-2">
                        
                        
                        <select name="jenis" class="form-select bg-search rounded-pill shadow-none w-auto" onchange="this.form.submit()" style="color: var(--text-body); font-weight: 500;">
                            <option value=""><?php echo e(__('all_categories')); ?></option>
                            <option value="Minuman" <?php echo e(request('jenis') == 'Minuman' ? 'selected' : ''); ?>><?php echo e(__('drinks')); ?></option>
                            <option value="Makanan" <?php echo e(request('jenis') == 'Makanan' ? 'selected' : ''); ?>><?php echo e(__('food')); ?></option>
                            <option value="Snack" <?php echo e(request('jenis') == 'Snack' ? 'selected' : ''); ?>><?php echo e(__('snacks')); ?></option>
                            <option value="Elektronik" <?php echo e(request('jenis') == 'Elektronik' ? 'selected' : ''); ?>>Elektronik</option>
                            <option value="ATK" <?php echo e(request('jenis') == 'ATK' ? 'selected' : ''); ?>>ATK</option>
                        </select>

                        
                        <select name="stok_status" class="form-select bg-search rounded-pill shadow-none w-auto" onchange="this.form.submit()" style="color: var(--text-body); font-weight: 500;">
                            <option value=""><?php echo e(__('all_stock_status')); ?></option>
                            <option value="ready" <?php echo e(request('stok_status') == 'ready' ? 'selected' : ''); ?>><?php echo e(__('stock_available')); ?></option>
                            <option value="kritis" <?php echo e(request('stok_status') == 'kritis' ? 'selected' : ''); ?>><?php echo e(__('stock_critical')); ?></option>
                            <option value="habis" <?php echo e(request('stok_status') == 'habis' ? 'selected' : ''); ?>><?php echo e(__('stock_out')); ?></option>
                        </select>

                        <?php if(request('search') || request('jenis') || request('stok_status')): ?>
                            <a href="<?php echo e(route('produk.index')); ?>" class="btn btn-sm btn-light rounded-pill px-3 border-0" style="color: var(--icon-color); background: var(--icon-bg);">
                                <i class="bi bi-x-circle me-1"></i><?php echo e(__('reset')); ?>

                            </a>
                        <?php endif; ?>
                    </div>

                </div>
            </form>
        </div>

        
        <div class="card-body p-0 mt-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 table-custom">
                    <thead>
                        <tr>
                            <th class="ps-4" style="width: 5%;"><?php echo e(__('no')); ?></th>
                            <th style="width: 8%;"><?php echo e(__('photo_header')); ?></th>
                            <th><?php echo e(__('product_name_header')); ?></th>
                            <th><?php echo e(__('category_header')); ?></th>
                            <th><?php echo e(__('added_by')); ?></th>
                            <th><?php echo e(__('purchase_price_header')); ?></th>
                            <th><?php echo e(__('selling_price_header')); ?></th>
                            <th><?php echo e(__('stock_header')); ?></th>
                            <th class="pe-4 text-end" style="width: 12%;"><?php echo e(__('action_header')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="product-row">
                            <td class="ps-4 text-muted small fw-semibold">
                                <?php echo e(method_exists($products, 'firstItem') ? $products->firstItem() + $loop->index : $loop->iteration); ?>

                            </td>
                            <td>
                                <?php if(!empty($product->foto)): ?>
                                    
                                    <img src="<?php echo e(Str::startsWith($product->foto, ['http://', 'https://']) ? $product->foto : asset('storage/' . $product->foto)); ?>" 
                                         alt="<?php echo e($product->nama); ?>" 
                                         class="product-thumb shadow-sm border"
                                         onerror="this.onerror=null; this.src='https://placehold.co/100x100?text=No+Image';">
                                <?php else: ?>
                                    <div class="product-thumb-placeholder d-flex align-items-center justify-content-center fw-bold shadow-sm">
                                        <i class="bi bi-image" style="color: var(--icon-color);"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="fw-bold d-block" style="color: var(--text-heading);"><?php echo e($product->nama); ?></span>
                            </td>
                            <td>
                                <span class="badge badge-purple px-3 py-1.5 rounded-pill fw-semibold">
                                    <i class="bi bi-tag-fill me-1"></i><?php echo e($product->jenis ?? __('general')); ?>

                                </span>
                            </td>
                            <td class="text-muted small">
                                <span class="badge badge-purple px-2.5 py-1 rounded-pill fw-medium">
                                    <i class="bi bi-person-fill me-1"></i><?php echo e($product->user->name ?? '-'); ?>

                                </span>
                            </td>
                            <td class="text-secondary small fw-semibold">
                                Rp <?php echo e(number_format($product->harga_beli, 0, ',', '.')); ?>

                            </td>
                            <td class="fw-bold small" style="color: var(--text-heading); font-size: 0.95rem;">
                                Rp <?php echo e(number_format($product->harga_jual, 0, ',', '.')); ?>

                            </td>
                            <td>
                                <?php if($product->stok > 10): ?>
                                    <span class="badge badge-soft-emerald px-3 py-1.5 rounded-pill fw-bold">
                                        <?php echo e($product->stok); ?> <?php echo e(__('pcs')); ?>

                                    </span>
                                <?php elseif($product->stok > 0): ?>
                                    <span class="badge badge-soft-amber px-3 py-1.5 rounded-pill fw-bold">
                                        <?php echo e($product->stok); ?> <?php echo e(__('pcs')); ?> (<?php echo e(__('critical')); ?>)
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-soft-danger px-3 py-1.5 rounded-pill fw-bold">
                                        <?php echo e(__('empty')); ?>

                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="pe-4 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view', $product)): ?>
                                        <a href="<?php echo e(route('produk.show', $product)); ?>" class="btn btn-action-purple rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;" title="<?php echo e(__('view_detail')); ?>">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    <?php endif; ?>

                                    
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $product)): ?>
                                        <a href="<?php echo e(route('produk.edit', $product)); ?>" class="btn btn-action-edit rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;" title="<?php echo e(__('edit_product')); ?>">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                    <?php endif; ?>

                                    
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete', $product)): ?>
                                        <button type="button"
                                                class="btn btn-action-delete rounded-circle d-inline-flex align-items-center justify-content-center"
                                                style="width: 36px; height: 36px;"
                                                title="<?php echo e(__('delete_product')); ?>"
                                                onclick="triggerDeleteModal('<?php echo e(route('produk.destroy', $product)); ?>', '<?php echo e($product->nama); ?>')">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="bi bi-box-seam fs-1 d-block mb-2" style="color: var(--icon-color);"></i>
                                <span class="fw-medium"><?php echo e(__('no_products_found')); ?></span>
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            
            <?php if(method_exists($products, 'hasPages') && $products->hasPages()): ?>
                <div class="card-footer bg-white border-0 px-4 py-3 border-top" style="background-color: var(--card-bg) !important; border-color: var(--card-border) !important;">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
                        <span class="pagination-info">
                            Menampilkan <strong><?php echo e($products->firstItem()); ?></strong> - <strong><?php echo e($products->lastItem()); ?></strong> dari <strong><?php echo e($products->total()); ?></strong> produk
                        </span>
                        <nav>
                            <ul class="pagination-modern">
                                
                                <?php if($products->onFirstPage()): ?>
                                    <li class="page-item disabled">
                                        <span class="page-link"><i class="bi bi-chevron-left"></i></span>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?php echo e($products->previousPageUrl()); ?><?php echo e(request()->query() ? '&' . http_build_query(request()->except('page')) : ''); ?>">
                                            <i class="bi bi-chevron-left"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                
                                <?php
                                    $startPage = max(1, $products->currentPage() - 2);
                                    $endPage = min($products->lastPage(), $products->currentPage() + 2);
                                ?>
                                <?php for($i = $startPage; $i <= $endPage; $i++): ?>
                                    <?php if($i == $products->currentPage()): ?>
                                        <li class="page-item active">
                                            <span class="page-link"><?php echo e($i); ?></span>
                                        </li>
                                    <?php else: ?>
                                        <li class="page-item">
                                            <a class="page-link" href="<?php echo e($products->url($i)); ?><?php echo e(request()->query() ? '&' . http_build_query(request()->except('page')) : ''); ?>"><?php echo e($i); ?></a>
                                        </li>
                                    <?php endif; ?>
                                <?php endfor; ?>

                                
                                <?php if($products->hasMorePages()): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?php echo e($products->nextPageUrl()); ?><?php echo e(request()->query() ? '&' . http_build_query(request()->except('page')) : ''); ?>">
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


<form id="globalDeleteForm" method="POST" style="display: none;">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
</form>

<script>
    function triggerDeleteModal(deleteUrl, productName) {
        Swal.fire({
            title: '<?php echo e(__('delete_product_title')); ?>',
            text: '<?php echo e(__('delete_product_message')); ?>'.replace('{product}', productName),
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#64748b',
            confirmButtonText: '<?php echo e(__('yes_delete')); ?>',
            cancelButtonText: '<?php echo e(__('cancel')); ?>',
            reverseButtons: true,
            customClass: { popup: 'shadow-lg' }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('globalDeleteForm');
                form.action = deleteUrl;
                form.submit();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        <?php if(session('error')): ?>
            Swal.fire({
                title: 'Gagal Dihapus!',
                text: "<?php echo e(session('error')); ?>",
                icon: 'error',
                confirmButtonColor: '#6d28d9',
                confirmButtonText: 'Mengerti'
            });
        <?php endif; ?>

        <?php if(session('success')): ?>
            Swal.fire({
                title: 'Berhasil!',
                text: "<?php echo e(session('success')); ?>",
                icon: 'success',
                confirmButtonColor: '#6d28d9',
                confirmButtonText: 'Tutup',
                timer: 3000,
                timerProgressBar: true
            });
        <?php endif; ?>

        // Instant Client-Side Fast Search Filter
        const searchInput = document.getElementById('fastSearchInput');
        const tableRows = document.querySelectorAll('.product-row');

        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const query = this.value.toLowerCase().trim();

                tableRows.forEach(function(row) {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(query) ? '' : 'none';
                });
            });
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\cadisetramadiR\resources\views/produk/index.blade.php ENDPATH**/ ?>