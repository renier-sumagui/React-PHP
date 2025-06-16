import type { UserModel } from "../context/models/AuthModel";

type SignInData = {
    email: string;
    password: string;
};

type SignUpData = {
    firstName: string;
    lastName: string;
    email: string;
    password: string;
    confirmPassword: string
};

type SignUpSuccess = {
    user: {
        firstName: string;
        lastName: string;
        email: string;
    };
    success: 1;
}


type SignUpError = {
    success: 0;
    errors?: Record<string, string>;
    message?: string;
}

type SignInSuccess = {
    success: 1;
    user: UserModel;
};

type SignInFailure = {
    success: 0;
    message: string;
}

type SignInResponse = SignInSuccess | SignInFailure;

type SignUpResponse = SignUpError | SignUpSuccess;

export type { SignInData, SignUpData, SignUpResponse, SignInResponse };