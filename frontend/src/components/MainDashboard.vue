<template>
    <v-layout class="rounded rounded-md">
        <v-navigation-drawer class="sibar">
            <v-list>
                <v-list-item class="drawer">
                    <v-list-item>
                        <div class="image">
                            <v-img class="image" :width="200" :height="130" aspect-ratio="16/9" cover
                                src="https://png.pngtree.com/png-clipart/20211017/original/pngtree-school-logo-png-image_6851480.png"
                                rounded rounded-sm>
                            </v-img>
                        </div>
                    </v-list-item>
                    <v-list-item class="mt-10">
                        <v-btn v-for="menu in menubar" :key="menu" class="btn mt-4" block rounded variant="outlined"
                            :to="menu.path" active-class="white--text">
                            <v-icon size="24" class="me-2">
                                {{ menu.icon }}
                            </v-icon> {{ menu.title }}
                        </v-btn>
                    </v-list-item>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar title="School Management">
            <v-menu offset-y open-on-hover>
                <template v-slot:activator="{ props }">
                    <v-btn>{{ users.first_name }} {{ users.last_name }}</v-btn>
                    <v-btn icon v-bind="props">
                        <v-avatar color="brown" size="large">
                             <v-img :src="users.profile" alt="Avatar" cover>
                    </v-img>
                        </v-avatar>
                    </v-btn>
                </template>


                <v-card>
                    <v-card-text >
                        <div class=" mx-auto text-center">
                            <v-btn class="btn mt-2" block variant="outlined" rounded to="/user-profile"
                                active-class="white--text">
                                <v-icon size="24">
                                    mdi-account
                                </v-icon>Profile
                            </v-btn>

                            <v-btn class="btn mt-2" block variant="outlined" rounded to="/student-score"
                                active-class="white--text">
                                <v-icon size="24">
                                    mdi-lock
                                </v-icon>
                                Change Password
                            </v-btn>
                            <v-btn class="btn mt-2" block variant="outlined" rounded to="/student-score"
                                active-class="white--text">
                                <v-icon size="24">
                                    mdi-logout
                                </v-icon>
                                Logout
                            </v-btn>
                        </div>
                    </v-card-text>
                </v-card>

            </v-menu>
        </v-app-bar>

        <v-main class="main">

            <router-view></router-view>

        </v-main>
    </v-layout>
</template>
  
  
<script>
import http from '@/htpp.common'
export default {
    props: ['menubar'],
    name: "LayoutDashboard",
    data: () => ({
        users: [],
    }),

    mounted() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            http.get("/api/v1/auth/user").then((response) => {
                this.users = response.data.data;
            });
        },


        logout() {
            http.post("/api/v1/auth/logout", {},
                {
                    headers: {
                        Authorization: "Bearer " + localStorage.getItem("access_token"),
                    },
                }
            )
            .then(() => {
                localStorage.removeItem("access_token");
                sessionStorage.removeItem("email");
            })

            .catch((error) => {
                console.log(error);
            });
        },
    }
};
</script>
  
  
<style scoped>
@import "~vuetify/dist/vuetify.css";

.white--text {
    color: white !important;
}
.sibar {
    margin-right: 20px;
    box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px;
}

.btn {
    display: flex;
    justify-content: flex-start;
}

.image {
    border-radius: 100%;
}

.user-name span{
    text-transform: uppercase;
}

</style>
  