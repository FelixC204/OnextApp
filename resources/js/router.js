import { createRouter, createWebHistory  } from "vue-router";
import Home from "../Pages/Home.vue";
import Login from "../Pages/Login.vue";
import Logout from "../Pages/Logout.vue";
import MenuBuilder from "../Pages/MenuBuilder.vue";
import NotFound from "../Pages/NotFound.vue";
import Profile from "../Pages/Profile.vue";
const routes = [
    {
        path: "/",
        component: Login,
        meta: {
            title: 'Login',
        },
    },
    {
        path: "/home",
        component: Home
    },
    {
        path: "/logout",
        component: Logout
    },
    {
        path: "/menu",
        component:  MenuBuilder
    },
    {
        path: "/:catchAll(.*)",
        component: NotFound,
    },
    {
        path: "/profile",
        component: Profile,
        meta: {
            title: 'Profile',
        },
    }
];


const router =  createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    document.title = to.meta.title || 'Onext Mega Menu';
    next();
});

export default router;
