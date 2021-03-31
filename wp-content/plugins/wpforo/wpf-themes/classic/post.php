
<script >
function goto_reply()
{
window.location.hash="#wpforo_form";
}

</script>
<?php
if( WPF()->perm->forum_can('vt') ):

	if( ($forum = WPF()->current_object['forum']) && ($topic = WPF()->current_object['topic']) && ($posts = WPF()->current_object['posts']) ) :
		if( !($topic['private'] && !wpforo_is_owner($topic['userid'], $topic['email']) && !WPF()->perm->forum_can('vp')) ): ?>

			<div class="wpf-head-bar">
				<h1 id="wpforo-title" class="cus_topic_title">
					<?php
					$icon_title = WPF()->tpl->icon('topic', $topic, false, 'title');
                    
					if( $icon_title ) echo '<span class="wpf-status-title">[' . esc_html($icon_title) . ']</span> ';
					echo esc_html( wpforo_text($topic['title'], 0, false) );
					?>&nbsp;&nbsp;
				</h1>
                <a href="#mceu_18" class="cus_reply_btn"  >Add Answer</a>
				<div class="wpf-action-link"><?php WPF()->tpl->topic_subscribe_link() ?></div>
			</div>
            

			<?php
			wpforo_template_pagenavi('wpf-navi-post-top');
			if( $forum['cat_layout'] == 3 ) include_once(wpftpl('layouts/3/comment.php'));
			include( wpftpl('layouts/' . $forum['cat_layout'] . '/post.php') );
			wpforo_template_pagenavi('wpf-navi-post-bottom');

			if( WPF()->perm->forum_can('cr') || ( wpforo_is_owner($topic['userid'], $topic['email']) && WPF()->perm->forum_can('ocr') ) ) {
				WPF()->tpl->reply_form($topic);
			}elseif( !WPF()->current_userid ){
			    WPF()->tpl->please_login();
            }
			do_action( 'wpforo_post_list_footer' );

		else: ?>
			<p class="wpf-p-error">
				<?php wpforo_phrase('Topic are private, please register or login for further information') ?>
			</p>
		<?php endif;
	endif;

else : ?>
	<p class="wpf-p-error">
		<?php wpforo_phrase("You don't have permissions to see this page, please register or login for further information") ?>
	</p>
   
<?php endif;