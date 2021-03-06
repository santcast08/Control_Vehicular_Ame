<?php

class grid_usuario_rtf
{
   var $Db;
   var $Erro;
   var $Ini;
   var $Lookup;
   var $nm_data;
   var $Texto_tag;
   var $Arquivo;
   var $Tit_doc;
   var $sc_proc_grid; 
   var $NM_cmp_hidden = array();

   //---- 
   function __construct()
   {
      $this->nm_data   = new nm_data("es");
      $this->Texto_tag = "";
   }

   //---- 
   function monta_rtf()
   {
      $this->inicializa_vars();
      $this->gera_texto_tag();
      $this->grava_arquivo_rtf();
      if ($this->Ini->sc_export_ajax)
      {
          $this->Arr_result['file_export']  = NM_charset_to_utf8($this->Rtf_f);
          $this->Arr_result['title_export'] = NM_charset_to_utf8($this->Tit_doc);
          $Temp = ob_get_clean();
          if ($Temp !== false && trim($Temp) != "")
          {
              $this->Arr_result['htmOutput'] = NM_charset_to_utf8($Temp);
          }
          $oJson = new Services_JSON();
          echo $oJson->encode($this->Arr_result);
          exit;
      }
      else
      {
          $this->monta_html();
      }
   }

   //----- 
   function inicializa_vars()
   {
      global $nm_lang;
      $dir_raiz          = strrpos($_SERVER['PHP_SELF'],"/") ;  
      $dir_raiz          = substr($_SERVER['PHP_SELF'], 0, $dir_raiz + 1) ;  
      $this->nm_location = $this->Ini->sc_protocolo . $this->Ini->server . $dir_raiz; 
      $this->Arquivo    = "sc_rtf";
      $this->Arquivo   .= "_" . date("YmdHis") . "_" . rand(0, 1000);
      $this->Arquivo   .= "_grid_usuario";
      $this->Arquivo   .= ".rtf";
      $this->Tit_doc    = "grid_usuario.rtf";
   }

   //----- 
   function gera_texto_tag()
   {
     global $nm_lang;
      global $nm_nada, $nm_lang;

      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      $this->sc_proc_grid = false; 
      $nm_raiz_img  = ""; 
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_usuario']['rtf_name']))
      {
          $this->Arquivo = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_usuario']['rtf_name'];
          $this->Tit_doc = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_usuario']['rtf_name'];
          unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_usuario']['rtf_name']);
      }
      if (isset($_SESSION['scriptcase']['sc_apl_conf']['grid_usuario']['field_display']) && !empty($_SESSION['scriptcase']['sc_apl_conf']['grid_usuario']['field_display']))
      {
          foreach ($_SESSION['scriptcase']['sc_apl_conf']['grid_usuario']['field_display'] as $NM_cada_field => $NM_cada_opc)
          {
              $this->NM_cmp_hidden[$NM_cada_field] = $NM_cada_opc;
          }
      }
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_usuario']['usr_cmp_sel']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_usuario']['usr_cmp_sel']))
      {
          foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_usuario']['usr_cmp_sel'] as $NM_cada_field => $NM_cada_opc)
          {
              $this->NM_cmp_hidden[$NM_cada_field] = $NM_cada_opc;
          }
      }
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_usuario']['php_cmp_sel']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_usuario']['php_cmp_sel']))
      {
          foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_usuario']['php_cmp_sel'] as $NM_cada_field => $NM_cada_opc)
          {
              $this->NM_cmp_hidden[$NM_cada_field] = $NM_cada_opc;
          }
      }
      $this->sc_where_orig   = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_usuario']['where_orig'];
      $this->sc_where_atual  = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_usuario']['where_pesq'];
      $this->sc_where_filtro = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_usuario']['where_pesq_filtro'];
      $this->arr_export = array('label' => array(), 'lines' => array());
      $this->arr_span   = array();
      $this->count_span = 0;

      $this->Texto_tag .= "<table>\r\n";
      $this->Texto_tag .= "<tr>\r\n";
      foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_usuario']['field_order'] as $Cada_col)
      { 
          $SC_Label = (isset($this->New_label['usuario_cedula'])) ? $this->New_label['usuario_cedula'] : "Cedula"; 
          if ($Cada_col == "usuario_cedula" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = sc_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['usuario_nombres'])) ? $this->New_label['usuario_nombres'] : "Nombres"; 
          if ($Cada_col == "usuario_nombres" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = sc_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['usuario_apellidos'])) ? $this->New_label['usuario_apellidos'] : "Apellidos"; 
          if ($Cada_col == "usuario_apellidos" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = sc_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['usuario_correo'])) ? $this->New_label['usuario_correo'] : "Correo"; 
          if ($Cada_col == "usuario_correo" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = sc_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['usuario_cargo'])) ? $this->New_label['usuario_cargo'] : "Cargo"; 
          if ($Cada_col == "usuario_cargo" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = sc_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['usuario_dependencia'])) ? $this->New_label['usuario_dependencia'] : "Dependencia"; 
          if ($Cada_col == "usuario_dependencia" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = sc_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['usuario_estado'])) ? $this->New_label['usuario_estado'] : "Estado"; 
          if ($Cada_col == "usuario_estado" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = sc_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['idusuario'])) ? $this->New_label['idusuario'] : "Idusuario"; 
          if ($Cada_col == "idusuario" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = sc_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
      } 
      $this->Texto_tag .= "</tr>\r\n";
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_usuario']['campos_busca']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_usuario']['campos_busca']))
      { 
          $Busca_temp = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_usuario']['campos_busca'];
          if ($_SESSION['scriptcase']['charset'] != "UTF-8")
          {
              $Busca_temp = NM_conv_charset($Busca_temp, $_SESSION['scriptcase']['charset'], "UTF-8");
          }
          $this->idusuario = $Busca_temp['idusuario']; 
          $tmp_pos = strpos($this->idusuario, "##@@");
          if ($tmp_pos !== false && !is_array($this->idusuario))
          {
              $this->idusuario = substr($this->idusuario, 0, $tmp_pos);
          }
          $this->usuario_cedula = $Busca_temp['usuario_cedula']; 
          $tmp_pos = strpos($this->usuario_cedula, "##@@");
          if ($tmp_pos !== false && !is_array($this->usuario_cedula))
          {
              $this->usuario_cedula = substr($this->usuario_cedula, 0, $tmp_pos);
          }
          $this->usuario_nombres = $Busca_temp['usuario_nombres']; 
          $tmp_pos = strpos($this->usuario_nombres, "##@@");
          if ($tmp_pos !== false && !is_array($this->usuario_nombres))
          {
              $this->usuario_nombres = substr($this->usuario_nombres, 0, $tmp_pos);
          }
          $this->usuario_apellidos = $Busca_temp['usuario_apellidos']; 
          $tmp_pos = strpos($this->usuario_apellidos, "##@@");
          if ($tmp_pos !== false && !is_array($this->usuario_apellidos))
          {
              $this->usuario_apellidos = substr($this->usuario_apellidos, 0, $tmp_pos);
          }
      } 
      $this->nm_field_dinamico = array();
      $this->nm_order_dinamico = array();
      if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_sybase))
      { 
          $nmgp_select = "SELECT usuario_cedula, usuario_nombres, usuario_apellidos, usuario_correo, usuario_cargo, usuario_dependencia, usuario_estado, idusuario from " . $this->Ini->nm_tabela; 
      } 
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mysql))
      { 
          $nmgp_select = "SELECT usuario_cedula, usuario_nombres, usuario_apellidos, usuario_correo, usuario_cargo, usuario_dependencia, usuario_estado, idusuario from " . $this->Ini->nm_tabela; 
      } 
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
      { 
       $nmgp_select = "SELECT usuario_cedula, usuario_nombres, usuario_apellidos, usuario_correo, usuario_cargo, usuario_dependencia, usuario_estado, idusuario from " . $this->Ini->nm_tabela; 
      } 
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_oracle))
      { 
          $nmgp_select = "SELECT usuario_cedula, usuario_nombres, usuario_apellidos, usuario_correo, usuario_cargo, usuario_dependencia, usuario_estado, idusuario from " . $this->Ini->nm_tabela; 
      } 
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_informix))
      { 
          $nmgp_select = "SELECT usuario_cedula, usuario_nombres, usuario_apellidos, usuario_correo, usuario_cargo, usuario_dependencia, usuario_estado, idusuario from " . $this->Ini->nm_tabela; 
      } 
      else 
      { 
          $nmgp_select = "SELECT usuario_cedula, usuario_nombres, usuario_apellidos, usuario_correo, usuario_cargo, usuario_dependencia, usuario_estado, idusuario from " . $this->Ini->nm_tabela; 
      } 
      $nmgp_select .= " " . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_usuario']['where_pesq'];
      $nmgp_order_by = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_usuario']['order_grid'];
      $nmgp_select .= $nmgp_order_by; 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nmgp_select;
      $rs = $this->Db->Execute($nmgp_select);
      if ($rs === false && !$rs->EOF && $GLOBALS["NM_ERRO_IBASE"] != 1)
      {
         $this->Erro->mensagem(__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg());
         exit;
      }
      $this->SC_seq_register = 0;
      while (!$rs->EOF)
      {
         $this->SC_seq_register++;
         $this->Texto_tag .= "<tr>\r\n";
         $this->usuario_cedula = $rs->fields[0] ;  
         $this->usuario_cedula = (string)$this->usuario_cedula;
         $this->usuario_nombres = $rs->fields[1] ;  
         $this->usuario_apellidos = $rs->fields[2] ;  
         $this->usuario_correo = $rs->fields[3] ;  
         $this->usuario_cargo = $rs->fields[4] ;  
         $this->usuario_dependencia = $rs->fields[5] ;  
         $this->usuario_estado = $rs->fields[6] ;  
         $this->idusuario = $rs->fields[7] ;  
         $this->idusuario = (string)$this->idusuario;
         //----- lookup - usuario_cargo
         $this->look_usuario_cargo = $this->usuario_cargo; 
         $this->Lookup->lookup_usuario_cargo($this->look_usuario_cargo, $this->usuario_cargo) ; 
         $this->look_usuario_cargo = ($this->look_usuario_cargo == "&nbsp;") ? "" : $this->look_usuario_cargo; 
         //----- lookup - usuario_dependencia
         $this->look_usuario_dependencia = $this->usuario_dependencia; 
         $this->Lookup->lookup_usuario_dependencia($this->look_usuario_dependencia, $this->usuario_dependencia) ; 
         $this->look_usuario_dependencia = ($this->look_usuario_dependencia == "&nbsp;") ? "" : $this->look_usuario_dependencia; 
         $this->sc_proc_grid = true; 
         foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_usuario']['field_order'] as $Cada_col)
         { 
            if (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off")
            { 
                $NM_func_exp = "NM_export_" . $Cada_col;
                $this->$NM_func_exp();
            } 
         } 
         $this->Texto_tag .= "</tr>\r\n";
         $rs->MoveNext();
      }
      $this->Texto_tag .= "</table>\r\n";
      if(isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_usuario']['export_sel_columns']['field_order']))
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_usuario']['field_order'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_usuario']['export_sel_columns']['field_order'];
          unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_usuario']['export_sel_columns']['field_order']);
      }
      if(isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_usuario']['export_sel_columns']['usr_cmp_sel']))
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_usuario']['usr_cmp_sel'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_usuario']['export_sel_columns']['usr_cmp_sel'];
          unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_usuario']['export_sel_columns']['usr_cmp_sel']);
      }
      $rs->Close();
   }
   //----- usuario_cedula
   function NM_export_usuario_cedula()
   {
         nmgp_Form_Num_Val($this->usuario_cedula, "", "", "0", "S", "2", "", "N:1", "-") ; 
         if (!NM_is_utf8($this->usuario_cedula))
         {
             $this->usuario_cedula = sc_convert_encoding($this->usuario_cedula, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         $this->usuario_cedula = str_replace('<', '&lt;', $this->usuario_cedula);
         $this->usuario_cedula = str_replace('>', '&gt;', $this->usuario_cedula);
         $this->Texto_tag .= "<td>" . $this->usuario_cedula . "</td>\r\n";
   }
   //----- usuario_nombres
   function NM_export_usuario_nombres()
   {
         $this->usuario_nombres = html_entity_decode($this->usuario_nombres, ENT_COMPAT, $_SESSION['scriptcase']['charset']);
         $this->usuario_nombres = strip_tags($this->usuario_nombres);
         if (!NM_is_utf8($this->usuario_nombres))
         {
             $this->usuario_nombres = sc_convert_encoding($this->usuario_nombres, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         $this->usuario_nombres = str_replace('<', '&lt;', $this->usuario_nombres);
         $this->usuario_nombres = str_replace('>', '&gt;', $this->usuario_nombres);
         $this->Texto_tag .= "<td>" . $this->usuario_nombres . "</td>\r\n";
   }
   //----- usuario_apellidos
   function NM_export_usuario_apellidos()
   {
         $this->usuario_apellidos = html_entity_decode($this->usuario_apellidos, ENT_COMPAT, $_SESSION['scriptcase']['charset']);
         $this->usuario_apellidos = strip_tags($this->usuario_apellidos);
         if (!NM_is_utf8($this->usuario_apellidos))
         {
             $this->usuario_apellidos = sc_convert_encoding($this->usuario_apellidos, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         $this->usuario_apellidos = str_replace('<', '&lt;', $this->usuario_apellidos);
         $this->usuario_apellidos = str_replace('>', '&gt;', $this->usuario_apellidos);
         $this->Texto_tag .= "<td>" . $this->usuario_apellidos . "</td>\r\n";
   }
   //----- usuario_correo
   function NM_export_usuario_correo()
   {
         $this->usuario_correo = html_entity_decode($this->usuario_correo, ENT_COMPAT, $_SESSION['scriptcase']['charset']);
         $this->usuario_correo = strip_tags($this->usuario_correo);
         if (!NM_is_utf8($this->usuario_correo))
         {
             $this->usuario_correo = sc_convert_encoding($this->usuario_correo, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         $this->usuario_correo = str_replace('<', '&lt;', $this->usuario_correo);
         $this->usuario_correo = str_replace('>', '&gt;', $this->usuario_correo);
         $this->Texto_tag .= "<td>" . $this->usuario_correo . "</td>\r\n";
   }
   //----- usuario_cargo
   function NM_export_usuario_cargo()
   {
         $this->look_usuario_cargo = html_entity_decode($this->look_usuario_cargo, ENT_COMPAT, $_SESSION['scriptcase']['charset']);
         $this->look_usuario_cargo = strip_tags($this->look_usuario_cargo);
         if (!NM_is_utf8($this->look_usuario_cargo))
         {
             $this->look_usuario_cargo = sc_convert_encoding($this->look_usuario_cargo, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         $this->look_usuario_cargo = str_replace('<', '&lt;', $this->look_usuario_cargo);
         $this->look_usuario_cargo = str_replace('>', '&gt;', $this->look_usuario_cargo);
         $this->Texto_tag .= "<td>" . $this->look_usuario_cargo . "</td>\r\n";
   }
   //----- usuario_dependencia
   function NM_export_usuario_dependencia()
   {
         $this->look_usuario_dependencia = html_entity_decode($this->look_usuario_dependencia, ENT_COMPAT, $_SESSION['scriptcase']['charset']);
         $this->look_usuario_dependencia = strip_tags($this->look_usuario_dependencia);
         if (!NM_is_utf8($this->look_usuario_dependencia))
         {
             $this->look_usuario_dependencia = sc_convert_encoding($this->look_usuario_dependencia, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         $this->look_usuario_dependencia = str_replace('<', '&lt;', $this->look_usuario_dependencia);
         $this->look_usuario_dependencia = str_replace('>', '&gt;', $this->look_usuario_dependencia);
         $this->Texto_tag .= "<td>" . $this->look_usuario_dependencia . "</td>\r\n";
   }
   //----- usuario_estado
   function NM_export_usuario_estado()
   {
         $this->usuario_estado = html_entity_decode($this->usuario_estado, ENT_COMPAT, $_SESSION['scriptcase']['charset']);
         $this->usuario_estado = strip_tags($this->usuario_estado);
         if (!NM_is_utf8($this->usuario_estado))
         {
             $this->usuario_estado = sc_convert_encoding($this->usuario_estado, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         $this->usuario_estado = str_replace('<', '&lt;', $this->usuario_estado);
         $this->usuario_estado = str_replace('>', '&gt;', $this->usuario_estado);
         $this->Texto_tag .= "<td>" . $this->usuario_estado . "</td>\r\n";
   }
   //----- idusuario
   function NM_export_idusuario()
   {
         nmgp_Form_Num_Val($this->idusuario, $_SESSION['scriptcase']['reg_conf']['grup_num'], $_SESSION['scriptcase']['reg_conf']['dec_num'], "0", "S", "2", "", "N:" . $_SESSION['scriptcase']['reg_conf']['neg_num'] , $_SESSION['scriptcase']['reg_conf']['simb_neg'], $_SESSION['scriptcase']['reg_conf']['num_group_digit']) ; 
         if (!NM_is_utf8($this->idusuario))
         {
             $this->idusuario = sc_convert_encoding($this->idusuario, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         $this->idusuario = str_replace('<', '&lt;', $this->idusuario);
         $this->idusuario = str_replace('>', '&gt;', $this->idusuario);
         $this->Texto_tag .= "<td>" . $this->idusuario . "</td>\r\n";
   }

   //----- 
   function grava_arquivo_rtf()
   {
      global $nm_lang, $doc_wrap;
      $this->Rtf_f = $this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arquivo;
      $rtf_f       = fopen($this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arquivo, "w");
      require_once($this->Ini->path_third      . "/rtf_new/document_generator/cl_xml2driver.php"); 
      $text_ok  =  "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\r\n"; 
      $text_ok .=  "<DOC config_file=\"" . $this->Ini->path_third . "/rtf_new/doc_config.inc\" >\r\n"; 
      $text_ok .=  $this->Texto_tag; 
      $text_ok .=  "</DOC>\r\n"; 
      $xml = new nDOCGEN($text_ok,"RTF"); 
      fwrite($rtf_f, $xml->get_result_file());
      fclose($rtf_f);
   }

   function nm_conv_data_db($dt_in, $form_in, $form_out)
   {
       $dt_out = $dt_in;
       if (strtoupper($form_in) == "DB_FORMAT")
       {
           if ($dt_out == "null" || $dt_out == "")
           {
               $dt_out = "";
               return $dt_out;
           }
           $form_in = "AAAA-MM-DD";
       }
       if (strtoupper($form_out) == "DB_FORMAT")
       {
           if (empty($dt_out))
           {
               $dt_out = "null";
               return $dt_out;
           }
           $form_out = "AAAA-MM-DD";
       }
       nm_conv_form_data($dt_out, $form_in, $form_out);
       return $dt_out;
   }
   //---- 
   function monta_html()
   {
      global $nm_url_saida, $nm_lang;
      include($this->Ini->path_btn . $this->Ini->Str_btn_grid);
      unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_usuario']['rtf_file']);
      if (is_file($this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arquivo))
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_usuario']['rtf_file'] = $this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arquivo;
      }
      $path_doc_md5 = md5($this->Ini->path_imag_temp . "/" . $this->Arquivo);
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_usuario'][$path_doc_md5][0] = $this->Ini->path_imag_temp . "/" . $this->Arquivo;
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_usuario'][$path_doc_md5][1] = $this->Tit_doc;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
            "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML<?php echo $_SESSION['scriptcase']['reg_conf']['html_dir'] ?>>
<HEAD>
 <TITLE>USUARIOS :: RTF</TITLE>
 <META http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['scriptcase']['charset_html'] ?>" />
<?php
if ($_SESSION['scriptcase']['proc_mobile'])
{
?>
  <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
<?php
}
?>
  <META http-equiv="Expires" content="Fri, Jan 01 1900 00:00:00 GMT"/>
  <META http-equiv="Last-Modified" content="<?php echo gmdate("D, d M Y H:i:s"); ?> GMT"/>
  <META http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate"/>
  <META http-equiv="Cache-Control" content="post-check=0, pre-check=0"/>
  <META http-equiv="Pragma" content="no-cache"/>
 <link rel="shortcut icon" href="../_lib/img/sys__NM__ico__NM__favicons_ame_nuevo.png">
  <link rel="stylesheet" type="text/css" href="../_lib/css/<?php echo $this->Ini->str_schema_all ?>_export.css" /> 
  <link rel="stylesheet" type="text/css" href="../_lib/css/<?php echo $this->Ini->str_schema_all ?>_export<?php echo $_SESSION['scriptcase']['reg_conf']['css_dir'] ?>.css" /> 
  <link rel="stylesheet" type="text/css" href="../_lib/buttons/<?php echo $this->Ini->Str_btn_css ?>" /> 
</HEAD>
<BODY class="scExportPage">
<?php echo $this->Ini->Ajax_result_set ?>
<table style="border-collapse: collapse; border-width: 0; height: 100%; width: 100%"><tr><td style="padding: 0; text-align: center; vertical-align: middle">
 <table class="scExportTable" align="center">
  <tr>
   <td class="scExportTitle" style="height: 25px">RTF</td>
  </tr>
  <tr>
   <td class="scExportLine" style="width: 100%">
    <table style="border-collapse: collapse; border-width: 0; width: 100%"><tr><td class="scExportLineFont" style="padding: 3px 0 0 0" id="idMessage">
    <?php echo $this->Ini->Nm_lang['lang_othr_file_msge'] ?>
    </td><td class="scExportLineFont" style="text-align:right; padding: 3px 0 0 0">
     <?php echo nmButtonOutput($this->arr_buttons, "bexportview", "document.Fview.submit()", "document.Fview.submit()", "idBtnView", "", "", "", "", "", "", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "");
 ?>
     <?php echo nmButtonOutput($this->arr_buttons, "bdownload", "document.Fdown.submit()", "document.Fdown.submit()", "idBtnDown", "", "", "", "", "", "", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "");
 ?>
     <?php echo nmButtonOutput($this->arr_buttons, "bvoltar", "document.F0.submit()", "document.F0.submit()", "idBtnBack", "", "", "", "", "", "", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "");
 ?>
    </td></tr></table>
   </td>
  </tr>
 </table>
</td></tr></table>
<form name="Fview" method="get" action="<?php echo $this->Ini->path_imag_temp . "/" . $this->Arquivo ?>" target="_blank" style="display: none"> 
</form>
<form name="Fdown" method="get" action="grid_usuario_download.php" target="_blank" style="display: none"> 
<input type="hidden" name="script_case_init" value="<?php echo NM_encode_input($this->Ini->sc_page); ?>"> 
<input type="hidden" name="nm_tit_doc" value="grid_usuario"> 
<input type="hidden" name="nm_name_doc" value="<?php echo $path_doc_md5 ?>"> 
</form>
<FORM name="F0" method=post action="./"> 
<INPUT type="hidden" name="script_case_init" value="<?php echo NM_encode_input($this->Ini->sc_page); ?>"> 
<INPUT type="hidden" name="script_case_session" value="<?php echo NM_encode_input(session_id()); ?>"> 
<INPUT type="hidden" name="nmgp_opcao" value="volta_grid"> 
</FORM> 
</BODY>
</HTML>
<?php
   }
   function nm_gera_mask(&$nm_campo, $nm_mask)
   { 
      $trab_campo = $nm_campo;
      $trab_mask  = $nm_mask;
      $tam_campo  = strlen($nm_campo);
      $trab_saida = "";
      $mask_num = false;
      for ($x=0; $x < strlen($trab_mask); $x++)
      {
          if (substr($trab_mask, $x, 1) == "#")
          {
              $mask_num = true;
              break;
          }
      }
      if ($mask_num )
      {
          $ver_duas = explode(";", $trab_mask);
          if (isset($ver_duas[1]) && !empty($ver_duas[1]))
          {
              $cont1 = count(explode("#", $ver_duas[0])) - 1;
              $cont2 = count(explode("#", $ver_duas[1])) - 1;
              if ($cont2 >= $tam_campo)
              {
                  $trab_mask = $ver_duas[1];
              }
              else
              {
                  $trab_mask = $ver_duas[0];
              }
          }
          $tam_mask = strlen($trab_mask);
          $xdados = 0;
          for ($x=0; $x < $tam_mask; $x++)
          {
              if (substr($trab_mask, $x, 1) == "#" && $xdados < $tam_campo)
              {
                  $trab_saida .= substr($trab_campo, $xdados, 1);
                  $xdados++;
              }
              elseif ($xdados < $tam_campo)
              {
                  $trab_saida .= substr($trab_mask, $x, 1);
              }
          }
          if ($xdados < $tam_campo)
          {
              $trab_saida .= substr($trab_campo, $xdados);
          }
          $nm_campo = $trab_saida;
          return;
      }
      for ($ix = strlen($trab_mask); $ix > 0; $ix--)
      {
           $char_mask = substr($trab_mask, $ix - 1, 1);
           if ($char_mask != "x" && $char_mask != "z")
           {
               $trab_saida = $char_mask . $trab_saida;
           }
           else
           {
               if ($tam_campo != 0)
               {
                   $trab_saida = substr($trab_campo, $tam_campo - 1, 1) . $trab_saida;
                   $tam_campo--;
               }
               else
               {
                   $trab_saida = "0" . $trab_saida;
               }
           }
      }
      if ($tam_campo != 0)
      {
          $trab_saida = substr($trab_campo, 0, $tam_campo) . $trab_saida;
          $trab_mask  = str_repeat("z", $tam_campo) . $trab_mask;
      }
   
      $iz = 0; 
      for ($ix = 0; $ix < strlen($trab_mask); $ix++)
      {
           $char_mask = substr($trab_mask, $ix, 1);
           if ($char_mask != "x" && $char_mask != "z")
           {
               if ($char_mask == "." || $char_mask == ",")
               {
                   $trab_saida = substr($trab_saida, 0, $iz) . substr($trab_saida, $iz + 1);
               }
               else
               {
                   $iz++;
               }
           }
           elseif ($char_mask == "x" || substr($trab_saida, $iz, 1) != "0")
           {
               $ix = strlen($trab_mask) + 1;
           }
           else
           {
               $trab_saida = substr($trab_saida, 0, $iz) . substr($trab_saida, $iz + 1);
           }
      }
      $nm_campo = $trab_saida;
   } 
}

?>
