<?php get_header(); ?>

 
<main class='main'>
        <!-- если sidebar зарегистрирован, то вывести его -->
        <div class="sidebar-left">
        <?php if ( ! dynamic_sidebar('sidebar_left') ) : ?>
         <?php  ( dynamic_sidebar('sidebar_left') )  ?>
                  <h2><?php _e('Categories')?></h2>
            <ul>
                  <?php wp_list_cats('sort_column=name&optioncount=1&hierarhial=0');?>
            </ul>
            <h3><?php _e('Archives')?></h3>
            <ul>
                  <?php wp_get_archives('type=monthly');?>
            </ul>
            <h4>Данные сайта</h4>
            <ul>
			  <li> <label class='sidebar_label' for="">Название: <?php bloginfo( 'name' ); ?></label></li>
              <li> <label class='sidebar_label' for="">Описание: <?php bloginfo( 'description' ); ?></label> </li>  
            </ul>
             
         <?php endif; ?>
         
         </div>
      
    
         <div class="content">
         <h1>Записи: </h1>
         <?php if(have_posts()): while(have_posts()): the_post();?>
         <h1><?php the_title();?></h1>
         <h4>Запись от <?php the_time('F jS, Y'); ?></h4>
         <p><?php the_content(_('(more...)'));?></p>
         <hr><?php endwhile;     else:?>

         <p><?php _e('Sorry, no posts');?></p>
         <?php endif; ?>
         </div>

         <?php do_action('save_post')?>

         <!-- если sidebar зарегистрирован, то вывести его -->
         <div class="sidebar-right">
         
         <?php if ( ! dynamic_sidebar('sidebar_right') ) : ?>
         <?php  ( dynamic_sidebar('sidebar_right') )  ?>
		 <h2>Логотип сайта:
		 <p><?php my_custom_logo();?></p>
		 </h2>
         <?php endif; ?>
         </div>
          <!-- если sidebar зарегистрирован, то вывести его -->
</main>
  
 
<?php get_footer(); ?>