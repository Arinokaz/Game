<template>
  <div class="col">
    <div class="row align-items-center justify-content-center flex-column">
      <div
        class="col-auto"
        v-if="prize.type !== null"
      >
        <div
          class="alert alert-success"
          role="alert"
        >
          {{displayType}}: {{prize.value}}
        </div>
      </div>
      <div
        class="col-auto"
        v-if="error"
      >
        <div
          class="alert alert-danger"
          role="alert"
        >
          {{error}}
        </div>
      </div>
      <template v-if="prize.type === null">
        <div class="col-auto">
          <button
            type="button"
            class="btn btn-primary btn-lg"
            @click="game()"
          >{{step}}</button>
        </div>
      </template>
      <template v-else>
        <div class="col-auto my-1">
          <button
            type="button"
            class="btn btn-primary btn-lg"
            @click="take()"
          >Забрать</button>
        </div>
        <div
          class="col-auto my-1"
          v-if="prize.type === prizesType.TYPE_MONEY"
        >
          <button
            type="button"
            class="btn btn-primary btn-lg"
            @click="convert()"
          >Конвектировать в балы</button>
        </div>
        <div class="col-auto my-1">
          <button
            type="button"
            class="btn btn-primary btn-lg"
            @click="resufe()"
          >Отказатся</button>
        </div>
      </template>

    </div>
  </div>
</template>

<script>
import api from '../utils/api';
import prizes_type from '../utils/prizesType';

export default {
  data() {
    return {
      prize: {
        id: null,
        value: null,
        type: null,
      },
      prizesType: prizes_type,
      error: '',
      step: 'Играть',
    };
  },

  computed: {
    displayType() {
      const type = {
        1: 'Money',
        2: 'Point',
        3: 'Thind',
      };
      return type[this.prize.type];
    },
  },

  methods: {
    game() {
      api
        .post('http://localhost:80/game', { id: this.$store.getters.User.id })
        .then((result) => {
          const response = result.data;
          if (response.type == 'success') {
            this.prize = response.prize;
            return;
          }
          this.error = response.message;
        })
        .catch((e) => console.error(e));
    },
    take() {
      api
        .post('http://localhost:80/take-prize', {
          id: this.$store.getters.User.id,
          ...this.prize,
        })
        .then((result) => {
          const response = result.data;
          if (response.type == 'success') {
            this.prize = {
              id: null,
              value: null,
              type: null,
            };
            this.step = 'Еще';
            return;
          }
          this.error = response.message;
        })
        .catch((e) => console.error(e));
    },
    convert() {
      this.error = '';
      api
        .post('http://localhost:80/convert', {
          ...this.prize,
        })
        .then((result) => {
          const response = result.data;
          if (response.type == 'success') {
            this.prize = {
              id: null,
              value: null,
              type: null,
            };
            this.step = 'Еще';
            return;
          }
          this.error = response.message;
        })
        .catch((e) => console.error(e));
    },
    resufe() {
      this.error = '';
      api
        .post('http://localhost:80/refuse', {
          ...this.prize,
        })
        .then((result) => {
          const response = result.data;
          if (response.type == 'success') {
            this.prize = {
              id: null,
              value: null,
              type: null,
            };
            this.step = 'Еще';
            return;
          }
          this.error = response.message;
        })
        .catch((e) => console.error(e));
    },
  },
};
</script>