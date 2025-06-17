import { api } from "../../../lib/api";
import axios from "axios";

import type { CreateReplyData, ReplyModel } from "../types/BlogModel";
import type { ApiResponse } from "../../../types/ApiResponse";

async function postReply(data: CreateReplyData): Promise<ApiResponse<ReplyModel>> {
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