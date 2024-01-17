// router/index.js
import * as Vue from 'vue';
import VueRouter from 'vue-router';

// Import your components
import TaskEdit from '../components/Task/TaskEdit.vue';
Vue.use(VueRouter);

const routes = [

  {
    path: '/tasks/:taskId/edit',
    name: 'tasks',
    component: TaskEdit,
  },
  // Add more routes as needed
];

const router = new VueRouter({
  routes,
});

export default router;
