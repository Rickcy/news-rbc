// const moment = require('moment');

class BaseEntity {
    static make(data) {
        let entity = new this();
        if (data) {
            for (let propName in data) {
                if (propName in entity) {
                    entity[propName] = data[propName]
                }
            }
        }
        return entity;
    }

    static makeDate(date) {
        if (date) {
            // return moment.utc(date).toDate()
        }
        return null;
    }
}


module.exports = BaseEntity;
