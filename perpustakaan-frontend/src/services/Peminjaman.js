import axios from 'axios';

const PeminjamanService = {
  getAll() {
    return axios.get('/api/peminjaman');
  },
  create(data) {
    return axios.post('/api/peminjaman', data);
  },
  update(id, data) {
    return axios.put(`/api/peminjaman/${id}`, data);
  },
  delete(id) {
    return axios.delete(`/api/peminjaman/${id}`);
  }
};

export default PeminjamanService;