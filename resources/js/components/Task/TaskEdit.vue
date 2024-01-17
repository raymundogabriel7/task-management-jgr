<!-- TaskForm.vue -->
<template>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <button class="btn btn-info" type="button" @click="redirectToListTask()">Task List</button>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <h2 class="text-center">Edit Task</h2>
        <form @submit.prevent="updateTask">
            <div class="mb-3">
              <label class="form-label">Title</label>
              <input class="form-control" v-model="task.title" />
              <div class="form-text text-danger" v-show="validationError.title !== ''">{{ validationError.title }}</div>
            </div>
            <div class="mb-3">
              <label class="form-label">Description</label>
              <textarea class="form-control" v-model="task.description"></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Status</label>
              <select class="form-control" v-model="task.status" id="status">
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Assign User</label>
              <select class="form-control" v-model="task.user_id" id="user_id">
                  <option v-for="userOption in userOptions" :key="userOption.id" :value="userOption.id">
                      {{ userOption.name }}
                  </option>
              </select>
              <div class="form-text text-danger" v-show="validationError.user_id !== ''">{{ validationError.user_id }}</div>
            </div>
            <br />
          <button class="btn btn-primary" type="submit">Update Task</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import getAllUsers from '../../api/user';
import { getTask, updateTask } from '../../api/task';

export default {
  props: ['id'],
  data() {
    return {
      task: {
        title: '',
        description: '',
        status: 'pending',
        user: null
      },
      validationError: {
        title: ''
      },
      error: '',
      userOptions: []
    };
  },
  mounted() {
    this.fetchTask();
    this.fetchAllUsers();
  },
  methods: {
    resetValidation: function () {
      this.validationError.title = ''
      this.error = ''
    },

    async fetchTask() {
      const task = await getTask(this.id);
      if(task.data) {
          this.task = task.data;
      }
    },
    async fetchAllUsers() {
      const allUsers = await getAllUsers();
      if(allUsers.data) {
          this.userOptions = allUsers.data;
      }
    },
    async updateTask() {
      this.resetValidation()

      if (!this.validate()) return

      const updatedTask = await updateTask(this.id, this.task);
      if(updatedTask.success) {
        this.$swal(updatedTask.message);
      } 
    },
    redirectToListTask() {
      window.location.href = import.meta.env.VITE_APP_BASE_URL + 'tasks'
    },
    validate: function () {
      let hasError = false

      if (!this.task.title) {
        hasError = true
        this.validationError.title = 'The title field is required.'
      }

      return !hasError
    }
  },
};
</script>

<style scoped>
/* Your component styles here */
</style>
