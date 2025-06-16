import './App.css'
import "bootstrap/dist/css/bootstrap.min.css";
import { RouterProvider } from 'react-router';
import { router } from './routes';

function App() {

  return (
    <RouterProvider router={router}></RouterProvider>
  )
}

export default App
