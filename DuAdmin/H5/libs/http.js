import Vue from 'vue';
import Axios from 'axios'
import { Toast } from 'vant';
Vue.use(Toast);
Axios.defaults.timeout = 5000;
Axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=UTF-8';
Axios.defaults.baseURL = document.querySelector('meta[api-gate]').getAttribute('api-gate');
Axios.interceptors.request.use(function(config) {
    Toast.loading({
        duration: 0,
        message: '加载中...',
        forbidClick: true,
        loadingType: 'spinner'
    });
    config.headers['Authorization'] = 'Bearer ' + localStorage.getItem('token')
    return config
});

const frontendUrl = document.querySelector('meta[frontend-gate]').getAttribute('frontend-gate');

function upload(resource, data, success, error) {
    return Axios.post(resource, data, {
            'Content-Type': 'multipart/form-data'
        })
        .then(res => {
            if (res.data.status == 200) {
                success && success(res.data.data);
            } else {
                error && error(res.data.message);
            }
            return res.data.data
        })
        .catch(error => {
            console.log(error);
            Toast.fail('失败');
        });
}

function get(resource, data, success, error) {
    return Axios.get(resource, { params: data })
        .then(res => {
            if (res.data.status == 200) {
                success && success(res.data.data);
            } else {
                error && error(res.data.message);
            }
            return res.data.data;
        })
        .catch(error => {
            console.log(error);
            Toast.fail('失败');
        });
}

function post(resource, data, success, error) {
    return Axios.post(resource, data)
        .then(res => {
            if (res.data.status == 200) {
                success && success(res.data.data);
            } else {
                error && error(res.data.message);
            }
            return res.data.data;
        })
        .catch(error => {
            console.log(error);
            Toast.fail('失败');
        });
}

Axios.interceptors.response.use(function(config) {
    Toast.clear()
    return config
});

function assets(resource) {
    return (frontendUrl + resource).replace("//", "/");
}
export default {
    get,
    post,
    upload,
    frontendUrl,
    assets
}