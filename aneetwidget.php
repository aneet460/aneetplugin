<?php

    /* 
        Plugin Name: Aneet's Social Media Widget.
        Plugin Description: Adds social media links to your theme footer.
        Plugin URI: *
        Author: Aneet Hundal
        Author URI: *
        Version: 1.0
    */

// widget

class aneetwidget extends WP_Widget{
    
    public function __construct(){
        $widget_stuff = array(
        'classname' => 'widget_socmed',
        'description' => 'Displays Social Media Links'
        );
    parent::__construct('socmed_link', "Aneet's Social Media Links", $widget_stuff);
    }

    public function widget($args, $instance){
			$title = apply_filters('widget_title', empty($instance['title']) ? 'Social Media Links' : $instance['title'], $instance, $this->id_base);
			
			echo $args['before_widget'];
			
			if($title){
				echo $args['before_title'] . $title . $args['after_title'];
			} ?>
	
					
         <div id="socmedarea">
                <ul>
                    <?php do_shortcode('[buttonfb]')?>
                </ul>  
                <ul>
                    <?php do_shortcode('[buttonig]')?>
                </ul>
                <ul>
                    <?php do_shortcode('[buttonli]')?>
                </ul>
                <ul>
                    <?php do_shortcode('[color_all]') ?>
                </ul>
        </div>  
				<?php  
					echo $args['after_widget'];
    }
    
    // form part
    
    public function form($instance){
						$instance = wp_parse_args((array) $instance, array('title'=>''));
						$title = strip_tags($instance['title']);
						
						?>
						
						<p>
							<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label> 
							<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
							</p>
							
<?php }
    
    //update part
    
public function update($new_instance,$old_instance){
					
					$instance = $old_instance;
					$new_instance = wp_parse_args((array) $new_instance, array('title' => ''));
					$instance['title'] = strip_tags($new_instance['title']);
					
					return $instance;
				}
}

add_action('widgets_init', function(){register_widget('aneetwidget');});


//Enqueuing plugin stylesheet
function addstyle(){
    wp_enqueue_style('plugin-style', plugins_url('style.css', __FILE__));
}

add_action('wp_enqueue_scripts','addstyle'); 


//shortcodes
/*
function socialm($atts, $content=null){
    extract(shortcode_atts(
    array (
        'title' => 'social media', 
        'link' => array 
                ( 'facebook' => 'http://facebook.com', 
                 'instag' => 'http://instagram.com'),
        'img' => array (
                    'fbimg' => '/img/facebookicon.png', 
                    'igimg' => 'img/instagramicon.png')
    ), $atts
    ));
    
    echo '<div id="socmedicons"> 
   <a href="' . $link. '">' . $title . '"</a></div>';
}

add_shortcode('socialm', 'socialm'); */

//facebook
function buttonfb ($atts, $content = null) 
    {
		extract(shortcode_atts(
		array (
				'title' => 'Facebook',  // name on the button
				'link' => 'http://facebook.com', 
                'buttoncolor' => '#3B5998',
                'tcolor' => '#fff'
				), $atts
		));

		echo '
            <style type="text/css">
                
                #buttonfb{
                    background-color:' . $buttoncolor . ';
                    color:' . $tcolor . ';
                    padding: 25px;
                }
                
            </style> 
           
     <div><a id="buttonfb" href="' . $link . '">' . $title . '</a> </div>';
}
add_shortcode('buttonfb', 'buttonfb');

//instagram
function buttonig ($atts, $content = null) 
    {
		extract(shortcode_atts(
		array (
				'title' => 'Instagram',  // name on the button
				'link' => 'http://instagram.com', 
                'buttoncolor' => '',
                'tcolor' => '#fff'
				), $atts
		));
// http://uigradients.com/# used for gradient
		echo '
            <style type="text/css">
                
                #buttonig{
                    background: #2196f3; /* fallback for old browsers */
                    background: -webkit-linear-gradient(to left, #2196f3 , #f44336); /* Chrome 10-25, Safari 5.1-6 */
                    background: linear-gradient(to left, #2196f3 , #f44336); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */;
                    color:' . $tcolor . ';
                    padding: 25px;
                }
                
            </style> 
           
     <div><a id="buttonig" href="' . $link . '">' . $title . '</a> </div>';
}
add_shortcode('buttonig', 'buttonig');

// linkedin

function buttonli ($atts, $content = null) 
    {
		extract(shortcode_atts(
		array (
				'title' => 'LinkedIn',  // name on the button
				'link' => 'http://linkedin.com', 
                'buttoncolor' => '#007bb5',
                'tcolor' => '#fff'
				), $atts
		));

		echo '
            <style type="text/css">
                
                #buttonli{
                    background-color:' . $buttoncolor . ';
                    color:' . $tcolor . ';
                    padding: 25px;
                }
                
            </style> 
           
     <div><a id="buttonli" href="' . $link . '">' . $title . '</a> </div>';
}
add_shortcode('buttonli', 'buttonli');

//applies to all
function color_all($atts, $content = null){
    extract(shortcode_atts(
    array(
        'borderrad'=> '25px',
        'color' => '#fff',
        'textalign' => 'center',
        'fontweight' => 'bold',
        'transform' => 'uppercase',
        'size' => '25px'
        
    ),$atts
    ));
    
    return '<style type="text/css"> 
    #divshortcode {
        border-radius:' . $borderrad .';
        color:' . $color . ';
        text-align:' .$textalign . ';
        font-weight:' .$fontweight .';
        text-transform:' . $transform . ';
        font-size:' . $size . ';
    }
    </style> 
    
    <div id="divshortcode">' .do_shortcode($content) . '</div>';
}

add_shortcode('color_all', 'color_all');  


// custom post type
add_action( 'init', 'create_post_type' );
function create_post_type() {
  register_post_type( 'ahspecial',
    array(
      'labels' => array(
        'name' => __( 'Special' ),
        'singular_name' => __( 'Special Ones' )
      ),
      'public' => true,
      'has_archive' => true,
    )
  );
}