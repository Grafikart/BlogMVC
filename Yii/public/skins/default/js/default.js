jQuery(document).ready(function($) {
    $('[role="toggle-category-menu"]').on('click', function() {
        var $container = $('[role="category-selector-container"]');
        $container.find('.form-control.hidden').removeClass('hidden').hide();
        var $visible = $container.find('.form-control:visible');
        var $hidden = $container.find('.form-control:not(:visible)');
        $hidden.prop('disabled', false);
        $visible.prop('disabled', true);
        $visible.add($hidden).slideToggle();
    });
});