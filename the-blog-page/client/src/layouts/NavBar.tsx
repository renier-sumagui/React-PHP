import { useRef, useState, type ReactNode } from "react";
import { Modal as BootstrapModal } from "bootstrap";
import { useForm } from "react-hook-form";
import { signIn, signUp, signOut } from "../features/auth/api/authApi";
import { useAuth } from "../features/auth/context/useAuth";

import type { SubmitHandler, RegisterOptions, UseFormRegister } from "react-hook-form";
import type { SignInData, SignUpData } from "../features/auth/models/authTypes";

// Shared Input Component
type FormProps = {
    changeForm: () => void,
    closeModal: () => void,
}

interface InputProps {
    id: string;
    type: string;
    label: string;
    error?: string;
    validation: RegisterOptions;
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    register: UseFormRegister<any>;
}

const FormInput = ({ id, type, label, register, error, validation }: InputProps) => (
    <div className="mb-3">
        <label htmlFor={id} className="form-label">{ label }</label>
        <input 
            type={ type } 
            id={ id }
            className="form-control"
            { ...register(id, validation) }
            aria-invalid={!!error}
        />
        { error && <p className="form-text text-danger">{ error }</p> }
    </div>
);

function SignInForm({ changeForm, closeModal }: FormProps) {
    const { register, handleSubmit, setError, formState: { errors } } = useForm<SignInData>()
    const context = useAuth();

    const onSubmit: SubmitHandler<SignInData> = async (data) => {
        const res = await signIn(data);

        if (res.success) {
            context.setUser(res.user);
            context.setIsLoggedIn(1);

            closeModal();
        } else {
            context.setUser(null);
            context.setIsLoggedIn(0);

            setError(
                "email",
                {
                    type: "manual",
                    message: res.message
                }
            );
            setError(
                "password",
                {
                    type: "manual",
                    message: res.message
                }
            );
        }
    };

    return (
        <form onSubmit={ handleSubmit(onSubmit) } className="container-fluid px-0" noValidate>
            <FormInput
                id="email"
                type="email"
                label="Email"
                register={ register }
                error={ errors.email?.message || (errors.email ? "Email is required" : undefined) }
                validation={{ required: "Email is required." }}
            />
            <FormInput
                id="password"
                type="password"
                label="Password"
                register={ register }
                error={ errors.password?.message || (errors.password ? "Password is required" : undefined) }
                validation={{ required: "Password is required"}}
            />
            <input type="submit" className="btn btn-primary form-control mb-3" value="Sign In" />
            <p>Don't have an account? <span className="text-primary cursor-pointer" role="button" onClick={() => changeForm()}>Sign Up</span></p>
        </form>
    )
}

function SignUpForm({ changeForm, closeModal }: FormProps) {
    const { register, handleSubmit, watch, setError, formState: { errors } } = useForm<SignUpData>()
    const { setUser, setIsLoggedIn } = useAuth();

    const onSubmit: SubmitHandler<SignUpData> = async data => {
        try {
            const res = await signUp(data);

            if (res.success) {
                setUser(res.user);
                setIsLoggedIn(1);

                closeModal();
            } else {
                for (const field in res.errors) {
                    setError(
                        field as keyof SignUpData, 
                        {
                            type: "manual",
                            message: res.errors[field]
                        }
                    );
                }
            }
        } catch {
            console.error("Something went wrong");
        }
    };

    return (
        <form action="#" onSubmit={handleSubmit(onSubmit)} className="container-fluid px-0" noValidate>
            <FormInput
                id="firstName"
                type="text"
                label="First Name"
                register={register}
                error={ errors.firstName?.message || (errors.firstName ? "First name is required" : undefined) }
                validation={{ required: "First name is required" }}
            />
            <FormInput
                id="lastName"
                type="text"
                label="First Name"
                register={register}
                error={ errors.lastName?.message || (errors.lastName ? "First name is required" : undefined) }
                validation={{ required: "First name is required" }}
            />
            <FormInput
                id="email"
                type="email"
                label="Email"
                register={register}
                error={ errors.email?.message || (errors.email ? "Email is required" : undefined) }
                validation={{ required: "Email is required" }}
            />
            <FormInput
                id="password"
                type="password"
                label="Password"
                register={ register }
                error={ errors.password?.message || (errors.password ? "Password is required" : undefined) }
                validation={{ required: "Password is required"}}
            />
            <FormInput
                id="confirmPassword"
                type="password"
                label="Confirm Password"
                register={ register }
                error={ errors.confirmPassword?.message || (errors.confirmPassword ? "Confirmation password is required" : undefined) }
                validation={{ 
                    required: "Password is required", 
                    validate: val => {
                        if (val !== watch("password")) {
                            return "Passwords must be the same."
                        }

                        return true;
                    }
                }} 
            />
            <input type="submit" className="btn btn-primary form-control mb-3" value="Sign Up" />
            <p>Already have an account? <span className="text-primary" role="button" onClick={() => changeForm()}>Sign In</span></p>
        </form>
    )
}

function NavBar() {
    const modalRef = useRef<HTMLDivElement | null>(null);
    const [modalTitle, setModalTitle] = useState("Sign In");
    const [isSignIn, setIsSignIn] = useState(true);
    const authContext = useAuth();

    const openModal = () => {
        setIsSignIn(true);
        setModalTitle("Sign In");

        if (modalRef.current) {
            BootstrapModal.getOrCreateInstance(modalRef.current).show();
        }
    }

    const closeModal = () => {
        if (modalRef.current) {
            BootstrapModal.getOrCreateInstance(modalRef.current).hide();
        }
    }

    const changeForm = () => {
        setModalTitle(state => (state === "sign In" ? "Sign Up" : "Sign In"));
        setIsSignIn(state => !state);
    };

    const onSignOut = async () => {
        const res = await signOut();

        console.log(res.message);

        authContext.clearAuth();
    };

    let AuthButton: ReactNode;

    if (authContext.isLoggedIn) {
        AuthButton = <button type="button" className="btn btn-link" onClick={onSignOut}>Sign Out</button>
    } else {
        AuthButton = <button type="button" className="btn btn-link" onClick={openModal}>Sign In</button>
    }

    return (
        <nav className="navbar navbar-expand-lg bg-body-light border-bottom border-dark">
            <div className="container-fluid">
                <a className="navbar-brand" href="#">Blog</a>
                <div className="d-flex align-items-center">
                    { authContext.user && <span className="fs-5">Welcome { authContext.user.firstName }</span>}
                    { AuthButton }
                    {/* Modal */}
                    <div 
                        className="modal fade" 
                        id="signInModal" 
                        tabIndex={-1} 
                        aria-labelledby="signInModalLabel"
                        ref={modalRef}
                    >
                        <div className="modal-dialog modal-dialog-centered">
                            <div className="modal-content">
                                <div className="modal-header">
                                    <h1 className="modal-title fs-5 text-center" id="signInModalLabel">{ modalTitle }</h1>
                                </div>
                                <div className="modal-body">
                                    { isSignIn ? <SignInForm changeForm={changeForm} closeModal={closeModal} /> : <SignUpForm changeForm={changeForm} closeModal={closeModal} />}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    )
}

export { NavBar };