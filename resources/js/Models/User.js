import Model from '@/Models/Model';
import { Inertia } from '@inertiajs/inertia';
import Notification from '@/Models/Notification';

export default class User extends Model {
    get secondsToEndCooldown() {
        return this._secondsToEndCooldown;
    }

    get unreadNotifications() {
        return this.unread_notifications.map((notification) => new Notification(notification));
    }

    startCooldownCountdownTimer() {
        if (!this.cooldown_end_at) {
            return;
        }

        this._cooldownTimerInterval = setInterval(() => {
            this._secondsToEndCooldown = dayjs(this.cooldown_end_at).diff(dayjs(), 's');
            if (this._secondsToEndCooldown <= 0 || isNaN(this._secondsToEndCooldown)) {
                this.cooldown_end_at = null;

                this.killCooldownCountdownTimer();
            }
        }, 1000);
    }

    killCooldownCountdownTimer() {
        clearInterval(this._cooldownTimerInterval);
    }

    markNotificationAsRead(notificationId) {
        this.unread_notifications = this.unread_notifications.filter((singleNotification) => {
            return singleNotification.id !== notificationId;
        });

        Inertia.put(
            `/notifications/${notificationId}`,
            {},
            {
                preserveState: true,
                preserveScroll: true,
            }
        );
    }

    markAllNotificationsAsRead() {
        this.unread_notifications = [];
    }

    deleteAllNotifications() {
        this.unread_notifications = [];
        Inertia.delete('/notifications', {
            preserveState: true,
            preserveScroll: true,
        });
    }
}
