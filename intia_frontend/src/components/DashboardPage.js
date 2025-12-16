import React, { useState, useEffect } from 'react';
import { useAuth } from '../contexts/AuthContext';
import { api } from '../services/api';

export const DashboardPage = () => {
  const { user, logout } = useAuth();
  const [activeTab, setActiveTab] = useState('clients');
  const [succursales, setSuccursales] = useState([]);
  const [clients, setClients] = useState([]);
  const [assurances, setAssurances] = useState([]);

  useEffect(() => {
    loadData();
  }, [activeTab]);

  const loadData = async () => {
    if (activeTab === 'succursales') {
      const data = await api.getSuccursales();
      if (data.success) setSuccursales(data.data);
    } else if (activeTab === 'clients') {
      const data = await api.getClients();
      if (data.success) setClients(data.data);
    } else if (activeTab === 'assurances') {
      const data = await api.getAssurances();
      if (data.success) setAssurances(data.data);
    }
  };




  const isDG = user?.role === 'dg';
  const canWrite = user?.role === 'succursale';

  return (
    <div style={{ padding: '20px' }}>
      <div style={{ display: 'flex', justifyContent: 'space-between', marginBottom: '30px', padding: '10px', background: '#f5f5f5', borderRadius: '4px' }}>
        <div>
          <h2 style={{ margin: 0 }}>INTIA Assurance</h2>
          <p style={{ margin: '5px 0 0 0', fontSize: '14px', color: '#666' }}>
            {user?.name} - {user?.role === 'dg' ? 'Direction Générale' : user?.succursale?.nom}
          </p>
        </div>
        <button onClick={logout} style={{ padding: '8px 16px', background: '#dc3545', color: 'white', border: 'none', borderRadius: '4px', cursor: 'pointer' }}>
          Déconnexion
        </button>
      </div>

      <div style={{ marginBottom: '20px', borderBottom: '2px solid #ddd' }}>
        {(isDG || canWrite) && (
          <button
            onClick={() => setActiveTab('succursales')}
            style={{ padding: '10px 20px', marginRight: '5px', background: activeTab === 'succursales' ? '#007bff' : '#fff', color: activeTab === 'succursales' ? '#fff' : '#000', border: 'none', borderBottom: activeTab === 'succursales' ? '3px solid #007bff' : 'none', cursor: 'pointer' }}
          >
            Succursales
          </button>
        )}
        <button
          onClick={() => setActiveTab('clients')}
          style={{ padding: '10px 20px', marginRight: '5px', background: activeTab === 'clients' ? '#007bff' : '#fff', color: activeTab === 'clients' ? '#fff' : '#000', border: 'none', borderBottom: activeTab === 'clients' ? '3px solid #007bff' : 'none', cursor: 'pointer' }}
        >
          Clients
        </button>
        <button
          onClick={() => setActiveTab('assurances')}
          style={{ padding: '10px 20px', background: activeTab === 'assurances' ? '#007bff' : '#fff', color: activeTab === 'assurances' ? '#fff' : '#000', border: 'none', borderBottom: activeTab === 'assurances' ? '3px solid #007bff' : 'none', cursor: 'pointer' }}
        >
          Assurances
        </button>
      </div>

      
    </div>
  );
};