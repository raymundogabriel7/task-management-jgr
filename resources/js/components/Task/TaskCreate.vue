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
        <h2 class="text-center">Create Task</h2>
        <form @submit.prevent="storeTask">
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
          <button class="btn btn-primary" type="submit">Create Task</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import getAllUsers from '../../api/user';
import { createTask } from '../../api/task';
export default {
  data() {
    return {
      task: {
        title: '',
        description: '',
        status: 'pending',
        user_id: null
      },
      validationError: {
        title: '',
        user_id: ''
      },
      error: '',
      userOptions: []
    };
  },
  mounted() {

    this.fetchAllUsers();
  },
  methods: {
    resetValidation: function () {
      this.validationError.title = ''
      this.validationError.user_id = ''
      this.error = ''
    },

    resetForm: function () {
      this.task.title = ''
      this.task.description = ''
      this.task.status = 'pending'
      this.task.user_id = ''
    },
    async fetchAllUsers() {
      const allUsers = await getAllUsers();
      if(allUsers.data) {
          this.userOptions = allUsers.data;
      }
    },
    async storeTask() {
      this.resetValidation()

      if (!this.validate()) return

      const newTask = await createTask(this.task);
      if(newTask.success) {
        this.$swal(newTask.message)
        this.resetForm()
      } 
      
    },
    validate: function () {
      let hasError = false
      if (!this.task.title) {
        hasError = true
        this.validationError.title = 'The title field is required.'
      }

      if (!this.task.user_id) {
        hasError = true
        this.validationError.user_id = 'Please assign a user'
      }

      return !hasError
    },
    redirectToListTask() {
      window.location.href = import.meta.env.VITE_APP_BASE_URL + 'tasks'
    },
  },
};
</script>