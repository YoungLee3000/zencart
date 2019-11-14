<?php
/**
 * Common Template - tpl_columnar_display.php
 *
 * This file is used for generating tabular output where needed, based on the supplied array of table-cell contents.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_columnar_display.php 3157 2006-03-10 23:24:22Z drbyte $
 */
?>
<?php
  if ($title) {
  ?>
<?php echo $title; ?>
<?php
 }
 ?>
<?php
if (is_array($list_box_contents) > 0 ) 
	{
		$string_parts = explode("=", $list_box_contents[0][0]['params']);
		$param = $string_parts[1];
		$param1 = trim($param,'"');
		
		$param2= explode(" ", $string_parts[1]);
		$param2 = $param2[0];
		$param2 = trim($param2,'"');
		
		$param3= explode(" ", $string_parts[1]);
		$param3 = $param3[1];
		$param3 = trim($param3,'"');
			
		//print_r($param3);
		$param4= explode(" ", $string_parts[1]);
		$param4 = $param4[0];
		$param4 = trim($param4,'"');
		//print_r($param4);
		$param5= explode(" ", $string_parts[1]);
		$param5 = $param5[0];
		$param5 = trim($param5,'"');
		//print_r($param5);
		$param6= explode(" ", $string_parts[1]);
		$param6 = $param6[0];
		$param6 = trim($param6,'"');
		if($param6 == "subcategory-item") 
		{ 
		?>
        <div class="subcategories">
			<div class="row">
        <?php
			for($row=0;$row<sizeof($list_box_contents);$row++) 
				{
    				$params = "";
    				//if (isset($list_box_contents[$row]['params'])) $params .= ' ' . $list_box_contents[$row]['params'];
        			for($col=0;$col<sizeof($list_box_contents[$row]);$col++) 
						{
      						$r_params = "";
      						if (isset($list_box_contents[$row][$col]['params'])) $r_params .= ' ' . (string)$list_box_contents[$row][$col]['params'];
     						if (isset($list_box_contents[$row][$col]['text'])) 
							{ 
								echo '<div ' . $r_params . '>' . $list_box_contents[$row][$col]['text'] .  '</div>';
					 		}
    					}
  				} ?>
            </div>
      	</div>
		<?php
		}
		elseif($param4 == "itemcenterBoxContentsSpecials" && !$this_is_home_page)
		{ ?>
        	<div class="row">
            	<div class="product-slider">
                <div id="special-slider-inner" class="owl-carousel owl-theme">
                <?php
                for($row=0;$row<sizeof($list_box_contents);$row++)
                    {
                        $params = "";
                        //if (isset($list_box_contents[$row]['params'])) $params .= ' ' . $list_box_contents[$row]['params'];
                        for($col=0;$col<sizeof($list_box_contents[$row]);$col++) 
                            {
                                $r_params = "";
                                if (isset($list_box_contents[$row][$col]['params'])) $r_params .= ' ' . (string)$list_box_contents[$row][$col]['params'];
                                if (isset($list_box_contents[$row][$col]['text'])) 
                                { 
                                    echo '<div' . $r_params . '>' . $list_box_contents[$row][$col]['text'] .  '</div>' . "\n";
                                }
                            }
                    }
                ?>
                </div>
                </div>
			</div>
			<?php		
		}
		elseif($param2 == "centerBoxContentsAlsoPurch") 
		{ 
		?>
        	<div class="carousel-products row" id="carouselAlsoPurchased">
                <?php
                for($row=0;$row<sizeof($list_box_contents);$row++) 
                    {
                        $params = "";
                        //if (isset($list_box_contents[$row]['params'])) $params .= ' ' . $list_box_contents[$row]['params'];
                        for($col=0;$col<sizeof($list_box_contents[$row]);$col++) 
                            {
                                $r_params = "";
                                if (isset($list_box_contents[$row][$col]['params'])) $r_params .= ' ' . (string)$list_box_contents[$row][$col]['params'];
                                if (isset($list_box_contents[$row][$col]['text'])) 
                                { 
                                    echo '<div' . $r_params . '>' . $list_box_contents[$row][$col]['text'] .  '</div>' . "\n";
                                }
                            }
                    } ?>
					</div>
				<?php
		}
		elseif($param3 == "centerBoxContentsRelatedProduct") 
		{ 
		?>
        <div class="carousel-products row" id="carouselRelated">
                <?php
                for($row=0;$row<sizeof($list_box_contents);$row++) 
                    {
                        $params = "";
                        //if (isset($list_box_contents[$row]['params'])) $params .= ' ' . $list_box_contents[$row]['params'];
                        for($col=0;$col<sizeof($list_box_contents[$row]);$col++) 
                            {
                                $r_params = "";
                                if (isset($list_box_contents[$row][$col]['params'])) $r_params .= ' ' . (string)$list_box_contents[$row][$col]['params'];
                                if (isset($list_box_contents[$row][$col]['text'])) 
                                { 
                                    echo '<div' . $r_params . '>' . $list_box_contents[$row][$col]['text'] .  '</div>' . "\n";
                                }
                            }
                    } ?>
					</div>
				<?php
		}
		elseif($param3 == "centerBoxContentsNew")
		{ ?>
			<?php if($nproducts_display_style=='tabs' && $this_is_home_page){ echo '<div id="'.$nproducttab_id.'-clone" style="display:none">'; } ?>
            <div class="<?php echo $nproduct_container_class; ?>" id="<?php echo $nproduct_container_id; ?>" <?php echo $pzen_newprod_index_data; ?>>
            <?php
				
            for($row=0;$row<sizeof($list_box_contents);$row++)
                {
                    $params = "";
                    //if (isset($list_box_contents[$row]['params'])) $params .= ' ' . $list_box_contents[$row]['params'];
                    for($col=0;$col<sizeof($list_box_contents[$row]);$col++) 
                        {
                            $r_params = "";
                            if (isset($list_box_contents[$row][$col]['params'])) $r_params .= ' ' . (string)$list_box_contents[$row][$col]['params'];
                            if (isset($list_box_contents[$row][$col]['text'])) 
                            { 
                                echo '<div' . $r_params . '>' . $list_box_contents[$row][$col]['text'] .  '</div>' . "\n";
                            }
                        }
                }
            ?>
            </div>
			<?php if($nproducts_display_style=='tabs' && $this_is_home_page){ echo '</div>'; } ?>
        	<?php		
		}
		elseif($param3 == "centerBoxContentsNewReloaded")
		{ ?>
	        <div id="<?php echo $category_id; ?>" class="<?php echo $category_class; ?>">
                <?php
                for($row=0;$row<sizeof($list_box_contents);$row++)
                    {
                        $params = "";
                        //if (isset($list_box_contents[$row]['params'])) $params .= ' ' . $list_box_contents[$row]['params'];
                        for($col=0;$col<sizeof($list_box_contents[$row]);$col++) 
                            {
                                $r_params = "";
                                if (isset($list_box_contents[$row][$col]['params'])) $r_params .= ' ' . (string)$list_box_contents[$row][$col]['params'];
                                if (isset($list_box_contents[$row][$col]['text'])) 
                                { 
                                    echo '<div' . $r_params . '>' . $list_box_contents[$row][$col]['text'] .  '</div>' . "\n";
                                }
                            }
                    }
                ?>
			</div>
			<?php		
		}
		elseif($param3 == "centerBoxContentsFeatured")
		{ 
		?>
			<?php if($fproducts_display_style=='tabs' && $this_is_home_page){ echo '<div id="'.$fproducttab_id.'-clone" style="display:none">'; } ?>
				<div class="<?php echo $fproduct_container_class; ?>" id="<?php echo $fproduct_container_id; ?>" <?php echo $pzen_featuredprod_index_data; ?>>
                <?php
                for($row=0;$row<sizeof($list_box_contents);$row++)
                    {	?>
                        <?php $params = "";
                        //if (isset($list_box_contents[$row]['params'])) $params .= ' ' . $list_box_contents[$row]['params'];
                        for($col=0;$col<sizeof($list_box_contents[$row]);$col++) 
                            {
                                $r_params = "";
                                if (isset($list_box_contents[$row][$col]['params'])) $r_params .= ' ' . (string)$list_box_contents[$row][$col]['params'];
                                if (isset($list_box_contents[$row][$col]['text'])) 
                                { 
                                    echo '<div' . $r_params . '>' . $list_box_contents[$row][$col]['text'] .  '</div>' . "\n";
                                }
                            } 
						?>
				  <?php  }
                ?>
				</div>
			<?php if($fproducts_display_style=='tabs' && $this_is_home_page){ echo '</div>'; } ?>
			<?php		
		}
		elseif($param3 == "centerBoxContentsSpecials")
		{ ?>
			<?php if($sproducts_display_style=='tabs' && $this_is_home_page){ echo '<div id="'.$sproducttab_id.'-clone" style="display:none">'; } ?>
				<div class="<?php echo $sproduct_container_class; ?>" id="<?php echo $sproduct_container_id; ?>" <?php echo $pzen_speprod_index_data; ?>>
                <?php
                for($row=0;$row<sizeof($list_box_contents);$row++)
                    {
                        $params = "";
                        //if (isset($list_box_contents[$row]['params'])) $params .= ' ' . $list_box_contents[$row]['params'];
                        for($col=0;$col<sizeof($list_box_contents[$row]);$col++) 
                            {
                                $r_params = "";
                                if (isset($list_box_contents[$row][$col]['params'])) $r_params .= ' ' . (string)$list_box_contents[$row][$col]['params'];
                                if (isset($list_box_contents[$row][$col]['text'])) 
                                { 
                                    echo '<div' . $r_params . '>' . $list_box_contents[$row][$col]['text'] .  '</div>' . "\n";
                                }
                            }
                    }
                ?>
				</div>
			<?php if($sproducts_display_style=='tabs' && $this_is_home_page){ echo '</div>'; } ?>
			<?php		
		}
		elseif($param3 == "centerBoxContentsSpecialsReloaded")
		{ ?>
        	<div id="<?php echo $category_id_two; ?>" class="<?php echo $category_class; ?>">
                <?php
                for($row=0;$row<sizeof($list_box_contents);$row++)
                    {
                        $params = "";
                        //if (isset($list_box_contents[$row]['params'])) $params .= ' ' . $list_box_contents[$row]['params'];
                        for($col=0;$col<sizeof($list_box_contents[$row]);$col++) 
                            {
                                $r_params = "";
                                if (isset($list_box_contents[$row][$col]['params'])) $r_params .= ' ' . (string)$list_box_contents[$row][$col]['params'];
                                if (isset($list_box_contents[$row][$col]['text'])) 
                                { 
                                    echo '<div' . $r_params . '>' . $list_box_contents[$row][$col]['text'] .  '</div>' . "\n";
                                }
                            }
                    }
                ?>
			</div>
			<?php		
		}
		elseif($param3 == "centerBoxContentsBestSellers")
		{ ?>
			<?php if($bproducts_display_style=='tabs' && $this_is_home_page){ echo '<div id="'.$bproducttab_id.'-clone" style="display:none">'; } ?>
           		<div id="<?php echo $bproduct_container_id; ?>" class="<?php echo $bproduct_container_class; ?>" <?php echo $pzen_bestsellerprod_index_data; ?> >
                    <?php
                    for($row=0;$row<sizeof($list_box_contents);$row++)
                        {
                            $params = "";
                            //if (isset($list_box_contents[$row]['params'])) $params .= ' ' . $list_box_contents[$row]['params'];
                            for($col=0;$col<sizeof($list_box_contents[$row]);$col++) 
                                {
                                    $r_params = "";
                                    if (isset($list_box_contents[$row][$col]['params'])) $r_params .= ' ' . (string)$list_box_contents[$row][$col]['params'];
                                    if (isset($list_box_contents[$row][$col]['text'])) 
                                    { 
                                        echo '<div' . $r_params . '>' . $list_box_contents[$row][$col]['text'] .  '</div>' . "\n";
                                    }
                                }
                        }
                    ?>
				</div>
			<?php if($bproducts_display_style=='tabs' && $this_is_home_page){ echo '</div>'; } ?>
			<?php		
		}
		elseif($param3 == "centerBoxContentsRandom")
		{ ?>
           	<div id="<?php echo $randproduct_container_id; ?>" class="<?php echo $randproduct_container_class; ?>" <?php echo $pzen_randprod_index_data; ?> >
			<?php
			for($row=0;$row<sizeof($list_box_contents);$row++)
				{
					$params = "";
					//if (isset($list_box_contents[$row]['params'])) $params .= ' ' . $list_box_contents[$row]['params'];
					for($col=0;$col<sizeof($list_box_contents[$row]);$col++) 
						{
							$r_params = "";
							if (isset($list_box_contents[$row][$col]['params'])) $r_params .= ' ' . (string)$list_box_contents[$row][$col]['params'];
							if (isset($list_box_contents[$row][$col]['text'])) 
							{ 
								echo '<div' . $r_params . '>' . $list_box_contents[$row][$col]['text'] .  '</div>' . "\n";
							}
						}
				}
			?>
		</div>
			<?php		
		}
		elseif($param5 == "additionalImages")
		{ 
			for($row=0;$row<sizeof($list_box_contents);$row++)
				{
					$params = "";
					//if (isset($list_box_contents[$row]['params'])) $params .= ' ' . $list_box_contents[$row]['params'];
					for($col=0;$col<sizeof($list_box_contents[$row]);$col++) 
					{
							$r_params = "";
						if (isset($list_box_contents[$row][$col]['params'])) $r_params .= ' ' . (string)$list_box_contents[$row][$col]['params'];
						if (isset($list_box_contents[$row][$col]['text'])) 
						{ 
							echo '<li' . $r_params . '>' . $list_box_contents[$row][$col]['text'] .  '</li>' . "\n";
						}
					}
				}
		}
		elseif($param6 == "specialsListBoxContents")
		{ ?>
			<div id="special-listing" <?php echo $spepage_container_data; ?>>
			<?php
			for($row=0;$row<sizeof($list_box_contents);$row++)
				{
    				$params = "";
    				//if (isset($list_box_contents[$row]['params'])) $params .= ' ' . $list_box_contents[$row]['params'];
        			for($col=0;$col<sizeof($list_box_contents[$row]);$col++) 
						{
      						$r_params = "";
      						if (isset($list_box_contents[$row][$col]['params'])) $r_params .= ' ' . (string)$list_box_contents[$row][$col]['params'];
     						if (isset($list_box_contents[$row][$col]['text'])) 
							{ 
								echo '<div' . $r_params . '>' . $list_box_contents[$row][$col]['text'] .  '</div>' . "\n";
					 		}
    					}
  				}
			?>
            </div>
			<?php		
		}
		else
		{ ?>
        	<ul>
			<?php
			for($row=0;$row<sizeof($list_box_contents);$row++)
				{
    				$params = "";
        			for($col=0;$col<sizeof($list_box_contents[$row]);$col++) 
						{
      						$r_params = "";
      						if (isset($list_box_contents[$row][$col]['params'])) $r_params .= ' ' . (string)$list_box_contents[$row][$col]['params'];
     						if (isset($list_box_contents[$row][$col]['text'])) 
							{ 
								echo '<li' . $r_params . '>' . $list_box_contents[$row][$col]['text'] .  '</li>' . "\n";
					 		}
    					}
  				}
			?>
            </ul>
			<?php		
		}
	}
?> 