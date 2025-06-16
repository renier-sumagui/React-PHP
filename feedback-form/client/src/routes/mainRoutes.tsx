import { lazy } from "react";
import { withSuspense } from "../utils/withSuspense";

const Feedback = lazy(() => import("../features/feedback/Feedback"));
const Result = lazy(() => import("../features/feedback/FeedbackResult"));

export const mainRoutes = [
  { index: true, element: withSuspense(Feedback) },
  { path: "result", element: withSuspense(Result) }
];