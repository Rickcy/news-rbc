module.exports = {
    findItemInArray(list, findValue, findName = 'id') {
        let index = null;
        let item = null;
        for (let i in list) {
            if (list[i][findName] && list[i][findName] == findValue) {
                index = i;
                break
            }
        }
        if (index) {
            item = list[index];
        }
        return {index, item}
    }

};