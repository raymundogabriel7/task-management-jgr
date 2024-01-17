
import {createApp} from 'vue/dist/vue.esm-bundler.js'
import Login from './components/Login.vue';
import TaskList from './components/Task/TaskList.vue';
import TaskCreate from './components/Task/TaskCreate.vue';
import TaskEdit from './components/Task/TaskEdit.vue';
import VueSweetalert2 from 'vue-sweetalert2';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import 'sweetalert2/dist/sweetalert2.min.css';


const app = createApp({
    components: {
        Login,
        TaskList,
        TaskCreate,
        TaskEdit
    }
});

app.use(VueSweetalert2);
app.mount("#app")