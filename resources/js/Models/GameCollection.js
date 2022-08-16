import Game from '@/Models/Game';
import ResourceCollection from '@/Models/ResourceCollection';

class GameCollection extends ResourceCollection {
    get data() {
        return this.collectionData.map((game) => new Game(game));
    }
}
