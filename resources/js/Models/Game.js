import Model from '@/Models/Model';
import { useCurrentUser } from '@/Composables/useCurrentUser';
import { Inertia } from '@inertiajs/inertia';

export default class Game extends Model {
    start() {
        let currentUser = useCurrentUser();
        if (!currentUser) {
            Inertia.visit('/login');
        }

        Inertia.post(`/game-lobbies/${this.id}/join`, {}, { replace: true });
    }
}
