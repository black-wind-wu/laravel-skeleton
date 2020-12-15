import axios from 'axios'

const CSRFToken = document.head.querySelector('meta[name="csrf-token"]');

// create an axios instance
const service = axios.create({
    //baseURL: process.env.MIX_APP_URL, // url = base url + request url
    //withCredentials: true, // send cookies when cross-domain requests
    timeout: 5000, // request timeout
});

// request interceptor
service.interceptors.request.use(
    config => {
        config.headers['X-Requested-With'] = 'XMLHttpRequest';
        // do something before request is sent
        if (CSRFToken) {
            // let each request carry token
            // ['X-CSRF-TOKEN'] is a custom headers key
            // please modify it according to the actual situation
            config.headers['X-CSRF-TOKEN'] = CSRFToken.content
        } else {
            //console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
        }
        return config
    },
    error => {
        // do something with request error
        console.log(error);// for debug
        return Promise.reject(error)
    }
);

// response interceptor
service.interceptors.response.use(
    /**
     * If you want to get http information such as headers or status
     * Please return  response => response
     */

    /**
     * Determine the request status by custom code
     * Here is just an example
     * You can also judge the status by HTTP Status Code
     */
    response => {
        return response.data;
    },
    error => {
        return Promise.reject(error)
    }
);
export default service
