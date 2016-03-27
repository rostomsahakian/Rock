/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function () {
    // 6 create an instance when the DOM is ready
    $('#pages-wrapper').jstree({
        "core": {
            "check_callback": true
        },
        "plugins":
                ["contextmenu", "dnd", "changed"],
    }).bind("move_node.jstree", function(e,data){
         var p = data.parent.replace(/.*_/, '');
        var new_order = [];
        var nodes = data.node.id.replace(/.*_/, '');
        for(var i = 0; i < nodes.length; ++i)
            
          new_order.push(nodes[i].replace(/.*_/, ''));
        $.getJSON('/rock.admin/pages/move_page.php?id='
                + data.node.id.replace(/.*_/, '') + '&parent_id='
                + (p == "#" ? 0 : p)
                + '&order=' + new_order
                );
        
               // nodes = data
        console.log(new_order+p);
    }).on("changed.jstree" ,function(g,data){
        document.location='?cmd=see_page&option=true&page_id='+data.node.id.replace(/.*_/, '');
    })
        
//        callback: {
//
//            onmove: function (node) {
//                var p = $.jstree.focused().parent(node);
//                console.log(p);
//                var new_order = [],
//                        nodes = node.parentNode.childNodes;
//                for (var i = 0; i < nodes.length; ++i)
//                    new_order.push(nodes[i].id.replace(/.*_/, ''));
//                $.getJSON('/rock.admin/pages/move_page.php?id='
//                        + node.id.replace(/.*_/, '') + '&parent_id='
//                        + (p == -1 ? 0 : p[0].id.replace(/.*_/, ''))
//                        + '&order=' + new_order
//                        );
//                console.log(p);
//            }
////        }
//    });
    var div = $(
            '<div><i>right-click for options</i><br/><br/></div>'
            );
    $('<button>add main page</button>').click(pages_add_main_page).appendTo(div);
    div.appendTo('#pages-wrapper');


});
function pages_add_main_page() {

}



