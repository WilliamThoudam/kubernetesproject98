import { ajax, hooks } from 'peepso';
import { currentuserid as LOGIN_USER_ID } from 'peepsodata';

/**
 * Send friend request to a community member.
 *
 * @param {number} userId
 * @returns {JQueryDeferred}
 */
function sendRequest(userId) {
	let params = { uid: LOGIN_USER_ID, user_id: userId };

	return ajax.post('friendsajax.send_request', params).then(json => {
		if (json.success) {
			hooks.doAction('friend_request_sent', userId, json.data);
		}
	});
}

/**
 * Cancel friend request sent to a community member.
 *
 * @param {number} userId
 * @param {number} requestId
 * @returns {JQueryDeferred}
 */
function cancelRequest(userId, requestId) {
	let params = { uid: LOGIN_USER_ID, user_id: userId, request_id: requestId, action: 'cancel' };

	return ajax.post('friendsajax.cancel_request', params).then(json => {
		if (json.success) {
			hooks.doAction('friend_request_canceled', userId, json.data);
		}
	});
}

/**
 * Accept friend request from a community member.
 *
 * @param {number} userId
 * @param {number} requestId
 * @returns {JQueryDeferred}
 */
function acceptRequest(userId, requestId) {
	let params = { uid: LOGIN_USER_ID, user_id: userId, request_id: requestId };

	return ajax.post('friendsajax.accept_request', params).then(json => {
		if (json.success) {
			hooks.doAction('friend_request_accepted', userId, json.data);
		}
	});
}

/**
 * Reject friend request from a community member.
 *
 * @param {number} userId
 * @param {number} requestId
 * @returns {JQueryDeferred}
 */
function rejectRequest(userId, requestId) {
	let params = { uid: LOGIN_USER_ID, user_id: userId, request_id: requestId, action: 'ignore' };

	return ajax.post('friendsajax.cancel_request', params).then(json => {
		if (json.success) {
			hooks.doAction('friend_request_rejected', userId, json.data);
		}
	});
}

/**
 * Remove friendship with a community member.
 *
 * @param {number} userId
 * @returns {JQueryDeferred}
 */
function remove(userId) {
	let params = { uid: LOGIN_USER_ID, user_id: userId };

	return ajax.post('friendsajax.remove_friend', params).then(json => {
		if (json.success) {
			hooks.doAction('friend_removed', userId, json.data);
		}
	});
}

/**
 * Follow a community member.
 *
 * @param {number} userId
 * @returns {JQueryDeferred}
 */
function follow(userId) {
	let params = { uid: LOGIN_USER_ID, user_id: userId, follow: 1 };

	return ajax.post('friendsajax.set_follow_status', params).then(json => {
		if (json.success) {
			hooks.doAction('friend_followed', userId, json.data);
		}
	});
}

/**
 * Unfollow a community member.
 *
 * @param {number} userId
 * @returns {JQueryDeferred}
 */
function unfollow(userId) {
	let params = { uid: LOGIN_USER_ID, user_id: userId, follow: 0 };

	return ajax.post('friendsajax.set_follow_status', params).then(json => {
		if (json.success) {
			hooks.doAction('friend_unfollowed', userId, json.data);
		}
	});
}


export default {
	sendRequest,
	cancelRequest,
	acceptRequest,
	rejectRequest,
	remove,
	follow,
	unfollow
};
