import request from './request'

const getClients = function () {
    return request({
        method: 'get',
        url: '/oauth/clients'
    });
};
const createClient = function (data) {
    return request({
        method: 'post',
        url: '/oauth/clients',
        data: data
    });
};
const updateClient = function (id, data) {
    return request({
        method: 'post',
        url: '/oauth/clients/' + id,
        data: {
            '_method': "put",
            name: data.name,
            redirect: data.redirect
        }
    });
};
const deleteClient = function (id) {
    return request({
        method: 'post',
        url: '/oauth/clients/' + id,
        data: {
            '_method': "delete"
        }
    });
};

const getTokens = function () {
    return request({
        method: 'get',
        url: '/oauth/tokens'
    });
};
const deleteToken = function (id) {
    return request({
        method: 'post',
        url: '/oauth/tokens/' + id,
        data: {
            '_method': "delete"
        }
    });
};
const getScopes = function () {
    return request({
        method: 'get',
        url: '/oauth/scopes'
    });
};

const getPersonalAccessTokens = function () {
    return request({
        method: 'get',
        url: '/oauth/personal-access-tokens'
    });
};
const createPersonalAccessTokens = function (data) {
    return request({
        method: 'post',
        url: '/oauth/personal-access-tokens',
        data: data
    });
};
const deletePersonalAccessTokens = function (id) {
    return request({
        method: 'post',
        url: '/oauth/personal-access-tokens/'+id,
        data: {
            '_method': "delete"
        }
    });
};

export {
    getClients,
    createClient,
    updateClient,
    deleteClient,
    getTokens,
    deleteToken,
    getPersonalAccessTokens,
    getScopes,
    createPersonalAccessTokens,
    deletePersonalAccessTokens
}
