import Model from '@/Models/Model';

export default class User extends Model {
    get secondsToEndCooldown() {
        return this._secondsToEndCooldown;
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
}
