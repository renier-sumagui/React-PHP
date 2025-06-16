import './App.css';
import { RouterProvider } from 'react-router';
import { AuthProvider } from './features/auth/context/AuthContext';
import { appRoutes } from './routes/AppRoutes';

function App() {
    return (
        <AuthProvider>
            <RouterProvider router={appRoutes}></RouterProvider>
        </AuthProvider>
    );
}

export default App
