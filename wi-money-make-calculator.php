<?php 
/*
Plugin Name: Money Make Calculator
Plugin URI: http://blog.affiliscore.com/2011/08/04/make-money-calculator-plugin/
Description: A plugin that creates a Make Money Calculator Widget 
Version: 1.0
Author: Yoav Shalev
Author URI: http://YoavShalev.com
License: GPLv2
*/

// use widgets_init action hook to execute custom function
add_action( 'widgets_init', 'wi_money_make_calculator_register_widgets' );

 //register our widget
function wi_money_make_calculator_register_widgets() {
    register_widget( 'wi_money_make_calculator' );
   
     wp_enqueue_script( "jquery");
   
     if(is_admin()){
            wp_enqueue_style( 'farbtastic' );
            wp_enqueue_script( 'farbtastic' );
     }
     else{
         
            wp_enqueue_script('jquery-ui-core');
            wp_enqueue_script('jquery-ui-widget');

            wp_register_script('jquery-ui-datepicker',plugin_dir_url( __FILE__ ).'js/jquery.ui.datepicker.js',array('jquery'), '1.0' );
            wp_enqueue_script('jquery-ui-datepicker');
            wp_register_style('jquery_ui_custom_css_for_wid',  plugin_dir_url( __FILE__ ).'css/jquery-ui-1.8.14.custom.css','','1.0' );

        
     }
        

        // add the register css

        wp_enqueue_style('jquery_ui_custom_css_for_wid');
    
   
    
}

//boj_widget_my_info class
class wi_money_make_calculator extends WP_Widget {

    //process the new widget
    function wi_money_make_calculator() {
        $widget_ops = array( 
			'classname' => 'wi_money_make_calculator_class', 
			'description' => 'Display a special calculator.' 
			); 
        $this->WP_Widget( 'wi_money_make_calculator', 'Make Money Calculator', $widget_ops );
    }
 
     //build the widget settings form
    function form($instance) {
        $defaults = array( 'title' => 'My Info','color_border' => '#123456','border_pixel'=>1 ,'money_symbol'=>'$','color' => '#123456','color_text' => '#123456','show_plugin_by_money'=>'on' ); 
        $instance = wp_parse_args( (array) $instance, $defaults );
        $title = $instance['title'];
        $color_border = $instance['color_border'];
        $show_plugin_by_money =$instance['show_plugin_by_money'];
        $border_pixel = $instance['border_pixel'];
        $color = $instance['color'];
        $color_text = $instance['color_text'];
        $money_symbol=$instance['money_symbol'];
        //echo $show_plugin_by_money;
        ?>
            <p>Title: <input class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>"  type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
            <p>Currency Symbol: <input class="widefat" name="<?php echo $this->get_field_name( 'money_symbol' ); ?>"  type="text" value="<?php echo esc_attr( $money_symbol ); ?>" /></p>
            <p>Support AffiliScore - Display our logo with a link to http://Affiliscore.com ? <input name="<?php echo $this->get_field_name( 'show_plugin_by_money' ); ?>"  type="checkbox" <?php checked( $show_plugin_by_money, 'on' ); ?> /></p>
            <p>Border width: <input class="widefat" name="<?php echo $this->get_field_name( 'border_pixel' ); ?>"  type="text" value="<?php echo esc_attr( $border_pixel ); ?>" /></p>
            <p>Border Color: <input class="widefat" name="<?php echo $this->get_field_name( 'color_border' ); ?>" <?php if($this->number!=''){ ?> id='<?php echo $this->number;?>_color_border'<?php }?>  type="text" value="<?php echo esc_attr( $color_border ); ?>" /></p>
            <div id="<?php echo $this->number;?>_colorpicker_border"></div>
            <p>Background color: <input class="widefat" name="<?php echo $this->get_field_name( 'color' ); ?>" <?php if($this->number!=''){ ?> id='<?php echo $this->number;?>_color'<?php }?>  type="text" value="<?php echo esc_attr( $color ); ?>" /></p>
            <div id="<?php echo $this->number;?>_colorpicker"></div>
            <p>Text Color: <input class="widefat" name="<?php echo $this->get_field_name( 'color_text' ); ?>" <?php if($this->number!=''){ ?> id='<?php echo $this->number;?>_color_text'<?php }?>  type="text" value="<?php echo esc_attr( $color_text ); ?>" /></p>
            <div id="<?php echo $this->number;?>_colorpicker_text"></div>
            <?php if($this->number!=''){?>
           
        
            
            <script type="text/javascript">
                (function($) {
                    
                  
                    $(document).ready(function() {
                              $('#<?php echo $this->number;?>_colorpicker_border').farbtastic('#<?php echo $this->number;?>_color_border');
                                $('#<?php echo $this->number;?>_colorpicker').farbtastic('#<?php echo $this->number;?>_color');
                                 $('#<?php echo $this->number;?>_colorpicker_text').farbtastic('#<?php echo $this->number;?>_color_text');
                           
                    });



                })(jQuery); 
            </script>
          <?php   } ?>
            <?php
    }
 
    //save the widget settings
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['color_border'] = strip_tags($new_instance['color_border']);
          $instance['show_plugin_by_money']=strip_tags($new_instance['show_plugin_by_money']);
        $instance['color'] = strip_tags($new_instance['color']);
        $instance['color_text'] = strip_tags($new_instance['color_text']);
        $instance['money_symbol'] = strip_tags($new_instance['money_symbol']);
        $instance['border_pixel'] = strip_tags($new_instance['border_pixel']);

        return $instance;
    }
 
    //display the widget
    function widget($args, $instance) {
        extract($args);
        echo $before_widget;
        ?>
                    
        <?php
        $title = apply_filters('widget_title', $instance['title']);
        $color = empty($instance['color']) ? '&nbsp;' : $instance['color'];
        $show_plugin_by_money=empty( $instance['show_plugin_by_money'] ) ? 0 : 1; 
        $color_border = empty($instance['color_border']) ? '#123456' : $instance['color_border'];
        $border_pixel = empty($instance['border_pixel']) ? '1' : $instance['border_pixel'];
        $color_text = empty($instance['color_text']) ? '&nbsp;' : $instance['color_text'];
        $money_symbol = empty($instance['money_symbol']) ? ' $' : esc_attr($instance['money_symbol']);

        if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
      
        
        ?>
        <style type="text/css">
            
        .wi_money_make_calculator_class {background:<?php echo $color;?>; color:<?php echo $color_text;?>;
        border: <?php echo $border_pixel;?>px solid <?php echo $color_border;?>;
        }
        .wi_money_make_calculator_class h3  {
           font-weight: bolder;  
           padding-left: 7px;
        }
        .wi_money_make_calculator_class #power_by{
           background: white;
           
        }
      
        .wi_money_make_calculator_class p{
           padding-left: 7px;
        }
        .wi_money_make_calculator_class b{
            font-size: 14px;
            color:black;
        }

          
           
        </style>
        <script>
                
                function round_up (val, precision) {

                    power = Math.pow (10, precision);
                    poweredVal = Math.ceil (val * power);
                    result = poweredVal / power;

                    return result;
                }
                
                    function formatCurrency(num) {
                    num = num.toString().replace(/\$|\,/g,'');
                    if(isNaN(num))
                    num = "0";
                    sign = (num == (num = Math.abs(num)));
                    num = Math.floor(num*100+0.50000000001);
                    cents = num%100;
                    num = Math.floor(num/100).toString();
                    if(cents<10)
                    cents = "0" + cents;
                    for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
                    num = num.substring(0,num.length-(4*i+3))+','+
                    num.substring(num.length-(4*i+3));
                    return (((sign)?'':'-')  + num + '.' + cents);
                    }
              
             (function($) {
                    wi_money_make_calculator_url='<?php echo plugin_dir_url( __FILE__ );?>';
                    $(document).ready(function() {
                     
                    wi_money_calculate_money_symbol='<?php echo $money_symbol;?>';
                    
                    // jquery wi_money_make_calculator_update_show_data function
                    
                    
                    $.fn.wi_money_make_calculator_update_show_data = function(id,wi_money_calculate_per_day,wi_money_calculate_money_symbol,amount){
                        if(wi_money_calculate_per_day<=0){
                            wi_money_calculate_per_day=1;     
                        }
                       
                        wi_money_calculate_per_day_m=amount/wi_money_calculate_per_day;

                        wi_money_calculate_per_sec  = wi_money_calculate_per_day/(24*60*60);
                        wi_money_calculate_per_sec_m= wi_money_calculate_per_day_m/(24*60*60);
                        
                        wi_money_calculate_per_min  = wi_money_calculate_per_sec*60;
                        wi_money_calculate_per_min_m=wi_money_calculate_per_day_m/(24*60);
                        wi_money_calculate_per_hr   = wi_money_calculate_per_sec*60*60;
                        wi_money_calculate_per_hr_m =wi_money_calculate_per_day_m/(24);
                        
                        if(wi_money_calculate_per_day>=7){
                        wi_money_calculate_per_week = wi_money_calculate_per_day*7;
                        wi_money_calculate_per_week_m=wi_money_calculate_per_day_m*7;
                        }else{
                          wi_money_calculate_per_week_m=0;  
                        }
                        if(wi_money_calculate_per_day>=30 ){
                        wi_money_calculate_per_month= wi_money_calculate_per_day*30;
                        wi_money_calculate_per_month_m=wi_money_calculate_per_day_m*30;
                        }else{
                          wi_money_calculate_per_month_m=0;  
                        }
                        if(wi_money_calculate_per_day>=365){
                        wi_money_calculate_per_year = wi_money_calculate_per_day*365;
                        wi_money_calculate_per_year_m=wi_money_calculate_per_day_m*365; 
                        }
                        else{
                            wi_money_calculate_per_year_m=0;
                        }
                        wi_money_calculate_per_day_m=amount/wi_money_calculate_per_day;
                        $('#'+id).html(
                                                "<p><b>This means you need to make at least:</b><br/>"
                                                + wi_money_calculate_money_symbol + '  '+formatCurrency(round_up (wi_money_calculate_per_year_m,3))    + '   each Year<br/>'
                                                + wi_money_calculate_money_symbol + '  '+formatCurrency(round_up (wi_money_calculate_per_month_m,3))   + '   each Month<br/>'
                                                + wi_money_calculate_money_symbol + '  '+formatCurrency(round_up (wi_money_calculate_per_week_m,3))    + '   each Week<br/>'
                                                + wi_money_calculate_money_symbol + '  '+formatCurrency(round_up (wi_money_calculate_per_day_m,3))     + '   each Day<br/>'
                                                + wi_money_calculate_money_symbol + '  '+formatCurrency(round_up (wi_money_calculate_per_hr_m,3))      + '   each Hour<br/>'
                                                + wi_money_calculate_money_symbol + '  '+formatCurrency(round_up (wi_money_calculate_per_min_m,3))     + '   each Minute<br/>'
                                                + wi_money_calculate_money_symbol + '  '+formatCurrency(round_up (wi_money_calculate_per_sec_m,3))     + '   each Second<br/></p>'
                                            );
                    }
                    
                    // end jquery function 
                    
                    var DateDiff = {

                        inSeconds: function(d1, d2) {
                            var t2 = d2.getTime();
                            var t1 = d1.getTime();

                            return parseInt((t2-t1)/(1000));
                        },
                        
                        inDays: function(d1, d2) {
                            var t2 = d2.getTime();
                            var t1 = d1.getTime();

                            return parseInt((t2-t1)/(24*3600*1000));
                        }                    }
                    
                    
                    $( "#wi_money_make_calculator_datepicker").datepicker({   

                        onSelect: function(dateText, inst) { 

                                var d2 = new Date(dateText);
                                var d1 = new Date();
                                if(DateDiff.inDays(d1, d2)<=0){
                                       alert('You can not select a previous date'); 
                                       $("#wi_money_make_calculator_datepicker").datepicker( "setDate" , +1 );
                                       d2=new Date($("#wi_money_make_calculator_datepicker").datepicker( "getDate" , +1 ));
                                       
                                    }
                                       
                                    wi_money_calculate_amount =   document.getElementById('wi_money_make_calculator_amount').value;
                                   
                                    if( wi_money_calculate_amount!=''){
                                        wi_money_calculate_per_day  = DateDiff.inDays(d1, d2);
                                        $(this).wi_money_make_calculator_update_show_data('wi_money_make_calculator_show_result',wi_money_calculate_per_day,wi_money_calculate_money_symbol,wi_money_calculate_amount);                                      
                                    }
                        },
                        changeMonth: true,
			changeYear: true,
                        showOn: "button",
                        buttonImage: wi_money_make_calculator_url+"css/images/calendar.gif",
                        buttonImageOnly: true,
                        dateFormat: 'MM, dd, yy',
                        showOptions: {direction: 'down' }
                    });
                        
                        
                    $("#wi_money_make_calculator_amount").keyup(function(){

                      wi_money_calculate_amount =   document.getElementById('wi_money_make_calculator_amount').value;
                     

                      if(isNaN(wi_money_calculate_amount) || wi_money_calculate_amount=='' ){

                                alert('Please give a valid number in amonunt input.');
                                $('#wi_money_make_calculator_show_result').html('');
                      }
                      else{
                                //alert('i am a number'+wi_money_calculate_amount);
                                if($("#wi_money_make_calculator_datepicker").datepicker("getDate" )!=null){

                                    //alert('i am ok');
                                    var d2 = new Date(document.getElementById("wi_money_make_calculator_datepicker").value);
                                    var d1 = new Date();

                                if(DateDiff.inDays(d1, d2)<0){

                                       alert('You can not select a previous date'); 
                                       $("#wi_money_make_calculator_datepicker").datepicker( "setDate" , +1 );


                                    } 
                                else{


                                    wi_money_calculate_per_day  = DateDiff.inDays(d1, d2);
                                     
                                    $(this).wi_money_make_calculator_update_show_data('wi_money_make_calculator_show_result',wi_money_calculate_per_day,wi_money_calculate_money_symbol,wi_money_calculate_amount);
                                   
                                }

                                }else{
                                    //alert('i am not ok');
                                }

                      }

              });   
                   
       
                    }); // end document ready
                    

            })(jQuery); 
	</script>
         
         <p>Pick Date: <input type="text" style="width: 50%" readonly="readonly" id="wi_money_make_calculator_datepicker">&nbsp;</p>
         <p>Pick Amount(<?php echo $money_symbol;?>): <input type="text" style="width: 40%" name='wi_money_make_calculator_amount' id="wi_money_make_calculator_amount"></p>
         
         
         <div id="wi_money_make_calculator_show_result"></div>
          <?php if($show_plugin_by_money){?>
         <div id="power_by">
             <div style="padding-left: 10px;margin-top: 7px;float: left;" >Plugin By</div><div align="right" style="margin-right: 3px;"><a align="right" href=" http://Affiliscore.com" target="_blank" ><img  src="<?php echo plugin_dir_url( __FILE__ );?>/logo.jpg" alt="Affiliate Marketing" /></a></div>
         </div>
       <?php } ?>
       <?php echo $after_widget;
    }
}
?>