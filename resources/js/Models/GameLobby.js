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
                gameAbortedRefunding: '.status.game-aborted-refunding',
                gameAborted: '.status.aborted',
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
        if(this._timeToStart <= "0d 0h 0m 0s"){
            return "0d 0h 0m 0s"
        }
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
        let startAt = dayjs(this.start_at);
        let blbl;
        this._countDownTimerInterval = setInterval(() => {
            let now = dayjs();
            let diff = dayjs.duration(startAt.diff(now));
            let days = `${diff.get('days')}d`;
            let hours = `${diff.get('hours')}h`;
            let minutes = `${diff.get('minutes')}m`;
            let seconds = `${diff.get('seconds')}s`;
            this._timeToStart = `${days} ${hours} ${minutes} ${seconds}`;
            if(this._timeToStart <= "0d 0h 0m 0s"){
                clearInterval(this._countDownTimerInterval)
            }
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
