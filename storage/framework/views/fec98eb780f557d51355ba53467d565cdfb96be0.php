<?php $__env->startSection('content'); ?>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="">Control Panel</a>
        </li>
        <li class="breadcrumb-item active">User Groups</li>
    </ol>
    <div class="row">
        <div class="col-lg-12">
           
           
            <table class="table table-striped">
                <thead>
                <tr>
                   
                    <th>username</th>
                    <th class="desktop">Member(s)</th>
                    <th class="th-2action">Action</th>
                </tr>
                </thead>
                <tbody>
                    
                    
                    
                    
                <?php $__currentLoopData = $exchange_g2f; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($role->email); ?></td>
                      
                      
                        <td><?php echo e($role->secret); ?></td>
                        
                        
                        <td>
                           
                                <a href="/admin/g2f/delete/<?php echo e($role->email); ?>" class="row-button delete" onclick="return confirm('Are you sure?')"><i class="fas fa-fw fa-trash"></i> Remove</a>
                            
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xpagg/public_html/resources/views/backend/system/g2f.blade.php ENDPATH**/ ?>