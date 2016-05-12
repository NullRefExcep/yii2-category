jQuery(function () {
    jQuery(document).on('click', '.collapse-list-btn', function () {
        jQuery(this).find('i').toggleClass('fa-arrow-down').toggleClass('fa-arrow-up');
    });

    var treeView = jQuery('#treeView');
    var formName = treeView.data('formName');

    treeView.find('> ol').nestedSortable({
        items: '.category-list-item',
        helper: 'clone',
        handle: '.drag-btn',
        toleranceElement: '> div',
        isTree: true,
        update: function (e, obj) {
            treeView.css({opacity: 0.4});
            var url = obj.item.data('updateUrl');
            var parent = obj.item.parents('li');
            var before = obj.item.prev();
            var data = {};
            data[formName] = {
                beforeId: before.length ? before.data('id') : 0,
                parent_id: parent.length ? parent.data('id') : 0
            };
            jQuery.ajax({
                url: url,
                method: 'post',
                data: data,
                success: function () {
                    treeView.css({opacity: 1});
                },
                error: function () {
                }
            });
            updateCollapseButtons();
        }
    }).disableSelection();

    function updateCollapseButtons() {
        console.log('trigger');
        var items = treeView.find('li');
        items.each(function () {
            var item = jQuery(this);
            var btn = item.find('> div .collapse-list-btn');
            var list = item.find('> ol');
            if (list.children().length) {
                btn.removeClass('disabled');
                if (list.hasClass('in')) {
                    btn.find('i').removeClass('fa-arrow-down').addClass('fa-arrow-up');
                } else {
                    btn.find('i').removeClass('fa-arrow-up').addClass('fa-arrow-down');
                }
            } else {
                btn.addClass('btn-default');
            }
        });
    }

    if (selectedCategoryId) {
        treeView.find('#categoryList' + selectedCategoryId).parents('li').each(function () {
            jQuery(this).find('>div>.collapse-list-btn').click();
        });
    }
});