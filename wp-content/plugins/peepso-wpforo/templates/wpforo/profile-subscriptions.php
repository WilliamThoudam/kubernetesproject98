<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

$user	 = PeepSoUser::get_instance( $view_user_id );
$options = PeepSoConfigSettings::get_instance();
?>
<div class="peepso ps-page-profile">
	<?php PeepSoTemplate::exec_template( 'general', 'navbar' ); ?>
	<?php PeepSoTemplate::exec_template( 'profile', 'focus', array( 'current' => $main_tab ) ); ?>
	<section id="mainbody" class="ps-page-unstyled">
		<section id="component" role="article" class="ps-clearfix">
			<div class="ps-tabs__wrapper">
				<div class="ps-tabs ps-tabs--arrows">
					<?php
					foreach ( $submenus as $key => $value ) {
						$enable	 = $options->get_option( 'wpforo_enable_' . $key );
						$enable	 = apply_filters( 'wpforo_show_tab_on_peepso_profile', $enable, $key, $submenus );
						if ( $enable ) {
							?>
							<div class="ps-tabs__item
							<?php
							if ( $key === $current ) {
								echo 'current';
							}
							?>
								 "><a href="<?php echo $user->get_profileurl() . $main_tab . '/' . $value[ 'href' ]; ?>"><?php echo esc_html( $value[ 'label' ] ); ?></a></div>
								 <?php
							 }
						 }
						 ?>
				</div>
			</div>
			<div id="wpforo-wrap" class="wpf-default wpft-subscriptions wpf-auth peepso-wp-subscriptions">
				<div class="wpforo-main">
					<div class="wpforo-content" style="width: 100%">
						<div class="wpforo-profile-wrap">
							<div class="wpforo-profile-content">
								<div class="wpforo-sbn-content">
									<?php wpforo_subscription_tools(); ?>
									<?php if ( $subscribes ) : ?>
										<table>
											<?php
											$bg = false;
											foreach ( $subscribes as $subscribe ) :
												?>
												<?php
												if ( in_array( $subscribe[ 'type' ], array( 'forum', 'forum-topic' ) ) ) {
													$item		 = WPF()->forum->get_forum( $subscribe[ 'itemid' ] );
													$item_url	 = WPF()->forum->get_forum_url( $item[ 'forumid' ] );
												} elseif ( $subscribe[ 'type' ] === 'topic' ) {
													$item		 = WPF()->topic->get_topic( $subscribe[ 'itemid' ] );
													$item_url	 = WPF()->topic->get_topic_url( $item[ 'topicid' ] );
												} elseif ( in_array( $subscribe[ 'type' ], array( 'forums', 'forums-topics' ) ) ) {
													$item		 = array( 'title' => wpforo_phrase( 'All ' . $subscribe[ 'type' ], false ) );
													$item_url	 = '#';
												}
												if ( empty( $item ) ) {
													continue;
												}
												?>
												<tr<?php echo ( $bg ? ' class="wpfbg-9"' : '' ); ?>>
													<td class="sbn-icon"><i class="fas fa-1x <?php echo ( $subscribe[ 'type' ] == 'forum' ) ? 'fa-comments' : 'fa-file-alt'; ?>"></i></td>
													<td class="sbn-title"><a href="<?php echo esc_url( $item_url ); ?>"><?php echo esc_html( $item[ 'title' ] ); ?></a></td>
													<?php if ( WPF()->current_object[ 'user_is_same_current_user' ] ) : ?>
														<td class="sbn-action"><a href="<?php echo esc_url( WPF()->sbscrb->get_unsubscribe_link( $subscribe[ 'confirmkey' ] ) ); ?>"><?php wpforo_phrase( 'Unsubscribe' ); ?></a></td>
													<?php else : ?>
														<td>&nbsp;</td>
													<?php endif ?>
												</tr>
												<?php
												$bg = ( $bg ? false : true );
											endforeach
											?>
										</table>
										<div class="sbn-foot">
											<?php wpforo_template_pagenavi(); ?>
										</div>
									<?php else : ?>
										<p class="wpf-p-error"> <?php wpforo_phrase( 'No subscriptions found for this member.' ); ?> </p>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section><!--end component-->
	</section><!--end mainbody-->
</div><!--end row-->
<?php PeepSoTemplate::exec_template( 'activity', 'dialogs' ); ?>
