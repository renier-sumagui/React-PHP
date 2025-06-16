import { createBrowserRouter } from "react-router";
import { mainRoutes } from "./mainRoutes";
import { RootRoute } from "../layouts/RootRoute";
import { withSuspense } from "../utils/withSuspense";

export const router = createBrowserRouter([
  {
    path: "/",
    element: withSuspense(RootRoute),
    children: [
      ...mainRoutes
    ]
  }
]);