import { api } from "../../../lib/api";
import axios from "axios";
import type { SignInData, SignUpData } from "../models/authTypes";
import type { SignUpResponse, SignInResponse } from "../models/authTypes";

async function signUp(data: SignUpData): Promise<SignUpResponse> {
    try {
        const response = await api.post("/auth/signup", data)

        return response.data;
    } catch (err: unknown) {
        if (axios.isAxiosError(err) && err.response?.data) {
            return err.response.data;
        }

        return { success: 0, message: "Something went wrong" };
    }
}

async function signIn(data: SignInData): Promise<SignInResponse> {
    try {
        const response = await api.post("/auth/signin", data);

        return response.data;
    } catch (err: unknown) {
        if (axios.isAxiosError(err) && err.response?.data) {
            return err.response.data;
        }

        return { success: 0, message: "Something went wrong" };
    }
}

async function signOut(): Promise<{ success: number, message: string }> {
    try {
        const response = await api.get("/auth/signout");

        return response.data;
    } catch (err) {
        return { 
            success: 0, 
            message: axios.isAxiosError(err) ? err.response?.data?.message : "Something went wrong" 
        }
    }
}

export { signUp, signIn, signOut };