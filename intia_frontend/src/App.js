import React from 'react';
import { useAuth } from './contexts/AuthContext';
import LoginPage from './components/LoginPage';
import { DashboardPage } from './components/DashboardPage';

function App() {
  const { user, loading } = useAuth();

  if (loading) {
    return <div style={{ textAlign: 'center', marginTop: '100px' }}>Chargement...</div>;
  }

  return user ? <DashboardPage /> : <LoginPage />;
}

export default App;