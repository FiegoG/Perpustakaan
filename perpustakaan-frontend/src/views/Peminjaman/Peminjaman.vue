<template>
  <div>
    <h2 class="text-2xl font-bold mb-4">Peminjaman Buku</h2>

    <!-- Form pencarian dan tambah data -->
    <div class="mb-4 flex justify-between">
      <button @click="showAddForm = true" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        + Tambah Data
      </button>
      <input
        type="text"
        v-model="searchQuery"
        placeholder="Search..."
        class="border px-3 py-2 rounded w-1/3"
        @input="searchData"
      />
    </div>

    <!-- Tabel Data -->
    <table class="w-full bg-white border-collapse border border-gray-300">
      <thead>
        <tr class="bg-gray-200 text-left">
          <th class="border border-gray-300 px-4 py-2">No</th>
          <th class="border border-gray-300 px-4 py-2">Buku</th>
          <th class="border border-gray-300 px-4 py-2">Peminjam</th>
          <th class="border border-gray-300 px-4 py-2">Tgl Peminjaman</th>
          <th class="border border-gray-300 px-4 py-2">Kelola</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in filteredData" :key="item.id">
          <td class="border border-gray-300 px-4 py-2 text-center">{{ index + 1 }}</td>
          <td class="border border-gray-300 px-4 py-2">{{ item.buku }}</td>
          <td class="border border-gray-300 px-4 py-2">{{ item.peminjam }}</td>
          <td class="border border-gray-300 px-4 py-2">{{ item.tanggal_peminjaman }}</td>
          <td class="border border-gray-300 px-4 py-2">
            <button @click="editData(item)" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">Edit</button>
            <button @click="deleteData(item.id)" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Modal Tambah Data -->
    <div v-if="showAddForm" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center">
      <div class="bg-white p-6 rounded">
        <h3 class="text-xl font-bold mb-4">Tambah Data</h3>
        <form @submit.prevent="addData">
          <div class="mb-4">
            <label class="block font-bold mb-2">Buku:</label>
            <input v-model="newData.buku" type="text" class="border px-3 py-2 rounded w-full" required />
          </div>
          <div class="mb-4">
            <label class="block font-bold mb-2">Peminjam:</label>
            <input v-model="newData.peminjam" type="text" class="border px-3 py-2 rounded w-full" required />
          </div>
          <div class="mb-4">
            <label class="block font-bold mb-2">Tanggal Peminjaman:</label>
            <input v-model="newData.tanggal_peminjaman" type="date" class="border px-3 py-2 rounded w-full" required />
          </div>
          <div class="flex justify-end">
            <button type="button" @click="showAddForm = false" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 mr-2">
              Cancel
            </button>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
              Submit
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      dataPeminjaman: [],
      searchQuery: '',
      showAddForm: false,
      newData: {
        buku: '',
        peminjam: '',
        tanggal_peminjaman: '',
      },
    };
  },
  computed: {
    filteredData() {
      if (!this.searchQuery) return this.dataPeminjaman;
      return this.dataPeminjaman.filter(
        (item) =>
          item.buku.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          item.peminjam.toLowerCase().includes(this.searchQuery.toLowerCase())
      );
    },
  },
  methods: {
    fetchData() {
      axios.get('http://localhost:8000/api/peminjaman').then((response) => {
        this.dataPeminjaman = response.data;
      });
    },
    searchData() {
      this.filteredData;
    },
    addData() {
      axios.post('http://localhost:8000/api/peminjaman', this.newData).then(() => {
        this.fetchData();
        this.newData = { buku: '', peminjam: '', tanggal_peminjaman: '' };
        this.showAddForm = false;
      });
    },
    editData(item) {
      // Add edit functionality
    },
    deleteData(id) {
      axios.delete(`http://localhost:8000/api/peminjaman/${id}`).then(() => {
        this.fetchData();
      });
    },
  },
  mounted() {
    this.fetchData();
  },
};
</script>

<style>
/* Tambahkan styling tambahan jika diperlukan */
</style>
