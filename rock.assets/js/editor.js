/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function iFrameOn() {
    richTextfield.document.designMode = 'on';
    iRefresh();
}
function iBold() {
    richTextfield.document.execCommand('bold', false, null);
}
function iUnderLine() {
    richTextfield.document.execCommand('underline', false, null);
}
function iItalic() {
    richTextfield.document.execCommand('italic', false, null);

}
function iFontSize() {
    var f = document.getElementById("font-size");
    var Size = f.options[f.selectedIndex].value;
    richTextfield.document.execCommand('FontSize', false, Size);

}

function iFontColor() {
    var color = document.getElementById("font-color");
    var color_value = color.options[color.selectedIndex].value;
    richTextfield.document.execCommand('foreColor', false, color_value);
}
function iFontFamily() {
    var font = document.getElementById('font-type');
    var fonttype = font.options[font.selectedIndex].value;
    richTextfield.document.execCommand('fontName', false, fonttype);

}

function iHorizontalRule() {
    richTextfield.document.execCommand('inserthorizontalrule', false, null);

}
function iUnorderedList() {
    richTextfield.document.execCommand('insertUnorderedList', false, "newUL");
}

function iOrderedList() {
    richTextfield.document.execCommand('insertOrderedList', false, "newOL");
}
function iLink() {
    var linkURL = prompt("Enter the URL for this link:", "http://");
    richTextfield.document.execCommand("CreateLink", false, linkURL);
}
function iUnLink() {

    richTextfield.document.execCommand("Unlink", false, null);

    var theForm = document.getElementById("form");
    var cont = window.frames['richTextfield'].document.body.innerHTML;
    console.log(cont);
}
function iImage() {
    var imagepath = prompt("Insert path for your image", "");
    richTextfield.document.execCommand('insertImage', false, imagepath);

}

function iJustifyCenter() {
    richTextfield.document.execCommand('justifyCenter', false, null);

}
function iJustifyLeft() {
    richTextfield.document.execCommand('justifyLeft', false, null);


}
function iJustifyRight() {
    richTextfield.document.execCommand('justifyRight', false, null);

}
function iJustifyFull() {
    richTextfield.document.execCommand('justifyFull', false, null);
}
function iInsertParagraph() {
    richTextfield.document.execCommand('insertParagraph', false, null);


}

function iRemoveFormat() {
    richTextfield.document.execCommand('removeFormat', false, null);

}
function iSelectAll() {
    richTextfield.document.execCommand('selectAll', false, null);

}
function iStrikeThrough() {
    richTextfield.document.execCommand('strikeThrough', false, null);

}
function iRedo() {
    richTextfield.document.execCommand('redo', false, null);

}



function iBackgroundColor() {
    var bgcolor = document.getElementById("bg-color");
    var bgcolorValue = bgcolor.options[bgcolor.selectedIndex].value;
    console.log(bgcolorValue);
    richTextfield.document.execCommand('backColor', false, bgcolorValue);

}

function iInsertHTML() {
    var html = document.getElementById("form");
    var htmlcode = html.elements["textAreaDiv"].value;
    richTextfield.document.execCommand('insertHtml', false, htmlcode);
}

function submit_form() {

    var theForm = document.getElementById("form");
    theForm.elements["myTextArea"].value = window.frames['richTextfield'].document.body.innerHTML;


    theForm.submit();

}
function iRefresh() {
    var theForm = document.getElementById("form");

    window.frames['richTextfield'].document.body.innerHTML = theForm.elements["myTextArea"].value;

}

function toggle_visibility() {
    var e = document.getElementById("htmlcodediv");
    if (e.style.display == 'block')
        e.style.display = 'none';
    else
        e.style.display = 'block';
}
