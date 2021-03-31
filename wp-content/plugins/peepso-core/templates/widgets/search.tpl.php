<?php
if(get_current_user_id()) {
    echo $args['before_widget'];

    ?>
    <div class="ps-widget__wrapper- ps-widget- ps-js-widget-search">

    <div class="ps-widget__header-">
        <?php
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        ?>
    </div>
    <div class="ps-widget__body-">
        <div class="ps-widget--members">
            <input class="ps-input ps-full ps-js-query ha" type="text"
                   placeholder="<?php echo __('Global search...', 'peepso-core'); ?>"
                   style="margin-bottom:15px;"
            />
            <div class="ps-js-loading" style="display:none">
                <img src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>">
            </div>
            <div class="ps-js-result" style="display:none"></div>
        </div>
    </div>
    </div><?php

    echo $args['after_widget'];
// EOF

}