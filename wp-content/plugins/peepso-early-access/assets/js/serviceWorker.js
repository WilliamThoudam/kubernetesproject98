'use strict';

self.addEventListener('push', function (event) {
    const notificationObject = JSON.parse(event.data.text());

    const title = notificationObject.title;
    const options = {
        body: notificationObject.msg,
        icon: notificationObject.icon,
        badge: notificationObject.badge
    };
    self.notificationURL = notificationObject.url;
    event.waitUntil(self.registration.showNotification(title, options));
});

self.addEventListener('notificationclick', function (event) {
    event.notification.close();

    event.waitUntil(
        clients.openWindow(self.notificationURL)
    );
});