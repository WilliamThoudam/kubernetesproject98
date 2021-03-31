import $ from 'jquery';
import { observer } from 'peepso';
import { activity } from 'peepsodata';

const IS_GROUP_STREAM = window.peepsogroupsdata && +window.peepsogroupsdata.group_id;
const IS_PERMALINK = +activity.is_permalink;

if (!IS_GROUP_STREAM && !IS_PERMALINK) {
	let stashedPosts = [];

	// Do not show pinned group posts at the top of non-group stream.
	observer.addFilter(
		'peepso_activity',
		$posts => {
			$posts = $posts.map(function() {
				let $post = $(this),
					mappedPost = this,
					$header,
					timestamp;

				// Stash pinned group post.
				if ($post.hasClass('ps-js-activity-pinned')) {
					if (!$post.data('pending-post')) {
						$header = $post.find('.ps-js-post-header');
						// Check if it is a group post.
						if ($header.find('.ps-post__subtitle .gci-users').length) {
							timestamp = +$header
								.find('.ps-post__date[data-timestamp]')
								.data('timestamp');
							if (timestamp) {
								mappedPost = null;
								stashedPosts.push({ post: this, timestamp: timestamp });
								stashedPosts = _.sortBy(stashedPosts, function(stashed) {
									return -stashed.timestamp;
								});
							}
						}
					}
				}

				// Put stashed pinned group posts to the original location as if its not pinned.
				else if (stashedPosts.length && $post.hasClass('ps-js-activity')) {
					$header = $post.find('.ps-js-post-header');
					timestamp = +$post.find('.ps-post__date[data-timestamp]').data('timestamp');
					if (timestamp) {
						stashedPosts = $.map(stashedPosts, function(stashed) {
							if (stashed.timestamp > timestamp) {
								if (!_.isArray(mappedPost)) {
									mappedPost = [mappedPost];
								}
								mappedPost.splice(mappedPost.length - 1, 0, stashed.post);
								return null;
							}
							return stashed;
						});
					}
				}

				return mappedPost;
			});

			return $posts;
		},
		10,
		1
	);

	// Clear the pending post cache on every filter change.
	observer.addFilter(
		'show_more_posts',
		params => {
			if (+params.page === 1) {
				stashedPosts = [];
			}
			return params;
		},
		10,
		1
	);

	// Return any pending posts HTML if available.
	observer.addFilter(
		'activitystream_pending_html',
		html => {
			let pendingHtml = '';
			stashedPosts.forEach(stashed => {
				let $wrapper = $('<div />').append(stashed.post);
				// Add a marker so the post will not be stashed again by "peepso_activity" filter above.
				$wrapper.find('.ps-js-activity-pinned').attr('data-pending-post', 'group');
				pendingHtml += $wrapper.html();
			});

			return html + pendingHtml;
		},
		10,
		1
	);
}
