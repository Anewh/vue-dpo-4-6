import {APP_CONFIG} from "../config.js";
import jsonp from "jsonp";

export const vkApi = {
    methods: {
        database: {
            getCountries: 'database.getCountries',
            getCities: 'database.getCities',
            getUniversities: 'database.getUniversities'
        }
    },
    get: function (method, queryParams, fn) {
        queryParams.lang = 'ru';
        queryParams.v = APP_CONFIG.vk.apiVersion;
        queryParams.access_token = APP_CONFIG.vk.token;

        jsonp(
            APP_CONFIG.vk.uri + method + '?' + makeQueryString(queryParams),
            null,
            fn
        );
    },
};

function makeQueryString(queryParams) {
    return Array.from(Object.entries(queryParams))
        .map(value => value[0] + '=' + encodeURIComponent(value[1]))
        .join('&');
}