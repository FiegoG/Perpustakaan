import axios from 'axios';

const PeminjamanService = {
  getAll() {
    return axios.get('http://localhost:8000/api/peminjaman/');
  },
  create(data) {
    return axios.post('http://localhost:8000/api/peminjaman/', data);
  },
  update(id, data) {
    return axios.put(`http://localhost:8000/api/peminjaman/${id}`, data);
  },
  delete(id) {
    return axios.delete(`http://localhost:8000/api/peminjaman/${id}`);
  }
};

export default PeminjamanService;