const BaseEntity = require('../entities/BaseEntity');

class News extends BaseEntity {
    constructor() {
        super();
        this.id = null;
        this.source = null;
        this.author = null;
        this.title = null;
        this.content = null;
        this.description = null;
        this.url = null;
        this.urlToImage = null;
        this.published_at = null;
    }

    static make(data) {
        if (data) {
            let entity = super.make(data);
            entity.published_at = super.makeDate(data.published_at);
            return entity;
        }
    }
}

module.exports = News;