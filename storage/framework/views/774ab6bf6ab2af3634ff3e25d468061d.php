

<?php $__env->startSection('title', __('notifications') . ' - POS System'); ?>

<?php $__env->startSection('content'); ?>

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #5b21b6 0%, #7c3aed 50%, #9333ea 100%);
        --card-bg: #ffffff;
        --card-border: #e9d5ff;
        --text-heading: #2e1065;
        --text-body: #4c1d95;
        --text-muted: #6b21a8;
        --icon-bg: #f3e8ff;
        --icon-color: #7e22ce;
        --radius-lg: 20px;
        --radius-md: 14px;
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

    .dashboard-card {
        border-radius: var(--radius-md);
        border: 1px solid var(--card-border) !important;
        background: var(--card-bg) !important;
        box-shadow: 0 4px 12px rgba(109, 40, 217, 0.04);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .dashboard-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(124, 58, 237, 0.12);
    }

    .notification-item {
        border-left: 4px solid;
        transition: all 0.25s ease;
    }

    .notification-item.unread {
        border-left-color: #7c3aed;
        background: linear-gradient(135deg, rgba(124, 58, 237, 0.08) 0%, rgba(168, 85, 247, 0.08) 100%);
    }

    .notification-item.read {
        border-left-color: #e9d5ff;
        background: #ffffff;
    }

    .notification-item:hover {
        transform: translateX(4px);
    }

    .notification-item h5 {
        color: #2e1065 !important;
        font-size: 1rem;
    }

    .notification-item p {
        color: #4c1d95 !important;
        font-size: 0.9rem;
    }

    .notification-item small {
        color: #6b21a8 !important;
    }

    .btn-back {
        background: var(--primary-gradient) !important;
        color: #ffffff !important;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.25s ease;
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
    }

    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(124, 58, 237, 0.4);
    }

    .notification-time {
        font-size: 0.8rem;
        color: #6b21a8 !important;
        font-weight: 500;
    }
</style>

<div class="container py-4" style="padding-top: 5rem;">

    
    <div class="dashboard-header-banner mb-4">
        <div class="row align-items-center g-3 position-relative" style="z-index: 1;">
            <div class="col-lg-7">
                <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                    <div class="date-badge">
                        <i class="bi bi-bell"></i>
                        <span><?php echo e(__('notifications')); ?></span>
                    </div>
                    <?php if($user->unreadNotifications->count() > 0): ?>
                    <span class="badge rounded-pill px-3 py-2 fw-semibold" style="background: #ef4444; color: white; font-size: 0.85rem;">
                        <?php echo e($user->unreadNotifications->count()); ?> <?php echo e(__('unread')); ?>

                    </span>
                    <?php endif; ?>
                </div>
                <h1 class="fw-bold text-white mb-2 fs-2">
                    <?php echo e(__('notification_history')); ?>

                </h1>
                <p class="text-white-50 mb-0 fs-6"><?php echo e(__('notification_subtitle')); ?></p>
            </div>
            <div class="col-lg-5 text-lg-end">
                <div class="d-flex gap-2 justify-content-lg-end">
                    <form action="<?php echo e(route('notifications.read-all')); ?>" method="POST" class="d-inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-outline-light rounded-pill px-4 shadow-sm fw-semibold d-inline-flex align-items-center gap-2">
                            <i class="bi bi-check-all"></i>
                            <span><?php echo e(__('mark_all_as_read')); ?></span>
                        </button>
                    </form>
                    <a href="<?php echo e(route('settings.index')); ?>" class="btn btn-outline-light rounded-pill px-4 shadow-sm fw-semibold d-inline-flex align-items-center gap-2">
                        <i class="bi bi-gear"></i>
                        <span><?php echo e(__('settings')); ?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card dashboard-card p-4">
                <?php if($notifications->count() > 0): ?>
                    <div class="list-group list-group-flush">
                        <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="list-group-item notification-item <?php echo e($notification->read_at ? 'read' : 'unread'); ?> p-4 mb-3 rounded-3 border" style="border-color: var(--card-border) !important;">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="flex-shrink-0">
                                        <?php if($notification->type === 'App\Notifications\SaleNotification'): ?>
                                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white;">
                                                <i class="bi bi-cart-check-fill fs-5"></i>
                                            </div>
                                        <?php elseif($notification->type === 'App\Notifications\StockNotification'): ?>
                                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white;">
                                                <i class="bi bi-box-seam-fill fs-5"></i>
                                            </div>
                                        <?php else: ?>
                                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: linear-gradient(135deg, #7c3aed 0%, #9333ea 100%); color: white;">
                                                <i class="bi bi-bell-fill fs-5"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h5 class="fw-bold mb-0" style="color: var(--text-heading);">
                                                <?php echo e($notification->data['message'] ?? __('notifications')); ?>

                                            </h5>
                                            <?php if(!$notification->read_at): ?>
                                                <span class="badge rounded-pill px-3 py-1 fw-semibold" style="background: linear-gradient(135deg, #7c3aed 0%, #9333ea 100%); color: white; font-size: 0.75rem;"><?php echo e(__('new')); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <p class="mb-2" style="color: var(--text-body);">
                                            
                                            <?php if(isset($notification->data['sale_id'])): ?>
                                                <small><?php echo e(__('transaction_id_label')); ?>: #<?php echo e($notification->data['sale_id']); ?></small><br>
                                            <?php endif; ?>
                                            <?php if(isset($notification->data['user_name'])): ?>
                                                <small><?php echo e(__('by_label')); ?>: <?php echo e($notification->data['user_name']); ?> (<?php echo e($notification->data['user_role'] ?? __('user_label')); ?>)</small><br>
                                            <?php endif; ?>
                                            <?php if(isset($notification->data['product_name'])): ?>
                                                <small><?php echo e(__('product_label')); ?>: <?php echo e($notification->data['product_name']); ?></small><br>
                                            <?php endif; ?>
                                            <?php if(isset($notification->data['total'])): ?>
                                                <small><?php echo e(__('total_label')); ?>: Rp <?php echo e(number_format($notification->data['total'], 0, ',', '.')); ?></small>
                                            <?php endif; ?>
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="notification-time">
                                                <i class="bi bi-clock me-1"></i>
                                                <?php echo e($notification->created_at->diffForHumans()); ?>

                                            </span>
                                            <?php if(!$notification->read_at): ?>
                                                <form action="<?php echo e(route('notifications.read', $notification->id)); ?>" method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="btn btn-sm btn-outline-light rounded-pill px-3" style="color: var(--text-heading) !important; border-color: var(--card-border) !important; background: var(--card-bg) !important;">
                                                        <i class="bi bi-check-lg me-1"></i> <?php echo e(__('mark_as_read')); ?>

                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    
                    <div class="d-flex justify-content-center mt-4">
                        <?php echo e($notifications->links()); ?>

                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="bi bi-bell-slash" style="font-size: 4rem; color: var(--text-muted);"></i>
                        </div>
                        <h4 class="fw-bold" style="color: var(--text-heading);">Tidak Ada Notifikasi</h4>
                        <p class="text-muted" style="color: var(--text-muted);">Anda belum menerima notifikasi apapun.</p>
                        <a href="<?php echo e(route('settings.index')); ?>" class="btn btn-back mt-3">
                            <i class="bi bi-gear me-2"></i>Atur Preferensi Notifikasi
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\cadisetramadiR\resources\views/settings/notifications.blade.php ENDPATH**/ ?>