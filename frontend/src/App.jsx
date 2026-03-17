import { BrowserRouter, Routes, Route, Navigate } from 'react-router-dom';
import { AuthProvider } from './context/AuthContext';
import Navbar from './components/Navbar';
import RequireAuth from './components/RequireAuth';
import LoginPage from './pages/LoginPage';
import RegisterPage from './pages/RegisterPage';
import NotesIndexPage from './pages/NotesIndexPage';
import NoteDetailPage from './pages/NoteDetailPage';
import CreateNotePage from './pages/CreateNotePage';
import EditNotePage from './pages/EditNotePage';
import './App.css';

export default function App() {
  return (
    <BrowserRouter>
      <AuthProvider>
        <Navbar />
        <main>
          <Routes>
            <Route path="/login" element={<LoginPage />} />
            <Route path="/register" element={<RegisterPage />} />
            <Route
              path="/"
              element={
                <RequireAuth>
                  <NotesIndexPage />
                </RequireAuth>
              }
            />
            <Route
              path="/notes/create"
              element={
                <RequireAuth>
                  <CreateNotePage />
                </RequireAuth>
              }
            />
            <Route
              path="/notes/:id"
              element={
                <RequireAuth>
                  <NoteDetailPage />
                </RequireAuth>
              }
            />
            <Route
              path="/notes/:id/edit"
              element={
                <RequireAuth>
                  <EditNotePage />
                </RequireAuth>
              }
            />
            <Route path="*" element={<Navigate to="/" replace />} />
          </Routes>
        </main>
      </AuthProvider>
    </BrowserRouter>
  );
}
