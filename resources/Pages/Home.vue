<template>
    <div>
        <LoadingPageComponent v-if="loading" />
        <div v-else class="min-h-screen bg-gradient-to-br from-gray-900 to-gray-800 p-4 sm:p-6 md:p-8">
            <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-2xl overflow-hidden">
                <div class="p-6 sm:p-8">
                    <h1 class="text-4xl font-bold mb-6 text-gray-800">Welcome back!</h1>
                    <p class="text-gray-600">You have <strong>{{ notifications.length }}</strong> new notifications.</p>
                    <div class="space-y-6">
                        <div class="flex items-center justify-between">
                            <h2 class="text-2xl font-semibold text-gray-700 flex items-center">
                                <Bell class="mr-2 h-6 w-6 text-gray-600" />
                                Notifications
                            </h2>
                            <span class="text-sm font-medium text-gray-500">{{ notifications.length }} new</span>
                        </div>

                        <TransitionGroup name="list" tag="div" class="space-y-3">
                            <div v-for="notification in notifications" :key="notification.id"
                                class="bg-gray-50 p-4 rounded-lg shadow-md flex justify-between items-center transition duration-300 ease-in-out hover:bg-gray-100">
                                <p class="text-gray-700">{{ notification.message }}</p>
                                <button
                                    @click="showComfirm('Are you sure you want to dismiss this notification?', notification.id)"
                                    class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded-full text-sm transition duration-300 ease-in-out">
                                    Dismiss
                                </button>
                            </div>
                        </TransitionGroup>

                        <p v-if="notifications.length === 0" class="text-gray-500 text-center py-4">
                            No new notifications
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';
import { Bell } from 'lucide-vue-next';
import LoadingPageComponent from '../Components/LoadingPageComponent.vue';

export default {
    name: "Home",
    components: {
        LoadingPageComponent,
        Bell,
    },
    data() {
        return {
            loading: true,
            token: null,
            notifications: [],
        };
    },

    async mounted() {
        const header = {
            'Content-Type': 'application/json',
        };
        const params = {
            secret: this.$route.query.secret,
            user_id: this.$route.query.user_id,
        };
        localStorage.setItem('shop', this.$route.query.shop);
        const url = '/api/get-access-token';
        if (localStorage.getItem('token') === null) {
            if (!params.secret) {
                this.showError('Secret is required');
                return;
            }
            if (!params.user_id) {
                this.showError('User ID is required');
                window.location.href = '/';
                return;
            }
            try {
                const response = await axios.post(url, {
                    secret: params.secret,
                    user_id: params.user_id,
                }, {
                    headers: header,
                });

                if (response.data) {
                    const access_token = response.data.access_token; // Fix: get access_token from response data
                    this.showSuccess('Đăng nhập thành công!');
                    localStorage.setItem('token', access_token);
                    this.token = access_token;
                } else {
                    this.showError(response.data.message);
                }
            } catch (error) {
                // Handle error (network error, server issues, etc.)
                console.error('Error during login:', error);
                this.showError('Đã xảy ra lỗi, vui lòng thử lại.');
            }
        }
        this.loading = false;
        this.notifications = [
            { id: 1, message: "You have a new message!" },
            { id: 2, message: "Your profile has been updated." },
        ];

    },
    methods: {
        removeNotification(id) {
            this.notifications = this.notifications.filter(notification => notification.id !== id);
        },
        showError(message) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...Bạn cần phải đăng nhập',
                text: message,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
            }).then(() => {
                window.location.href = '/';
            });
        },
        showSuccess(message) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: message,
            });
        },
        showComfirm(message, id) {
            loading: true,
                Swal.fire({
                    title: 'Are you sure?',
                    text: message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.removeNotification(id);
                        Swal.fire(
                            'Deleted!',
                            'Your notification has been dismissed.',
                            'success'
                        );
                    }
                });
        },
    },
};
</script>

<style scoped></style>
