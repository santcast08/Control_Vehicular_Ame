<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
    <head>
        <META http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['scriptcase']['charset_html'] ?>" />
        <title>Menu</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet"  href="<?php echo $_SESSION["scriptcase"]["Menu"]["glo_nm_path_prod"]; ?>/third/jquery.mobile/jquery.mobile-1.2.0.min.css" />
        <link rel="stylesheet"  href="<?php echo $this->url_css; ?>Tema_ame_V9/Tema_ame_V9_menuMobile.css" />
        <link rel="stylesheet"  href="<?php echo $this->url_css; ?>Tema_ame_V9/Tema_ame_V9_menuMobile<?php echo $_SESSION['scriptcase']['reg_conf']['css_dir'] ?>.css" />
        <script src="<?php echo $_SESSION["scriptcase"]["Menu"]["glo_nm_path_prod"]; ?>/third/jquery.mobile/jquery.js"></script>
        <script type="text/javascript">
            $(document).bind("mobileinit", function() {
                $.mobile.page.prototype.options.backBtnText = "<?php echo $this->Nm_lang["lang_btns_prev"]; ?>";
                $.mobile.page.prototype.options.addBackBtn = true;
            });
        </script>
        <script src="<?php echo $_SESSION["scriptcase"]["Menu"]["glo_nm_path_prod"]; ?>/third/jquery.mobile/jquery.mobile-1.2.0.min.js"></script>
    </head>
    <body>
<style>
#lin1_col1 { font-size:22px; width:500px; color: #FFFFFF; }
#lin1_col2 { font-family:Arial, Helvetica, sans-serif; font-size:12px; text-align:right; color: #FFFFFF;  }
#lin2_col1 { font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:15px; }
#lin2_col2 { font-family:Arial, Helvetica, sans-serif; font-size:12px; text-align:right; color: #FFFFFF;  }

</style>

<table width="100%" height="67px" class="scMenuHHeader">
        <tr>
                <td width="5px"></td>
        <td width="67px" class="scMenuHHeaderFont">   <IMG SRC="<?php echo $path_imag_cab ?>/sys__NM__img__NM__LOGOTIPO AME 2013 16.png" BORDER="0"/></td>
               <td class="scMenuHHeaderFont"><span id="lin1_col1"><?php echo "$sql2" ?></span><br /><span id="lin2_col1"><?php echo "ASOCIACIÓN DE MUNICIPALIDADES ECUATORIANAS" ?></span></td>
               <td align="right" class="scMenuHHeaderFont"><span  id="lin1_col2"><?php echo "$sql" ?></span><br /><span id="lin2_col2"><?php echo "$fecha" ?></span></td>
        <td width="5px"></td>
    </tr>
</table>

    <?php
        escreveMenuMobile($Menu_menuData["data"], $this->path_imag_apl);
    ?>
	<?php
		function escreveMenuMobile($arr_menu, $path_imag_apl)
		{
			$subSize   = 2;
			$subCount  = array();
			$tabSpace  = 1;
			$intMult   = 2;
			$aMenuItemList = array();
			foreach ($arr_menu as $ind => $resto)
			{
				$aMenuItemList[] = $resto;
			}
			?>
			<ul data-role='listview' data-theme='a'>
			<?php
			for ($i = 0; $i < sizeof($aMenuItemList); $i++)
			{
				echo str_repeat(' ', $tabSpace * $intMult); ?><li><?php
				$tabSpace++;
				$sDisabledClass = '';
				if ('Y' == $aMenuItemList[$i]['disabled'])
				{
					$aMenuItemList[$i]['link']   = '#';
					$aMenuItemList[$i]['target'] = '';
				}
				if ('' != $aMenuItemList[$i]['icon'] && file_exists($path_imag_apl . "/" . $aMenuItemList[$i]['icon']))
				{
					$iconHtml = '<img src="../_lib/img/' . $aMenuItemList[$i]['icon'] . '" alt="' . $aMenuItemList[$cont_menu_list_assoc]['hint'] . '" class="ui-li-icon"  />';
				}
				else
				{
					$iconHtml = '';
				}
				if (empty($aMenuItemList[$i]['link']))
				{
					$aMenuItemList[$i]['link']   = '#';
				}
				if (isset($aMenuItemList[$i + 1]) && $aMenuItemList[$i]['level'] < $aMenuItemList[$i + 1]['level'])
				{
					echo str_repeat(' ', $tabSpace * $intMult); ?><a href="<?php echo $aMenuItemList[$i]['link']; ?>" id="<?php echo $aMenuItemList[$i]['id']; ?>" title="<?php echo $aMenuItemList[$i]['hint']; ?>"><?php echo $iconHtml . $aMenuItemList[$i]['label']; ?></a><?php
					
					if (0 != $subSize && 0 < $aMenuItemList[$i + 1]['level'])
					{
						echo str_repeat(' ', $tabSpace * $intMult);
						$tabSpace++;
						echo str_repeat(' ', $tabSpace * $intMult);
						$tabSpace++;
					}
					echo str_repeat(' ', $tabSpace * $intMult); ?><ul><?php
					$tabSpace++;
				}
				else
				{
					echo str_repeat(' ', $tabSpace * $intMult); ?><a href="<?php echo $aMenuItemList[$i]['link']; ?>" id="<?php echo $aMenuItemList[$i]['id']; ?>" title="<?php echo $aMenuItemList[$i]['hint']; ?>"><?php echo $iconHtml . $aMenuItemList[$i]['label']; ?></a><?php
				}
				
				if ((isset($aMenuItemList[$i + 1]) && $aMenuItemList[$i]['level'] == $aMenuItemList[$i + 1]['level']) || 
					(isset($aMenuItemList[$i + 1]) && $aMenuItemList[$i]['level'] > $aMenuItemList[$i + 1]['level']) ||
					(!isset($aMenuItemList[$i + 1]) && $aMenuItemList[$i]['level'] > 0) ||
					(!isset($aMenuItemList[$i + 1]) && $aMenuItemList[$i]['level'] == 0))
				{
					$tabSpace--;
					echo str_repeat(' ', $tabSpace * $intMult); ?></li><?php
					
					if (0 != $subSize && 0 < $aMenuItemList[$i]['level'])
					{
						if (!isset($subCount[ $aMenuItemList[$i]['level'] ]))
						{
							$subCount[ $aMenuItemList[$i]['level'] ] = 0;
						}
						$subCount[ $aMenuItemList[$i]['level'] ]++;
					}
					if (isset($aMenuItemList[$i + 1]) && $aMenuItemList[$i]['level'] > $aMenuItemList[$i + 1]['level'])
					{
						for ($j = 0; $j < $aMenuItemList[$i]['level'] - $aMenuItemList[$i + 1]['level']; $j++)
						{
							unset($subCount[ $aMenuItemList[$i]['level'] - $j]);
							$tabSpace--;
							echo str_repeat(' ', $tabSpace * $intMult); ?></ul><?php
							
							if (0 != $subSize && 0 < $aMenuItemList[$i]['level'])
							{
								$tabSpace--;
								echo str_repeat(' ', $tabSpace * $intMult);
								$tabSpace--;
								echo str_repeat(' ', $tabSpace * $intMult);
							}
							$tabSpace--;
							
							echo str_repeat(' ', $tabSpace * $intMult); ?></li><?php
							
						}
					}
					elseif (!$aMenuItemList[$i + 1] && $aMenuItemList[$i]['level'] > 0)
					{
						for ($j = 0; $j < $aMenuItemList[$i]['level']; $j++)
						{
							unset($subCount[ $aMenuItemList[$i]['level'] - $j]);
							$tabSpace--;
							echo str_repeat(' ', $tabSpace * $intMult); ?></ul><?php
							
							if (0 != $subSize && 0 < $aMenuItemList[$i]['level'])
							{
								$tabSpace--;
								echo str_repeat(' ', $tabSpace * $intMult);
								$tabSpace--;
								echo str_repeat(' ', $tabSpace * $intMult);
							}
							$tabSpace--;
							echo str_repeat(' ', $tabSpace * $intMult); ?></li><?php
						}
					}
					if ($subSize == $subCount[ $aMenuItemList[$i]['level'] ])
					{
						$subCount[ $aMenuItemList[$i]['level'] ] = 0;
						echo str_repeat(' ', $tabSpace * $intMult);
					}
				}
			}
		?>
		</ul>
		<?php
		}
	?>
    </body>
</html>