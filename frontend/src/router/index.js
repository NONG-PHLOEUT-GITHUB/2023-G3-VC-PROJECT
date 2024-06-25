import { createRouter, createWebHistory } from "vue-router";

const routes = [
  {
    path: "/prestation",
    name: "MES PRESTATIONS ANNEXES",
    component: () => import("@/views/prestation/AdditionalService.vue"),
    meta: { isSecure: true },
  },
  {
    path: "/prestation/edit/:id?",
    name: "MODIFICATION PRESTATION ANNEXE",
    component: () => import("@/components/dialog/EditPrestation.vue"),
    meta: { isSecure: true },
  },
  {
    path: "/statistiques",
    name: "PRESTATIONS ANNEXES STATISTIQUES",
    component: () => import("@/views/prestation/PrestaionAnnexeStat.vue"),
    meta: { isSecure: true },
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: "/",
      meta: { isSecure: true },
      component: () => import("@/views/layout/Layout.vue"),
      children: routes,
      redirect: "prestation",
    },
  ],
});

export default router;
