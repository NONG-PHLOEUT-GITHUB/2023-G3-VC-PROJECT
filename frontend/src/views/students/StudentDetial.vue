<template>
  <custom-title icon="mdi-eye"></custom-title>
  <!-- {{ studentDetails }} -->
  <v-card class="elevation-0">
    <v-tabs v-model="tab" align-tabs="start" color="deep-purple-accent-4">
      <v-tab value="1" direction="true" class="text-none">Account</v-tab>
      <v-tab value="2" class="text-none">Parent Info</v-tab>
      <v-tab value="3" class="text-none">Comment</v-tab>
      <v-tab value="4" class="text-none">Score</v-tab>
      <v-tab value="5" class="text-none">Attendance</v-tab>
    </v-tabs>
    <v-window v-model="tab">
      <v-window-item value="1" class="pa-0">
        <v-container fluid>
          <v-layout class="rounded rounded-md px-0">
            <v-col cols="3">
              <v-card>
                <v-card-text class="px-0 text-center">
                  <v-col>
                    <div>
                      <v-avatar
                        color="grey"
                        rounded="100"
                        size="150"
                        class="elevation-1"
                      >
                        <v-img :src="studentDetails.profile" cover></v-img>
                      </v-avatar>
                    </div>
                    <v-btn class="mt-2" :disabled="isEdit">
                      upload new profile
                    </v-btn>
                  </v-col>
                </v-card-text>
              </v-card>
            </v-col>
            <v-col cols="9">
              <v-card class="px-2">
                <template v-slot:append>
                  <v-tooltip text="Edit profile">
                    <template v-slot:activator="{ props }">
                      <v-btn
                        v-bind="props"
                        color="primary"
                        icon="mdi-pencil"
                        @click="isEdit = !isEdit"
                      ></v-btn>
                    </template>
                  </v-tooltip>
                </template>
                <custom-sub-title icon="mdi-account-card">
                  Personal Information
                </custom-sub-title>
                <v-row>
                  <v-col>
                    <v-text-field
                      color="textField"
                      v-model="studentDetails.first_name"
                      density="compact"
                      label="First name"
                      variant="outlined"
                      prepend-inner-icon="mdi-card-account-details-outline"
                      :readonly="isEdit"
                    ></v-text-field>
                  </v-col>
                  <v-col>
                    <v-text-field
                      color="textField"
                      v-model="studentDetails.last_name"
                      density="compact"
                      label="Last name"
                      variant="outlined"
                      :readonly="isEdit"
                      prepend-inner-icon="mdi-card-account-details-outline"
                    ></v-text-field>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col>
                    <v-text-field
                      color="textField"
                      v-model="studentDetails.gender"
                      density="compact"
                      label="Gender"
                      variant="outlined"
                      :readonly="isEdit"
                      prepend-inner-icon="mdi-gender-male-female"
                    ></v-text-field>
                  </v-col>
                  <v-col>
                    <v-text-field
                      color="textField"
                      v-model="studentDetails.date_of_birth"
                      density="compact"
                      label="Date of birth"
                      variant="outlined"
                      :readonly="isEdit"
                      prepend-inner-icon=" mdi-calendar-range"
                    ></v-text-field>
                    <v-text-field
                      color="textField"
                      v-model="studentDetails.age"
                      density="compact"
                      label="Age"
                      variant="outlined"
                      :readonly="isEdit"
                      prepend-inner-icon="mdi-calendar-multiple-check"
                    ></v-text-field>
                  </v-col>
                </v-row>
                <custom-sub-title icon="mdi-contacts">
                  Contact Information
                </custom-sub-title>
                <v-row>
                  <v-col>
                    <v-text-field
                      color="textField"
                      v-model="studentDetails.email"
                      density="compact"
                      label="Email"
                      variant="outlined"
                      :readonly="isEdit"
                      prepend-inner-icon="mdi-email"
                    ></v-text-field>
                  </v-col>
                  <v-col>
                    <v-text-field
                      color="textField"
                      v-model="studentDetails.phone_number"
                      density="compact"
                      label="Phone number"
                      variant="outlined"
                      :readonly="isEdit"
                      prepend-inner-icon="mdi-phone"
                    ></v-text-field>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col>
                    <v-text-field
                      color="textField"
                      v-model="studentDetails.address"
                      density="compact"
                      label="Address"
                      variant="outlined"
                      :readonly="isEdit"
                      prepend-inner-icon="mdi-map-marker"
                    ></v-text-field>
                  </v-col>
                </v-row>

                <v-card-actions class="px-0">
                  <v-btn color="red" variant="outlined">Cancel</v-btn>
                  <v-btn class="bg-primary" :disabled="isEdit">
                    Save change
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-col>
          </v-layout>
        </v-container>
      </v-window-item>
      <!-- infor tab -->
      <v-window-item value="2">
        <v-layout class="rounded rounded-md px-0">
          <v-col cols="3">
            <v-card>
              <v-card-text class="px-0 text-center">
                <v-col>
                  <div>
                    <v-avatar
                      color="grey"
                      rounded="100"
                      size="150"
                      class="elevation-1"
                    >
                      <v-img :src="profile_image" cover></v-img>
                    </v-avatar>
                  </div>
                  <v-btn class="mt-2" :disabled="isEdit">
                    upload new profile
                  </v-btn>
                </v-col>
                <v-divider></v-divider>
                <v-col>
                  <div>
                    <v-avatar
                      color="grey"
                      rounded="100"
                      size="150"
                      class="elevation-1"
                    >
                      <v-img :src="studentDetails.profile" cover></v-img>
                    </v-avatar>
                  </div>
                  <v-btn class="mt-2" :disabled="isEdit">
                    upload new profile
                  </v-btn>
                </v-col>
              </v-card-text>
            </v-card>
          </v-col>
          <v-col cols="9">
            <v-card class="px-2">
              <template v-slot:append>
                <v-tooltip text="Edit profile">
                  <template v-slot:activator="{ props }">
                    <v-btn
                      v-bind="props"
                      color="primary"
                      icon="mdi-pencil"
                      @click="isEdit = !isEdit"
                    ></v-btn>
                  </template>
                </v-tooltip>
              </template>
              <custom-sub-title icon="mdi-account-card">
                Personal Information
              </custom-sub-title>
              <v-row>
                <v-col>
                  <v-text-field
                    color="textField"
                    v-model="first_name"
                    density="compact"
                    label="First name"
                    variant="outlined"
                    prepend-inner-icon="mdi-card-account-details-outline"
                    :readonly="isEdit"
                  ></v-text-field>
                </v-col>
                <v-col>
                  <v-text-field
                    color="textField"
                    v-model="last_name"
                    density="compact"
                    label="Last name"
                    variant="outlined"
                    :readonly="isEdit"
                    prepend-inner-icon="mdi-card-account-details-outline"
                  ></v-text-field>
                </v-col>
              </v-row>
              <v-row>
                <v-col>
                  <v-text-field
                    color="textField"
                    v-model="gender"
                    density="compact"
                    label="Gender"
                    variant="outlined"
                    :readonly="isEdit"
                    prepend-inner-icon="mdi-gender-male-female"
                  ></v-text-field>
                </v-col>
                <v-col>
                  <v-text-field
                    color="textField"
                    v-model="date_of_birth"
                    density="compact"
                    label="Date of birth"
                    variant="outlined"
                    :readonly="isEdit"
                    prepend-inner-icon=" mdi-calendar-range"
                  ></v-text-field>
                  <v-text-field
                    color="textField"
                    v-model="age"
                    density="compact"
                    label="Age"
                    variant="outlined"
                    :readonly="isEdit"
                    prepend-inner-icon="mdi-calendar-multiple-check"
                  ></v-text-field>
                </v-col>
              </v-row>
              <custom-sub-title icon="mdi-contacts">
                Contact Information
              </custom-sub-title>
              <v-row>
                <v-col>
                  <v-text-field
                    color="textField"
                    v-model="email"
                    density="compact"
                    label="Email"
                    variant="outlined"
                    :readonly="isEdit"
                    prepend-inner-icon="mdi-email"
                  ></v-text-field>
                </v-col>
                <v-col>
                  <v-text-field
                    color="textField"
                    v-model="phone_number"
                    density="compact"
                    label="Phone number"
                    variant="outlined"
                    :readonly="isEdit"
                    prepend-inner-icon="mdi-phone"
                  ></v-text-field>
                </v-col>
              </v-row>
              <v-row>
                <v-col>
                  <v-text-field
                    color="textField"
                    v-model="address"
                    density="compact"
                    label="Address"
                    variant="outlined"
                    :readonly="isEdit"
                    prepend-inner-icon="mdi-map-marker"
                  ></v-text-field>
                </v-col>
              </v-row>

              <v-card-actions class="px-0">
                <v-btn color="red" variant="outlined">Cancel</v-btn>
                <v-btn class="bg-primary" :disabled="isEdit">Save change</v-btn>
              </v-card-actions>
            </v-card>
          </v-col>
        </v-layout>
      </v-window-item>
      <v-window-item value="3">
        <v-card class="elevation-0 py-2">
          <v-row>
            <v-col>
              <v-text-field
                color="textField"
                label="Teacher name"
                hide-details
                density="compact"
                variant="outlined"
              ></v-text-field>
            </v-col>
            <v-col>
              <v-text-field
                color="textField"
                label="Title"
                hide-details
                density="compact"
                variant="outlined"
              ></v-text-field>
            </v-col>
          </v-row>
        </v-card>
        <v-card class="mt-2">
          <v-list
            :lines="false"
            elevation="0"
            v-if="studentDetails.comments.length != 0"
          >
            <v-list-item
              v-for="(comment, i) in studentDetails.comments"
              :key="i"
              :value="comment"
              class="item mt-1"
              rounded="lg"
              elevation="0"
            >
              <template v-slot:prepend>
                <v-avatar>
                  <v-img color="white" :src="comment.teacher_profile"></v-img>
                </v-avatar>
              </template>
              <v-list-item-title>
                {{ comment.teacher_fullname }}
              </v-list-item-title>
              <v-list-item-subtitle>
                {{ formatDate(comment.created_at) }}
              </v-list-item-subtitle>
              <v-list-item class="pa-0">
                {{ comment.body }}
              </v-list-item>
              <template v-slot:append>
                <v-btn icon="mdi-reply" variant="text"></v-btn>
              </template>
            </v-list-item>
          </v-list>
        </v-card>
      </v-window-item>
      <v-window-item value="4">score {{ scores }}</v-window-item>
      <v-window-item value="5">
        <v-data-table
          :headers="headers"
          :items="studentDetails.attendacnes"
          item-value="id"
          class="elevation-2"
        ></v-data-table>
      </v-window-item>
    </v-window>
  </v-card>
</template>

<script>
  import { mapActions, mapState } from 'pinia'
  import { useStudentStore } from '@/stores/student'
  import { format, parseISO } from 'date-fns'

  export default {
    name: 'UserDetails',
    created() {
      const id = this.$route.params.id
      this.getStudentDetails(id)
    },
    data() {
      return {
        users: [],
        reveal: false,
        comments: [],
        parents: [],
        teacherID: [],
        listUser: [],
        tab: 4,
        isEdit: true,
        headers: [
          { title: 'Date', key: 'date' },
          { title: 'Reason', key: 'reason' },
          { title: 'Status', key: 'status' }
        ]
      }
    },
    computed: {
      ...mapState(useStudentStore, ['studentDetails'])
    },
    methods: {
      ...mapActions(useStudentStore, ['getStudentDetails']),
      formatDate(dateString) {
        try {
          const date = parseISO(dateString)
          return format(date, 'dd-MMM-yyyy')
        } catch (error) {
          console.error('Error parsing date:', error)
          return dateString // Fallback to the original string if parsing fails
        }
      }
    }
  }
</script>
