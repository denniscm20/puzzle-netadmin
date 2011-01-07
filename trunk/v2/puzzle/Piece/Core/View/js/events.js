/*
 * View/js/events.js - Copyright 2010 Dennis Cohn Muroy
 *
 * This file is part of puzzle.
 *
 * tiny-weblog is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * tiny-weblog is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with puzzle.  If not, see <http://www.gnu.org/licenses/>.
 */

function showHide(id)
{
    element = document.getElementById(id);
    visible = element.style.visibility;
    if (visible == "hidden") {
        element.style.visibility = "visible";
        element.style.height = "";
    } else {
        element.style.visibility = "hidden";
        element.style.height = "0px";
    }
    return false;
}

function evtSubmit(formId, eventValue, idValue)
{
    form = document.getElementById(formId);
    $("#id").val(idValue);
    $("#event").val(eventValue);
    form.submit();
}

function evtSearch(formId) {
    evtSubmit(formId, "search", "");
}

function evtDelete(formId) {
    evtSubmit(formId, "delete", "");
}

function next()
{

}

function prev()
{
    
}

function evtTextFocus(id, defaultText)
{
    id = "#"+id;
    if ($(id).val() == defaultText) {
        $(id).val("");
    }
}

function evtTextBlur(id, defaultText)
{
    id = "#"+id;
    if ($(id).val() == "") {
        $(id).val(defaultText);
    }
}
