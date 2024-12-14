<template>
  <div>
    <div class="header">
      <div class="menu">
        <div class="menu-icon"></div>
      </div>
      <span>Sistem Informasi Perpustakaan Berbasis Web</span>
    </div>
    <div class="content">
      <div class="table-container">
        <h1>Peminjaman Buku</h1>
        <div class="controls">
          <button class="tambah-button" @click="showAddForm = true">+ Tambah Data</button>
          <input type="text" placeholder="Search..." v-model="searchQuery">
        </div>
        <table>
          <thead>
            <tr>
              <th>No</th>
              <th>Buku</th>
              <th>Peminjam</th>
              <th>Tgl Peminjaman</th>
              <th>Kelola</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in filteredData" :key="index">
              <td>{{ index + 1 }}</td>
              <td>{{ item.buku }}</td>
              <td>{{ item.peminjam }}</td>
              <td>{{ item.tglPeminjaman }}</td>
              <td>
                <button class="edit-button" @click="editData(index)">Edit</button>
                <button class="hapus-button" @click="deleteData(index)">Hapus</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div v-if="showAddForm || showEditForm" class="add-form">
        <h2 v-if="showAddForm">Tambah Data</h2>
        <h2 v-if="showEditForm">Edit Data</h2>
        <form @submit.prevent="showAddForm ? submitData() : updateData()">
          <div>
            <label for="buku">Buku:</label>
            <input type="text" id="buku" v-model="newData.buku" required />
          </div>
          <div>
            <label for="peminjam">Peminjam:</label>
            <input type="text" id="peminjam" v-model="newData.peminjam" required />
          </div>
          <div>
            <label for="tglPeminjaman">Tanggal Peminjaman:</label>
            <input type="date" id="tglPeminjaman" v-model="newData.tglPeminjaman" required />
          </div>
          <div class="form-actions">
            <button type="submit" @click="updateData">Simpan</button>
            <button type="button" @click="cancelForm">Batal</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import PeminjamanService from '@/services/Peminjaman';

export default {
  data() {
    return {
      searchQuery: '',
      data: [],
      showAddForm: false,
      showEditForm: false,
      currentEditIndex: null,
      newData: {
        buku: '',
        peminjam: '',
        tglPeminjaman: ''
      }
    };
  },
  computed: {
    filteredData() {
      return this.data.filter(item =>
        item.buku.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
        item.peminjam.toLowerCase().includes(this.searchQuery.toLowerCase())
      );
    }
  },
  methods: {
    async fetchData() {
      try {
        const response = await PeminjamanService.getAll();
        this.data = response.data; // Pastikan struktur data benar
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    },
    async submitData() {
      try {
        await PeminjamanService.create({
          id_user: this.$store.state.user.id, // Ambil ID user dari store
          id_buku: this.newData.buku, // Pastikan mengirim ID buku
          tgl_pinjam: this.newData.tglPeminjaman
        });
        this.fetchData();
        this.resetForm();
      } catch (error) {
        console.error('Error adding data:', error);
      }
    },
    async updateData() {
      try {
        const id = this.data[this.currentEditIndex].id;
        await PeminjamanService.update(id, {
          id_user: this.$store.state.user.id,
          id_buku: this.newData.buku,
          tgl_pinjam: this.newData.tglPeminjaman
        });
        this.fetchData();
        this.resetForm();
      } catch (error) {
        console.error('Error updating data:', error);
      }
    },
    async deleteData(index) {
      if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        try {
          const id = this.data[index].id;
          await PeminjamanService.delete(id);
          this.fetchData();
        } catch (error) {
          console.error('Error deleting data:', error);
        }
      }
    },
    cancelForm() {
      this.resetForm();
    },
    resetForm() {
      this.newData = {
        buku: '',
        peminjam: '',
        tglPeminjaman: ''
      };
      this.showAddForm = false;
      this.showEditForm = false;
      this.currentEditIndex = null;
    }
  },
  mounted() {
    this.fetchData(); // Ambil data saat komponen dimuat
  }
};
</script>

<style>
body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  background-color: #f8f8f8;
}
.header {
  background-color: #333;
  color: white;
  padding: 10px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.header .menu {
  display: flex;
  align-items: center;
}
.menu-icon {
  background-color: white;
  width: 20px;
  height: 2px;
  margin: 3px 0;
}
.tambah-button {
  margin-right:50px;
}
.edit-button {
  margin: 10px;
}
.hapus-button {
  margin: 10px;
}
.content {
  padding: 20px;
}
.table-container {
  background: white;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
.table-container h1 {
  text-align: center;
  font-size: 1.5em;
  margin-bottom: 20px;
}
.table-container .controls {
  display: flex;
  justify-content: space-between;
  margin-bottom: 10px;
}
.table-container .controls button {
  background-color: #007bff;
  color: white;
  border: none;
  padding: 10px 15px;
  border-radius: 5px;
  cursor: pointer;
}
.table-container .controls input {
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 5px;
}
table {
  width: 100%;
  border-collapse: collapse;
}
table th, table td {
  border: 1px solid #ddd;
  padding: 10px;
  text-align: left;
}
table th {
  background-color: #f4f4f4;
}
.add-form {
  background: white;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  margin-top: 20px;
}
.add-form h2 {
  text-align: center;
  margin-bottom: 20px;
}
.add-form form div {
  margin-bottom: 10px;
}
.add-form label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}
.add-form input {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 5px;
}
.add-form .form-actions {
  display: flex;
  justify-content: space-between;
}
.add-form .form-actions button {
  padding: 10px 15px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
.add-form .form-actions button:first-child {
  background-color: #28a745;
  color: white;
}
.add-form .form-actions button:last-child {
  background-color: #dc3545;
  color: white;
}
</style>
