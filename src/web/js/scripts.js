if (typeof dvizh == "undefined" || !dvizh) {
    var dvizh = {};
}

dvizh.tree = {
    tree: '[data-role=tree]',
    expand: '[data-role=expand-tree]',
    curtial: '[data-role=curtial-tree]',
    deleteBtn: '[data-role=delete-tree]',
    child: '[data-role=child]',

    init: function () {
        $(document).on('click', dvizh.tree.expand, this.expandTree);
        $(document).on('click', dvizh.tree.curtial, this.curtialTree);
        $(document).on('click', dvizh.tree.deleteBtn, this.deleteCategory);

        dvizh.tree.csrf = $('meta[name=csrf-token]').attr("content");
        dvizh.tree.csrf_param = $('meta[name=csrf-param]').attr("content");
    },

    deleteCategory: function () {
        var self = this,
            id = $(self).data('id'),
            model = $(dvizh.tree.tree).data('model'),
            action = $(dvizh.tree.tree).data('action-delete');

        if (!!(id)) {
            var data = {};
            var confirmation = confirm("Удалить данный элемент?");

            if(confirmation === true) {
                data.id = id;
                data.model = model;
                dvizh.tree.sendData(data, action, self);
            }
        }
    },

    expandTree: function () {

        var self = this,
            id = $(self).data('id'),
            model = $(dvizh.tree.tree).data('model'),
            action = $(dvizh.tree.tree).data('action-expand');

        if (!!(id)) {
            var data = {};

            data.id = id;
            data.model = model;
            dvizh.tree.sendData(data, action, self);
        }

        return false;
    },

    curtialTree: function () {
        var self = this;

        dvizh.tree.changeClass('curtial', self);
        $(self).parents('li:first').find('.child').remove();
    },

    sendData: function (data, link, self) {

        data[dvizh.tree.csrf_param] = dvizh.tree.csrf;

        $.post(link, data,
            function (response) {
                if (response && response != 'delete') {
                    if ($(self).parents('li:first').hasClass('main')) {
                        $(self).closest('.main').append(response);
                    } else {
                        $(self).parents('.children-li').append(response);
                    }
                    dvizh.tree.changeClass('expand', self);
                } else {
                    $(self).parents('li:first').remove();
                }

            }, "html");

        return false;
    },

    changeClass: function (action, branch) {
        if (action === 'expand') {
            $(branch).data('role', 'curtial-tree').attr('data-role', 'curtial-tree');
            $(branch).find('.glyphicon').addClass('glyphicon-chevron-right').removeClass('glyphicon-chevron-down');
        } else {
            $(branch).data('role', 'expand-tree').attr('data-role', 'expand-tree');
            $(branch).find('.glyphicon').addClass('glyphicon-chevron-down').removeClass('glyphicon-chevron-right');
        }
    }
};

dvizh.tree.init();
