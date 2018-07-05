<?php
// functions file
// this file contains the necessary functions for the plugin to work


// styles
function ocwscc_styles() {
	wp_enqueue_style( 'ocws-creationcache-styles', OCWSCC_BASE_URL.'/ocws-creationcache-styles.css' );
}

// function to create a random string
if (!function_exists('ocws_randomstring')) {
function ocws_randomstring($ocwsl,$ocseed) {
	$olength = $ocwsl;
	$ostring = "";
	$ocharacters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"; // change to whatever characters you want
	while ($olength > 0) {
		// echo $olength;
		$ostring .= $ocharacters[mt_rand(0,strlen($ocharacters)-1)];
		$olength -= 1;
	}
	$ostring = $ocseed.$ostring;
	return $ostring;
} // end function ocws_randomstring
} // end if

/* This will create the dashboard widget */
function ocwscc_dashboard_example_widgets() {

	//create a custom dashboard widget
	wp_add_dashboard_widget( 'dashboard_custom_feed', 'OCWS Creationcache Plugin', 'ocwscc_dashboard_example_display' );
	
}

function ocwscc_dashboard_example_display()
{
    echo "<img src=\"".OCWSCC_BASE_URL."/images/".CC_LOGO80."\" alt=\"Old Castle Web Services logo\" title=\"OCWS logo\" width=\"60\" height=\"60\" style=\"float:left;padding-right:10px;\" />\n";
	echo "<p>".CCDASH_INFO."</p>\n";	
	echo "<hr style=\"align:center; width:80%\" />\n";
	echo "<p>Further information can be obtained from <a href=\"http://www.oldcastleweb.com\" title=\"Oldcastle Web Services\" target=\"_blank\">Oldcastle Web Services</a>.</p>\n";
}
/* end of dashboard widget functions */

/* META BOXES CODE */
/* (I might not need the database functions below) */
/* we need meta boxes */
function ocwscc_mbe_create() {

	//create a custom meta box
	add_meta_box( 'ocwscc-meta', 'OCWS '.CCNAME_SG.' Data', 'ocwscc_mbe_function', CCSLUG, 'normal', 'high' );
	add_meta_box( 'ocwscc-meta-shortdesc', 'OCWS '.CCNAME_SG.' Short Description', 'ocwscc_mbe_function_sd', CCSLUG, 'normal', 'high' );

}

/**
 * This organizes all the meta data for the new post type
 * @param type $post
 */
function ocwscc_mbe_function($post) {
	echo "<p>All the extra information required for the ".CCNAME_SG." should be in this section.</p>";
	
	// let's see if any metadata values exist
	$ocwscc_ccname = get_post_meta( $post->ID, '_ocwscc_ccname', true);
	$ocwscc_ccdate = get_post_meta( $post->ID, '_ocwscc_ccdate', true);
	$ocwscc_cclon = get_post_meta( $post->ID, '_ocwscc_cclon', true);
	$ocwscc_cclat = get_post_meta( $post->ID, '_ocwscc_cclat', true);
	$ocwscc_gpname = get_post_meta( $post->ID, '_ocwscc_gpname', true);
	$ocwscc_gpowner = get_post_meta( $post->ID, '_ocwscc_gpowner', true);
	$ocwscc_gpdiff = get_post_meta( $post->ID, '_ocwscc_gpdiff', true);
	$ocwscc_gpterr = get_post_meta( $post->ID, '_ocwscc_gpterr', true);
	$ocwscc_gpcountry = get_post_meta( $post->ID, '_ocwscc_gpcountry', true);
	$ocwscc_gpstate = get_post_meta( $post->ID, '_ocwscc_gpstate', true);
	
	if ( $ocwscc_ccname == "") {
		$ocwscc_ccname = ocws_randomstring(5,CC_PRFX);
		$ocwscc_ccdate = date('Y-m-d');
	}
	

	
	// create the metabox form

	?>

	<table id="ocws_metaboxtable" style="width:100%; border:0;">
	<tr>
	<td style="width:33%">
		<div id="ocws_box_left" style="border:solid 1px #000000; border-radius:25px; padding:10px; width:90%;float:left;min-height:270px;">
			<table width="100%">
			  <tr><!-- Row 1 -->
				 <td><?php echo CCNAME_SG." Code:";?></td><!-- Col 1 -->
				 <td><input type="text" name="ocwscc_ccname" value="<?php echo esc_attr($ocwscc_ccname); ?>" readonly /></td><!-- Col 2 -->
			  </tr>
			  <tr><!-- Row 2 -->
				 <td><?php echo CCNAME_SG." Owner:";?></td><!-- Col 1 -->
				 <td><input type="text" name="ocwscc_gpowner" value="<?php echo esc_attr($ocwscc_gpowner); ?>" /></td><!-- Col 2 -->
			  </tr>
			  <tr><!-- Row 3 -->
				 <td><?php echo CCNAME_SG." Date Created:";?></td><!-- Col 1 -->
				 <td><input type="text" name="ocwscc_ccdate" value="<?php echo esc_attr($ocwscc_ccdate); ?>" readonly /></td><!-- Col 2 -->
			  </tr>
			  <tr><!-- Row 4 -->
				 <td>Difficulty:</td><!-- Col 1 -->
				 <td><select name="ocwscc_gpdiff">
						<option value="0.5" <?php selected($ocwscc_gpdiff, 0.5); ?>>0.5</option>
						<option value="1.0" <?php selected($ocwscc_gpdiff, 1.0); ?>>1.0</option>
						<option value="1.5" <?php selected($ocwscc_gpdiff, 1.5); ?>>1.5</option>
						<option value="2.0" <?php selected($ocwscc_gpdiff, 2.0); ?>>2.0</option>
						<option value="2.5" <?php selected($ocwscc_gpdiff, 2.5); ?>>2.5</option>
						<option value="3.0" <?php selected($ocwscc_gpdiff, 3.0); ?>>3.0</option>
						<option value="3.5" <?php selected($ocwscc_gpdiff, 3.5); ?>>3.5</option>
						<option value="4.0" <?php selected($ocwscc_gpdiff, 4.0); ?>>4.0</option>
						<option value="4.5" <?php selected($ocwscc_gpdiff, 4.5); ?>>4.5</option>
						<option value="5.0" <?php selected($ocwscc_gpdiff, 5.0); ?>>5.0</option>
					</select><!-- end select ocwscc_gpdiff --></td><!-- Col 2 -->
			  </tr>
			  <tr><!-- Row 5 -->
				 <td>Terrain:</td><!-- Col 1 -->
				 <td><select name="ocwscc_gpterr">
						<option value="0.5" <?php selected($ocwscc_gpterr, 0.5); ?>>0.5</option>
						<option value="1.0" <?php selected($ocwscc_gpterr, 1.0); ?>>1.0</option>
						<option value="1.5" <?php selected($ocwscc_gpterr, 1.5); ?>>1.5</option>
						<option value="2.0" <?php selected($ocwscc_gpterr, 2.0); ?>>2.0</option>
						<option value="2.5" <?php selected($ocwscc_gpterr, 2.5); ?>>2.5</option>
						<option value="3.0" <?php selected($ocwscc_gpterr, 3.0); ?>>3.0</option>
						<option value="3.5" <?php selected($ocwscc_gpterr, 3.5); ?>>3.5</option>
						<option value="4.0" <?php selected($ocwscc_gpterr, 4.0); ?>>4.0</option>
						<option value="4.5" <?php selected($ocwscc_gpterr, 4.5); ?>>4.5</option>
						<option value="5.0" <?php selected($ocwscc_gpterr, 5.0); ?>>5.0</option>
					</select><!-- end select ocwscc_gpterr --></td><!-- Col 2 -->
			  </tr>
			</table>

		</div><!-- end ocws_box_left -->
	  </td>
	  <td style="width:33%">
  
  <div id="ocws_box_mid" style="border:solid 1px #000000; border-radius:25px; padding:10px; width:90%; margin-left:auto; margin-right:auto;min-height:270px;">
  	   <table width="100%">
          <tr><!-- Row 1 -->
             <td>Longitude:</td><!-- Col 1 -->
             <td><input type="text" name="ocwscc_cclon" value="<?php echo esc_attr($ocwscc_cclon); ?>" /></td><!-- Col 2 -->
          </tr>
          <tr><!-- Row 2 -->
             <td>Latitude:</td><!-- Col 1 -->
             <td><input type="text" name="ocwscc_cclat" value="<?php echo esc_attr($ocwscc_cclat); ?>" /></td><!-- Col 2 -->
          </tr>
          <tr><!-- Row 3 -->
             <td>Country:</td><!-- Col 1 -->
             <td><select name="ocwscc_gpcountry">
			<option value="USA" <?php selected($ocwscc_gpcountry, 'USA'); ?>>USA</option>
			<option value="UK" <?php selected($ocwscc_gpcountry, 'UK'); ?>>UK</option>
			<option value="Canada" <?php selected($ocwscc_gpcountry, 'Canada'); ?>>Canada</option>

		</select><!-- end select ocwscc_gpcountry --></td><!-- Col 2 -->
          </tr>
          <tr><!-- Row 4 -->
             <td>State:</td><!-- Col 1 -->
             <td><select name="ocwscc_gpstate">
			<option value="n/a">(not US or Canada)</option>
			<option value="AL" <?php selected($ocwscc_gpstate, 'AL'); ?>>Alabama</option>
			<option value="AK" <?php selected($ocwscc_gpstate, 'AK'); ?>>Alaska</option>
			<option value="AZ" <?php selected($ocwscc_gpstate, 'AZ'); ?>>Arizona</option>
			<option value="AR" <?php selected($ocwscc_gpstate, 'AR'); ?>>Arkansas</option>
			<option value="CA" <?php selected($ocwscc_gpstate, 'CA'); ?>>California</option>
			<option value="CO" <?php selected($ocwscc_gpstate, 'CO'); ?>>Colorado</option>
			<option value="CT" <?php selected($ocwscc_gpstate, 'CT'); ?>>Connecticut</option>
			<option value="DE" <?php selected($ocwscc_gpstate, 'DE'); ?>>Delaware</option>
			<option value="DC" <?php selected($ocwscc_gpstate, 'DC'); ?>>District Of Columbia</option>
			<option value="FL" <?php selected($ocwscc_gpstate, 'FL'); ?>>Florida</option>
			<option value="GA" <?php selected($ocwscc_gpstate, 'GA'); ?>>Georgia</option>
			<option value="HI" <?php selected($ocwscc_gpstate, 'HI'); ?>>Hawaii</option>
			<option value="ID" <?php selected($ocwscc_gpstate, 'ID'); ?>>Idaho</option>
			<option value="IL" <?php selected($ocwscc_gpstate, 'IL'); ?>>Illinois</option>
			<option value="IN" <?php selected($ocwscc_gpstate, 'IN'); ?>>Indiana</option>
			<option value="IA" <?php selected($ocwscc_gpstate, 'IA'); ?>>Iowa</option>
			<option value="KS" <?php selected($ocwscc_gpstate, 'KS'); ?>>Kansas</option>
			<option value="KY" <?php selected($ocwscc_gpstate, 'KY'); ?>>Kentucky</option>
			<option value="LA" <?php selected($ocwscc_gpstate, 'LA'); ?>>Louisiana</option>
			<option value="ME" <?php selected($ocwscc_gpstate, 'ME'); ?>>Maine</option>
			<option value="MD" <?php selected($ocwscc_gpstate, 'MD'); ?>>Maryland</option>
			<option value="MA" <?php selected($ocwscc_gpstate, 'MA'); ?>>Massachusetts</option>
			<option value="MI" <?php selected($ocwscc_gpstate, 'MI'); ?>>Michigan</option>
			<option value="MN" <?php selected($ocwscc_gpstate, 'MN'); ?>>Minnesota</option>
			<option value="MS" <?php selected($ocwscc_gpstate, 'MS'); ?>>Mississippi</option>
			<option value="MO" <?php selected($ocwscc_gpstate, 'MO'); ?>>Missouri</option>
			<option value="MT" <?php selected($ocwscc_gpstate, 'MT'); ?>>Montana</option>
			<option value="NE" <?php selected($ocwscc_gpstate, 'NE'); ?>>Nebraska</option>
			<option value="NV" <?php selected($ocwscc_gpstate, 'NV'); ?>>Nevada</option>
			<option value="NH" <?php selected($ocwscc_gpstate, 'NH'); ?>>New Hampshire</option>
			<option value="NJ" <?php selected($ocwscc_gpstate, 'NJ'); ?>>New Jersey</option>
			<option value="NM" <?php selected($ocwscc_gpstate, 'NM'); ?>>New Mexico</option>
			<option value="NY" <?php selected($ocwscc_gpstate, 'NY'); ?>>New York</option>
			<option value="NC" <?php selected($ocwscc_gpstate, 'NC'); ?>>North Carolina</option>
			<option value="ND" <?php selected($ocwscc_gpstate, 'ND'); ?>>North Dakota</option>
			<option value="OH" <?php selected($ocwscc_gpstate, 'OH'); ?>>Ohio</option>
			<option value="OK" <?php selected($ocwscc_gpstate, 'OK'); ?>>Oklahoma</option>
			<option value="OR" <?php selected($ocwscc_gpstate, 'OR'); ?>>Oregon</option>
			<option value="PA" <?php selected($ocwscc_gpstate, 'PA'); ?>>Pennsylvania</option>
			<option value="RI" <?php selected($ocwscc_gpstate, 'RI'); ?>>Rhode Island</option>
			<option value="SC" <?php selected($ocwscc_gpstate, 'SC'); ?>>South Carolina</option>
			<option value="SD" <?php selected($ocwscc_gpstate, 'SD'); ?>>South Dakota</option>
			<option value="TN" <?php selected($ocwscc_gpstate, 'TN'); ?>>Tennessee</option>
			<option value="TX" <?php selected($ocwscc_gpstate, 'TX'); ?>>Texas</option>
			<option value="UT" <?php selected($ocwscc_gpstate, 'UT'); ?>>Utah</option>
			<option value="VT" <?php selected($ocwscc_gpstate, 'VT'); ?>>Vermont</option>
			<option value="VA" <?php selected($ocwscc_gpstate, 'VA'); ?>>Virginia</option>
			<option value="WA" <?php selected($ocwscc_gpstate, 'WA'); ?>>Washington</option>
			<option value="WV" <?php selected($ocwscc_gpstate, 'WV'); ?>>West Virginia</option>
			<option value="WI" <?php selected($ocwscc_gpstate, 'WI'); ?>>Wisconsin</option>
			<option value="WY" <?php selected($ocwscc_gpstate, 'WY'); ?>>Wyoming</option>
			<option value="AB" <?php selected($ocwscc_gpstate, 'AB'); ?>>Alberta</option>
			<option value="BC" <?php selected($ocwscc_gpstate, 'BC'); ?>>British Columbia</option>
			<option value="MB" <?php selected($ocwscc_gpstate, 'MB'); ?>>Manitoba</option>
			<option value="NB" <?php selected($ocwscc_gpstate, 'NB'); ?>>New Brunswick</option>
			<option value="NL" <?php selected($ocwscc_gpstate, 'NL'); ?>>Newfoundland and Labrador</option>
			<option value="NS" <?php selected($ocwscc_gpstate, 'NS'); ?>>Nova Scotia</option>
			<option value="ON" <?php selected($ocwscc_gpstate, 'ON'); ?>>Ontario</option>
			<option value="PE" <?php selected($ocwscc_gpstate, 'PE'); ?>>Prince Edward Island</option>
			<option value="QC" <?php selected($ocwscc_gpstate, 'QC'); ?>>Quebec</option>
			<option value="SK" <?php selected($ocwscc_gpstate, 'SK'); ?>>Saskatchewan</option>
			<option value="NT" <?php selected($ocwscc_gpstate, 'NT'); ?>>Northwest Territories</option>
			<option value="NU" <?php selected($ocwscc_gpstate, 'NU'); ?>>Nunavut</option>
			<option value="YT" <?php selected($ocwscc_gpstate, 'YT'); ?>>Yukon</option>
		</select></td><!-- Col 2 -->
          </tr>
        </table>

  
  </div><!-- end ocws_box_mid -->
  </td>
  <td style="width:33%">
	
	  <div id="ocws_box_right" style="border:solid 1px #000000; border-radius:25px; padding:10px; width:90%;float:right;text-align:center;min-height:270px;">
	  <?php
			if (($ocwscc_cclon != "") && ($ocwscc_cclat != "")) {
				echo ocws_googlemap($ocwscc_cclon,$ocwscc_cclat,250,250) . "\n";
				
			}
	  ?>
	  </div><!-- end ocws_box_right -->
	  </td>
	  </tr>
	  </table><!-- end of ocws_metaboxtable -->
	
	<?php
	
} // end of ocwscc_mbe_function

function ocwscc_mbe_function_sd($post) {
// mdeta box for short description
echo "<p>If you need to add a short description for the ".CCNAME_SG.", you can add it here. The Long Description is added above, in the main editing box.</p>";

$ocwscc_shortdesc=  get_post_meta($post->ID, '_ocwscc_gpshortdesc' , true ) ;
$ocws_wpe_settings = array(
    'textarea_rows' => 10,
);
wp_editor( htmlspecialchars_decode($ocwscc_shortdesc), 'ocwscc_gpshortdesc', $ocws_wpe_settings );


} // end ocwscc_mbe_function_sd 

function ocwscc_mbe_function_save($post_id) {
	// this function will save the data used by ocwscc_mbe_function and ocwscc_mbe_function_sd
	
	// first check to ssee if the metadata has been set
	if ( isset( $_POST['ocwscc_ccname'])) {
		
		// now save the data
		
		update_post_meta( $post_id, '_ocwscc_ccname', strip_tags( $_POST['ocwscc_ccname']));
		update_post_meta( $post_id, '_ocwscc_ccdate', strip_tags( $_POST['ocwscc_ccdate']));
		update_post_meta( $post_id, '_ocwscc_cclon', strip_tags( $_POST['ocwscc_cclon']));
		update_post_meta( $post_id, '_ocwscc_cclat', strip_tags( $_POST['ocwscc_cclat']));
		update_post_meta( $post_id, '_ocwscc_gpowner', strip_tags( $_POST['ocwscc_gpowner']));
		update_post_meta( $post_id, '_ocwscc_gpdiff', strip_tags( $_POST['ocwscc_gpdiff']));
		update_post_meta( $post_id, '_ocwscc_gpterr', strip_tags( $_POST['ocwscc_gpterr']));
		update_post_meta( $post_id, '_ocwscc_gpcountry', strip_tags( $_POST['ocwscc_gpcountry']));
		update_post_meta( $post_id, '_ocwscc_gpstate', strip_tags( $_POST['ocwscc_gpstate']));
		update_post_meta( $post_id, '_ocwscc_gpshortdesc', htmlspecialchars ( $_POST['ocwscc_gpshortdesc']));
		
	/* FILE CREATION */
	/* ------------------------------------------------------------------------------------------------------ */
	/* I need to add a routine here to create both the .gpx and .loc files, and store them somewhere suitable */
	/* It needs to create the file if it doesn't exist, check whether it exists,                              */
	/* and update it if it already exists                                                                     */
		ocwscc_createandsave("gpx", $post_id);
		ocwscc_createandsave("loc", $post_id);
	/* ------------------------------------------------------------------------------------------------------ */
	/* FILE CREATION END */
		
		
	} // end if
	
	
} // end ocwscc_mbe_function_save

function ocwscc_createandsave($cc_fileext, $ccpostid) {
	// this function checks the file extension and directs to the appropriate builder
	switch ($cc_fileext) {
		case "gpx":
			$occoutput = cc_bld_gpx($ccpostid);
			break;
		case "loc":
			$occoutput = cc_bld_loc($ccpostid);
			break;
		default:
			exit( "<p style=\"color:#ff0000\">File extension only works with gpx or loc</p>\n" );
	} // end switch
	
	$ocwscc_ccname = get_post_meta( $ccpostid, '_ocwscc_ccname', true);
	$cc_filename = $ocwscc_ccname.".".$cc_fileext;
	
	$cc_filepath = OCWSCC_GPX."/".$cc_filename;
	file_put_contents($cc_filepath,$occoutput);
	
        $cc_zipfilename = $ocwscc_ccname."_".$cc_fileext.".zip";
	$cc_zipfilepath = OCWSCC_GPX."/".$cc_zipfilename;
	
	if (file_exists($cc_zipfilepath)) {
	unlink($cc_zipfilepath);
        }
        $zip = new ZipArchive();
        $zip->open($cc_zipfilepath, ZIPARCHIVE::CREATE);

	$zip->addFile($cc_filepath, $cc_filename);
	
	$zip->close();
	

	
	
} // end function ocwscc_createandsave

function cc_bld_gpx($ccpostid) {
	// builds the gpx file
	
	// let's see if any metadata values exist
	$ocwscc_ccname = get_post_meta( $ccpostid, '_ocwscc_ccname', true);
	$ocwscc_ccdate = get_post_meta( $ccpostid, '_ocwscc_ccdate', true);
	$ocwscc_cclon = get_post_meta( $ccpostid, '_ocwscc_cclon', true);
	$ocwscc_cclat = get_post_meta( $ccpostid, '_ocwscc_cclat', true);
	$ocwscc_gpname = get_post_meta( $ccpostid, '_ocwscc_gpname', true);
	$ocwscc_gpowner = get_post_meta( $ccpostid, '_ocwscc_gpowner', true);
	$ocwscc_gpdiff = get_post_meta( $ccpostid, '_ocwscc_gpdiff', true);
	$ocwscc_gpterr = get_post_meta( $ccpostid, '_ocwscc_gpterr', true);
	$ocwscc_gpcountry = get_post_meta( $ccpostid, '_ocwscc_gpcountry', true);
	$ocwscc_gpstate = get_post_meta( $ccpostid, '_ocwscc_gpstate', true);
	$ocwscc_shortdesc =  get_post_meta($ccpostid, '_ocwscc_gpshortdesc' , true );
	$ocwscc_cachetype = get_the_term_list( $ccpostid,'cachetype'); 
	$cccontent_post = get_post($ccpostid);
	$cccontent = $cccontent_post->post_content;
	$cccontent = apply_filters('the_content', $cccontent);
	$cccontent = htmlspecialchars($cccontent);
	
	// now let's build the file output
	$cc_output = "";
	$cc_output .= "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$cc_output .= "<gpx xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" version=\"1.0\" creator=\"Mount St Helens Creation Center. All Rights Reserved. http://www.mshcreationcenter.org\" xsi:schemaLocation=\"http://www.topografix.com/GPX/1/0 http://www.topografix.com/GPX/1/0/gpx.xsd http://www.groundspeak.com/cache/1/0 http://www.groundspeak.com/cache/1/0/cache.xsd\" xmlns=\"http://www.topografix.com/GPX/1/0\">\n";
	$cc_output .= "  <name>Creation Cache listing from mshcreationcenter.org</name>\n";
	$cc_output .= "  <desc>This is an individual cache generated from mshcreationcenter.org</desc>\n";
	$cc_output .= "  <author>Account \"".$ocwscc_gpowner."\" From mshcreationcenter.org</author>\n";
	$cc_output .= "  <email>info@mshcreationcenter.org</email>\n";
	$cc_output .= "  <url>http://www.mshcreationcenter.org</url>\n";
	$cc_output .= "  <urlname>Creation Caching - the treasure hunting bug with a biblical and scientific perspective</urlname>\n";
	$cc_output .= "  <time>".time()."</time>\n";
	$cc_output .= "  <keywords>cache, geocache, creationcache</keywords>\n";
	$cc_output .= "  <bounds minlat=\"".$ocwscc_cclat."\" minlon=\"".$ocwscc_cclon."\" maxlat=\"".$ocwscc_cclat."\" maxlon=\"".$ocwscc_cclon."\" />\n";
	$cc_output .= "  <wpt lat=\"".$ocwscc_cclat."\" lon=\"".$ocwscc_cclon."\">\n";
	$cc_output .= "    <time>".$ocwscc_ccdate."</time>\n";
	$cc_output .= "    <name>".$ocwscc_ccname."</name>\n";
	$cc_output .= "    <desc>".get_the_title($ccpostid)." by ".$ocwscc_gpowner.", Unknown Cache (".$ocwscc_gpdiff."/".$ocwscc_gpterr.")</desc>\n";
	$cc_output .= "    <url>".get_post_permalink($ccpostid)."</url>\n";
	$cc_output .= "    <urlname>".get_the_title($ccpostid)."</urlname>\n";
	$cc_output .= "    <sym>Creation Cache Found</sym>\n";
	$cc_output .= "    <type>Creation Cache|Unknown Cache</type>\n";
	$cc_output .= "    <groundspeak:cache id=\"".$ccpostid."\" available=\"True\" archived=\"False\" xmlns:groundspeak=\"http://www.groundspeak.com/cache/1/0\">\n";
	$cc_output .= "      <groundspeak:name>".get_the_title($ccpostid)."</groundspeak:name>\n";
	$cc_output .= "      <groundspeak:placed_by>".$ocwscc_gpowner."</groundspeak:placed_by>\n";
	$cc_output .= "      <groundspeak:owner>".$ocwscc_gpowner."</groundspeak:owner>\n";
	$cc_output .= "      <groundspeak:type>".$ocwscc_cachetype." Cache</groundspeak:type>\n";
	$cc_output .= "      <groundspeak:container>Unknown</groundspeak:container>\n";
	$cc_output .= "      <groundspeak:difficulty>".$ocwscc_gpdiff."</groundspeak:difficulty>\n";
	$cc_output .= "      <groundspeak:terrain>".$ocwscc_gpterr."</groundspeak:terrain>\n";
	$cc_output .= "      <groundspeak:country>".$ocwscc_gpcountry."</groundspeak:country>\n";
	$cc_output .= "      <groundspeak:state>".$ocwscc_gpstate."</groundspeak:state>\n";
	$cc_output .= "      <groundspeak:short_description html=\"True\">".$ocwscc_shortdesc."</groundspeak:short_description>\n";
	$cc_output .= "      <groundspeak:long_description html=\"True\">".$cccontent."</groundspeak:long_description>\n";
	$cc_output .= "      <groundspeak:encoded_hints>\n";
	$cc_output .= "      </groundspeak:encoded_hints>\n";
	$cc_output .= "      <groundspeak:travelbugs />\n";
	$cc_output .= "    </groundspeak:cache>\n";
	$cc_output .= "  </wpt>\n";
	$cc_output .= "</gpx>";
	
	return $cc_output;
} // end cc_bld_gpx

function cc_bld_loc($ccpostid) {
	// builds the gpx file
	
	// let's see if any metadata values exist
	$ocwscc_ccname = get_post_meta( $ccpostid, '_ocwscc_ccname', true);
	$ocwscc_ccdate = get_post_meta( $ccpostid, '_ocwscc_ccdate', true);
	$ocwscc_cclon = get_post_meta( $ccpostid, '_ocwscc_cclon', true);
	$ocwscc_cclat = get_post_meta( $ccpostid, '_ocwscc_cclat', true);
	$ocwscc_gpname = get_post_meta( $ccpostid, '_ocwscc_gpname', true);
	$ocwscc_gpowner = get_post_meta( $ccpostid, '_ocwscc_gpowner', true);
	$ocwscc_gpdiff = get_post_meta( $ccpostid, '_ocwscc_gpdiff', true);
	$ocwscc_gpterr = get_post_meta( $ccpostid, '_ocwscc_gpterr', true);
	$ocwscc_gpcountry = get_post_meta( $ccpostid, '_ocwscc_gpcountry', true);
	$ocwscc_gpstate = get_post_meta( $ccpostid, '_ocwscc_gpstate', true);
	$ocwscc_shortdesc =  get_post_meta($ccpostid, '_ocwscc_gpshortdesc' , true );
	$ocwscc_cachetype = get_the_term_list( $ccpostid,'cachetype'); 
	$cccontent_post = get_post($ccpostid);
	$cccontent = $cccontent_post->post_content;
	$cccontent = apply_filters('the_content', $cccontent);
	$cccontent = htmlspecialchars($cccontent);
	
	$cc_output="";
	$cc_output.="<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
	$cc_output.="<loc version=\"1.0\" src=\"Groundspeak\">\n";
	$cc_output.="<waypoint>\n";
	$cc_output.="<name id=\"".$ocwscc_ccname."\"><![CDATA[".get_the_title($ccpostid)." by ".$ocwscc_gpowner."]]>\n";
	$cc_output.="</name>\n";
	$cc_output.="<coord lat=\"".$ocwscc_cclat."\" lon=\"".$ocwscc_cclon."\"/>\n";
	$cc_output.="<type>Geocache</type>\n";
	$cc_output.="<link text=\"Cache Details\">".get_post_permalink($ccpostid)."</link>\n";
	$cc_output.="<difficulty>".$ocwscc_gpdiff."</difficulty>\n";
	$cc_output.="<terrain>".$ocwscc_gpterr."</terrain>\n";
	$cc_output.="<container></container>\n";
	$cc_output.="</waypoint></loc>";
	
	return $cc_output;
} // end function cc_bld_loc

/* end of meta boxes code */

/* RECORD DELETION ROUTINE */
/* ================================================================= */
/* There are hooks to operate when the trash link is clicked */
/* I need to manipulate these hooks, to ensure that */
/* all post meta data is deleted when a record is deleted */
/* and the .gpx and .loc files previously created are also deleted */
/* ================================================================= */
/* END RECORD DELETION ROUTINE */



function ocws_googlemap($olon,$olat,$ow,$oh) {
// this function creates a Google map from inputted longitude and latitude
$html="";
$html .= "<iframe src=\"https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d11020.919125834707!2d".$olon."!3d".$olat."!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sus!4v1439768024304\" width=\"".$ow."\" height=\"".$oh."\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>";
return $html;
}

/* START DISPLAY FUNCTIONS */

/* This is my own special function, to create the main content for a Creation Cache page */
function ocwscc_get_template_part($osection, $opagetype, $post) {
	// this will replace the get_template_part function to deliver my own content
	if ($opagetype == 'single') { // this if statement tests for the display of a single. The 'else' part will display an archive
		// initialize the function
		$ocwscc_ccname = get_post_meta( $post->ID, '_ocwscc_ccname', true);
		$ocwscc_ccdate = get_post_meta( $post->ID, '_ocwscc_ccdate', true);
		$ocwscc_cclon = get_post_meta( $post->ID, '_ocwscc_cclon', true);
		$ocwscc_cclat = get_post_meta( $post->ID, '_ocwscc_cclat', true);
		$ocwscc_gpname = get_post_meta( $post->ID, '_ocwscc_gpname', true);
		$ocwscc_gpowner = get_post_meta( $post->ID, '_ocwscc_gpowner', true);
		$ocwscc_gpdiff = get_post_meta( $post->ID, '_ocwscc_gpdiff', true);
		$ocwscc_gpterr = get_post_meta( $post->ID, '_ocwscc_gpterr', true);
		$ocwscc_gpcountry = get_post_meta( $post->ID, '_ocwscc_gpcountry', true);
		$ocwscc_gpstate = get_post_meta( $post->ID, '_ocwscc_gpstate', true);
		$ocwscc_shortdesc=  get_post_meta($post->ID, '_ocwscc_gpshortdesc' , true ) ;
		?>
			<!-- create ocwscc_infobox section -->
			<div id="ocwscc_infobox">
				<p><strong><?php echo CCNAME_SG; ?> Details</strong></p>
				<table>
					<tr>
					<td class="ocwscc_tright">Longitude:</td>
					<td class="ocwscc_tleft"><?php echo $ocwscc_cclon; ?></td>
					</tr>
					<tr>
					<td class="ocwscc_tright">Latitude:</td>
					<td class="ocwscc_tleft"><?php echo $ocwscc_cclat; ?></td>
					</tr>
					<tr>
					<td class="ocwscc_tright">Difficulty:</td>
					<td class="ocwscc_tleft"><?php echo ocwscc_displaystars(5,$ocwscc_gpdiff); ?></td>
					</tr>
					<tr>
					<td class="ocwscc_tright">Terrain:</td>
					<td class="ocwscc_tleft"><?php echo ocwscc_displaystars(5,$ocwscc_gpterr); ?></td>
					</tr>
					<tr>
					<td class="ocwscc_tright">Date Created:</td>
					<td class="ocwscc_tleft"><?php echo $ocwscc_ccdate; ?></td>
					</tr>
				</table>
				<?php echo ocws_googlemap($ocwscc_cclon,$ocwscc_cclat,250,250); ?><br /><br />
				<div id="ocwscc_infobox_inner" class="ocwscc_infoboxc2">
				<p>To download files: right-click on button and select &quot;Save Link As&quot;</p>
				<a href="<?php echo OCWSCC_GPX_URL.$ocwscc_ccname.".gpx"; ?>" download><img src="<?php echo OCWSCC_BASE_URL."/images/download_gpx.png"; ?>" width="150" height="31" alt="Click to download .gpx file" title=".gpx" /></a><br />
				<a href="<?php echo OCWSCC_GPX_URL.$ocwscc_ccname.".loc"; ?>" download><img src="<?php echo OCWSCC_BASE_URL."/images/download_loc.png"; ?>" width="150" height="31" alt="Click to download .loc file" title=".loc" /></a>
				</div><!-- end ocwscc_infobox_inner -->
			</div><!-- end ocwscc_infobox -->
			<!-- end ocwscc_infobox section -->
		<?php
		$ocwscc_cacheterms = get_the_term_list( $post_id,'cachetype');
                
		echo "<h1><a href=\"".get_site_url()."/".CCSLUG."/"."\">".CCNAME_SG."</a> #".$ocwscc_ccname."</h1>\n";
                echo "<div id=\"ocwscc-typeimg-box\" class=\"ocwscc-typeimg-box\">\n";

                echo "<img src=\"" . ocwscc_ctype_image_url($post_id) . "\" alt=\"".wp_strip_all_tags($ocwscc_cacheterms)."\" title=\"".wp_strip_all_tags($ocwscc_cacheterms)."\"class=\"wp-post-image ocws-typeimg-size\" />\n";
                echo "</div><!-- end ocwscc-typeimg-box -->\n";
                echo "<p><strong>A cache placed by ".$ocwscc_gpowner.".</strong> (<em>A ".$ocwscc_cacheterms." Cache.</em>)</p>\n";
		echo "<p>Cache situated in ".$ocwscc_gpstate.", ".$ocwscc_gpcountry.".</p>\n";
		?>

		<?php
		
		echo "<p><strong>".CCNAME_SG." Description</strong></p>\n";
		get_template_part( $osection, $opagetype );
		
		echo "<p><strong>Short Description</strong></p>\n";
		echo htmlspecialchars_decode($ocwscc_shortdesc)."<br />";
?>
                        <p>&nbsp;</p><p><strong>About <?php echo CCNAME_ACT; ?></strong></p>
                <p><?php echo CCNAME_ACT; ?> (<em>based on Geocaching&trade;</em>) is a real-world, outdoor treasure hunting game using GPS-enabled devices. Participants navigate
	to a specific set of GPS coordinates and then attempt to find the geocache (container) hidden at that location.</p>
<?php
	} // end of the 'single' display items
	else { // this is to display an archive
		if ($opagetype == 'archive') { // this just checks that it really is an archive, and leads to failure of any other type attenpted
			// initialize
			
					$ocwscc_ccname = get_post_meta( $post->ID, '_ocwscc_ccname', true);
					$ocwscc_ccdate = get_post_meta( $post->ID, '_ocwscc_ccdate', true);
					$ocwscc_cclon = get_post_meta( $post->ID, '_ocwscc_cclon', true);
					$ocwscc_cclat = get_post_meta( $post->ID, '_ocwscc_cclat', true);
					$ocwscc_gpname = get_post_meta( $post->ID, '_ocwscc_gpname', true);
					$ocwscc_gpowner = get_post_meta( $post->ID, '_ocwscc_gpowner', true);
					$ocwscc_gpdiff = get_post_meta( $post->ID, '_ocwscc_gpdiff', true);
					$ocwscc_cachetype = get_the_term_list( $post->ID,'cachetype');
                                        
					echo the_title("<h3><a href=\"".get_permalink()."\">","</a></h3>",false)."\n";
					echo "<div id=\"ocwscc-typeimg-box\" class=\"ocwscc-typeimg-box\">\n";
                                        echo "<img src=\"" . ocwscc_ctype_image_url($post_id) . "\" alt=\"".wp_strip_all_tags($ocwscc_cachetype)."\" title=\"".wp_strip_all_tags($ocwscc_cachetype)."\"class=\"wp-post-image ocws-typeimg-size-arch\" />\n";
                                        echo "</div><!-- end ocwscc-typeimg-box -->\n";
                                        echo "<p><strong>".CCNAME_SG." #".$ocwscc_ccname."</strong> - A ".$ocwscc_cachetype." cache placed by ".$ocwscc_gpowner." on ".$ocwscc_ccdate."</p>\n";
					echo "<p>".the_excerpt();
					echo "<a href=\"".get_permalink()."\">Read more...</a></p>\n";
					
		} // end of archive positive test
	} // end of archive display
} // end function ocwscc_get_template_part

function ocwscc_displaystars($onum,$oseed) {
	// this will display 5 stars, indicating quantities out of 5
	$ounits = intval($oseed);
	$odiff = $onum - $oseed;
	$ogray = intval($odiff);
	echo "<span title=\"".$oseed."\">";
	if ($ounits > 0) {
		for ($x=1; $x<=$ounits; $x++) {
			echo "<img src=\"".OCWSCC_BASE_URL."/images/goldstar.png\" alt=\"\" title=\"".$oseed."\" />";
		}
	}
	if ($onum != ($ogray+$units)) {
		echo "<img src=\"".OCWSCC_BASE_URL."/images/goldgraystar.png\" alt=\"\" title=\"".$oseed."\" />";
	}
	if ($ogray > 0) {
		for ($x=1; $x<=$ogray; $x++) {
			echo "<img src=\"".OCWSCC_BASE_URL."/images/graystar.png\" alt=\"\" title=\"".$oseed."\" />";
		}
	}
	echo "</span>\n";
	
}

function get_custom_post_type_template($single_template) {
     global $post;

     if ($post->post_type == CCSLUG) {
          $single_template = OCWSCC_BASE_DIR . '/templates/single-creationcache.php';
     }
     return $single_template;
}

function get_custom_post_type_archtemplate($archive_template) {
     global $post;

     if ($post->post_type == CCSLUG) {
          $archive_template = OCWSCC_BASE_DIR . '/templates/archive-creationcache.php';
     }
     return $archive_template;
}

/* END DISPLAY FUNCTIONS */

/* MAKE AN INFO PAGE (where the settings page normally goes */

function ocwscc_admin_menu() {
	// makes the info page
	
	add_submenu_page('options-general.php','OCWS Creation Cache', 'OCWS Creation Cache', 'administrator', 'ocws_creationcache', 'ocwscc_info_page');
	
	
} // end ocwscc_admin_menu

function ocwscc_info_page() {
	// here is where the page code goes
	?>
	<div id="ocwscc_info_page_id" class="wrap">
		<h2>OCWS Creation Cache Plugin</h2>
		
		<img src="<?php echo OCWSCC_BASE_URL."/images/".CC_LOGO80; ?>" width="80" height="80" style="float:right;" alt="Creation Cache logo" title="Creation Cache" />

		<h3>An <img src="<?php echo OCWSCC_BASE_URL."/images/castlelogo16x16.png"; ?>" width="16" height="16" alt="Old Castle Web Services logo" title="OCWS" /> <a href="http://oldcastleweb.com" target="_blank">Old Castle Web Services</a> plugin - Version <?php echo CCVERSION; ?></h3>
		
		<p style="font-variant: small-caps;">Although the heading above refers to Creation Caches, you can change the name of the caches to that of your choice. As this change needs hard-wiring, this should be done by amending the configuration file (ocws-creationcache-config.php). The hard-wiring could not be achieved through a dashboard panel here. If you make the changes in the configuration file, your users will see only your name for the caches, not mine.</p>
		<p><a href="<?php echo OCWSCC_EDITCONF; ?>">Edit the ocws-creationcache-config.php file here</a><p>
		<hr style="width:60%" />
		<h3>This is an <strong>Information Page</strong> (not a settings page)</h3>
		<p>Not so long ago, caching files could be downloaded and added, by USB cable, to a suitable third-party device, such as a GPS device. (For example, the excellent <strong>eTrex</strong> devices produced by Garmin&trade;). 
		</p>
		<p>
		Today, however, most people do caching by smartphone. This is easy, but it means that Groundspeak (which operates the site geocaching.com) have sewn up most of the methods of delivering caches. If you are going to offer alternative, open source caches, you will need a method of enabling your users to use their smartphones. This will not be as easy as using the Geocaching&trade; app, but it does not have to be very difficult. You need to encourage your users to use an independent smartphone app, which can import .gpx or .loc files. 
		</p>
		<p>
		The best such app that I have found is CacheSense, which runs on Android phones and tablets. I have found that it displays my cache creations perfectly. At the time of writing, I do not know of a suitable alternative for iPhones, so would welcome suggestions.</p>
		<hr style="width:60%" />
		<h3>Make your own information page</h3>
		<p>Many of your users will not understand the concept of caching. You need an information page of your own, to help them. I thought about getting this plugin to make one for you, but I think everyone's needs are likely to be different, so I suggest you make your own, as a static page. This could be accessed from your menu, and then you could use the <?php echo CCNAME_SG; ?> archive listing as a link from this. Please feel welcome to copy any of the information that I have put here, and chop and change it however you want.</p>
		<p>Happy Caching!</p>
		<hr style="width:60%" />
		<h3>Some of the things your users will need</h3>
		<div id="ocwscc_floating_images" class="ocwscc_infoboxc2">
		<table>
		<tr>
		<td><img src="<?php echo OCWSCC_BASE_URL."/images/gps_device.jpg"; ?>" width="200" height="200" alt="GPS device" title="GPS device" style="padding-right:5px;" /></td>
		<td><img src="<?php echo OCWSCC_BASE_URL."/images/cachesense.jpg"; ?>" width="120" height="200" alt="Cachesense app on an Android smartphone" title="CacheSense" style="padding-right:5px;" /></td>
		<td><img src="<?php echo OCWSCC_BASE_URL."/images/looking4cache.jpg"; ?>" width="133" height="200" alt="Looking 4 Cache on an iPhone" title="Looking 4 Cache" style="padding-right:5px;" /></td>
		<td><img src="<?php echo OCWSCC_BASE_URL."/images/easygps.jpg"; ?>" width="284" height="200" alt="EasyGPS" title="EasyGPS" style="padding-right:5px;" /></td>
		</tr>
		
		<tr>
		<td><span style="font-size:9pt;font-weight:bold;font-variant:small-caps;">A hand-held GPS device</span></td>
		<td><span style="font-size:9pt;font-weight:bold;font-variant:small-caps;">The CacheSense app on Android</span></td>
		<td><span style="font-size:9pt;font-weight:bold;font-variant:small-caps;">The Looking4Cache app on iPhone/iPad</span></td>
		<td><span style="font-size:9pt;font-weight:bold;font-variant:small-caps;">The EasyGPS Program</span></td>
		</tr>
		
		</table>
		</div><!-- end div ocwscc_floating_images -->
		<p>
		Your users need something to display and find the caches with. This device will need to be able to accept, store and read the .gpx or .loc files produced by this plugin. Some of the possibilities are displayed above, and they are:
		<ul style="list-style-type: circle;">
			<li>A hand-held GPS device. The most common, and probably best, of these are the eTrex series from <a href="https://buy.garmin.com/en-US/US/eTrex/into-sports/handheld/cIntoSports-c10341-bBRAND472-p1.html" target="_blank">Garmin</a>.</li>
			<li>Android and iPhones alike have GPS location apparatus on board. So you need a good app to make use of this. The app needs not just to interface with geocaching.com, because your site will now be offering non-geocaching caches. So you need an app which will import anyone elses .gpx and .loc files. One of the best of these on Android is <a href="http://www.cachesense.com/" target="_blank">CacheSense</a>. Although the free version is okay, the pro version is not expensive, and I recommend getting it.</li>
			<li>I am not an iPhone user. Browsing the websites, it would appear, on recommendations from other blogs, that a good Applestore alternative to CacheSense is <a href="http://www.looking4cache.com/" target="_blank">Looking 4 Cache</a>.</li>
			<li>Your users might find it useful to have some software to read the .gpx files on the PC, and to make transfer of these files to your device easier. Some free software that does this is <a href="http://www.easygps.com/" target="_blank">EasyGPS</a></li>
		</ul>
		</p>
		<p style="font-weight:bold">Please note that there are many others available. I am not sponsored by any of these companies - I am offering these hopefully only as helpful suggestions, not advertisements or endorsements.</p>

	
	
	</div><!-- /end ocwscc-info-page-id -->
	
	<?php
	
	
} // end ocwscc_info_page

function ocws_creationcache_info_link($links) { 

  $settings_link = '<a href="options-general.php?page=ocws_creationcache">Information</a>'; 

  array_unshift($links, $settings_link); 

  return $links; 

}

/* END INFO PAGE */

/* Functions for edit pages */
function add_new_creationcache_columns($columns) {
    $new_columns['cb'] = '<input type="checkbox" />';
     
    
	$new_columns['cachenum'] = __('Cache #');
    $new_columns['title'] = _x('Creation Cache', 'column name');
    $new_columns['author'] = __('Author');
     
    $new_columns['cachetype'] = __('Cache Type');
    $new_columns['ctype_img'] = __('Image');
    $new_columns['date'] = _x('Date', 'column name');
 
    return $new_columns;
}

function manage_creationcache_columns($column_name, $post_id) {
    // global $post;
        $ocwscc_cachetype = get_the_term_list( $post_id,'cachetype');
	switch ($column_name) {
    
	case 'cachenum':
		echo get_post_meta( $post_id, '_ocwscc_ccname', true);
			break;
	case 'cachetype':
		echo wp_strip_all_tags(get_the_term_list( $post_id,'cachetype'));
			break;
        case 'ctype_img':
            $ccterm_name = wp_strip_all_tags(get_the_term_list( $post_id,'cachetype'));
            $ccterm = get_term_by( 'name', $ccterm_name,'cachetype');
            $ccterm_id = $ccterm->term_id;
            // echo ocws_ctype_id_image_url($ccterm_id);
            echo "<img src=\"" . ocws_ctype_id_image_url($ccterm_id) . "\" alt=\"".wp_strip_all_tags($ocwscc_cachetype)."\" title=\"".wp_strip_all_tags($ocwscc_cachetype)."\" class=\"wp-post-image ocws-typeimg-size-arch\" width=\"40\" height=\"40\" />\n";
                        break;
    default:
        break;
    } // end switch
}   

function creationcache_sortable_columns( $columns ) {

	$columns['cachenum'] = 'Cache #';
        $columns['cachetype'] = 'Cache Type';


	return $columns;
}

/* Only run our customization on the 'edit.php' page in the admin. */

function my_edit_creationcache_load() {
	add_filter( 'request', 'my_sort_creationcaches' );
}

/* Sorts the creation caches. */
function my_sort_creationcaches( $vars ) {

	/* Check if we're viewing the 'creationcache' post type. */
	if ( isset( $vars['post_type'] ) && CCSLUG == $vars['post_type'] ) {

		/* Check if 'orderby' is set to 'cachenum'. */
		/* THIS SECTION OF THE FUNCTION MAY NEED CHECKING!! */
		if ( isset( $vars['orderby'] ) && 'cachenum' == $vars['orderby'] ) {

			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'cachenum',
					'orderby' => 'meta_value_num'
				)
			);
		}
	}

	return $vars;
}


/* End Functions for edit pages */


/* Deleting stuff */
add_action( 'trash_'.CCSLUG, 'ocwscc_deleteacache' );

function ocwscc_deleteacache($post_id) {
	// this function runs when a cache record is deletd, so that post-meta data and the appropriate files are deleted
	
		$ocwscc_ccname = get_post_meta( $post_id, '_ocwscc_ccname', true);
		unlink(OCWSCC_GPX.$ocwscc_ccname.".gpx");
		unlink(OCWSCC_GPX.$ocwscc_ccname.".loc");
		unlink(OCWSCC_GPX.$ocwscc_ccname."_gpx.zip");
		unlink(OCWSCC_GPX.$ocwscc_ccname."_loc.zip");
		
		
		delete_post_meta( $post_id, '_ocwscc_ccname');
		delete_post_meta( $post_id, '_ocwscc_ccdate');
		delete_post_meta( $post_id, '_ocwscc_cclon');
		delete_post_meta( $post_id, '_ocwscc_cclat');
		delete_post_meta( $post_id, '_ocwscc_gpname');
		delete_post_meta( $post_id, '_ocwscc_gpowner');
		delete_post_meta( $post_id, '_ocwscc_gpdiff');
		delete_post_meta( $post_id, '_ocwscc_gpterr');
		delete_post_meta( $post_id, '_ocwscc_gpcountry');
		delete_post_meta( $post_id, '_ocwscc_gpstate');
		delete_post_meta( $post_id, '_ocwscc_gpshortdesc') ;
	
		
} // end function ocwscc_deleteacache


/* End delete stuff */



?>
