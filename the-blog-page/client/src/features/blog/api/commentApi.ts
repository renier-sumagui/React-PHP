import { api } from "../../../lib/api";
import axios from "axios";

import type { CreateCommentData } from "../types/BlogModel";

async function postComment(data: CreateCommentData) {
    console.log(data);
    
    try {
        const response = await api.post("/comment/create", data);

        return response.data;
    } catch (err) {
        if (axios.isAxiosError(err)) {
            return  { success: 0, message: err.response?.data?.message || "Something went wrong" };
        }
    }
}

async function getAllComments() {
    try {
        const response = await api.get("/comment/getall");

        return response.data;
    } catch (err) {
                if (axios.isAxiosError(err)) {
            return  { success: 0, message: err.response?.data?.message || "Something went wrong" };
        }
    }
}

export { postComment, getAllComments };