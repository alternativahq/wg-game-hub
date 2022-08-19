export default class ResourceCollection {
    constructor(resourceCollection) {
        if (this.constructor === ResourceCollection) {
            throw new Error('Class "ResourceCollection" cannot be instantiated');
        }
        this.collectionMeta = resourceCollection.meta;
        this.collectionLinks = resourceCollection.links;
        this.collectionData = resourceCollection.data;
    }

    get meta() {
        return this.collectionMeta;
    }

    get links() {
        return this.collectionLinks;
    }

    get data() {
        throw new Error('Getter "data()" must be implemented.');
    }
}
