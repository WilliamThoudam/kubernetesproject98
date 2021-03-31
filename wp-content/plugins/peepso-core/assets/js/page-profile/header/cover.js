import $ from 'jquery';
import { throttle } from 'underscore';
import { ajax, dialog, hooks } from 'peepso';
import { ajaxurl_legacy, currentuserid as USER_ID, profile as profileData } from 'peepsodata';

const PROFILE_ID = +profileData.id;
const IMG_COVER_DEFAULT = profileData.img_cover_default;
const COVER_NONCE = profileData.cover_nonce;
const COVER_UPLOAD_URL = `${ajaxurl_legacy}profile.upload_cover?cover`;
const COVER_UPLOAD_MAXSIZE = +peepsodata.upload_size;
const COVER_TEXT_ERROR_FILETYPE = profileData.text_error_filetype;
const COVER_TEXT_ERROR_FILESIZE = profileData.text_error_filetype;

let hasCover = +profileData.has_cover;

$(function () {
	let $container = $('.ps-js-focus--profile .ps-js-cover');
	if (!$container.length) {
		return;
	}

	let $upload = $('.ps-js-cover-upload').on('click', upload),
		$uploadFile = uploadInit(),
		$remove = $('.ps-js-cover-remove').on('click', remove),
		$reposition = $('.ps-js-cover-reposition').on('click', repositionStart),
		$repositionActions = $('.ps-js-cover-reposition-actions').hide(),
		$repositionCancel = $('.ps-js-cover-reposition-cancel').on('click', repositionCancel),
		$repositionConfirm = $('.ps-js-cover-reposition-confirm').on('click', repositionConfirm),
		$coverWrapper = $container.find('.ps-js-cover-wrapper'),
		$coverImage = $container.find('.ps-js-cover-image');

	// Do not show related buttons if cover image is not set.
	if (!hasCover) {
		$reposition.hide();
		$remove.hide();
	}

	/**
	 * Upload a new cover image.
	 *
	 * @param {Event} e
	 */
	function upload(e) {
		e.preventDefault();

		// Reset input file value before use to prevent the need to replace the element.
		// https://github.com/blueimp/jQuery-File-Upload/wiki/Frequently-Asked-Questions#why-is-the-file-input-field-cloned-and-replaced-after-each-selection
		// https://stackoverflow.com/questions/1703228/how-can-i-clear-an-html-file-input-with-javascript
		$uploadFile[0].value = null;

		// Simulate user click.
		$uploadFile.trigger('click');
	}

	function uploadInit() {
		let name = 'profile-cover-upload',
			accept = 'image/*',
			css = { position: 'absolute', opacity: 0, height: 1, width: 1 },
			html = `<input type="file" name="filedata" accept="${accept}" data-name="${name}" />`,
			$file = $(html).css(css);

		$file.appendTo(document.body);
		$file.psFileupload({
			formData: { user_id: PROFILE_ID, _wpnonce: COVER_NONCE },
			dataType: 'json',
			url: COVER_UPLOAD_URL,
			replaceFileInput: false,
			add(e, data) {
				let file = data.files[0];
				if (!file.type.match(/image\/(jpe?g|png)$/i)) {
					alert(COVER_TEXT_ERROR_FILETYPE);
				} else if (file.size > COVER_UPLOAD_MAXSIZE) {
					alert(COVER_TEXT_ERROR_FILESIZE);
				} else {
					$coverImage.css('opacity', 0.5);
					data.submit();
				}
			},
			done(e, data) {
				let json = data.result;

				if (json.success) {
					let imgCover = json.data.image_url;

					$remove.show();
					$reposition.show();
					hasCover = true;
					$coverImage
						.attr('style', '')
						.attr('src', imgCover + '?' + Math.random())
						.one('load', fixHorizontalPadding);

					hooks.doAction('profile_cover_updated', PROFILE_ID, imgCover);
				} else if (json.errors) {
					alert(json.errors);
				}
			}
		});

		return $file;
	}

	/**
	 * Remove cover image.
	 */
	function remove(e) {
		e.preventDefault();

		let popup = dialog(profileData.template_cover_remove).show();
		popup.$el.on('click', '.ps-js-cancel', () => popup.hide());
		popup.$el.on('click', '.ps-js-submit', () => {
			popup.hide();
			$coverImage.css('opacity', 0.5);

			let params = { uid: USER_ID, user_id: PROFILE_ID, _wpnonce: COVER_NONCE };
			ajax.post('profile.remove_cover_photo', params).then(json => {
				if (json.success) {
					$remove.hide();
					$reposition.hide();
					hasCover = false;
					$coverImage
						.attr('style', '')
						.attr('src', IMG_COVER_DEFAULT)
						.one('load', fixHorizontalPadding);

					hooks.doAction('profile_cover_updated', PROFILE_ID, IMG_COVER_DEFAULT);
				}
			});
		});
	}

	/**
	 * Initialize cover repositioning.
	 *
	 * @param {Event} e
	 */
	function repositionStart(e) {
		e.preventDefault();

		// Save current style for undo-ing.
		$coverImage.data('style', $coverImage.attr('style'));
		$coverImage.css('z-index', 1);

		$container.addClass('ps-focus-cover-edit');
		$repositionActions.show();

		let maxWidth = $coverWrapper.width() - $coverImage.width(),
			maxHeight = $coverWrapper.height() - $coverImage.height();

		$coverImage.draggable({
			cursor: 'move',
			// Impose dragging boundary.
			drag(e, ui) {
				ui.position.left = Math.min(0, Math.max(maxWidth, ui.position.left));
				ui.position.top = Math.min(0, Math.max(maxHeight, ui.position.top));
			},
			// Convert value to percentage when dragging is done.
			stop(e, ui) {
				let pos = ui.position,
					reposX = (100 * pos.left) / $coverWrapper.width(),
					reposY = (100 * pos.top) / $coverWrapper.height();

				// Round the position.
				reposX = Math.ceil(reposX * 10000) / 10000;
				reposY = Math.ceil(reposY * 10000) / 10000;

				$coverImage.css({ left: `${reposX}%`, top: `${reposY}%` });

				// Also save value to be sent later to the endpoint.
				$coverImage.data({ reposX, reposY });
			}
		});
	}

	/**
	 * Cancel cover repositioning.
	 *
	 * @param {Event} e
	 */
	function repositionCancel(e) {
		e.preventDefault();

		$container.removeClass('ps-focus-cover-edit');
		$repositionActions.hide();
		$coverImage.css('z-index', '');
		$coverImage.draggable('destroy');

		// Put back previous style.
		$coverImage.attr('style', $coverImage.data('style')).removeData('style');
	}

	/**
	 * Confirm cover repositioning.
	 *
	 * @param {Event} e
	 */

	function repositionConfirm(e) {
		e.preventDefault();

		$container.removeClass('ps-focus-cover-edit');
		$repositionActions.hide();
		$coverImage.css('z-index', '');
		$coverImage.draggable('destroy');

		let params = {
			user_id: PROFILE_ID,
			_wpnonce: COVER_NONCE,
			// Values are swapped :/
			y: $coverImage.data('reposX'),
			x: $coverImage.data('reposY')
		};

		ajax.post('profile.reposition_cover', params); // Optimistic call.
	}

	/**
	 * Fix horizontal padding issue caused by dimension difference between
	 * the cover image and its container.
	 */
	let fixHorizontalPadding = () => {
		// Reset image height.
		$coverImage.css({ height: 'auto', width: '100%', minWidth: '100%', maxWidth: '100%' });

		// Adjust image height to fill available space vertically it is less than the container width.
		let wrapperHeight = $coverWrapper.height(),
			wrapperWidth = $coverWrapper.width(),
			coverHeight = $coverImage.height(),
			coverWidth = $coverImage.width();

		if (coverHeight < wrapperHeight) {
			$coverImage.css({
				height: '100%',
				width: 'auto',
				minWidth: '100%',
				maxWidth: 'none'
			});
			coverHeight = $coverImage.height();
			coverWidth = $coverImage.width();
		}

		// Make sure image vertical position doesn't go out of viewport due to reposition value.
		let top = parseFloat($coverImage[0].style.top) || 0,
			minTop = 0;

		if (coverHeight >= wrapperHeight) {
			minTop = ((coverHeight - wrapperHeight) / wrapperHeight) * -100;
			if (top < minTop) {
				$coverImage.css('top', `${minTop}%`);
			}
		}

		// Make sure image horizontal position doesn't go out of viewport due to reposition value.
		let left = parseFloat($coverImage[0].style.left) || 0,
			minLeft = 0;

		if (coverWidth >= wrapperWidth) {
			minLeft = ((coverWidth - wrapperWidth) / wrapperWidth) * -100;
			if (left < minLeft) {
				$coverImage.css('left', `${minLeft}%`);
			}
		}

		// Show initially invisible cover image.
		$coverImage.css('opacity', '');
	};

	// Throttle the function.
	fixHorizontalPadding = throttle(fixHorizontalPadding, 500);

	// Fix horizontal padding issue on page load.
	$coverImage
		.one('load', () => fixHorizontalPadding())
		.each((i, img) => img.complete && fixHorizontalPadding());

	// Efficiently handles cover image dimension change on browser resize.
	let _docWidth;
	hooks.addAction('browser_resize', 'profile_cover', dimension => {
		if (!_docWidth || _docWidth !== dimension.width) {
			_docWidth = dimension.width;
			fixHorizontalPadding();
		}
	});

	let $coverButtonPopup = $('.ps-js-cover-button-popup');

	$coverButtonPopup.on('click', function (e) {
		if (e.currentTarget !== e.target) {
			return;
		}

		let $button = $(this);
		let coverUrl = $button.data('cover-url');
		if (coverUrl) {
			peepso.simple_lightbox(coverUrl);
		}
	});

	hooks.addAction('profile_cover_updated', 'page_profile', (id, imageUrl) => {
		if (+id === PROFILE_ID) {
			if (imageUrl.indexOf(`/users/${id}/`) > -1) {
				// Custom cover.
				$coverButtonPopup.css('cursor', 'pointer');
				$coverButtonPopup.data('cover-url', imageUrl);
			} else {
				// Default cover.
				$coverButtonPopup.css('cursor', '');
				$coverButtonPopup.removeData('cover-url');
			}
		}
	});
});
