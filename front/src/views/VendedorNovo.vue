<script lang="ts">
import ModalEnviando from '../components/ModalEnviando.vue'
import axios from 'axios'
import * as bootstrap from 'bootstrap'

export default {
  components: {
    ModalEnviando
  },
  methods: {
    async cadastrar() {
      const modalEnviando = new bootstrap.Modal(document.getElementById('modal-carregando'), {})
      modalEnviando.show()
      await axios.post(this.API_URL + '/vendedor', {
        nome: nome.value,
        email: email.value
      })
      modalEnviando.hide()
      this.$router.push('/')
    }
  }
}
</script>

<template>
  <main>
    <div class="row">
      <h1 class="text-center">Cadastro de Vendedores</h1>
      <div class="d-grid gap-3 d-md-block"></div>
    </div>
    <div class="row">
      <form @submit.prevent="onSubmit">
        <div class="mb-3">
          <label for="nome" class="form-label">Nome</label>
          <input class="form-control" v-model="nome" id="nome" name="nome" />
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">E-mail</label>
          <input type="email" v-model="email" class="form-control" id="email" name="email" />
        </div>
        <button @click="cadastrar" type="submit" class="btn btn-primary">Cadastrar</button>
      </form>
    </div>
  </main>
  <ModalEnviando />
</template>
