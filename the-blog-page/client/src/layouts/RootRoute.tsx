import { Outlet } from "react-router"
import { NavBar } from "./NavBar";

function RootRoute() {
    return (
        <>
            <NavBar />
            <main className="container-lg pt-3">
                <Outlet />
            </main>
        </>
    )
}

export default RootRoute;