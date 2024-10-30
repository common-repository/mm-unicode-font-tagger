<?php
/*
Plugin Name: Myanmar Unicode Font Tagger
Plugin URI: http://ttkz.me
Description: This plugin for those who write blog in Myanmar Unicode. This will force to tag CSS Font Family, Myanmar Unicode.
Author: Thant Thet Khin Zaw
Version: 1.1.2
Author URI: http://ttkz.me/
*/

$mm_unicode_font_tagger = new mm_unicode_font_tagger();
$mm_unicode_font_tagger->hook();

class mm_unicode_font_tagger {
    
    static $option_name = 'mm_unicode_font_tagger';
    
    public function hook() {
        add_action('init', array('mm_unicode_font_tagger', 'init'));
        add_action('wp_head', array('mm_unicode_font_tagger', 'wp_head'));
        // add_action('wp_footer', array('mm_unicode_font_tagger', 'wp_footer'));
        
        add_action('admin_menu', array('mm_unicode_font_tagger', 'admin_menu'));

        if ( ! get_option(mm_unicode_font_tagger::$option_name) ) {
            $options['fontName'] = 'myanmar3';
            update_option(mm_unicode_font_tagger::$option_name, $options );
        }
    }
    
    public static function admin_menu() {
		add_options_page('MM Font Tagger', 'MM Font Tagger', 8, 'mm-font-tag', array('mm_unicode_font_tagger', 'options'));
	}
	
	function data_save()
	{
		if(isset($_POST['submitter']))
		{
		    $options = array();
			$options['fontName'] = $_POST['fontName'];
			
			if ( get_option(mm_unicode_font_tagger::$option_name) )
				update_option(mm_unicode_font_tagger::$option_name, $options);
			else
				add_option(mm_unicode_font_tagger::$option_name, $options);
		}
	}
	
	public static function options() {
	    mm_unicode_font_tagger::data_save();
		$options = get_option(mm_unicode_font_tagger::$option_name);
		
		$fonts = array (
		    "No Font Embedding" => "",
	        "Yunghkio" => "yunghkio",
	        "Myanmar3" => "myanmar3",
	        "Padauk" => "padauk",
	        "MyMyanmar" => "MyMyanmar"
	        );
	        
	?>
	    <div class="wrap">
	        <h2>Myanmar Unicode Font Tagger</h2>
	        <div class="font_tagger">
			<form method="post" name="font_tagger_form">
			    <label>Font to embed:</label>
			    <select name="fontName">
			    <?php
			    foreach ($fonts as $n => $f) {
			        $selected = ($f === $options['fontName']) ? "selected=\"selected\"" : "";
			        echo "<option $selected value=\"$f\">$n</option>";
		        }
			    ?>
			    </select>
			    <p><input type="submit" name="submitter" value="<?php esc_attr_e('Save Changes') ?>" class="button-primary" /></p>
		    </form>
		    </div>
	    </div>
	<?php
	}
    
    public static function init() {
       // register your script location, dependencies and version
       wp_register_script('mm-font-tagger', plugins_url( 'js/fonttagger.js' , __FILE__ ));
       // enqueue the script
       wp_enqueue_script('mm-font-tagger');
	}
	
	public static function wp_head() {
	    $options = get_option(mm_unicode_font_tagger::$option_name);
	    
	    if ($options['fontName']) {
	        $csslink = "<link href='http://mywebfont.appspot.com/css?font={$options['fontName']}' rel='stylesheet' type='text/css'/>";
	    }
	    echo $csslink;
	}
	
	public static function wp_footer() {
	    
	}
}
?>