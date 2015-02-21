var clientPC = navigator.userAgent.toLowerCase();
var clientVer = parseInt(navigator.appVersion);
var is_ie = ((clientPC.indexOf("msie") != -1) && (clientPC.indexOf("opera") == -1));
var is_win = ((clientPC.indexOf("win") != -1) || (clientPC.indexOf("16bit") != -1));
var is_nav = ((clientPC.indexOf('mozilla') != -1) && (clientPC.indexOf('spoofer') == -1)
        && (clientPC.indexOf('compatible') == -1) && (clientPC.indexOf('opera') == -1)
        && (clientPC.indexOf('webtv') == -1) && (clientPC.indexOf('hotjava') == -1));
var is_moz = 0;
var is_mac = (clientPC.indexOf("mac") != -1);

// From http://www.massless.org/mozedit/
function mozWrap(txtarea, open, close)
{
    var selLength = txtarea.textLength;
    var selStart = txtarea.selectionStart;
    var selEnd = txtarea.selectionEnd;
    if (selEnd == 1 || selEnd == 2)
        selEnd = selLength;

    var s1 = (txtarea.value).substring(0, selStart);
    var s2 = (txtarea.value).substring(selStart, selEnd)
    var s3 = (txtarea.value).substring(selEnd, selLength);
    txtarea.value = s1 + open + s2 + close + s3;
    return;
}

// Insert at Claret position. Code from
// http://www.faqts.com/knowledge_base/view.phtml/aid/1052/fid/130
function storeCaret(textEl) {
    if (textEl.createTextRange)
        textEl.caretPos = document.selection.createRange().duplicate();
}

// Insert a bbcode in textarea
function insertBB(dom, bbopen, bbclose) {
    if ((clientVer >= 4) && is_ie && is_win) {
        var text = document.selection.createRange().text;
        if (!text) {
            dom.value += bbopen + bbclose;
            dom.focus();
            return;
        } else {
            document.selection.createRange().text = bbopen + text + bbclose;
            dom.focus();
            return;
        }
    }
    else if (dom.selectionEnd && (dom.selectionEnd - dom.selectionStart > 0))
    {
        mozWrap(dom, bbopen, bbclose);
        return;
    }
    else
    {
        dom.value += bbopen + bbclose;
        dom.focus();
    }
}

function rcxCodeBold(id) {
    var bbopen = "[b]";
    var bbclose = "[/b]";
    var dom = rcxGetElementById(id);
    insertBB(dom, bbopen, bbclose);
    storeCaret(dom);
}

function rcxCodeItalic(id) {
    var bbopen = "[i]";
    var bbclose = "[/i]";
    var dom = rcxGetElementById(id);
    insertBB(dom, bbopen, bbclose);
    storeCaret(dom);
}

function rcxCodeUnderline(id) {
    var bbopen = "[u]";
    var bbclose = "[/u]";
    var dom = rcxGetElementById(id);
    insertBB(dom, bbopen, bbclose);
    storeCaret(dom);
}

function rcxCodeStrike(id) {
    var bbopen = "[s]";
    var bbclose = "[/s]";
    var dom = rcxGetElementById(id);
    insertBB(dom, bbopen, bbclose);
    storeCaret(dom);
}

function rcxCodeOverline(id) {
    var bbopen = "[o]";
    var bbclose = "[/o]";
    var dom = rcxGetElementById(id);
    insertBB(dom, bbopen, bbclose);
    storeCaret(dom);
}

function rcxCodeList(id) {
    var bbopen = "[list]";
    var bbclose = "[/list]";
    var dom = rcxGetElementById(id);
    insertBB(dom, bbopen, bbclose);
    storeCaret(dom);
}

function rcxCodeHr(id) {
    var dom = rcxGetElementById(id);
    dom.value += "[hr]";
}

function rcxCodeRight(id) {
    var bbopen = "[right]";
    var bbclose = "[/right]";
    var dom = rcxGetElementById(id);
    insertBB(dom, bbopen, bbclose);
    storeCaret(dom);
}

function rcxCodeCenter(id) {
    var bbopen = "[center]";
    var bbclose = "[/center]";
    var dom = rcxGetElementById(id);
    insertBB(dom, bbopen, bbclose);
    storeCaret(dom);
}

function rcxCodeLeft(id) {
    var bbopen = "[left]";
    var bbclose = "[/left]";
    var dom = rcxGetElementById(id);
    insertBB(dom, bbopen, bbclose);
    storeCaret(dom);
}

function rcxCodeJustify(id) {
    var bbopen = "[justify]";
    var bbclose = "[/justify]";
    var dom = rcxGetElementById(id);
    insertBB(dom, bbopen, bbclose);
    storeCaret(dom);
}

function rcxCodeMarqd(id) {
    var bbopen = "[marqd]";
    var bbclose = "[/marqd]";
    var dom = rcxGetElementById(id);
    insertBB(dom, bbopen, bbclose);
    storeCaret(dom);
}

function rcxCodeMarqu(id) {
    var bbopen = "[marqu]";
    var bbclose = "[/marqu]";
    var dom = rcxGetElementById(id);
    insertBB(dom, bbopen, bbclose);
    storeCaret(dom);
}

function rcxCodeMarql(id) {
    var bbopen = "[marql]";
    var bbclose = "[/marql]";
    var dom = rcxGetElementById(id);
    insertBB(dom, bbopen, bbclose);
    storeCaret(dom);
}

function rcxCodeMarqr(id) {
    var bbopen = "[marqr]";
    var bbclose = "[/marqr]";
    var dom = rcxGetElementById(id);
    insertBB(dom, bbopen, bbclose);
    storeCaret(dom);
}

function rcxCodeMarqh(id) {
    var bbopen = "[marqh]";
    var bbclose = "[/marqh]";
    var dom = rcxGetElementById(id);
    insertBB(dom, bbopen, bbclose);
    storeCaret(dom);
}

function rcxCodeMarqv(id) {
    var bbopen = "[marqv]";
    var bbclose = "[/marqv]";
    var dom = rcxGetElementById(id);
    insertBB(dom, bbopen, bbclose);
    storeCaret(dom);
}

function rcxCodeUrl(id) {
    var text = prompt(enterUrl, "");
    var dom = rcxGetElementById(id);

    if (text != null && text != "") {
        var text2 = prompt(enterWebTitle, "");
        if (text2 != null) {
            if (text2 == "") {
                var result = "[url=" + text + "]" + text + "[/url]";
            } else {
                var result = "[url=" + text + "]" + text2 + "[/url]";
            }
            dom.focus();
            dom.value += result;
        }
    }
}

function rcxCodeImg(id) {
    var dom = rcxGetElementById(id);
    var text = prompt(enterImgUrl, "");

    if (text != null && text != "") {
        var text2 = prompt(enterImgPos + "\n" + imgPosRorl, "");
        while ((text2 != "") && (text2 != "r") && (text2 != "R") && (text2 != "l") && (text2 != "L") && (text2 != null)) {
            text2 = prompt(errorImgPos + "\n" + imgPosRorl, "");
        }
        if (text2 == "l" || text2 == "L") {
            text2 = " align=left";
        } else if (text2 == "r" || text2 == "R") {
            text2 = " align=right";
        } else {
            text2 = "";
        }
        var result = "[img" + text2 + "]" + text + "[/img]";
        dom.focus();
        dom.value += result;
    }
}

function rcxCodeEmail(id) {
    var text = prompt(enterEmail, "");
    var dom = rcxGetElementById(id);

    if (text != null && text != "") {
        var result = "[email]" + text + "[/email]";
        dom.focus();
        dom.value += result;
    }
}

function rcxCodeQuote(id) {
    var bbopen = "[quote]";
    var bbclose = "[/quote]";
    var dom = rcxGetElementById(id);
    insertBB(dom, bbopen, bbclose);
    storeCaret(dom);
}

function rcxCodeCode(id) {
    var bbopen = "[code]";
    var bbclose = "[/code]";
    var dom = rcxGetElementById(id);
    insertBB(dom, bbopen, bbclose);
    storeCaret(dom);
}

function rcxCodeSize(id) {
    var sizeDom = rcxGetElementById(id + "Size");
    var sizeDomValue = sizeDom.options[sizeDom.options.selectedIndex].value;

    var bbopen = "[size=" + sizeDomValue + "]";
    var bbclose = "[/size]";
    var dom = rcxGetElementById(id);
    insertBB(dom, bbopen, bbclose);
    storeCaret(dom);

}

function rcxCodeFont(id) {
    var fontDom = rcxGetElementById(id + "Font");
    var fontDomValue = fontDom.options[fontDom.options.selectedIndex].value;

    var bbopen = "[font=" + fontDomValue + "]";
    var bbclose = "[/font]";
    var dom = rcxGetElementById(id);
    insertBB(dom, bbopen, bbclose);
    storeCaret(dom);
}

function rcxCodeColor(id) {
    var colorDom = rcxGetElementById(id + "Color");
    var colorDomValue = colorDom.options[colorDom.options.selectedIndex].value;

    var bbopen = "[color=" + colorDomValue + "]";
    var bbclose = "[/color]";
    var dom = rcxGetElementById(id);
    insertBB(dom, bbopen, bbclose);
    storeCaret(dom);
}

function rcxCodeSmilie(id, smilieCode) {
    var textareaDom = rcxGetElementById(id);

    textareaDom.focus();
    textareaDom.value += smilieCode;
}

function rcxValidate(subjectId, textareaId, submitId) {
    var maxchars = 65535;
    var subjectDom = rcxGetElementById(subjectId);
    var textareaDom = rcxGetElementById(textareaId);
    var submitDom = rcxGetElementById(submitId);

    if (textareaDom.value == "") {
        alert(plzComplete);
        textareaDom.focus();
        return false;
    }

    if (subjectDom.value == "") {
        alert(plzComplete);
        subjectDom.focus();
        return false;
    }

    if (maxchars != 0) {
        if (textareaDom.value.length > maxchars) {
            alert(messageTooLong + "\n\n" + allowEdChar + maxchars + "\n" + currChar + textareaDom.value.length + "");
            textareaDom.focus();
            return false;
        } else {
            submitDom.disabled = true;
            return true;
        }
    } else {
        submitDom.disabled = true;
        return true;
    }
}