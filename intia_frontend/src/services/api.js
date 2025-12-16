import { API_URL } from '../config/api';
import { storage } from '../utils/storage';

export const api = {
  async request(endpoint, options = {}) {
    const token = await storage.getToken();
    const response = await fetch(`${API_URL}${endpoint}`, {
      ...options,
      headers: {
        'Content-Type': 'application/json',
        ...(token && { Authorization: `Bearer ${token}` }),
        ...options.headers,
      },
    });
    return response.json();
  },

  getSuccursales: () => api.request('/succursales'),
  createSuccursale: (data) => api.request('/succursales', { method: 'POST', body: JSON.stringify(data) }),
  updateSuccursale: (id, data) => api.request(`/succursales/${id}`, { method: 'PUT', body: JSON.stringify(data) }),
  deleteSuccursale: (id) => api.request(`/succursales/${id}`, { method: 'DELETE' }),

  getClients: () => api.request('/clients'),
  getClient: (id) => api.request(`/clients/${id}`),
  createClient: (data) => api.request('/clients', { method: 'POST', body: JSON.stringify(data) }),
  updateClient: (id, data) => api.request(`/clients/${id}`, { method: 'PUT', body: JSON.stringify(data) }),
  deleteClient: (id) => api.request(`/clients/${id}`, { method: 'DELETE' }),

  getAssurances: () => api.request('/assurances'),
  createAssurance: (data) => api.request('/assurances', { method: 'POST', body: JSON.stringify(data) }),
  updateAssurance: (id, data) => api.request(`/assurances/${id}`, { method: 'PUT', body: JSON.stringify(data) }),
  deleteAssurance: (id) => api.request(`/assurances/${id}`, { method: 'DELETE' }),
};