<template>
  <custom-title icon="mdi-human-female-boy"></custom-title>
  <v-card class="pa-2  elevation-0">
    <form-guardian
      ref="formGuardian"
      :guardian-details="guardianDetails"
      @submit="addGuardian"
    />
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn class="mr-2" :to="{ path: '/guardian-list' }" variant="outlined">
        {{ $t('btn.cancel') }}
      </v-btn>
      <v-btn @click="submitForm" class="bg-primary">
        {{ $t('btn.update') }}
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
  import { mapActions, mapState } from 'pinia'
  import { useGuardianStore } from '@/stores/guardian'
  import FormGuardian from '@/components/common/FormGuardian.vue'
  export default {
    components: {
      FormGuardian
    },
    created() {
      const id = this.$route.params.id
      this.getGuardianDetails(id)
    },
    data() {
      return {}
    },
    computed: {
      ...mapState(useGuardianStore, ['guardianDetails'])
    },
    methods: {
      ...mapActions(useGuardianStore, [
        'getGuardianDetails',
        'updateGuardianList'
      ]),
      addGuardian(formData) {
        this.updateGuardianList(formData)
          .then(() => {
            this.$root.$notif(this.$t('alert.update'), {
              type: 'success',
              color: 'primary'
            })
            this.$router.push('/guardian-list')
          })
          .catch(err => {
            this.$root.$notif(err, {
              type: 'info',
              color: 'info'
            })
          })
      },
      submitForm() {
        this.$refs.formGuardian.emitSubmit()
      }
    }
  }
</script>
