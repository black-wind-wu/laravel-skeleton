import {getInfo, getProfile} from '../../api/user'

const state = {
    guest: true,//是否是游客
    username: "",
    avatar: "",
    unreadNotificationCount: 0,//未读消息数
    userInfo: {

    },//用户基本信息
};

const mutations = {
    SET_INFO(state, info) {
        state.info = info;
        state.guest = !info.isLogin;
        state.username = info.username;
        state.unreadNotificationCount = info.unreadNotificationCount;
    },
    SET_PROFILE(state, profile) {
        state.profile = profile;
        state.avatar = profile.avatar;
    }
};

const actions = {
    init({dispatch, commit}) {
        getInfo().then(response => {
            commit('SET_INFO', response);
            if (response.isLogin === true) {
                dispatch('getProfile');
            }
        });
    },

    //初始化 Profile 信息
    getProfile({commit}) {
        return new Promise((resolve, reject) => {
            getProfile().then(response => {
                commit('SET_PROFILE', response);
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

