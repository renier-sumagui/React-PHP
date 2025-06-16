import { Suspense } from "react";
import type { FC } from "react";

// eslint-disable-next-line react-refresh/only-export-components
const Loading = () => <h1>Loading...</h1>;

export const withSuspense = (Component: FC) => <Suspense fallback={<Loading />}><Component /></Suspense>;