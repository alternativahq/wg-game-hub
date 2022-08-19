import User from '@/Models/User';
import { Inertia } from '@inertiajs/inertia';
import { reactive } from 'vue';

export function useCurrentUser() {
    return Inertia.page.props.auth.user ? reactive(new User(reactive(Inertia.page.props.auth.user))) : false;
}
