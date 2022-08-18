import Model from '@/Models/Model';
import { Inertia } from '@inertiajs/inertia';
import { useCurrentUser } from '@/Composables/useCurrentUser';

export default class ChatRoom extends Model {
    isMainChannel() {
        return this.type === 30;
    }

    sendChatMessage(message) {
        let currentUser = useCurrentUser();

        if (!currentUser) {
            return Inertia.get('/login');
        }

        if (message.length <= 0) {
            return;
        }

        Inertia.post(
            `chat-rooms/${this.id}/message`,
            {
                message: message,
            },
            {
                preserveScroll: true,
            }
        );
    }
}
