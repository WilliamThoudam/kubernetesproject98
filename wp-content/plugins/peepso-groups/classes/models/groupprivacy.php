<?php

class PeepSoGroupPrivacy
{
	public $settings = array();

	const PRIVACY_OPEN 		= 0;
	const PRIVACY_CLOSED 	= 1;
	const PRIVACY_SECRET 	= 2;

	public static function _($privacy = NULL)
	{

        $PeepSoUrlSegments= PeepSoUrlSegments::get_instance();

        $page_type = $PeepSoUrlSegments->get(0);
        $grp_name = $PeepSoUrlSegments->get(1);
        $channel_page = $PeepSoUrlSegments->get(2);
        $text = 'groups';

        $posts = get_posts(array('name' => $grp_name, 'post_type' => 'peepso-group'));
        foreach ($posts as $post)
        {
            $parent_id = wp_get_post_parent_id($post->ID);
            break; //use this to limit to a single result
        }

        if((($parent_id != 0) && ($grp_name != '')) || ($channel_page == 'channels'))
          $text = 'channels';


		$settings = array(

			self::PRIVACY_OPEN => array(
				'id' 	=> self::PRIVACY_OPEN,
				'icon'	=> 'gcis gci-globe-americas',
                'name'	=> __('Open', 'groupso'),
                'notif'	=> __('open', 'groupso'),
				'desc'	=> __('Anyone can join this '.$text.' and participate.', 'groupso') . PHP_EOL . __('Non-members can see everything in the '.$text.', but they can\'t post, comment etc.','groupso'),
			),

            self::PRIVACY_CLOSED => array(
                'id'	=> self::PRIVACY_CLOSED,
                'icon'	=> 'gcis gci-lock',
                'name'	=> __('Closed', 'groupso'),
                'notif'	=> __('closed', 'groupso'),
                'desc'	=> __('Users need to be invited or request '.$text.' membership and be accepted.', 'groupso') . PHP_EOL . htmlspecialchars(__('Non-members can only see the '.$text.'\'s "about" page.','groupso')),
            ),
            self::PRIVACY_SECRET=> array(
                'id'	=> self::PRIVACY_SECRET,
                'icon'	=> 'gcis gci-shield-alt',
                'name'	=> __('Secret', 'groupso'),
                'notif' => __('secret', 'groupso'),
                'desc'	=> __('Users need to be invited.','groupso') . PHP_EOL .  __('Non-members can\'t see the '.$text.' at all.', 'groupso'),
            ),
		);

		// Return a single privacy setting if requested
		if(NULL !== $privacy) {
			return $settings[$privacy];
		}

		// Otherwise return everything
		return $settings;
	}

    /**
     * Displays the privacy options in an unordered list.
     * @param string $callback Javascript callback
     */
    public static function render_dropdown($callback = '')
    {
        ob_start();

/*
        TO only show Closed and secret option in channels view
        It will be not be reflected for groups
        changes made by rishabh on 13/2/2021
*/


        $PeepSoUrlSegments= PeepSoUrlSegments::get_instance();
        $page_type = $PeepSoUrlSegments->get(0);
        $grp_name = $PeepSoUrlSegments->get(1);
        $channel_page = $PeepSoUrlSegments->get(2);

        $parent_id = 0;

        $posts = get_posts(array('name' => $grp_name, 'post_type' => 'peepso-group'));

        foreach ($posts as $post)
        {
            $parent_id = wp_get_post_parent_id($post->ID);
            break; //use this to limit to a single result
        }

        $i = 0;

        if((($parent_id != 0) && ($grp_name != '')) || ($channel_page == 'channels'))
         $i++;


        echo '<div class="ps-dropdown__menu ps-js-dropdown-menu">';

        $options = self::_();


        for($i; $i < 3; $i++)
        {
            $option = $options[$i];

            printf('<a href="#" class="ps-dropdown__group" data-option-value="%d" onclick="%s; return false;">%s</a>',
                $i, $callback, '<div class="ps-dropdown__group-title"><i class="' . $option['icon'] . '"></i><span>' . $option['name'] . '</span></div><div class="ps-dropdown__group-desc">' . nl2br($option['desc']) .'</div>'
            );
        }
        echo '</div>';

        return ob_get_clean();
    }
}
