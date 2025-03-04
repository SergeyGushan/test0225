<template>
  <table>
    <thead>
    <tr>
      <th v-for="(value, index) in tableHeaders">{{ value }}</th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="(row, index) in tableData" :key="index">
      <td>{{ row.code }}</td>
      <td>{{ row.name }}</td>
      <td>{{ row.level1 }}</td>
      <td>{{ row.level2 }}</td>
      <td>{{ row.level3 }}</td>
      <td>{{ row.price }}</td>
      <td>{{ row.price_sp }}</td>
      <td>{{ row.quantity }}</td>
      <td>{{ row.unit }}</td>
      <td>{{ row.property_fields }}</td>
      <td>{{ row.joint_purchases }}</td>
      <td>{{ row.image }}</td>
      <td>{{ row.show_on_main }}</td>
      <td>{{ row.description }}</td>
    </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  name: 'Table',
  props: {
    tableData: {
      type: Array,
      required: true,
    },
    tableHeaders: {
      type: Array,
      required: true,
    }
  },
};
</script>

<style scoped>
table {
  width: 100%;
  border-collapse: collapse;
  margin: 20px 0;
}

table, th, td {
  border: 1px solid #ddd;
}

th, td {
  padding: 10px;
  text-align: left;
}

th {
  background-color: #f4f4f4;
}
</style>
