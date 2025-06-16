import { Suspense, type ComponentType, type LazyExoticComponent } from "react";
import { LoadingScreen } from "../components/LoadingScreen";

function withSuspense<T extends object>(
  Component: LazyExoticComponent<ComponentType<T>>
): ComponentType<T> {
  return (props: T) => (
    <Suspense fallback={<LoadingScreen />}>
      <Component {...props} />
    </Suspense>
  );
}

export { withSuspense };