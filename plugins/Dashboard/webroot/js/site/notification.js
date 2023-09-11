"use strict";

/*
 * Start jQuery
 * Most of the elements in this file depend on jQuery.
 * Ensure that jQuery is loaded before this file is loaded.
 */
$(function () {
    /*
     * Configure sound property
     * Uses the ion API for sounds found at http://ionden.com/a/plugins/ion.sound/en.html
     */
    ion.sound({
        sounds: [
            {
                name: "water_droplet",
            },
        ],
        volume: 1.0,
        path: "/dashboard/js/ion_sound/sounds/",
        preload: true,
    });

    /**
     * Notification Card Generator
     *
     * Create a new notification card in the notification list.
     *
     * @param {string} message Message the should be in the notification item.
     * @param {string} link Hyperlink for the notification.
     * @return void
     */
    const createNotificationCard = (message, link) => {
        let anchor = $(`<a href="${link}" class="dropdown-item notification-item bg-info text-light">`);
        anchor.text(message);
        $("#notification-list").prepend(anchor);
    };

    /**
     * Toast notifier
     *
     * Create the toast notification for a new commission report.
     *
     * @param {string} url Link to the commission report.
     * @return void
     */
    const notifyCommissionReport = (url) => {
        $.notify({
            message: "Your commission report is now ready! Click to download.",
            url: url,
            icon: 'description',
        }, {
            type: "success",
            placement: {
                from: "bottom",
                align: "left",
            }
        });
    };

    /**
     * Check Notifications
     *
     * Ajax call to check for notifications.
     *
     * @return {JQuery.jqXHR} Response from the server.
     */
    const getNew = () => {
        return $.get('/notifications/get-new');
    };

    /**
     * Notification generator
     *
     * Create the notification elements for the list items, toasts, and desktop notifications.
     * *Note: The desktop notifications may not work.*
     *
     * @param {Object} notifications Message for the notification.
     * @param {string} message Title of the notification items.
     * @return void
     */
    const addNotification = (notifications, message) => {
        for (let i = 0; i < notifications.length; i++) {
            notifyCommissionReport(notifications[i].link);
            createNotificationCard(message, notifications[i].link);
            if (!window.Notification) {
                console.log('Browser does not support notifications')
            } else {
                if (Notification.permission === 'granted') {
                    let notify = new Notification(message, {
                        body: 'Go To the Application For More Information.',
                        icon: '/dashboard/img/navigation/small-logo.png',
                        vibrate: true,
                        lang: 'en_US',
                        image: '/dashboard/img/navigation/small-logo.png',
                    });
                } else {
                    // request permission from user
                    Notification.requestPermission().then(function (p) {
                        if (p === 'granted') {
                            let notify = new Notification(message, {
                                body: 'Go To the Application For More Information.',
                                icon: '/dashboard/img/navigation/small-logo.png',
                                vibrate: true,
                                lang: 'en_US',
                                image: '/dashboard/img/navigation/small-logo.png',
                            });
                        } else {
                            console.log('User blocked notifications.');
                        }
                    }).catch(function (err) {
                        console.error((err));
                    });
                }
            }
        }
    };

    /**
     * Notification Sound Player
     *
     * Play a sound to alert the user that a notification has come in.
     *
     * @return void
     */
    const playNotificationSound = () => {
        ion.sound.play('water_droplet');
    };

    /**
     * Notification Count Incrementor
     *
     * Update the count for notification by the bell icon for both desktop and mobile views.
     * This will always either result in the badge remaining the same or displaying a higher amount.
     *
     * @param {number} newCount Number of new notifications that should be represented.
     * @return void
     */
    const updateNotificationCount = (newCount) => {
        let badge = $('.notification.bell-notification');
        let mobileBadge = $('.notification.sidebar-notification');
        let count = parseInt(badge.text() ? badge.text() : 0);
        count += newCount;
        badge.text(count);
        mobileBadge.text(count);
        badge.removeClass('d-none');
        mobileBadge.removeClass('d-none');
    };

    /**
     * Notification controller
     *
     * Run the check for new notifications and if needed process them.
     *
     * @return void
     */
    const checkNotifications = () => {
        $.when(getNew())
            .then(notifications => {
                if (notifications.length) {
                    // todo: make this dynamic
                    addNotification(notifications, 'Your commission report is ready');
                    playNotificationSound();
                    updateNotificationCount(notifications.length);
                }
            });
    }

    /*
     * Set up the automatic checking.
     * Runs every 10 seconds.
     */
    setInterval(checkNotifications, 10000);

    /*
     * Notification "click" event handler
     *
     *
     * Remove the look of the card for the "new" or "unread" types.
     * Decrease the number of notifications represented on the bell icon.
     * If the number is zero, hide the badge.
     */
    $(document).on('click', '.notification-item', function () {
        if ($(this).hasClass('bg-info')) {
            $(this).removeClass('bg-info')
                .removeClass('text-light');
            let badge = $('.notification.bell-notification');
            let mobileBadge = $('.notification.sidebar-notification');
            let count = parseInt(badge.text() ? badge.text() : 0);
            count--;
            if (count === 0) {
                badge.text('');
                mobileBadge.text('');
                badge.addClass('d-none');
                mobileBadge.addClass('d-none');
            } else {
                badge.text(count);
                mobileBadge.text(count);
            }
        }
    });
});