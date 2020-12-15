import {getAppConfig, getIPInfo} from '../../api/util'

const state = {
    config: {},//客户端配置信息
    ipInfo: {
        ip: ''
    },
};

const mutations = {
    SET_INFO(state, config) {
        state.config = config;
    },
    SET_IPINFO(state, ipinfo) {
        state.ipInfo = ipinfo;
    }
};

const actions = {
    init({dispatch, commit}) {
        getAppConfig().then(response => {
            commit('SET_INFO', response);
            dispatch('getIPInfo');
        });
    },

    //初始化 getIPInfo 信息
    getIPInfo({commit}) {
        return new Promise((resolve, reject) => {
            getIPInfo().then(response => {
                console.info(response)
                commit('SET_IPINFO', response);
                resolve(response)
            }).catch(error => {
                reject(error)
            })
        });
    },
};

export default {
    namespaced: true,
    state,
    mutations,
    actions
}
