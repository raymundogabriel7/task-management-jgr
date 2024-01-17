<template>
  <div class="container mt-5">
    <div class="row mt-3">
      <div class="col-md-6">
        <div class="form-group">
          <input v-model="searchQuery" placeholder="Search by title" class="form-control" />
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <select v-model="searchStatus" class="form-control">
              <option value="all" selected>All</option>
              <option value="pending">Pending</option>
              <option value="completed">Completed</option>
          </select>
        </div>
      </div>
      <div class="col-md-2">
          <button class="btn btn-info" type="button" @click="redirectToCreateTask()">Create Task</button>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Pending</th>
            <th>User</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="task in filteredItems" :key="task.id">
            <td>{{ task.id }}</td>
            <td>{{ task.title }}</td>
            <td>{{ task.status }}</td>
            <td>{{ task.user.name }}</td>
            <td>
              <button class="btn btn-primary btn-sm mr-1" @click="redirectToEditTask(task.id)">Edit</button>
              <button class="btn btn-danger btn-sm" @click="deleteTaskWarning(task.id)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <nav class="text-center">
      <button class="btn btn-link btn-sm" @click="previousPage" :disabled="currentPage === 1">Previous</button>
      <span>{{ currentPage }} / {{ totalPages }}</span>
      <button class="btn btn-link btn-sm" @click="nextPage" :disabled="currentPage === totalPages">Next</button>
    </nav>
  </div>
</template>

<script>
import {getAllTasks, deleteTask} from '../../api/task';
export default {
  data() {
    return {
      tasks: [],
      itemsPerPage: 5,
      currentPage: 1,
      searchQuery: '',
      searchStatus: 'all'
    };
  },
  mounted() {
    this.fetchAllTasks();
    

  },
  computed: {
    totalPages() {
      return Math.ceil(this.tasks.length / this.itemsPerPage);
    },
    paginatedTasks() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.tasks.slice(start, end);
    },
    filteredItems() {
      return this.paginatedTasks.filter(item =>
        item.title.toLowerCase().includes(this.searchQuery.toLowerCase()) &&
        (item.status.includes(this.searchStatus) || this.searchStatus === 'all')
      );
    },
  },
  methods: {
    async fetchAllTasks() {
      const allTasks = await getAllTasks();
      if(allTasks.data) {
          this.tasks = allTasks.data;
      }
    },
    deleteTaskWarning(taskId) {
      
      this.$swal({
        title: "Delete this record?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes"
    }).then(async (result) => {
        if (result.value) {
          const deleteTaskResult = await deleteTask(taskId);
          if(deleteTaskResult.success) {
              this.$swal(deleteTaskResult.message)
              this.fetchAllTasks()
          }
        }
    });
    },
    redirectToCreateTask() {
      window.location.href = import.meta.env.VITE_APP_BASE_URL + 'tasks/create'
    },

    redirectToEditTask(id) {
      window.location.href = import.meta.env.VITE_APP_BASE_URL + `tasks/${id}/edit`
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
      }
    },
    previousPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
      }
    },
  },
};
</script>
