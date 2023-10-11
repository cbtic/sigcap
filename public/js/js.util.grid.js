
function fn_util_obtieneNroPagina(iDisplayStart, iDisplayLength) {
    var start = (iDisplayStart == 0 ? 1 : iDisplayStart);
    return (start / iDisplayLength) + 1;
}


function fn_util_LineaDatatable(poTable) {
    $(poTable + ' tbody').on('click', 'tr', function () {
        if ($(this).hasClass('row_selected')) {
            //$(this).removeClass('row_selected');
        } else {
            var odtableAyu = $(poTable).dataTable();
            odtableAyu.$('tr.row_selected').removeClass('row_selected');
            $(this).addClass('row_selected');
        }
    });
}


function fn_util_ObtenerNumeroFila(poTable) {
    var aReturn = new Array();
    var aTrs = poTable.fnGetNodes();

    for (var i = 0; i < aTrs.length; i++) {
        if ($(aTrs[i]).hasClass('row_selected')) {
            aReturn.push(aTrs[i]);
        }
    }
    return aReturn;
}


function fn_util_ConvertirFecha(psFecha) {
    var date = '';
    if (psFecha != '') {
        var iNumero = parseInt(psFecha.replace(/[^0-9]/g, ''));

        var fecha = new Date(iNumero);
        var day = fecha.getDate();
        var month = fecha.getMonth() + 1;
        var year = fecha.getFullYear();
        if (day < 10) {
            day = "0" + day;
        }
        if (month < 10) {
            month = "0" + month;
        }

        date = day + "/" + month + "/" + year;
    }
    return date;
}


function fn_util_CrearInputGrilla(pType, pName, pId, pValue, pOnclick, pClass, pStyle, pMaxlength, pWidth, pOtro) {
    var vInput = "";

    vInput = "<input ";
    vInput += "type=\"" + pType + "\" ";
    vInput += "name=\"" + pName + "\" ";
    vInput += "id=\"" + pId + "\" ";
    if (pValue != "") vInput += "value=\"" + pValue + "\" ";
    if (pOnclick != "") vInput += "onclick=\"" + pOnclick + "\" ";
    if (pClass != "") vInput += "class=\"" + pClass + "\" ";
    if (pStyle != "") vInput += "style=\"" + pStyle + "\" ";
    if (pMaxlength != "") vInput += "maxlength=\"" + pMaxlength + "\" ";
    if (pWidth != "") vInput += "width=\"" + pWidth + "\" ";
    if (pOtro != "") vInput += "" + pOtro + " ";
    vInput += "/>";

    return vInput;
}


function fn_util_CrearComboGrilla(pName, pId, pOpciones, pOnclick, pClass, pStyle, pOtro) {
    var vInput = "";

    vInput = "<select ";
    vInput += "name=\"" + pName + "\" ";
    vInput += "id=\"" + pId + "\" ";
    if (pOnclick != "") vInput += "onclick=\"" + pOnclick + "\" ";
    if (pClass != "") vInput += "class=\"" + pClass + "\" ";
    if (pStyle != "") vInput += "style=\"" + pStyle + "\" ";
    if (pOtro != "") vInput += "" + pOtro + " ";
    vInput += "/>";
    vInput += "" + pOpciones + "";
    vInput += "</select>";

    return vInput;
}


function fn_Ordenar_ColumnaDatatable(poTable) {
    setTimeout(function () {
        poTable.fnAdjustColumnSizing();
    }, 10);
}


function fn_util_CrearSelect(pName, pId, pClass, pStyle, pLista, pCodigo, pValor, pData, pTipo, pOtro) {
    var strHtml = "<center><select id='" + pId + "' name='" + pName + "'" +
                    "style='" + pStyle + "'  class='" + pClass + "' " + pOtro + " >";

    $.each(pLista, function () {
        var sTexto = '';
        if (pTipo == 1) {
            sTexto = this[pValor];
        } else if (pTipo == 2) {
            sTexto = this[pCodigo] + " - " + this[pValor];
        }

        if (this[pCodigo] == pData) {
            strHtml = strHtml + '<option value="' + this[pCodigo] + '" selected="selected" >' + sTexto + '</option>';
        } else {
            strHtml = strHtml + '<option value="' + this[pCodigo] + '">' + sTexto + '</option>';
        }
    });

    strHtml = strHtml + "</select></center>";
    return strHtml;
}

function fn_Llenar_Combo(pNombre, pLista, pCodigo, pValor, data, pAtributos) {
    var strHtml = "<center><select id='" + pNombre + "' class='css_campos' " + pAtributos + ">";
    $.each(pLista, function () {
        if (this[pCodigo] == data) {
            strHtml = strHtml + '<option value="' + this[pCodigo] + '" selected="selected" >' + this[pValor] + '</option>';
        } else {
            strHtml = strHtml + '<option value="' + this[pCodigo] + '">' + this[pValor] + '</option>';
        }
    });
    strHtml = strHtml + "</select></center>";
    return strHtml;
}

function fn_Llenar_ComboConCodigo(pNombre, pLista, pCodigo, pValor, data, pAtributos) {
    var strHtml = " <select id='" + pNombre + "' class='css_campos' " + pAtributos + ">";
    $.each(pLista, function () {
        if (this[pCodigo] == data) {
            strHtml = strHtml + '<option value="' + this[pCodigo] + '" selected="selected" >' + this[pCodigo] + " - " + this[pValor] + '</option>';
        } else {
            strHtml = strHtml + '<option value="' + this[pCodigo] + '">' + this[pCodigo] + " - " + this[pValor] + '</option>';
        }
    });
    strHtml = strHtml + "</select>";
    return strHtml;
}


function fn_util_CrearInputCheckbox(pName, pId, pClass, pStyle, pCodigo, pValor, pCorrecto, pOtro) {
    var strHtml = '<center>';
    if (pValor == pCorrecto) {
        strHtml = strHtml + "<input id='" + pId + "' name='" + pName + "' type='checkbox' " +
            "style='" + pStyle + "'  class='" + pClass + "' value='" + pCodigo +
            "' checked " + pOtro + "  />";
    } else {
        strHtml = strHtml + "<input id='" + pId + "' name='" + pName + "' type='checkbox' " +
          "style='" + pStyle + "'  class='" + pClass + "' value='" + pCodigo +
          "' " + pOtro + "  />";
        
    }
    strHtml = strHtml + "</center>";
    return strHtml;
}


