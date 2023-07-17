import { defineStore } from "pinia";
export const useUserStore = defineStore("User", {
    state() {
        return {
            name: "Hello world"
        }
    }
})