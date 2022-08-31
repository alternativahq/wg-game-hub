import Model from '@/Models/Model';
import { Inertia } from '@inertiajs/inertia';
import { inject } from 'vue';
import { useCurrentUser } from '@/Composables/useCurrentUser';

export default class Game extends Model {
    start() {
        let currentUser = useCurrentUser();
        // let currentUser = inject('currentUser');

        if (!currentUser) {
            Inertia.visit('/login');
        }

        Inertia.post(`/game-lobbies/${this.id}/join`, {}, { replace: true });
    }
}
