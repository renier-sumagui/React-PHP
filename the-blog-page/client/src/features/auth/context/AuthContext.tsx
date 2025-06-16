import { createContext, useState, useEffect } from "react";

import type { UserModel, AuthContextType, AuthCheckResponse } from "./models/AuthModel";
import type { ReactNode } from "react";
import { api } from "../../../lib/api";

const AuthContext = createContext<AuthContextType | null>(null);

function AuthProvider({ children }: { children: ReactNode}) {
    const [user, setUser] = useState<UserModel | null>(null);
    const [isLoggedIn, setIsLoggedIn] = useState<boolean | number>(false);

    const clearAuth = () => {
        setUser(null);
        setIsLoggedIn(0);
    };

    useEffect(() => {
        async function isLoggedIn() {
            try {
                const res = await api.get("/auth/check");
                const data: AuthCheckResponse = res.data;
                
                if (data.success) {
                    setUser(data.user);
                    setIsLoggedIn(data.isLoggedIn);
                }
            } catch {
                console.log("Something went wrong");
            }
        }

        isLoggedIn();
    }, []);

    return (
        <AuthContext.Provider value={{ user, isLoggedIn, setUser, setIsLoggedIn, clearAuth }}>
            { children }
        </AuthContext.Provider>
    )
}

export { AuthProvider };
export default AuthContext;