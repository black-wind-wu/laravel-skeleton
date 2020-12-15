import request from './request'

/**
 * 获取国家列表
 * @returns {AxiosPromise}
 */
const getCountry = function () {
    return request({
        method: 'get',
        url: '/api/country'
    });
};

/**
 * 获取短信验证码
 * @param phone
 * @param ticket
 * @param randstr
 * @returns {AxiosPromise}
 */
const getPhoneVerifyCode = function (phone, ticket, randstr) {
    return request({
        method: 'post',
        url: '/api/phone-verify-code',
        data: {
            phone: phone,
            ticket: ticket,
            randstr: randstr
        }
    });
};

/**
 * 获取邮箱验证码
 * @param email
 * @param ticket
 * @param randstr
 * @returns {AxiosPromise}
 */
const getEmailVerifyCode = function (email, ticket, randstr) {
    return request({
        method: 'post',
        url: '/api/mail-verify-code',
        data: {
            email: email,
            ticket: ticket,
            randstr: randstr
        }
    });
};

/**
 * 获取App 配置
 * @returns {AxiosPromise}
 */
const getAppConfig = function () {
    return request({
        method: 'get',
        url: '/api/config'
    });
};

const getIPInfo = function () {
    return request({
        method: 'get',
        url: 'https://api.myip.la/cn?json'
    });
};

/**
 * 点赞
 * @param id
 * @param type
 * @returns {AxiosPromise}
 */
const support = function (id, type) {
    return request({
        method: 'post',
        url: '/api/v1/support',
        data: {
            id: id,
            type: type
        }
    });
};

/**
 * 收藏
 * @param id
 * @param type
 * @returns {AxiosPromise}
 */
const collect = function (id, type) {
    return request({
        method: 'post',
        url: '/api/v1/collect',
        data: {
            id: id,
            type: type
        }
    });
}

/**
 * 关注
 * @param id
 * @param type
 * @returns {AxiosPromise}
 */
const follow = function (id, type) {
    return request({
        method: 'post',
        url: '/api/v1/follow',
        data: {
            id: id,
            type: type
        }
    });
}

export {
    getCountry,
    getPhoneVerifyCode,
    getEmailVerifyCode,
    getAppConfig,
    getIPInfo,
    support,
    collect,
    follow
}
