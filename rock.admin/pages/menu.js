/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function () {
    // 6 create an instance when the DOM is ready
    $('#pages-wrapper').jstree({
        "core": {
            "check_callback": true,
        },
        "plugins":
                ["contextmenu", "dnd", "changed", "search", "types"],
    }).bind("move_node.jstree", function (e, data) {



        var p = data.parent.replace(/.*_/, '');

        var nodes = data.instance.get_node(data.node).parents;
        var n_p = data.position;
        var o_p = data.old_position;
        console.log(n_p);
        console.log(o_p);

        console.log(nodes);
        var c = data.node.id.replace(/.*_/, '');
        var new_order = [];

        for (i = 0, j = nodes.length; i < j; ++i)
            new_order.push(nodes[i].replace(/.*_/, ''));
        var childs = data.position[i];
        //console.log(childs);

        $.getJSON('?cmd=move_page&id='
                + data.node.id.replace(/.*_/, '') + '&parent_id='
                + (p == "#" ? 0 : p)
                + '&order=' + new_order
                );

        console.log('?cmd=move_page&id='
                + data.node.id.replace(/.*_/, '') + '&parent_id='
                + (p == "#" ? 0 : p)
                + '&order=' + new_order.join(', '));


    }).on("changed.jstree", function (g, data) {


        document.location = '?cmd=edit_page&option=true&page_id=' + data.node.id.replace(/.*_/, '');

    })


    var div = $(
            '<div><i>right-click for options</i><br/><br/></div>'
            );
    $('<button>add main page</button>').click(pages_add_main_page).appendTo(div);
    div.appendTo('#pages-wrapper');


});
function pages_add_main_page() {

}



