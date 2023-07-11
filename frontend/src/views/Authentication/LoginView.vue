<template>
    <div class="container d-flex align-center justify-center" style="height: 100vh">
        <v-sheet width="500" class="mx-auto border--5" elevation="10">
            <v-row>
                <v-col cols="12">
                    <h2 class="mb-10">LOGIN</h2>
                </v-col>
            </v-row>
            <v-form @submit.prevent="login">
                <v-text-field ref="emailField" variant="outlined" v-model="email" btype="email" label="Email"
                    placeholder="Email" prepend-inner-icon="mdi-account" required />

                <v-text-field ref="passwordField" class="mt-4" variant="outlined" v-model="password" />
                <a href="#" class="text-body-2 font-weight-regular">Forgot Password?</a>

                <v-btn type="submit" color="primary" block class="mt-4">login</v-btn>

            </v-form>
        </v-sheet>
    </div>
</template>
<script>
import axios from 'axios';
export default {
    data: () => ({
        email: '',
        password: '',
    }),

    methods: {
        login() {
            console.log(this.email, this.password);
            axios.post('/api/v1/auth/login', {
                email: this.email,
                password: this.password,
            })
                .then(response => {
                    // store JWT token in localStorage
                    console.log(response);
                    // localStorage.setItem('token', response.data.token)

                    // redirect to dashboard page
                    this.$router.push('/dashboard')
                })
                .catch(error => {
                    // handle error
                    console.log(error);
                })
        }
    }

}
</script>
<style>
.container {
    padding: 20px;
}

.mx-auto {
    padding: 20px;
}

h2 {
    margin-bottom: 20%;
}
</style>