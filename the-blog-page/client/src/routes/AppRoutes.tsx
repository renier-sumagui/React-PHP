import { createBrowserRouter } from "react-router";
import { withSuspense } from "../utils/helpers";
import { lazy } from "react";

const BlogPage = withSuspense(lazy(() => import("../features/blog/BlogPage")));
const RootRoute = withSuspense(lazy(() => import("../layouts/RootRoute")));

const appRoutes = createBrowserRouter([
    {
        path: "/",
        element: <RootRoute />,
        children: [
            {
                index: true,
                element: <BlogPage />
            }
        ]
    }
]);

export { appRoutes };