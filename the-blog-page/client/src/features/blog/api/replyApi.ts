import { api } from "../../../lib/api";
import axios from "axios";

import type { CreateReplyData, CreateReplyResponse } from "../types/BlogModel";

async function postReply(data: CreateReplyData): Promise<CreateReplyResponse> {
    try {
        const response = await api.post("/reply/create", data);

        return response.data;
    } catch (err) {
        if (axios.isAxiosError(err)) {
            return { success: 0, message: err.response?.data?.message || "Something went wrong" };
        }

        return {
            success: 0,
            message: "An unexpected error occurred",
        };
    }
}

export { postReply };