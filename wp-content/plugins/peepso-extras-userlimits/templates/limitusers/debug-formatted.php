<?php
$PeepSoProfile = PeepSoProfile::get_instance();
$PeepSoUser = $PeepSoProfile->user;
?>
<div class="ps-ulimits__debug-wrapper">
    <a href="<?php echo $PeepSoUser->get_profileurl();?>about">
    <?php

    if (isset($data['avatar']) && count($data['avatar'])) {
        echo '<div class="ps-ulimits__debug">';
        echo '<div class="ps-ulimits__debug-title"><i class="gcir gci-check-circle"></i>', __('Upload an avatar to:', 'peepsolimitusers'), '</div>';
        echo '<div class="ps-ulimits__debug-list">';
        foreach ($data['avatar'] as $section) {
            echo '<span class="ps-ulimits__debug-item"><i class="gcis gci-check"></i>', $sections_descriptions[$section], '</span>';
        }
        echo '</div>';
        echo '</div>';
    }

    if (isset($data['cover']) && count($data['cover'])) {
        echo '<div class="ps-ulimits__debug">';
        echo '<div class="ps-ulimits__debug-title"><i class="gcir gci-check-circle"></i>', __('Upload a cover to:', 'peepsolimitusers'), '</div>';
        echo '<div class="ps-ulimits__debug-list">';
        foreach ($data['cover'] as $section) {
            echo '<span class="ps-ulimits__debug-item"><i class="gcis gci-check"></i>', $sections_descriptions[$section], '</span>';
        }
        echo '</div>';
        echo '</div>';
    }

    if (isset($data['profile']) && count($data['profile'])) {

        ksort($data['profile']);

        echo '<div class="ps-ulimits__debug">';
        echo '<div class="ps-ulimits__debug-title"><i class="gcir gci-check-circle"></i>', __('Complete your profile to at least:', 'peepsolimitusers'), '</div>';
        echo '<div class="ps-ulimits__debug-list">';
        foreach ($data['profile'] as $limit => $sections) {
            foreach ($sections as $section) {
                echo '<span class="ps-ulimits__debug-item">',$sections_icon[$section],$limit,'% ',__('to', 'peepsolimitusers'),' ', $sections_descriptions[$section],'</span>';
            }

        }

        echo '</div>';
        echo '</div>';
    }

    ?>
    </a>
</div>
