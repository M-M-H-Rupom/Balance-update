<?php 
/**
 * Plugin Name: User balanced 
 * Description: hello
 * Version: 1.0
 * Author: Rupom
 * Text Domain: 
 * 
 */

function scripts_enqueue_callback(){
    wp_enqueue_style( 'style_css', plugin_dir_url( __FILE__ ) . '/assets/css/style.css');
    wp_enqueue_script( 'main_js', plugin_dir_url( __FILE__ ).'/assets/js/main.js', array('jquery'), time(), true);
    wp_localize_script( 'main_js', 'localize_data', array(
        'url' => admin_url('admin-ajax.php'),
    ) );
}
add_action( 'wp_enqueue_scripts', 'scripts_enqueue_callback' );

function user_balance_callback(){
    $current_user = wp_get_current_user();
    // using post method
    // $current_balance = get_post_meta( $current_user->ID, 'user_balanced', true );
    // if(isset($_POST['update_balanced'])){
    //     $balanced = $_POST['user_balance'];
    //     update_post_meta( $current_user->ID, 'user_balanced', $balanced );
    // }
    ob_start();
    ?>  
    <div class="balance_container">
        <div class="main_table">
            <table>
                <tr>
                    <th> User Id</th>
                    <th> User Name</th>
                    <th> Balance</th>
                    <th>Update Balance </th>
                </tr>
                <tr>
                    <td><?php echo $current_user->ID; ?></td>
                    <td><?php echo $current_user->user_login; ?></td>
                    <td class='display_balance'><?php echo get_post_meta( $current_user->ID, 'user_current_balance', true) ?> </td> 
                    <td class='balanced_field'> 
                        <!-- <form method="post">
                            <input type="text" name="user_balance" class="user_balance" value='<?php echo $current_balance ?>'>
                            <input type="submit" name="update_balanced" value="Update Balanced" id="update_balanced">
                        </form> -->

                        <input type="number" name="user_balance" class="user_balance">
                        <button id="update_balanced"> Update Balance</button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'user_balance', 'user_balance_callback');

// ajax handle
function balance_ajax_callback(){
    $current_user = wp_get_current_user();
    if(isset($_POST['balanced_val'])){
        $balance_value = $_POST['balanced_val'];
        if(!empty($balance_value)){
            update_post_meta( $current_user->ID, 'user_current_balance', $balance_value );
        }
    }
    $current_balance = get_post_meta( $current_user->ID, 'user_current_balance', true);
    wp_send_json($current_balance);
}
add_action( 'wp_ajax_balance_ajax', 'balance_ajax_callback');