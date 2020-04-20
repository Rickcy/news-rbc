const axios = require('axios');

const api = axios.create({
    baseURL: '/api',
    withCredentials: true
});

const STATUS = {
    SUCCESS: 0,
    ERROR: 1,
    SERVER_ERROR: -1,
};

api.interceptors.response.use(res => {
    switch (res.data.status) {
        case STATUS.SUCCESS:
            return {error: null, data: res.data.data};
        case STATUS.ERROR:
        case STATUS.SERVER_ERROR:
            return {error: res.data.data, data: null};
    }
    return res.data
}, error => {
    return {error: error, data: null};
});


module.exports = api;