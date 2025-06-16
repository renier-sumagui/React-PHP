type UserModel = {
    id: number,
    firstName: string,
    lastName: string,
    email: string,
    createdAt?: string,
    updatedAt?: string
}

interface AuthContextType {
    user: UserModel | null;
    setUser: (user: UserModel | null) => void;
    isLoggedIn: boolean | number;
    setIsLoggedIn: (state: boolean | number) => void;
    clearAuth: () => void;
}

type SuccessResponse = {
    user: UserModel
    success: 1;
    isLoggedIn: boolean;
}

type FailureResponse = {
    success: 0;
    message: string;
}

type AuthCheckResponse = SuccessResponse | FailureResponse;

export type { UserModel, AuthContextType, AuthCheckResponse };