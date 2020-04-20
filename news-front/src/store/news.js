const api = require('../api');
const {ACTIONS, MUTATTIONS} = require('../namespaces');
import NewsEntity from '../entities/News'

export default {
    state: {
        list: [],
        error: null,
        item: null,
    },
    getters: {
        newsError(state) {
            return state.error
        },
        news(state) {
            return state.list
        },
        newsDetails(state) {
            return state.item
        }
    },
    mutations: {
        [MUTATTIONS.NEWS_LIST_SET](state, list) {
            state.list = list;
        },
        [MUTATTIONS.NEWS_ITEM_SET](state, item) {
            state.item = item;
        },
        [MUTATTIONS.NEWS_ERROR_SET](state, error) {
            state.error = error;
        }
    },

    actions: {
        async [ACTIONS.NEWS_LIST]({commit}) {
            let {error, data} = await api.get('news/list');

            if (data) {
                let list = data.list.map(item => NewsEntity.make(item));
                commit(MUTATTIONS.NEWS_LIST_SET, list)
            }
            if (error) {
                console.error(error);
            }
        },
        async [ACTIONS.NEWS_ITEM]({commit}, params = {}) {
            commit(MUTATTIONS.NEWS_ITEM_SET, null);

            let {error, data} = await api.get('news/item', {params: params});

            if (data && data.item) {
                let item = NewsEntity.make(data.item);
                commit(MUTATTIONS.NEWS_ITEM_SET, item)
            }
            if (error) {
                commit(MUTATTIONS.NEWS_ERROR_SET, error);
                console.error(error);
            }
        }
    }
}