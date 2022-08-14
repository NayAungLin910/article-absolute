import axios from "axios";

export const api_url = "http://www.coffeesojava.xyz/absolute/public";

export const cusaxios = axios.create({
    baseURL: api_url,
})