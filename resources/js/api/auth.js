import axios from 'axios';
const apiBaseUrl = import.meta.env.VITE_API_BASE_URL;
const authUser = async function(request) {
    let response = null;

    await axios.post(apiBaseUrl + 'authenticate', request)
        .then(res => {
          console.log('Login successful');
          response = res;
        })
        .catch(error => {
          console.error('Login failed:', error);
          response = error.response;
        });
    return response;
}

export default authUser