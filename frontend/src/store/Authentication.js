import { defineStore } from "pinia";
export const useUserAuth = defineStore("",{
    state: () => ({
        loggedIn: false,
        user: null,
      }),
    
      login(email, password) {
        // Perform authentication logic here
        // ...
    
        // Update the store's state
        this.loggedIn = true;
        this.user = { email };
      },
    
      logout() {
        // Perform logout logic here
        // ...
    
        // Update the store's state
        this.loggedIn = false;
        this.user = null;
      },
    
      get currentUser() {
        return this.user;
      },
    
      get isLoggedIn() {
        return this.loggedIn;
      },
})