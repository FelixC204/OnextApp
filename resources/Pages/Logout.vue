<template>
    <div>
      <!-- You can add a loading indicator here if needed -->
    </div>
  </template>
  
  <script>
  import { onMounted } from 'vue';
  import axios from 'axios';
  import Swal from 'sweetalert2';
  import { useRouter } from 'vue-router';
  
  export default {
    name: "Logout",
    setup() {
      const router = useRouter();
  
      const showError = (message) => {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: message,
        });
      };
  
      const showSuccess = (message) => {
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: message,
        });
      };
  
      const logout = async () => {
        try {
          const response = await axios.post('/api/logout', {}, {
            headers: {
              'Content-Type': 'application/json',
              'Authorization': `Bearer ${localStorage.getItem('token')}`,
            },
          });
  
          if (response.status === 200) {
        //    Xoá hết dữ liệu trong localStorage
            localStorage.clear();
            showSuccess('Đăng xuất thành công!');
            router.push('/');
          } else {
            throw new Error('Unexpected response from server');
          }
        } catch (error) {
          console.error('Logout error:', error);
          if (error.response) {
            // The request was made and the server responded with a status code
            // that falls out of the range of 2xx
            showError(`An error occurred: ${error.response.data.message || 'Please try again.'}`);
          } else if (error.request) {
            // The request was made but no response was received
            showError('No response received from server. Please check your connection and try again.');
          } else {
            // Something happened in setting up the request that triggered an Error
            showError('An error occurred while logging out. Please try again.');
          }
        }
      };
  
      onMounted(() => {
        logout();
      });
  
      return { showError, showSuccess };
    }
  }
  </script>