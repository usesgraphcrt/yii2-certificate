if (typeof usesgraphcrt == "undefined" || !usesgraphcrt) {
    var usesgraphcrt = {};
}

usesgraphcrt.certificate = {
    init: function () {
        $targetModel = $('[data-role=target-model]');
        $targetsList = $('[data-role=model-list]');
        $productModels = {};

        $('[data-role=send-form]').on('click', function (e) {
            usesgraphcrt.certificate.validate(e);
        });


        $(document).on('click', '[data-role=remove-target-item]', function () {

            if (!confirm('Вы действительно хотите удалить этот элемент?')) {
                return false;
            }
            var delete_url = $(this).data('href');
            var block = $(this).closest('[data-role=item]');
            var data = {
                'certificateId': usesgraphcrt.certificate.getUrlVar()["id"],
                'targetModel': $(this).data('target-model'),
                'targetModelId': $(this).data('target-model-id')
            };
            usesgraphcrt.certificate.deleteTargetItem(delete_url, data, block);
            $(currentBlock).remove();
        });

        $(document).on('change', '#certificate-type', function () {
            if ($(this).val() == 'sum') {
                $('[data-role=certificate-type]').text('Сумма');
            } else if ($(this).val() == 'item') {
                $('[data-role=certificate-type]').text('Количество применений');
            }
        });
    },

    validate: function (e) {
        e.preventDefault();
        if ($(document).find("input[name ^='targetModels']").length > 0) {
            $(document).find('[data-role=send-form2]').click();
        } else {
            $('[data-role=error-validate]').removeClass('hidden').fadeIn();
        }
    },

    getTargetItem: function (targetModelId, targetModel) {
        var check = $(document).find('[data-name=' + targetModel.replace(/\\/g, '') + targetModelId + ']');

        if (check.length > 0) {
            return true;
        }
        return false;
    },

    // bootstrapScrollTable: function (table) {
    //     $('#' + table + ' tbody').css('overflow-y', 'scroll');
    //     $('#' + table + ' tbody').css('position', 'absolute');
    //
    //     var hTable = parseInt($('#' + table).css('height'));
    //     var hHead = parseInt($('#' + table + ' thead').css('height'));
    //     var h = hTable - hHead;
    //
    //     $('#' + table + ' tbody').css('height', h);
    //
    //
    //     var thead = parseInt($('#' + table + ' thead').css('width'));
    //     var tbody = parseInt($('#' + table + ' tbody').css('width'));
    //     var delta = tbody - thead;
    //
    //     $('#' + table + ' tbody').css('width', $('thead').css('width'));
    //     var pos = $('#' + table + ' tbody').position();
    //     var left = pos.left;
    //     var top = pos.top;
    //
    //     $('#' + table + ' tbody').css('left', left - 0);
    //     $('#' + table + ' tbody').css('top', top - 0);
    //
    //     var colCount = $('#' + table + ' thead tr:nth-child(1) th').length;
    //     var rowCount = $('#' + table + ' tbody tr').length;
    //
    //     for (x = 1; x <= colCount; x++) {
    //         var w = parseInt($('#' + table + ' thead tr:nth-child(1) th:nth-child(' + x + ')').css('width'));
    //         if (x == colCount) {
    //             w = w - 18;
    //         }
    //
    //         for (y = 1; y <= rowCount; y++) {
    //             var idx = '#' + table + ' tbody tr:nth-child(' + y + ') td:nth-child(' + x + ')';
    //             $(idx).css('width', w);
    //         }
    //     }
    // },

    deleteTargetItem: function (url, data, $block) {
        currentBlock = $block;
        $.ajax({
            type: 'POST',
            url: url,
            data: {data: data},
            success: function (response) {
                if (response.status === 'success') {
                    $(currentBlock).remove();
                }
            },
            fail: function () {
                alert('Что-то пошло не так :\'(');
            }
        });
    },

    updateModelList: function (targetModelId, targetModel, targetModelName) {
        if (!targetModelId) {
            targetModelId = 0;
            $(document).find('.product-modal').modal('hide');
        }
        $targetsList.append($($('<tr data-role="item">')
            .append('<td><label>' + targetModelName + '</label><input type="hidden" data-role="product-model" ' +
                'name="targetModels[' + targetModel + '][' + targetModelId + ']"' +
                ' data-name="' + targetModel.replace(/\\/g, '') + targetModelId + '"/></td>')
            .append('<td><input class="form-control" type="text" data-role="product-model-amount" ' +
                'name="targetModels[' + targetModel + '][' + targetModelId + ']"' +
                ' data-name="' + targetModel.replace(/\\/g, '') + targetModelId + '"/ required></td>')
            .append('<td><span class="btn glyphicon glyphicon-remove" style="color: red;" data-role="remove-target-item"' +
                ' data-target-model="' + targetModel + '"' +
                ' data-target-model-id="' + targetModelId + '"></span></td>')
        ));

        $('[data-role=error-validate]').fadeOut();

    },

    getUrlVar: function () {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
            vars[key] = value;
        });
        return vars;
    }


};
usesgraphcrt.certificate.init();
// usesgraphcrt.certificate.bootstrapScrollTable('scrolling-table');