$(document).ready(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $('#product_tree').fancytree({
        extensions: ['glyph','wide','edit'],
        glyph: {
            preset: 'bootstrap3',
            map: {}
        },
        source: $.ajax({
            method: 'POST',
            url: window.location.protocol + "//" + window.location.host + "/" + 'product_category/get-trees',
            dataType: 'json',
            data: {product_id: $('#product_id').val(), _token: CSRF_TOKEN},
            success: function (response) {
                return response;
            }
        }),

        lazyload: function (event, data) {
            var node = data.node;
            data.result = {
                method: 'POST',
                url: window.location.protocol + "//" + window.location.host + "/" + 'product_category/get-childs',
                data: {mode: 'children', parent_id: node.key, _token: CSRF_TOKEN},
                cache: false
            };
        },

        edit: {
            triggerStart: ["clickActive", "dblclick", "f2", "mac+enter", "shift+click"],
            close: function(event, data){
                var nodeKey = data.node.key;
                if(nodeKey !== null) {
                    if(nodeKey.indexOf('_') === -1) {
                        $.ajax({
                            method: 'POST',
                            url: window.location.protocol + "//" + window.location.host + "/" + 'product_category/rename-node',
                            dataType: 'json',
                            data: {node_key: data.node.key, name: data.node.title, _token: CSRF_TOKEN},
                            success: function (response) {

                            }
                        });
                    }
                }
                // console.log(data.node);
            }
        }
    });

    $('#modal_category').on('hidden.bs.modal', function (e) {
        location.reload();
    })
});

function setProductCategoryType(selected) {
    var type = $(selected).data('type');
    var product_id = $('#product_id').val();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    if(type === 'root') {
        if($('#category_name').val() === '') {
            $('#category_name_error').removeClass('invisible');
        } else {
            $('#category_name_error').addClass('invisible');
            $.ajax({
                method: 'POST',
                url: window.location.protocol + "//" + window.location.host + "/" + 'product_category/add-parent-node',
                dataType: 'json',
                data: {product_id: product_id, category_name: $('#category_name').val(), _token: CSRF_TOKEN},
                success: function (response) {
                    var rootNode = $('#product_tree').fancytree('getRootNode');
                    rootNode.addChildren({
                        title: response.name,
                        key: response.id,
                        folder: true,
                        lazy: true
                    });
                    $('#category_name').val('');
                }
            });
        }
    } else if(type === 'sub') {
        var activeNode = $('#product_tree').fancytree('getActiveNode');
        console.log(activeNode);
        if(activeNode === null) {
            alert('please select category first');
        } else {
            if($('#sub_name').val() === '') {
                $('#sub_category_error').removeClass('invisible');
            } else {
                $('#sub_category_error').addClass('invisible');
                $.ajax({
                    method: 'POST',
                    url: window.location.protocol + "//" + window.location.host + "/" + 'product_category/add-child-node',
                    dataType: 'json',
                    data: {parent_id: activeNode.key, name: $('#sub_name').val(), _token: CSRF_TOKEN},
                    success: function (response) {
                        activeNode.editCreateNode('child', {
                           title: response.name,
                           key: response.id,
                           folder: true,
                           lazy: true
                        });
                        $('#sub_name').val('');
                    }
                })
            }
        }
    } else if(type === 'edit') {
        var activeNode = $('#product_category_tree').fancytree('getActiveNode');
        if(activeNode === null) {
            alert('please select category first');
        } else {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                method: 'POST',
                url: window.location.protocol + "//" + window.location.host + "/" + 'product_category/get-category',
                dataType: 'json',
                data: {node_id: activeNode.key, _token: CSRF_TOKEN},
                success: function (category) {
                    $('#txt_edit_product_category').val(category.name);
                }
            });
        }
    } else if(type === 'delete') {
        var activeNode = $('#product_tree').fancytree('getActiveNode');
        if(activeNode === null) {
            alert('please select category first');
        } else {
            var isConfirmed = confirm('Are you sure want to delete this category ?');
            if(isConfirmed === true) {
                $.ajax({
                    method: 'POST',
                    url: window.location.protocol + "//" + window.location.host + "/" + 'product_category/delete-node',
                    dataType: 'json',
                    data: {node_id: activeNode.key, _token: CSRF_TOKEN},
                    success: function (response) {
                        if(response.status === 'success') {
                            activeNode.remove();
                        }
                    }
                })
            }
        }
    }
}