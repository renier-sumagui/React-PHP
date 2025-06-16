import { Outlet } from "react-router"

export function RootRoute() {
  return (
    <div className="container-lg py-4">
      <Outlet/>
    </div>
  )
}