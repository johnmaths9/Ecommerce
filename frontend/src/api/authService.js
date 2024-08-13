import axios from 'axios';

const authService = {
  login(credentials) {
    return axios.post('/api/login', credentials).then(response => {
      localStorage.setItem('authToken', response.data.token);
      return response.data.user;
    });
  },
  logout() {
    localStorage.removeItem('authToken');
  },
  getUser() {
    const token = localStorage.getItem('authToken');
    if (token) {
      return axios.get('/api/user', {
        headers: { 'Authorization': `Bearer ${token}` }
      }).then(response => response.data);
    }
    return null;
  }
};

export default authService;
