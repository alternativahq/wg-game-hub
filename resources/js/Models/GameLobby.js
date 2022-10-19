import { reactive } from 'vue';
import Model from '@/Models/Model';
import { Inertia } from '@inertiajs/inertia';

export default class GameLobby extends Model {
    static get socketEvents() {
        return {
            chatMessage: '.chat.message',
            userJoined: '.user.joined',
            userLeft: '.user.left',
            status: {
                scheduled: '.status.scheduled',
                awaitingPlayers: '.status.awaiting-players',
                gameStartDelayed: '.status.game-start-delayed',
                inGame: '.status.in-game',
                gameEnded: '.status.game-ended',
                distributingPrizes: '.status.distributing-prizes',
                distributedPrizes: '.status.distributed-prizes',
                archived: '.status.archived',
                latestUpdate: '.status.latest-update',
            },
            prizeUpdated: '.prize-updated',
        };
    }

    static get availableStatuses() {
        return {
            Scheduled: 10,
            AwaitingPlayers: 20,
            InGame: 30,
            GameEnded: 40,
            DistributingPrizes: 50,
            DistributedPrizes: 60,
            Archived: 70,
        };
    }

    get timeToStartAsString() {
        return this._timeToStart;
    }

    addUser(user) {
        this.users.push(user);
    }

    removeUser(user) {
        _.remove(this.users, (userObj) => {
            return userObj.id === user.id;
        });
    }

    startCountDownTimer() {
        // dayjs(u).utc().local().tz(dayjs.tz.guess())
        // let startAt = dayjs(this.start).utc().local().tz(dayjs.tz.guess());
        let scheduledAt = dayjs(this.scheduled_at_utc_string);
        this._countDownTimerInterval = setInterval(() => {
            let now = dayjs();
            let diff = dayjs.duration(scheduledAt.diff(now));
            let days = `${diff.get('days')}d`;
            let hours = `${diff.get('hours')}h`;
            let minutes = `${diff.get('minutes')}m`;
            let seconds = `${diff.get('seconds')}s`;
            this._timeToStart = `${days} ${hours} ${minutes} ${seconds}`;
        }, 1000);
    }

    killCountDownTimer() {
        clearInterval(this._countDownTimerInterval);
    }

    is(gameLobby) {
        return this.id === gameLobby.id;
    }

    join() {
        Inertia.post(`/game-lobbies/${this.id}/join`, {}, { replace: true });
    }

    redirectBackToGameLobby() {
        Inertia.replace(`/game-lobbies/${this.id}`);
    }
}
