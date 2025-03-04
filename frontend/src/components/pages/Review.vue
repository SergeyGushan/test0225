<template>
  <Table :tableData="parentTableData" :tableHeaders="parentTableHeader" />
</template>

<script>
import Table from '@/components/Table.vue';
import api from "@/utils/api.js"; // импортируем дочерний компонент

export default {
  components: {
    Table
  },
  data() {
    return {
      parentTableData: [],
      parentTableHeader: [
        "Код",
        "Наименование",
        "Уровень1",
        "Уровень2",
        "Уровень3",
        "Цена",
        "ЦенаСП",
        "Количество",
        "Единица измерения",
        "Поля свойств",
        "Совместные покупки",
        "Картинка",
        "Выводить на главной",
        "Описание"
      ]
    };
  },
  mounted() {
    this.fetchTableData();
  },
  methods: {
    fetchTableData() {
      api.get('api/products?limit=200')
          .then(response => {
            console.log(response.data.products)
            this.parentTableData = response.data.products;
          })
          .catch(error => {
            console.error("Ошибка при загрузке данных: ", error);
          });
    }
  }
};
</script>

<style scoped>

</style>