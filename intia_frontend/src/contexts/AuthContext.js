import React, { createContext, useContext, useState, useEffect } from 'react';
import { API_URL } from '../config/api';
import { storage } from '../utils/storage';

const AuthContext = createContext(null);

export const AuthProvider = ({ children }) => {
  const [user, setUser] = useState(null);
  const [token, setToken] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const loadToken = async () => {
      const savedToken = await storage.getToken();
      if (savedToken) {
        setToken(savedToken);
        await fetchUser(savedToken);
      }
      setLoading(false);
    };
    loadToken();
  }, []);

  const fetchUser = async (authToken) => {
    try {
      const response = await fetch(`${API_URL}/user`, {
        headers: { Authorization: `Bearer ${authToken}` },
      });
      if (response.ok) {
        const data = await response.json();
        setUser(data.data);
      }
    } catch (error) {
      console.error('Error fetching user:', error);
    }
  };

  const login = async (email, password) => {
    const response = await fetch(`${API_URL}/login`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ email, password }),
    });
    const data = await response.json();
    if (data.success) {
      setToken(data.data.token);
      setUser(data.data.user);
      await storage.saveToken(data.data.token);
      return { success: true };
    }
    return { success: false, message: data.message };
  };

  const logout = async () => {
    if (token) {
      await fetch(`${API_URL}/logout`, {
        method: 'POST',
        headers: { Authorization: `Bearer ${token}` },
      });
    }
    setToken(null);
    setUser(null);
    await storage.removeToken();
  };

  return (
    <AuthContext.Provider value={{ user, token, login, logout, loading }}>
      {children}
    </AuthContext.Provider>
  );
};

export const useAuth = () => useContext(AuthContext);