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

export default {getAllTasks, createTask}