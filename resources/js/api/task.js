import axiosInstance from '../api/interceptors';
const apiBaseUrl = import.meta.env.VITE_API_BASE_URL;

export const getAllTasks = async function() {
    let response = null;

    await axiosInstance.get(apiBaseUrl + 'tasks')
        .then(res => {
          console.log('Successfully fetched all tasks.');
          response = res.data;
        })
        .catch(error => {
          console.error('Failed to fetch all tasks:', error);
          response = error.data;
        });

    return response;
};

export const getTask = async function(id) {
  let response = null;

  await axiosInstance.get(apiBaseUrl + `tasks/${id}`)
      .then(res => {
        console.log('Successfully fetched task.');
        response = res.data;
      })
      .catch(error => {
        console.error('Failed to fetch task:', error);
        response = error.data;
      });

  return response;
};

export const createTask = async function(request) {
    let response = null;

    await axiosInstance.post(apiBaseUrl + 'tasks', request)
        .then(res => {
          console.log('Successfully fetched all tasks.');
          response = res.data;
        })
        .catch(error => {
          console.error('Failed to fetch all tasks:', error);
          response = error.data;
        });

    return response;
}

export const updateTask = async function(id, request) {
  let response = null;

  await axiosInstance.put(apiBaseUrl + `tasks/${id}`, request)
      .then(res => {
        console.log('Successfully fetched all tasks.');
        response = res.data;
      })
      .catch(error => {
        console.error('Failed to fetch all tasks:', error);
        response = error.data;
      });

  return response;
}

export const deleteTask = async function(id) {
  let response = null;

  await axiosInstance.delete(apiBaseUrl + `tasks/${id}`)
      .then(res => {
        console.log('Successfully deleted task.');
        response = res.data;
      })
      .catch(error => {
        console.error('Failed to delete task:', error);
        response = error.data;
      });

  return response;
};

export default {getAllTasks, createTask, updateTask, deleteTask}