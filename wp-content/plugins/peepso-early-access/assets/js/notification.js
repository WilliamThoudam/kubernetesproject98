'use strict';

let isSubscribed = false;
let swRegistration = null;

function urlB64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding)
        .replace(/\-/g, '+')
        .replace(/_/g, '/');

    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);

    for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}

if ('serviceWorker' in navigator && 'PushManager' in window) {
    console.log('Service Worker and Push is supported');

    navigator.serviceWorker.register(peepso_push_notification.plugin_url + 'assets/js/serviceWorker.js')
        .then(function (swReg) {
            console.log('Service Worker is registered', swReg);

            swRegistration = swReg;
            initialiseUI();

        })
        .catch(function (error) {
            console.error('Service Worker Error', error);
        });
} else {
    console.warn('Push messaging is not supported');
}

function subscribeUser() {
    const applicationServerKey = urlB64ToUint8Array(peepso_push_notification.public_key);
    swRegistration.pushManager.subscribe({
        userVisibleOnly: true,
        applicationServerKey: applicationServerKey
    })
        .then(function (subscription) {
            console.log('User is subscribed.');

            updateSubscriptionOnServer(subscription);

            isSubscribed = true;

            updateSubscription();
        })
        .catch(function (err) {
            console.log('Failed to subscribe the user: ', err);
            updateSubscription();
        });
}

function initialiseUI() {
    subscribeUser();

    // Set the initial subscription value
    swRegistration.pushManager.getSubscription()
        .then(function (subscription) {
            isSubscribed = !(subscription === null);

            if (isSubscribed) {
                console.log('User IS subscribed.');
            } else {
                console.log('User is NOT subscribed.');
            }

            updateSubscription();
        });
}

function updateSubscription() {
    if (Notification.permission === 'denied') {
        updateSubscriptionOnServer(null);
        return;
    }
}

function updateSubscriptionOnServer(subscription) {
    if (subscription && !isSubscribed) {
        const key = subscription.getKey('p256dh');
        const token = subscription.getKey('auth');

        jQuery.post(peepso_push_notification.ajax_url, {
            action: 'push_subscribe',
            endpoint: subscription.endpoint,
            publicKey: key ? btoa(String.fromCharCode.apply(null, new Uint8Array(key))) : null,
            authToken: token ? btoa(String.fromCharCode.apply(null, new Uint8Array(token))) : null,
        });
    }
}