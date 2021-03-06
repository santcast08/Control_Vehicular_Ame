
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
  scEventControl_data["idtipo_mantenimiento" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["tipo" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["tipo_mantenimiento_descripcion" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["tipo_mantenimiento_estado" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["vehiculos_idvehiculo" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
}

function scEventControl_active(iSeqRow) {
  if (scEventControl_data["idtipo_mantenimiento" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["idtipo_mantenimiento" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["tipo" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["tipo" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["tipo_mantenimiento_descripcion" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["tipo_mantenimiento_descripcion" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["tipo_mantenimiento_estado" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["tipo_mantenimiento_estado" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["vehiculos_idvehiculo" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["vehiculos_idvehiculo" + iSeqRow]["change"]) {
    return true;
  }
  return false;
} // scEventControl_active

function scEventControl_onFocus(oField, iSeq) {
  var fieldId, fieldName;
  fieldId = $(oField).attr("id");
  fieldName = fieldId.substr(12);
  scEventControl_data[fieldName]["blur"] = true;
  if ("tipo_mantenimiento_estado" + iSeq == fieldName) {
    scEventControl_data[fieldName]["blur"] = false;
  }
  if ("vehiculos_idvehiculo" + iSeq == fieldName) {
    scEventControl_data[fieldName]["blur"] = false;
  }
  if ("listado" + iSeq == fieldName) {
    scEventControl_data[fieldName]["blur"] = false;
  }
  if ("listado_c" + iSeq == fieldName) {
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
  $('#id_sc_field_idtipo_mantenimiento' + iSeqRow).bind('blur', function() { sc_form_tipo_mantenimiento_idtipo_mantenimiento_onblur(this, iSeqRow) })
                                                  .bind('focus', function() { sc_form_tipo_mantenimiento_idtipo_mantenimiento_onfocus(this, iSeqRow) });
  $('#id_sc_field_tipo' + iSeqRow).bind('blur', function() { sc_form_tipo_mantenimiento_tipo_onblur(this, iSeqRow) })
                                  .bind('focus', function() { sc_form_tipo_mantenimiento_tipo_onfocus(this, iSeqRow) });
  $('#id_sc_field_tipo_mantenimiento_descripcion' + iSeqRow).bind('blur', function() { sc_form_tipo_mantenimiento_tipo_mantenimiento_descripcion_onblur(this, iSeqRow) })
                                                            .bind('focus', function() { sc_form_tipo_mantenimiento_tipo_mantenimiento_descripcion_onfocus(this, iSeqRow) });
  $('#id_sc_field_tipo_mantenimiento_estado' + iSeqRow).bind('blur', function() { sc_form_tipo_mantenimiento_tipo_mantenimiento_estado_onblur(this, iSeqRow) })
                                                       .bind('focus', function() { sc_form_tipo_mantenimiento_tipo_mantenimiento_estado_onfocus(this, iSeqRow) });
  $('#id_sc_field_vehiculos_idvehiculo' + iSeqRow).bind('blur', function() { sc_form_tipo_mantenimiento_vehiculos_idvehiculo_onblur(this, iSeqRow) })
                                                  .bind('focus', function() { sc_form_tipo_mantenimiento_vehiculos_idvehiculo_onfocus(this, iSeqRow) });
} // scJQEventsAdd

function sc_form_tipo_mantenimiento_idtipo_mantenimiento_onblur(oThis, iSeqRow) {
  do_ajax_form_tipo_mantenimiento_mob_validate_idtipo_mantenimiento();
  scCssBlur(oThis);
}

function sc_form_tipo_mantenimiento_idtipo_mantenimiento_onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis);
}

function sc_form_tipo_mantenimiento_tipo_onblur(oThis, iSeqRow) {
  do_ajax_form_tipo_mantenimiento_mob_validate_tipo();
  scCssBlur(oThis);
}

function sc_form_tipo_mantenimiento_tipo_onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis);
}

function sc_form_tipo_mantenimiento_tipo_mantenimiento_descripcion_onblur(oThis, iSeqRow) {
  do_ajax_form_tipo_mantenimiento_mob_validate_tipo_mantenimiento_descripcion();
  scCssBlur(oThis);
}

function sc_form_tipo_mantenimiento_tipo_mantenimiento_descripcion_onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis);
}

function sc_form_tipo_mantenimiento_tipo_mantenimiento_estado_onblur(oThis, iSeqRow) {
  do_ajax_form_tipo_mantenimiento_mob_validate_tipo_mantenimiento_estado();
  scCssBlur(oThis);
}

function sc_form_tipo_mantenimiento_tipo_mantenimiento_estado_onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis);
}

function sc_form_tipo_mantenimiento_vehiculos_idvehiculo_onblur(oThis, iSeqRow) {
  do_ajax_form_tipo_mantenimiento_mob_validate_vehiculos_idvehiculo();
  scCssBlur(oThis);
}

function sc_form_tipo_mantenimiento_vehiculos_idvehiculo_onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis);
}

function displayChange_block(block, status) {
	if ("0" == block) {
		displayChange_block_0(status);
	}
}

function displayChange_block_0(status) {
	displayChange_field("idTipo_Mantenimiento", "", status);
	displayChange_field("Tipo", "", status);
	displayChange_field("tipo_mantenimiento_descripcion", "", status);
	displayChange_field("tipo_mantenimiento_estado", "", status);
	displayChange_field("vehiculos_IdVehiculo", "", status);
}

function displayChange_row(row, status) {
	displayChange_field_idtipo_mantenimiento(row, status);
	displayChange_field_tipo(row, status);
	displayChange_field_tipo_mantenimiento_descripcion(row, status);
	displayChange_field_tipo_mantenimiento_estado(row, status);
	displayChange_field_vehiculos_idvehiculo(row, status);
}

function displayChange_field(field, row, status) {
	if ("idtipo_mantenimiento" == field) {
		displayChange_field_idtipo_mantenimiento(row, status);
	}
	if ("tipo" == field) {
		displayChange_field_tipo(row, status);
	}
	if ("tipo_mantenimiento_descripcion" == field) {
		displayChange_field_tipo_mantenimiento_descripcion(row, status);
	}
	if ("tipo_mantenimiento_estado" == field) {
		displayChange_field_tipo_mantenimiento_estado(row, status);
	}
	if ("vehiculos_idvehiculo" == field) {
		displayChange_field_vehiculos_idvehiculo(row, status);
	}
}

function displayChange_field_idtipo_mantenimiento(row, status) {
}

function displayChange_field_tipo(row, status) {
}

function displayChange_field_tipo_mantenimiento_descripcion(row, status) {
}

function displayChange_field_tipo_mantenimiento_estado(row, status) {
}

function displayChange_field_vehiculos_idvehiculo(row, status) {
	if ("on" == status) {
		$("#id_sc_field_vehiculos_idvehiculo" + row).select2("destroy");
		scJQSelect2Add(row, "vehiculos_idvehiculo");
	}
}

function scResetPagesDisplay() {
	$(".sc-form-page").show();
}

function scHidePage(pageNo) {
	$("#id_form_tipo_mantenimiento_mob_form" + pageNo).hide();
}

function scCheckNoPageSelected() {
	if (!$(".sc-form-page").filter(".scTabActive").filter(":visible").length) {
		var inactiveTabs = $(".sc-form-page").filter(".scTabInactive").filter(":visible");
		if (inactiveTabs.length) {
			var tabNo = $(inactiveTabs[0]).attr("id").substr(35);
		}
	}
}
function scJQUploadAdd(iSeqRow) {
} // scJQUploadAdd

function scJQSelect2Add(seqRow, specificField) {
  if (null == specificField || "vehiculos_idvehiculo" == specificField) {
    scJQSelect2Add_vehiculos_idvehiculo(seqRow);
  }
} // scJQSelect2Add

function scJQSelect2Add_vehiculos_idvehiculo(seqRow) {
  $("#id_sc_field_vehiculos_idvehiculo" + seqRow).select2(
    {
      language: {
        noResults: function() {
          return "<?php echo $this->Ini->Nm_lang['lang_autocomp_notfound'] ?>";
        },
        searching: function() {
          return "<?php echo $this->Ini->Nm_lang['lang_autocomp_searching'] ?>";
        }
      }
    }
  );
} // scJQSelect2Add


function scJQElementsAdd(iLine) {
  scJQEventsAdd(iLine);
  scEventControl_init(iLine);
  scJQUploadAdd(iLine);
  scJQSelect2Add(iLine);
} // scJQElementsAdd

var scBtnGrpStatus = {};
function scBtnGrpShow(sGroup) {
  if (typeof(scBtnGrpShowMobile) === typeof(function(){})) { return scBtnGrpShowMobile(sGroup); };
  var btnPos = $('#sc_btgp_btn_' + sGroup).offset();
  scBtnGrpStatus[sGroup] = 'open';
  $('#sc_btgp_btn_' + sGroup).mouseout(function() {
    scBtnGrpStatus[sGroup] = '';
    setTimeout(function() {
      scBtnGrpHide(sGroup);
    }, 1000);
  }).mouseover(function() {
    scBtnGrpStatus[sGroup] = 'over';
  });
  $('#sc_btgp_div_' + sGroup + ' span a').click(function() {
    scBtnGrpStatus[sGroup] = 'out';
    scBtnGrpHide(sGroup);
  });
  $('#sc_btgp_div_' + sGroup).css({
    'left': btnPos.left
  })
  .mouseover(function() {
    scBtnGrpStatus[sGroup] = 'over';
  })
  .mouseleave(function() {
    scBtnGrpStatus[sGroup] = 'out';
    setTimeout(function() {
      scBtnGrpHide(sGroup);
    }, 1000);
  })
  .show('fast');
}
function scBtnGrpHide(sGroup) {
  if ('over' != scBtnGrpStatus[sGroup]) {
    $('#sc_btgp_div_' + sGroup).hide('fast');
  }
}
