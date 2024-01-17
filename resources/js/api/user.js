import axiosInstance from '../api/interceptors';

const apiBaseUrl = import.meta.env.VITE_API_BASE_URL;

export const getAllUsers = async function() {
    let response = null;

    await axiosInstance.get(apiBaseUrl + 'users')
        .then(res => {
          console.log('Successfully fetched all users.');
          response = res.data;
        })
        .catch(error => {
          console.error('Failed to fetch all users:', error);
          response = error.data;
        });

    return response;
};

export default getAllUsers;