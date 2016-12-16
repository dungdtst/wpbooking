<?php
/**
 * Created by ShineTheme.
 * User: NAZUMI
 * Date: 11/4/2016
 * Version: 1.0
 */
?>
<div class="content">
    <div class="content-header">
        <h3 class="title"><?php echo esc_html__('Reset Password','wpbooking'); ?></h3>
    </div>
    <div class="content-center">
        <?php echo esc_attr('Someone has requested a password reset for the following account:','wpbooking'); ?>
        <br><br>
        <?php echo esc_attr('Username : ','wpbooking').'<strong>'.esc_html($user_login).'</strong>'; ?>
        <br><br>
        <?php echo esc_attr('If this was a mistake, just ignore this email and nothing will happen.','wpbooking'); ?>
        <br><br>
        <?php echo esc_attr('To reset your password, visit the following address:','wpbooking'); ?><br>
        <a href="<?php echo esc_url(site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' )); ?>"><?php echo site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' ); ?></a>
    </div>

</div>