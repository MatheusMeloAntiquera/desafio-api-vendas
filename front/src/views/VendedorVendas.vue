<script lang="ts">
import TrVenda from '../components/TrVenda.vue'
import ModalCarregando from '../components/ModalCarregando.vue'
import axios from 'axios'
import * as bootstrap from 'bootstrap'

interface Venda {
  id: number
  valor: number
  comissao: string
  data: Date
}

export default {
  components: {
    TrVenda,
    ModalCarregando
  },
  data() {
    return {
      vendas: [] as Venda[],
      listagemCarregada: false,
      modalNovaVenda: null,
      modalCarregando: null
    }
  },
  async mounted() {
    this.modalNovaVenda = new bootstrap.Modal(document.getElementById('modalNovaVenda'), {})
    this.modalCarregando = new bootstrap.Modal(document.getElementById('modal-carregando'), {})
    this.modalCarregando.show()
    const response = await axios.get(
      this.API_URL+ '/vendedor/' + this.$route.params.id + '/vendas'
    )
    this.vendas = response.data
    this.listagemCarregada = true
    this.modalCarregando.hide()
  },
  methods: {
    async salvarVenda() {
      this.modalNovaVenda.hide()
      this.modalCarregando.show()
      await axios.post(this.API_URL+ '/venda', {
        vendedor_id: this.$route.params.id,
        valor: valor.value
      })
      this.modalCarregando.hide()
      this.$router.go()
    },
    abrirModalNovaVenda() {
      this.modalNovaVenda.show()
    }
  }
}
</script>

<template>
  <main>
    <div class="row">
      <h1 class="text-center">Vendas</h1>
      <div class="d-grid gap-3 d-md-block"></div>
    </div>
    <div class="row">
      <table class="table table-hover caption-top" v-if="this.listagemCarregada">
        <caption>
          <div class="row">Lista de Vendas</div>
          <div class="row gap-2 d-flex flex-row-reverse">
            <button
              type="button"
              class="btn btn-warning col-2 btn-sm"
              @click="this.$router.push('/')"
            >
              Voltar Para Listagem Vendedores
            </button>
            <button type="button" class="btn btn-primary col-2 btn-sm" @click="abrirModalNovaVenda">
              Nova Venda
            </button>
          </div>
        </caption>
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Valor</th>
            <th scope="col">Comissão</th>
            <th scope="col">Data</th>
          </tr>
        </thead>
        <tbody>
          <TrVenda
            v-for="venda in vendas"
            :key="venda.id"
            :id="venda.id"
            :valor="venda.valor"
            :comissao="venda.comissao"
            :data="venda.data"
          />
        </tbody>
      </table>
    </div>
  </main>
  <ModalCarregando />
  <div class="modal fade" id="modalNovaVenda" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modal-nova-venda-titulo">Cadastrar Nova Venda</h1>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <form @submit.prevent="onSubmit">
              <div class="mb-3">
                <label for="valor" class="form-label">Valor da Venda</label>
                <input class="form-control" type="number" v-model="valor" name="valor" id="valor" />
              </div>
            </form>
          </div>
        </div>
        <div class="modal-footer">
          <button
            id="fechar-modal-nova-venda"
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
          >
            Fechar
          </button>
          <button type="button" @click="salvarVenda" class="btn btn-primary">Salvar</button>
        </div>
      </div>
    </div>
  </div>
</template>
