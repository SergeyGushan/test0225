import { createRouter, createWebHistory } from 'vue-router';
import Review from "@/components/pages/Review.vue";
import Upload from "@/components/pages/Upload.vue";

const routes = [
  {
    path: '/',
    name: 'Review',
    component: Review
  },
  {
    path: '/upload',
    name: 'Upload',
    component: Upload
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
