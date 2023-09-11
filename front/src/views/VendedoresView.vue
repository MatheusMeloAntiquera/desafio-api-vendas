<script lang="ts">
import TrVendedor from '../components/TrVendedor.vue'
import ModalCarregando from '../components/ModalCarregando.vue'
import axios from 'axios'
import * as bootstrap from 'bootstrap'

interface Vendedor {
  id: number
  nome: string
  email: string
  comissao: number
}
export default {
  components: {
    TrVendedor,
    ModalCarregando
  },
  data() {
    return {
      vendedores: [] as Vendedor[],
      listagemCarregada: false,
    }
  },
  async mounted(){
    const modal = new bootstrap.Modal(document.getElementById("modal-carregando"), {})
    modal.show()
    const response = await axios.get(this.API_URL+'/vendedor/')
    this.vendedores = response.data
    this.listagemCarregada = true
    modal.hide();
  }
}
</script>

<template>
  <main>
    <div class="row">
      <h1 class="text-center">Vendedores</h1>
      <div class="d-grid gap-3 d-md-block"></div>
    </div>
    <div class="row">
      <table class="table table-hover caption-top" v-if="this.listagemCarregada">
        <caption>
          <div class="row">Lista de Vendedores</div>
          <div class="row d-flex flex-row-reverse">
          <router-link to="/vendedor/novo" type="button" class="btn btn-primary col-2 btn-sm">
            Novo Vendedor
            </router-link>
          </div>
        </caption>
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">E-mail</th>
            <th scope="col">Comissão</th>
            <th scope="col">Vendas</th>
          </tr>
        </thead>
        <tbody>
          <TrVendedor
            v-for="vendedor in vendedores"
            :key="vendedor.id"
            :id="vendedor.id"
            :nome="vendedor.nome"
            :email="vendedor.email"
            :comissao="vendedor.comissao"
          />
        </tbody>
      </table>
    </div>
  </main>
  <ModalCarregando />
</template>
