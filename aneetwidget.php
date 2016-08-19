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
	
					
                    <ul> 
                    <?php do_shortcode('[socialm]')?>
                    </ul>
                    
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

add_action('wp_enqueue_scripts','styles')


//shortcodes

function socialm($atts, $content=null){
    extract(shortcode_atts(
    'link' => array (
        'facebook' => 'http://facebook.com', 
        'instagram' => 'http://instagram.com',
        'linkedin' => 'http://linkedin.com'
    ), $atts
    ));
    
    return '<div id="socmedicons"> 
    <a id="fbbut" href ="' . $linkf . '"><img src="/img/facebookicon.png> </a> </div>'; 
}

add_shortcode('fbbutton', 'fbbutton');