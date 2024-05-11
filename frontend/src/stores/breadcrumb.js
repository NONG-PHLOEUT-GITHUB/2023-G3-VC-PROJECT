// store.js
import { defineStore } from 'pinia';

export const useBreadcrumbStore = defineStore("breadcrumb",{
    state: () => ({
      previousRoute: null,
    }),
    actions: {
      // Action to update the previous route
      updatePreviousRoute(route) {
        this.previousRoute = route;
      },
    },
})
