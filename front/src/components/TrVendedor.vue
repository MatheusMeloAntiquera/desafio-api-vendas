<script setup lang="ts">
defineProps<{
  id: number
  nome: string
  email: string
  comissao: number
}>()


</script>

<template>
  <tr>
    <th scope="row">{{ id }}</th>
    <td>{{ nome }}</td>
    <td>{{ email }}</td>
    <td>R$ {{ comissao }}</td>
    <td><button @click="this.$router.push('/vendedor/' + id + '/vendas')" type="button" class="btn btn-success">Vendas</button></td>
    
  </tr>
</template>

<style scoped></style>
