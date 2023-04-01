import axios from "axios";

export async function axiosGetRequest(url){
    let res = await window.axios.request({
        url:  "api/" + url,
        method: 'GET',
        'headers': {
            'accept': 'application/json',
        }
    });

    return res.data;
}

export async function axiosPostRequest(url, data) {

    let res = await window.axios.request({
        url: "/api/" + url,
        method: 'Post',
        'headers': {
            'accept': 'application/json',
        },
        data: data
    })
    return res.data;
}

export async function axiosPutRequest(url, data) {
    data._method = 'put';
    let res = await window.axios.request({
        url: "api/" + url,
        method: 'Post',
        'headers': {
            'accept': 'application/json',
        },
        data: data
    })
    return res.data;
}
