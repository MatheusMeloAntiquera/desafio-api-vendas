<script setup lang="ts">
defineProps<{
  id: number
  valor: number
  comissao: string
  data: Date
}>()
</script>

<template>
  <tr>
    <th scope="row">{{ id }}</th>
    <td>R$ {{ valor }}</td>
    <td>R$ {{ comissao }}</td>
    <td>{{ data }}</td>
  </tr>
</template>