import GameLobby from '@/Models/GameLobby';
import ResourceCollection from '@/Models/ResourceCollection';

export default class GameLobbyCollection extends ResourceCollection {
    get data() {
        return this.collectionData.map((gameLobby) => new GameLobby(gameLobby));
    }
}
