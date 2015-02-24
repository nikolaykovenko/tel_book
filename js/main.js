function ajaxDefaultResponse(data) {
    var result = $.parseJSON(data);
    alert(result.message);

    if (result.status == 'ok') {
        $('[data-action-form] form').slideUp(200, function() {
            $('[data-action-form]').html('');
        });

        refreshItemsTable();
    }

}

function ajaxQuery(data, response) {
    if (!response) {
        response = ajaxDefaultResponse;
    }

    return $.get('index.php', data, response);
}


function deleteItem(id) {
    if (confirm('Вы действительно хотите удалить телефон из базы?')) {
        ajaxQuery({'mode': 'deleteItem', 'id': id});
    }
}

function editItem(id) {
    ajaxQuery({'mode': 'getEditForm', 'id': id}, function (data) {
        $('[data-action-form]').html(data);
    });
}

function addItem() {
    ajaxQuery({'mode': 'getAddForm'}, function (data) {
        $('[data-action-form]').html(data);
    });
}

function refreshItemsTable(search) {
    var block = $('[data-telehpones-table]');
    
    block.stop(true, true, true).fadeTo(200, .5);
    return ajaxQuery({'mode': 'SearchItems', 'search': search}, function (data) {
        block.fadeTo(200, 1);
        block.html(data);
    });
}


var request;
$(function () {
    refreshItemsTable();
    
    $('[data-telehpones-table]').on('click', '[data-delete]', function () {
        deleteItem($(this).parents('tr[data-item-id]').data('item-id'));
    });

    $('[data-telehpones-table]').on('click', '[data-edit]', function () {
        editItem($(this).parents('tr[data-item-id]').data('item-id'));
    });

    $('body').on('click', '[data-add]', function () {
        addItem();
    });

    $('[data-search-query]')[0].oninput = function() {
        if (typeof request !== 'undefined') {
            request.abort();
        }

        request = refreshItemsTable($(this).val());
    };


    $('body').on('submit', 'form[data-ajax-form]', function (e) {
        e.preventDefault();
        var form = $(this);

        form.fadeTo(200, .6);
        $.post(form.attr('action'), {'form': form.serialize()}, function (data) {
            var result = $.parseJSON(data),
                 callback = form.attr('data-ajax-form-response'),
                 fn = window[callback];

            if (typeof fn === 'function') {
                fn(result, form);
            } else {
                form.fadeTo(200, 1);
                ajaxDefaultResponse(data);
            }
        });

        return false;
    });
});