<!-- TaskList.vue -->
<template>
  <div>
    <table class="task-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Description</th>
          <th>Pending</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="task in tasks" :key="task.id">
          <td>{{ task.id }}</td>
          <td>{{ task.title }}</td>
          <td>{{ task.description }}</td>
          <td>{{ task.pending }}</td>
          <td>
            <button @click="editTask(task)">Edit</button>
            <button @click="deleteTask(task.id)" class="delete-btn">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import {getAllTasks} from '../../api/task';
export default {
  data() {
    return {
      tasks: [],
    };
  },
  mounted() {
    this.fetchAllTasks();
  },
  methods: {
    async fetchAllTasks() {
      const allTasks = await getAllTasks();
      if(allTasks.data) {
          this.tasks = allTasks.data;
      }
    },
    editTask(task) {
      console.log('Edit task:', task);
    },
    deleteTask(taskId) {
      console.log('Delete task:', taskId);
    },
  },
};
</script>

<style scoped>
/* TaskList.vue styles */
.task-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.task-table th, .task-table td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

.delete-btn {
  color: white;
  background-color: red;
  border: none;
  padding: 5px 10px;
  cursor: pointer;
}
</style>
