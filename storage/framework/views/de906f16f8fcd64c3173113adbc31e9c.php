<?php
    $templates = ['website.each.home.home_1', 'website.each.home.home_2'];
    $selectedTemplate = $templates[array_rand($templates)];
?>


<?php echo $__env->make($selectedTemplate, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Lifemate\Desktop\modern\resources\views/website/each/home.blade.php ENDPATH**/ ?>