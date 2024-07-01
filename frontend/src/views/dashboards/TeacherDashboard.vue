<template>
  <custom-title icon="mdi-view-dashboard-edit-outline"></custom-title>
  <v-layout class="rounded rounded-md">
    <v-container fluid class="pa-0 me-3">
      <v-card
        class="mx-auto mb-5 pa-2"
        variant="outlined"
        elevation="0"
        color="primary"
        rounded="xl"
      >
        <v-row>
          <v-col>
            <v-row>
              <v-col class="d-flex align-center justify-center">
                <v-avatar size="220">
                  <v-img
                    class="align-end text-white"
                    :src="authUser.profile"
                    cover
                  ></v-img>
                </v-avatar>
              </v-col>
              <v-col class="d-flex align-center justify-center">
                <v-card-title class="pa-0">
                  <span>{{ greeting }},</span><br>
                 <strong>{{ authUser.first_name }} {{ authUser.last_name }}</strong> 
                </v-card-title>
              </v-col>
            </v-row>
          </v-col>
          <v-col cols="12">
            <v-card-actions class="pa-0">
              <v-spacer></v-spacer>
              <v-btn
                variant="outlined"
                rounded="xl"
                color="primary"
                text="See profile"
                to="user-profile"
                class="text-none mt-8"
                append-icon="mdi-arrow-right"
              ></v-btn>
            </v-card-actions>
          </v-col>
        </v-row>
      </v-card>
      <v-col v-for="subject in authUser.subjects" class="pa-0">
        <v-card
          elevation="0"
          rounded="xl"
          class="mt-2 ms-1"
          border="primary sm opacity-100"
        >
          <template v-slot:title>
            <div class="font-weight-bold">{{ subject.subject_name }}</div>
          </template>
          <template v-slot:prepend>
            <v-btn icon="mdi-calculator-variant" color="primary"></v-btn>
          </template>
          <template v-slot:append>
            <v-btn size="x-small" icon="mdi-arrow-up" color="secondary"></v-btn>
          </template>
        </v-card>
      </v-col>
    </v-container>
    <v-container fluid class="pa-0">
      <v-row class="mb-4">
        <v-col cols="12" md="4">
          <v-card
            class="mx-auto pa-0 elevation-0"
            border="primary sm opacity-100"
            rounded="xl"
            subtitle="All class 12 in school"
            title="Class 12"
          >
            <template v-slot:prepend>
              <v-btn class="bg-primary" icon="mdi-google-classroom"></v-btn>
            </template>
            <v-card-text class="py-0">
              <v-col>
                <h1>
                  <strong>{{ classroom['12'] }}</strong>
                </h1>
              </v-col>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="12" md="4">
          <v-card
            class="mx-auto pa-0 elevation-0"
            border="primary sm opacity-100"
            rounded="xl"
            subtitle="All teachers in school"
            title="Class 11"
          >
            <template v-slot:prepend>
              <v-btn class="bg-primary" icon="mdi-google-classroom"></v-btn>
            </template>
            <v-card-text class="py-0">
              <v-col>
                <h1>
                  <strong>{{ classroom['11'] }}</strong>
                </h1>
              </v-col>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="12" md="4">
          <v-card
            class="mx-auto pa-0 elevation-0"
            border="primary sm opacity-100"
            rounded="xl"
            subtitle="All classrooms in school"
            title="Class 10"
          >
            <template v-slot:prepend>
              <v-btn class="bg-primary" icon="mdi-google-classroom"></v-btn>
            </template>
            <v-card-text class="py-0">
              <v-col>
                <h1>
                  <strong>{{ classroom['10'] }}</strong>
                </h1>
              </v-col>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
      <student-most-absence />
    </v-container>
  </v-layout>
</template>

<script>
  import { mapActions, mapState } from 'pinia'
  import { useClassroomStore } from '@/stores/classroom'
  import StudentMostAbsence from '@/components/dashboard/StudentMostAbsence.vue'
  import { useAuthStore } from '@/stores/auth'

  export default {
    components: {
      StudentMostAbsence
    },
    data() {
      return {}
    },
    created() {
      this.getCassroomTotal()
    },
    computed: {
      ...mapState(useClassroomStore, ['classroom']),
      ...mapState(useAuthStore, ['authUser']),
      greeting() {
        const hour = new Date().getHours()
        if (hour >= 5 && hour < 12) {
          return 'Good morning'
        } else if (hour >= 12 && hour < 18) {
          return 'Good afternoon'
        } else {
          return 'Good evening'
        }
      }
    },
    methods: {
      ...mapActions(useClassroomStore, ['getCassroomTotal']),
      ...mapActions(useAuthStore, ['fetchUser'])
    }
  }
</script>
