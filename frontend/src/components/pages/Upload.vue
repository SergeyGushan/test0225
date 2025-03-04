<template>
  <div class="upload-form">
    <h2>Загрузить CSV файл</h2>

    <form @submit.prevent="handleSubmit">
      <div class="form-group">
        <label for="csvFile">Выберите CSV файл</label>
        <input
            type="file"
            id="csvFile"
            accept=".csv"
            @change="handleFileChange"
            required
        />
      </div>

      <div class="form-group">
        <label for="delimiter">Выберите разделитель</label>
        <select id="delimiter" v-model="delimiter" required>
          <option value=",">Запятая (,)</option>
          <option value=";">Точка с запятой (;)</option>
          <option value="\t">Табуляция</option>
        </select>
      </div>

      <div class="form-group">
        <button type="submit" class="btn-submit">Загрузить</button>
      </div>
    </form>

    <div v-if="error" class="error-message">{{ error }}</div>
  </div>
</template>

<script>
import api from "@/utils/api.js";

export default {
  data() {
    return {
      file: null,
      delimiter: ',',
      error: null,
    };
  },
  methods: {
    handleFileChange(event) {
      const selectedFile = event.target.files[0];
      if (selectedFile) {
        this.file = selectedFile;
        this.error = null;
      }
    },
    handleSubmit() {
      if (!this.file) {
        this.error = "Пожалуйста, выберите файл для загрузки.";
        return;
      }

      const formData = new FormData();
      formData.append("file", this.file);
      formData.append("separator", this.delimiter);

      api.post('/api/products/import', formData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          }
      ).then(response => {
        console.log('Файл успешно загружен', response);
        this.$router.push('/')
      })
      .catch(error => {
        console.error('Ошибка при загрузке файла', error);
      });

      console.log("Файл:", this.file);
      console.log("Разделитель:", this.delimiter);
    }
  }
};
</script>

<style scoped>
.upload-form {
  max-width: 500px;
  margin: 50px auto;
  padding: 20px;
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h2 {
  text-align: center;
  color: #333;
  margin-bottom: 20px;
}

.form-group {
  margin-bottom: 15px;
}

label {
  display: block;
  font-weight: 600;
  margin-bottom: 8px;
  color: #555;
}

input[type="file"],
select {
  width: 100%;
  padding: 10px;
  font-size: 16px;
  border: 1px solid #ddd;
  border-radius: 5px;
  background-color: #fff;
}

input[type="file"] {
  padding: 5px 0;
}

button[type="submit"] {
  background-color: #4CAF50;
  color: white;
  padding: 12px 20px;
  font-size: 16px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  width: 100%;
}

button[type="submit"]:hover {
  background-color: #45a049;
}

.error-message {
  margin-top: 15px;
  color: red;
  text-align: center;
  font-weight: bold;
}
</style>
