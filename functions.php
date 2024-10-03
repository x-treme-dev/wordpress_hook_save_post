<?php
 

  // добавить 2 сайдбара с содержимым
 

function register_my_custom_widget() {
      register_sidebar(array(
        'name' => 'Cодержание',
        'id' => 'sidebar_left',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="">',
        'after_title' => '</h2>',
    )); 

    register_sidebar(array(
        'name' => 'Разное',
        'id' => 'sidebar_right',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="">',
        'after_title' => '</h2>',
    ));
}
add_action('widgets_init', 'register_my_custom_widget');

// Добавляем поддержку логотипа
function my_theme_setup() {
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));
}
add_action('after_setup_theme', 'my_theme_setup');

// Функция для вывода логотипа
function my_custom_logo() {
    if (has_custom_logo()) {
        the_custom_logo();
    } else {
        // Если логотип не установлен, можно вывести текст или альтернативное изображение
        echo '<a href="' . esc_url(home_url('/')) . '">Test</a>';
        // Или вывести альтернативное изображение
        // echo '<img src="' . esc_url(get_template_directory_uri() . '/images/default-logo.png') . '" alt="Логотип">';
    }
}

// получить все посты для последющего изменения статуса
// если пост не опубликован (статус draft), то к заголовку добавляем пометку "DRAFT: ".
// если опубликован, убираем пометку
$args = array(
    'post_type'   => 'post', // Укажите тип записи, если нужно
    'post_status' => array('publish', 'draft'), // Статусы постов
    'posts_per_page' => -1, // Получить все посты
);

$posts = get_posts($args);
foreach($posts as $key=>$value){
    $post_id = $value->ID;
    add_action('save_post', 'my_custom_save_post_function', $post_id);
}
 
// изменяем в коллбеке статус постов
 function my_custom_save_post_function($post_id) {
     // Проверяем, является ли это автосохранением
     if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
         return;
     }
 
     // Проверяем права пользователя
     if (!current_user_can('edit_post', $post_id)) {
         return;
     }
 
     // Получаем объект записи
    $post = get_post($post_id);
    
    // Проверяем, что это запись или страница
    if ($post->post_type === 'post' || $post->post_type === 'page') {
        // Если статус черновика
        if ($post->post_status === 'draft') {
            // Добавляем "DRAFT: " к заголовку, если это еще не сделано
            if (strpos($post->post_title, 'DRAFT: ') !== 0) {
                $new_title = 'DRAFT: ' . $post->post_title;
                // Обновляем заголовок
                wp_update_post(array(
                    'ID' => $post_id,
                    'post_title' => $new_title,
                ));
            }
        } elseif ($post->post_status === 'publish') {
            // Удаляем "DRAFT: " из заголовка, если оно есть
            if (strpos($post->post_title, 'DRAFT: ') === 0) {
                $new_title = str_replace('DRAFT: ', '', $post->post_title);
                // Обновляем заголовок
                wp_update_post(array(
                    'ID' => $post_id,
                    'post_title' => $new_title,
                ));
            }
        }
    }
 
     
   
    
 }
 



?>