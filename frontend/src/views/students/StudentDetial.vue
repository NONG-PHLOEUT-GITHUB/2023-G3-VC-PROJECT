<template>
  <custom-title icon="mdi-eye"></custom-title>
  <v-breadcrumbs :items="items">
      <template v-slot:divider>
        <v-icon icon="mdi-chevron-right"></v-icon>
      </template>
    </v-breadcrumbs>
  <v-card>
    <v-tabs v-model="tab" align-tabs="start" color="deep-purple-accent-4">
      <v-tab value="1" direction="true">Account</v-tab>
      <v-tab value="2">Info</v-tab>
      <v-tab value="3">Comment</v-tab>
      <v-tab value="4">Score</v-tab>
      <v-tab value="5">Attendance</v-tab>
    </v-tabs>
    <v-window v-model="tab">
      <v-window-item value="1">
        <v-container fluid>
          <v-layout class="rounded rounded-md px-0">
            <v-col cols="3">
              <v-card>
                <v-card-text class="px-0 text-center">
                  <v-col>
                    <div>
                      <v-avatar color="grey" rounded="100" size="150" class="elevation-1">
                        <v-img :src="profile_image" cover></v-img>
                      </v-avatar>
                    </div>
                    <v-btn class="mt-2" :disabled="isEdit">upload new profile</v-btn>
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
                <custom-sub-title icon="mdi-account-card">Personal Information</custom-sub-title>
                <v-row>
                  <v-col>
                    <v-text-field
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
                      v-model="date_of_birth"
                      density="compact"
                      label="Date of birth"
                      variant="outlined"
                      :readonly="isEdit"
                      prepend-inner-icon=" mdi-calendar-range"
                    ></v-text-field>
                    <v-text-field
                      v-model="age"
                      density="compact"
                      label="Age"
                      variant="outlined"
                      :readonly="isEdit"
                      prepend-inner-icon="mdi-calendar-multiple-check"
                    ></v-text-field>
                  </v-col>
                </v-row>
                <custom-sub-title icon="mdi-contacts">Contact Information</custom-sub-title>
                <v-row>
                  <v-col>
                    <v-text-field
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
                    <v-avatar color="grey" rounded="100" size="150" class="elevation-1">
                      <v-img :src="profile_image" cover></v-img>
                    </v-avatar>
                  </div>
                  <v-btn class="mt-2" :disabled="isEdit">upload new profile</v-btn>
                </v-col>
                <v-divider></v-divider>
                <v-col>
                  <div>
                    <v-avatar color="grey" rounded="100" size="150" class="elevation-1">
                      <v-img :src="profile_image" cover></v-img>
                    </v-avatar>
                  </div>
                  <v-btn class="mt-2" :disabled="isEdit">upload new profile</v-btn>
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
              <custom-sub-title icon="mdi-account-card">Personal Information</custom-sub-title>
              <v-row>
                <v-col>
                  <v-text-field
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
                    v-model="date_of_birth"
                    density="compact"
                    label="Date of birth"
                    variant="outlined"
                    :readonly="isEdit"
                    prepend-inner-icon=" mdi-calendar-range"
                  ></v-text-field>
                  <v-text-field
                    v-model="age"
                    density="compact"
                    label="Age"
                    variant="outlined"
                    :readonly="isEdit"
                    prepend-inner-icon="mdi-calendar-multiple-check"
                  ></v-text-field>
                </v-col>
              </v-row>
              <custom-sub-title icon="mdi-contacts">Contact Information</custom-sub-title>
              <v-row>
                <v-col>
                  <v-text-field
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
                label="Teacher name"
                hide-details
                density="compact"
                variant="outlined"
              ></v-text-field>
            </v-col>
            <v-col>
              <v-text-field
                label="Title"
                hide-details
                density="compact"
                variant="outlined"
              ></v-text-field>
            </v-col>
          </v-row>
        </v-card>
        <v-card class="mt-2">
          <v-list :items="commentStudent" lines="three" item-props>
            <v-list-item
              v-for="comment in commentStudent"
              :key="comment.title"
              :subtitle="comment.title"
              :title="comment.first_name + ' ' + comment.last_name"
            >
              <span>{{ comment.body }}</span>
              <v-divider></v-divider>
              <template v-slot:subtitle="{ subtitle }">
                <div v-html="subtitle"></div>
              </template>
              <template v-slot:prepend>
                <v-avatar>
                  <v-img color="white" :src="comment.profile"></v-img>
                </v-avatar>
              </template>
            </v-list-item>
          </v-list>
        </v-card>
      </v-window-item>
      <v-window-item value="4"> score {{ scores }} </v-window-item>
      <v-window-item value="5">
        <v-data-table-server
          v-model:items-per-page="itemsPerPage"
          :headers="headers"
          :items="attendances"
          :items-length="attendances.length || 0"
          item-value="name"
          class="elevation-2"
        >
        </v-data-table-server>
      </v-window-item>
    </v-window>
  </v-card>
</template>

<script>
import { mapActions, mapState } from 'pinia'
import { useStudentStore } from '@/stores/student'
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
      itemsPerPage: 10,
      headers: [
        { title: 'Date', key: 'date' },
        { title: 'Reason', key: 'reason' },
        { title: 'Status', key: 'status' }
      ],
      items: [
        {
          title: 'Dashboard',
          disabled: false,
          href: 'breadcrumbs_dashboard',
        },
        {
          title: 'Link 1',
          disabled: false,
          href: 'breadcrumbs_link_1',
        },
        {
          title: 'Link 2',
          disabled: true,
          href: 'breadcrumbs_link_2',
        },
      ],
    }
  },
  computed: {
    ...mapState(useStudentStore, [
      'studentDetails',
      'classTeahcer',
      'commentStudent',
      'scores',
      'attendances',
      'first_name',
      'last_name',
      'gender',
      'date_of_birth',
      'profile_image',
      'age',
      'email',
      'address',
      'phone_number'
    ])
  },
  methods: {
    ...mapActions(useStudentStore, ['getStudentDetails'])
    //     getParentsByStudentID(id) {
    //       // http.get(`/getParents/${id}`).then((response) => {
    //       //   this.parents = response.data.guardian;
    //       //   console.log(this.parents);
    //       // });
    //     },
  }

  //   mounted() {
  //     this.getParents(id);
  //   },
}
</script>
