// script: autofocus.js
// desc: autofocus form
function focusElement(sForm, sElement)
{
        var f, e;
        if (document && document.forms && (f = document.forms[sForm]) && f.elements && (e = f.elements[sElement]) && e.focus)
        {
                e.focus();
        }
}