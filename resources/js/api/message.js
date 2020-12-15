import request from './request'

/**
 * 删除消息
 * @param id
 * @returns {AxiosPromise}
 */
const deleteMessage = function (id) {
    return request({
        method: 'post',
        url: '/api/v1/user/messages/' + id,
        data: {_method: 'DELETE'}
    });
};

export {
    deleteMessage
}
