

<?php $__env->startSection('title', __('manage_categories_title') . ' - POS ILHAM'); ?>

<?php $__env->startSection('content'); ?>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        margin-bottom: 2rem;
        box-shadow: 0 10px 40px rgba(124, 58, 237, 0.15);
        position: relative;
        overflow: hidden;
    }

    .custom-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: var(--radius-lg);
        box-shadow: 0 4px 20px rgba(124, 58, 237, 0.08);
    }

    .table thead th {
        background-color: var(--table-head-bg);
        color: var(--text-heading);
        font-weight: 600;
        border-bottom: 2px solid #e9d5ff;
    }

    .table tbody tr:hover {
        background-color: var(--table-hover-bg);
    }

    .btn-primary-custom {
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 600;
        border-radius: var(--radius-md);
        padding: 0.6rem 1.5rem;
        transition: var(--transition);
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(124, 58, 237, 0.3);
        color: white;
    }

    .btn-action {
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 500;
        transition: var(--transition);
    }

    .btn-edit {
        background: #f3e8ff;
        color: #7c3aed;
        border: 1px solid #ddd6fe;
    }

    .btn-edit:hover {
        background: #7c3aed;
        color: white;
        border-color: #7c3aed;
    }

    .btn-delete {
        background: #fee2e2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }

    .btn-delete:hover {
        background: #dc2626;
        color: white;
        border-color: #dc2626;
    }

    .search-box {
        border: 2px solid #e9d5ff;
        border-radius: var(--radius-md);
        padding: 0.2rem 0.5rem;
        transition: var(--transition);
    }

    .search-box:focus-within {
        border-color: #7c3aed;
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
    }

    .swal2-popup {
        border-radius: 20px !important;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
    }
</style>

<div class="container py-4" style="padding-top: 5rem;">

    
    <div class="dashboard-header-banner position-relative">
        <div class="position-relative" style="z-index: 1;">
            <h2 class="fw-bold text-white mb-2 d-flex align-items-center gap-2">
                <i class="bi bi-tags-fill fs-2"></i> <?php echo e(__('Kategori / Jenis Produk')); ?>

            </h2>
            <p class="text-white opacity-75 mb-0"><?php echo e(__('Kelola kategori produk untuk mempermudah pengelompokan barang.')); ?></p>
        </div>
        <div class="position-absolute end-0 bottom-0 opacity-15 pe-4 pb-2 d-none d-md-block">
            <i class="bi bi-tags text-white" style="font-size: 6rem;"></i>
        </div>
    </div>

    <div class="custom-card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            
            <form action="<?php echo e(route('jenis.index')); ?>" method="GET" class="flex-grow-1" style="max-width: 400px;">
                <div class="input-group search-box">
                    <span class="input-group-text bg-transparent border-0 text-muted">
                        <i class="bi bi-search" style="color: #7c3aed;"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-0 shadow-none"
                           placeholder="<?php echo e(__('Cari Kategori...')); ?>" value="<?php echo e(request('search')); ?>">
                    <?php if(request('search')): ?>
                        <a href="<?php echo e(route('jenis.index')); ?>" class="btn btn-link text-muted pe-2 border-0 shadow-none align-self-center">
                            <i class="bi bi-x-circle-fill"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </form>

            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', App\Models\Jenis::class)): ?>
            <a href="<?php echo e(route('jenis.create')); ?>" class="btn btn-primary-custom d-inline-flex align-items-center gap-2">
                <i class="bi bi-plus-lg"></i>
                <span><?php echo e(__('Tambah Kategori')); ?></span>
            </a>
            <?php endif; ?>
        </div>

        
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 10%;" class="ps-3">No</th>
                        <th style="width: 60%;">Kategori / Jenis</th>
                        <th style="width: 30%;" class="pe-3 text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $jenis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="fw-semibold ps-3 text-muted">
                            <?php echo e(method_exists($jenis, 'firstItem') ? $jenis->firstItem() + $loop->index : $loop->iteration); ?>

                        </td>
                        <td class="fw-bold" style="color: var(--text-heading);">
                            <span class="badge bg-purple-subtle text-purple border px-3 py-2 rounded-pill fw-semibold" style="background-color: #f3e8ff; color: #7e22ce; border-color: #e9d5ff !important;">
                                <i class="bi bi-tag-fill me-1"></i><?php echo e($item->nama); ?>

                            </span>
                        </td>
                        <td class="pe-3 text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $item)): ?>
                                <a href="<?php echo e(route('jenis.edit', $item)); ?>" class="btn btn-action btn-edit d-inline-flex align-items-center gap-1">
                                    <i class="bi bi-pencil-fill"></i>
                                    <span><?php echo e(__('Edit')); ?></span>
                                </a>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete', $item)): ?>
                                <button type="button" 
                                        class="btn btn-action btn-delete d-inline-flex align-items-center gap-1"
                                        onclick="triggerDeleteModal('<?php echo e(route('jenis.destroy', $item)); ?>', '<?php echo e($item->nama); ?>')">
                                    <i class="bi bi-trash-fill"></i>
                                    <span><?php echo e(__('Hapus')); ?></span>
                                </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="3" class="text-center py-5">
                            <div class="text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2" style="color: var(--icon-color);"></i>
                                <p class="mb-0 fw-medium"><?php echo e(__('Tidak ada data kategori ditemukan.')); ?></p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <?php if(method_exists($jenis, 'hasPages') && $jenis->hasPages()): ?>
        <div class="d-flex justify-content-center mt-4 pt-2 border-top">
            <?php echo e($jenis->links()); ?>

        </div>
        <?php endif; ?>
    </div>

</div>


<form id="globalDeleteForm" method="POST" style="display: none;">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
</form>

<script>
    // Konfirmasi Hapus SweetAlert2
    function triggerDeleteModal(deleteUrl, categoryName) {
        Swal.fire({
            title: 'Hapus Kategori?',
            text: `Apakah Anda yakin ingin menghapus kategori "${categoryName}"? Data yang terhubung mungkin akan terpengaruh.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
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
        // Flash Message Notifikasi Sukses / Gagal
        <?php if(session('error')): ?>
            Swal.fire({
                title: 'Gagal!',
                text: "<?php echo e(session('error')); ?>",
                icon: 'error',
                confirmButtonColor: '#7c3aed',
                confirmButtonText: 'Tutup'
            });
        <?php endif; ?>

        <?php if(session('success')): ?>
            Swal.fire({
                title: 'Berhasil!',
                text: "<?php echo e(session('success')); ?>",
                icon: 'success',
                confirmButtonColor: '#7c3aed',
                confirmButtonText: 'Tutup',
                timer: 3000,
                timerProgressBar: true
            });
        <?php endif; ?>
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\cadisetramadiR\resources\views/jenis/index.blade.php ENDPATH**/ ?>