
function scJQGeneralAdd() {
  scLoadScInput('input:text.sc-js-input');
  scLoadScInput('input:password.sc-js-input');
  scLoadScInput('input:checkbox.sc-js-input');
  scLoadScInput('input:radio.sc-js-input');
  scLoadScInput('select.sc-js-input');
  scLoadScInput('textarea.sc-js-input');

} // scJQGeneralAdd

function scFocusField(sField) {
  var $oField = $('#id_sc_field_' + sField);

  if (0 == $oField.length) {
    $oField = $('input[name=' + sField + ']');
  }

  if (0 == $oField.length && document.F1.elements[sField]) {
    $oField = $(document.F1.elements[sField]);
  }

  if (false == scSetFocusOnField($oField) && $("#id_ac_" + sField).length > 0) {
    if (false == scSetFocusOnField($("#id_ac_" + sField))) {
      setTimeout(function() { scSetFocusOnField($("#id_ac_" + sField)); }, 500);
    }
  }
  else {
    setTimeout(function() { scSetFocusOnField($oField); }, 500);
  }
} // scFocusField

function scSetFocusOnField($oField) {
  if ($oField.length > 0 && $oField[0].offsetHeight > 0 && $oField[0].offsetWidth > 0 && !$oField[0].disabled) {
    $oField[0].focus();
    return true;
  }
  return false;
} // scSetFocusOnField

function scEventControl_init(iSeqRow) {
  scEventControl_data["dependencia_descripcion" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["dependencia_estado" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
}

function scEventControl_active(iSeqRow) {
  if (scEventControl_data["dependencia_descripcion" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["dependencia_descripcion" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["dependencia_estado" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["dependencia_estado" + iSeqRow]["change"]) {
    return true;
  }
  return false;
} // scEventControl_active

function scEventControl_onFocus(oField, iSeq) {
  var fieldId, fieldName;
  fieldId = $(oField).attr("id");
  fieldName = fieldId.substr(12);
  scEventControl_data[fieldName]["blur"] = true;
  if ("dependencia_estado" + iSeq == fieldName) {
    scEventControl_data[fieldName]["blur"] = false;
  }
  scEventControl_data[fieldName]["change"] = false;
} // scEventControl_onFocus

function scEventControl_onBlur(sFieldName) {
  scEventControl_data[sFieldName]["blur"] = false;
  if (scEventControl_data[sFieldName]["change"]) {
        if (scEventControl_data[sFieldName]["original"] == $("#id_sc_field_" + sFieldName).val() || scEventControl_data[sFieldName]["calculated"] == $("#id_sc_field_" + sFieldName).val()) {
          scEventControl_data[sFieldName]["change"] = false;
        }
  }
} // scEventControl_onBlur

function scEventControl_onChange(sFieldName) {
  scEventControl_data[sFieldName]["change"] = false;
} // scEventControl_onChange

function scEventControl_onAutocomp(sFieldName) {
  scEventControl_data[sFieldName]["autocomp"] = false;
} // scEventControl_onChange

var scEventControl_data = {};

function scJQEventsAdd(iSeqRow) {
  $('#id_sc_field_dependencia_descripcion' + iSeqRow).bind('blur', function() { sc_form_dependencia_dependencia_descripcion_onblur(this, iSeqRow) })
                                                     .bind('focus', function() { sc_form_dependencia_dependencia_descripcion_onfocus(this, iSeqRow) });
  $('#id_sc_field_dependencia_estado' + iSeqRow).bind('blur', function() { sc_form_dependencia_dependencia_estado_onblur(this, iSeqRow) })
                                                .bind('focus', function() { sc_form_dependencia_dependencia_estado_onfocus(this, iSeqRow) });
} // scJQEventsAdd

function sc_form_dependencia_dependencia_descripcion_onblur(oThis, iSeqRow) {
  do_ajax_form_dependencia_validate_dependencia_descripcion();
  scCssBlur(oThis);
}

function sc_form_dependencia_dependencia_descripcion_onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis);
}

function sc_form_dependencia_dependencia_estado_onblur(oThis, iSeqRow) {
  do_ajax_form_dependencia_validate_dependencia_estado();
  scCssBlur(oThis);
}

function sc_form_dependencia_dependencia_estado_onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis);
}

function displayChange_block(block, status) {
	if ("0" == block) {
		displayChange_block_0(status);
	}
}

function displayChange_block_0(status) {
	displayChange_field("dependencia_descripcion", "", status);
	displayChange_field("dependencia_estado", "", status);
}

function displayChange_row(row, status) {
	displayChange_field_dependencia_descripcion(row, status);
	displayChange_field_dependencia_estado(row, status);
}

function displayChange_field(field, row, status) {
	if ("dependencia_descripcion" == field) {
		displayChange_field_dependencia_descripcion(row, status);
	}
	if ("dependencia_estado" == field) {
		displayChange_field_dependencia_estado(row, status);
	}
}

function displayChange_field_dependencia_descripcion(row, status) {
}

function displayChange_field_dependencia_estado(row, status) {
}

function scResetPagesDisplay() {
	$(".sc-form-page").show();
}

function scHidePage(pageNo) {
	$("#id_form_dependencia_form" + pageNo).hide();
}

function scCheckNoPageSelected() {
	if (!$(".sc-form-page").filter(".scTabActive").filter(":visible").length) {
		var inactiveTabs = $(".sc-form-page").filter(".scTabInactive").filter(":visible");
		if (inactiveTabs.length) {
			var tabNo = $(inactiveTabs[0]).attr("id").substr(24);
		}
	}
}
function scJQUploadAdd(iSeqRow) {
} // scJQUploadAdd

function scJQSelect2Add(seqRow, specificField) {
} // scJQSelect2Add


function scJQElementsAdd(iLine) {
  scJQEventsAdd(iLine);
  scEventControl_init(iLine);
  scJQUploadAdd(iLine);
  scJQSelect2Add(iLine);
} // scJQElementsAdd

