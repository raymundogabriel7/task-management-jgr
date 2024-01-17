
import {createApp} from 'vue/dist/vue.esm-bundler.js'
import Login from './components/Login.vue';
import TaskList from './components/Task/TaskList.vue';
import TaskCreate from './components/Task/TaskCreate.vue';
import TaskEdit from './components/Task/TaskEdit.vue';

//import router from './router';

const app = createApp({
    components: {
        Login,
        TaskList,
        TaskCreate,
        TaskEdit
    }
});
//app.use(router)
app.mount("#app")