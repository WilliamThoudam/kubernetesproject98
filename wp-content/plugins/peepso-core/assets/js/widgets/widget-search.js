// import $ from 'jquery';
// import { Promise, modules } from 'peepso';
// import { rest_url } from 'peepsodata';

(function($, Promise, modules, rest_url) {
	/**
	 * Shorthand to the get method on the request modules.
	 *
	 * @type {Function}
	 * @returns {Promise}
	 */
	const get = modules.request.get;

	let uniqueId = 0;

	class WidgetSearch {
		constructor(element) {
			this.uniqueId = ++uniqueId;

			this.$element = $(element);
			this.$query = this.$element.find('.ps-js-query').val('test');
			this.$loading = this.$element.find('.ps-js-loading');
			this.$result = this.$element.find('.ps-js-result');

			this.$query.on('input', () => this.onSearch());
			this.onSearch();
		}

		/**
		 * Calls AJAX search endpoint based on the supplied query string.
		 *
		 * @param {string} query
		 * @returns {Promise}
		 */
		search(query = '') {
			query = query.trim();

			return new Promise((resolve, reject) => {
				let endpoint = `${rest_url}search`,
					endpoint_id = `${endpoint}_${this.uniqueId}`,
					params = { query },
					promise;

				promise = get(endpoint_id, endpoint, params);
				promise.then(json => resolve(json)).catch(reject);
			});
		}

		/**
		 * Render search result.
		 *
		 * @param {Object} data
		 */
		render(data = {}) {
			let results = data.results,
				sections = data.meta.sections,
				image_size = 100,
				html = '',
				html_no_results = '';

			for (const key in results) {
				var temp_html = '';

				temp_html += `<div data-type="${key}">`;
				// Header.
				temp_html += `<div style="clear: both;"><h3><a href="${sections[key].url}">${sections[key].title}</a></h3></div>`;

				if (results.hasOwnProperty(key) && results[key].length) {
					// Results.
					temp_html +=
						'<ul style="list-style:none; padding:0px 0px 30px 10px;margin:0px 0px 20px 0px;clear: both;">';
					results[key].forEach(item => {
						// Item START
						temp_html += `<li style="margin-bottom:15px;clear:both;" data-type="${key}" data-id="${item.id}">`;

						// Image for thumb

						var opacity = 1;

						if (!item.image) {
							item.image =
								'wp-content/plugins/peepso-core/assets/images/embeds/no_preview_available.png';
							opacity = 0.1;
						}

						// Thumb
						temp_html += `<div style="opacity: ${opacity};margin:0px 10px 10px 0px;height:${image_size}px;width:${image_size}px;float:left; background: url('${item.image}');background-size:cover;background-position: center center;" ></div>`;

						// Title
						temp_html += `<a href="${item.url}"><strong>${item.title}</strong></a>`;

						// Meta - privacy
						if (item.meta) {
							console.log(item.meta);
							var meta_html = '';

							for (var key in item.meta) {
								if (item.meta.hasOwnProperty(key)) {
									var meta = item.meta[key];
									meta_html += `<span style="margin-right:5px"><i class="${meta.icon}"></i> ${meta.title}</span>`;
								}
							}

							if (meta_html.length) {
								temp_html +=
									`<small style="font-size:12px;opacity:0.5"><br/>` +
									meta_html +
									`</small>`;
							}
						}

						// Text
						if (item.text) {
							temp_html += `<br/><span style="font-size:14px">${item.text}</span>`;
						}

						// Item END
						temp_html += `</li>`;
					});
					temp_html += '</ul>';
				} else {
					temp_html += '<p>No results<br/><br/></p>';
				}

				temp_html += '</div>';

				if (results.hasOwnProperty(key) && results[key].length) {
					html += temp_html;
				} else {
					html_no_results += '<div style="opacity:0.5">' + temp_html + '</div>';
				}
			}

			html += html_no_results;

			this.$result.html(html);
		}

		onSearch() {
			let query = this.$query.val(),
				trimmed = query.replace(/^\s+/, '');

			if (query !== trimmed) {
				query = trimmed;
				this.$query.val(trimmed);
			}

			this.$result.hide().empty();
			this.$loading.show();
			this.search(query)
				.then(json => {
					this.$loading.hide();
					this.$result.show();
					this.render(json);
				})
				.catch(() => {
					this.$loading.hide();
				});
		}
	}

	$(() => {
		$('.ps-js-widget-search').each(function() {
			new WidgetSearch(this);
		});
	});
})(jQuery, peepso.Promise, peepso.modules, peepsodata.rest_url);
