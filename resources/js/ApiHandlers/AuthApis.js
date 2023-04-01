import {axiosGetRequest, axiosPostRequest} from "@/ApiHandlers/Helpers/AxiosHelper";
import {dataCleanser} from "@/ApiHandlers/Helpers/Helpers";

export async function loginApi(params = {
    name: '',
    password: ''
}) {
    let data = dataCleanser(params);
    let res = await axiosPostRequest(data);
    return res;
}

export async function logoutApi() {
    let res = await axiosGetRequest('logout');
    return res.data;
}
