<!-- TaskForm.vue -->
<template>
  <div>
    <h2>Update Task</h2>
    <form @submit.prevent="storeTask">
        <label>Title:</label>
        <input v-model="task.title" required />
        <br />
        <label>Description:</label>
        <textarea v-model="task.description" required></textarea>
        <br />
        <label for="status">Task Status:</label>
        <select v-model="task.status" id="status">
            <option value="pending">Pending</option>
            <option value="completed">Completed</option>
        </select>
        <br />
        <label for="user_id">Select an option:</label>
        <select v-model="task.user_id" id="user_id">
            <option v-for="userOption in userOptions" :key="userOption.id" :value="userOption.id">
                {{ userOption.name }}
            </option>
        </select>
        <br />
      <button type="submit">Update Task</button>
    </form>
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
        user: null
      },
      userOptions: []
    };
  },
  mounted() {
    console.log(this)
    //this.fetchTask();
    //this.fetchAllUsers();
  },
  methods: {
    async fetchAllUsers() {
      const allUsers = await getAllUsers();
      if(allUsers.data) {
        console.log(allUsers)
          this.userOptions = allUsers.data;
      }
    },
    async storeTask() {
      const newTask = await createTask(this.task);

      console.log(newTask)
    },
  },
};
</script>

<style scoped>
/* Your component styles here */
</style>
