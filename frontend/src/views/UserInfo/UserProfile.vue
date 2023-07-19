<template>
    <admin-dashboard></admin-dashboard>
    <v-sheet border="lg opacity-12" class="detail mt-6" elevation="4" height="450" rounded max-width="80%">
        <v-container fluid>
            <v-row>
                <v-col cols="12" md="3">
                    <v-img :src="users.profile" alt="Avatar" class="img-fluid my-7 w-75 rounded-circle ms-10" height="200"
                        cover>
                    </v-img>
                    <!-- {{ users.first_name }} {{ users.last_name }} -->
                    <v-btn class="ms-10 mt-5">
                        <v-icon size='24'>
                            mdi-account-plus
                        </v-icon>Change profile
                    </v-btn>
                </v-col>

                <v-col cols="12" md="9">
                    <v-col cols="auto" class="imformation">
                        <v-btn block density="default"><v-icon>
                                mdi-information
                            </v-icon>Personal Information</v-btn>

                        <v-card variant="text">
                            <v-icon>mdi-account </v-icon>Full name : {{ users.first_name }} {{ users.last_name }}
                        </v-card>
                        <v-icon>
                            mdi-map-marker 
                        </v-icon> {{ users.gender }}
                        <v-icon>
                            mdi-calendar
                        </v-icon> {{ users.date_of_birth }}
                        <v-icon>
                            mdi-numeric
                        </v-icon> {{ users.age }}
                       
                    <v-col cols="auto">
                        <v-btn block density="default">Contact Information</v-btn>
                    </v-col>
                        <v-icon> 
                            mdi-phone
                        </v-icon> {{ users.phone_number }}
                        <v-icon>
                            mdi-gender-transgender
                        </v-icon> {{ users.address }}
                        <v-icon>
                            mdi-email
                        </v-icon> {{ users.email }}
                    </v-col>
                    <v-col cols="auto">
                        <v-btn block density="default">Parent Information</v-btn>
                    </v-col>
                </v-col>
            </v-row>
        </v-container>
    </v-sheet>
</template>


<script>
import http from "@/htpp.common";

export default {
    name: "UserDetails",
    data() {
        return {
            users: " ",
        };
    },
    methods: {
        fetchData() {
            http.get("/api/v1/auth/user").then((response) => {
                this.users = response.data.data;
            });
        },
    },

    mounted() {
        this.fetchData();
    },
};
</script>


<style>
.detail {
    margin-left: 18%;
}

.imformation {
    display: flex;
    flex-direction: column;
}
</style>