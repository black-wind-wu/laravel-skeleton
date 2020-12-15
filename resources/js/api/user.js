import request from './request'

/**
 * 登录
 * @param account
 * @param password
 * @returns {AxiosPromise}
 */
const login = function (account, password) {
    return request({
        method: 'post',
        url: 'login',
        data: {
            account: account,
            password: password
        }
    });
};

/**
 * 退出
 * @returns {AxiosPromise}
 */
const logout = function () {
    return request({
        method: 'post',
        url: 'logout'
    });
};

/**
 * 用户名是否可用
 * @param username
 * @returns {AxiosPromise}
 */
const existUsername = function (username) {
    return request({
        method: 'post',
        url: '/api/v1/user/exists',
        data: {
            username: username
        }
    });
};

/**
 * 邮箱是否可用
 * @param email
 * @returns {AxiosPromise}
 */
const existEMail = function (email) {
    return request({
        method: 'post',
        url: '/api/v1/user/exists',
        data: {
            email: email
        }
    });
};

/**
 * 手机是否可用
 * @param phone
 * @returns {AxiosPromise}
 */
const existPhone = function (phone) {
    return request({
        method: 'post',
        url: '/api/v1/user/exists',
        data: {
            phone: phone
        }
    });
};

/**
 * 获取 登录状态
 * @returns {AxiosPromise}
 */
const getInfo = function () {
    return request({
        method: 'get',
        url: '/ajax/info'
    });
};

/**
 * 手机注册
 * @param phone
 * @param verifyCode
 * @param password
 * @returns {AxiosPromise}
 */
const phoneRegister = function (phone, verifyCode, password) {
    return request({
        method: 'post',
        url: '/api/v1/user/phone-register',
        data: {
            phone: phone,
            verifyCode: verifyCode,
            password: password
        }
    });
};

/**
 * 邮箱注册
 * @param email
 * @param verifyCode
 * @param password
 * @returns {AxiosPromise}
 */
const emailRegister = function (email, verifyCode, password) {
    return request({
        method: 'post',
        url: '/api/v1/user/email-register',
        data: {
            email: email,
            verifyCode: verifyCode,
            password: password
        }
    });
};

/**
 * 手机重置密码
 * @param phone
 * @param verifyCode
 * @param password
 * @returns {AxiosPromise}
 */
const phoneResetPassword = function (phone, verifyCode, password) {
    return request({
        method: 'post',
        url: '/api/v1/user/phone-reset-password',
        data: {
            phone: phone,
            verifyCode: verifyCode,
            password: password
        }
    });
};

/**
 * 获取个人资料
 * @returns {AxiosPromise}
 */
const getProfile = function () {
    return request({
        method: 'get',
        url: '/api/v1/user/profile'
    });
};

/**
 * 获取扩展资料
 * @returns {AxiosPromise}
 */
const getExtra = function () {
    return request({
        method: 'get',
        url: '/api/v1/user/extra'
    });
};

/**
 * 修改个人资料
 * @param data
 * @returns {AxiosPromise}
 */
const editProfile = function (data) {
    return request({
        method: 'post',
        url: '/api/v1/user/profile',
        data: data
    });
};

/**
 * 修改邮箱
 * @returns {AxiosPromise}
 * @param email
 * @param verifyCode
 */
const editEMail = function (email, verifyCode) {
    return request({
        method: 'post',
        url: '/api/v1/user/email',
        data: {
            email: email,
            verifyCode: verifyCode,
        }
    });
};

/**
 * 修改手机号
 * @param phone
 * @param verifyCode
 * @returns {AxiosPromise}
 */
const editMobile = function (phone, verifyCode) {
    return request({
        method: 'post',
        url: '/api/v1/user/phone',
        data: {
            phone: phone,
            verifyCode: verifyCode,
        }
    });
};
/**
 * 修改密码
 * @param old_password
 * @param password
 * @returns {AxiosPromise}
 */
const editPassword = function (old_password, password) {
    return request({
        method: 'post',
        url: '/api/v1/user/password',
        data: {
            old_password: old_password,
            password: password
        }
    });
};

/**
 * 获取实名认证
 * @returns {AxiosPromise}
 */
const identification = function () {
    return request({
        method: 'get',
        url: '/api/v1/user/identification'
    });
};

/**
 * 提交实名认证
 * @param data
 * @returns {AxiosPromise}
 */
const modifyIdentification = function (data) {
    return request({
        method: 'post',
        url: '/api/v1/user/identification',
        data: data
    });
};

/**
 * 获取登录历史
 * @returns {AxiosPromise}
 */
const loginHistories = function (page) {
    return request({
        method: 'get',
        url: '/api/v1/user/login-histories',
        params: {
            page: page
        }
    });
};

/**
 * 获取已经绑定的社交账户
 * @returns {AxiosPromise}
 */
const socialAccounts = function () {
    return request({
        method: 'get',
        url: '/api/v1/user/social/accounts'
    });
};

/**
 * 解绑社交账户
 * @param provider
 * @returns {AxiosPromise}
 */
const deleteSocialAccount = function (provider) {
    return request({
        method: 'post',
        url: '/api/v1/user/social/accounts/' + provider,
        data: {_method: 'DELETE'}
    });
};

/**
 * 搜索账户
 * @returns {AxiosPromise}
 */
const search = function (q) {
    return request({
        method: 'get',
        url: '/api/v1/user/search',
        params: {
            q: q
        }
    });
};

/**
 * 标记所有未读的通知为已读
 * @returns {AxiosPromise}
 */
const markNotificationsAsRead = function () {
    return request({
        method: 'post',
        url: '/api/v1/user/notifications/mark-read'
    });
};

/**
 * 未读通知
 * @returns {AxiosPromise}
 */
const unreadNotificationCount = function () {
    return request({
        method: 'get',
        url: '/api/v1/user/notifications/unread-count'
    });
};

/**
 * 发送站内信
 * @param data
 * @returns {AxiosPromise}
 */
const sendMessage = function (data) {
    return request({
        method: 'post',
        url: '/api/v1/user/messages',
        data: data
    });
};

export {
    login, logout, existUsername, existEMail, existPhone, getInfo, getProfile, getExtra, editEMail, editMobile,
    editPassword, editProfile, phoneResetPassword, phoneRegister, emailRegister, identification, modifyIdentification,
    loginHistories, socialAccounts, deleteSocialAccount, search, markNotificationsAsRead,
    unreadNotificationCount, sendMessage
}
