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
console.log(click(pages_add_main_page).appendTo(div));

});
function pages_add_main_page() {
    pages_new(0);
    console.log(pages_new);
}
function pages_new(p) {
    $('<form id="new_page_dialog" method="post"> <input typ="hidden" name="cmd" value="insert page details"/> \n\
       <input type="hidden" name="special[1]" value="1"/>\n\
        <input type="hidden" name="parent" value="'+p+'" /> \n\
         <table>\n\
           <tr><th>Name</th><td><input type="text" name="name"/></td></tr>         \n\
           <tr><th>Page Type</th><td><select name="type"><option value="0">normal</option></select></td></tr>         \n\
</table></form> ')
            .dialog({
                modal:true,
                buttons:{
                    'Create Page':function(){
                        $('#newpage_page_dialog').submit();
                    },
                    'Cancel': function(){
                        $(this).dialog('distroy');
                        $(this).remove();
                    }
                }
            });
            return false;
}



