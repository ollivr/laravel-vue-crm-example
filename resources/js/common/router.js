import Vue from 'vue';
import VueRouter from 'vue-router';
import i18n from './i18n';
import Welcome from '../components/frontend/Welcome';
import Login from '../components/user/Login';
import Users from '../components/user/Users';
import UserForm from '../components/user/UserForm';
import User from '../components/user/User';
import Departments from '../components/department/Departments';
import Department from '../components/department/Department';
import DepartmentForm from '../components/department/DepartmentForm';
import store from "./store";
import Dashboard from "../components/backend/Dashboard";

Vue.use(VueRouter);

const router = new VueRouter({
    routes: [
        {
            path: '/',
            name: 'welcome',
            component: Welcome,
            meta: {
                guest: true,
                title: i18n.t('welcome')
            }
        },
        {
            path: '/admin',
            name: 'dashboard',
            component: Dashboard,
            meta: {
                auth: true,
                title: i18n.t('dashboard')
            }
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
            meta: {
                guest: true,
                title: i18n.t('login')
            }
        },
        {
            path: '/admin/users/',
            name: 'users',
            component: Users,
            meta: {
                auth: true,
                title: i18n.t('users')
            }
        },
        {
            path: '/admin/users/create',
            name: 'user-add',
            component: UserForm,
            meta: {
                auth: true,
                title: i18n.t('addUser')
            }
        },
        {
            path: '/admin/users/:id',
            name: 'user-view',
            component: User,
            meta: {
                auth: true,
                title: i18n.t('viewUser')
            }
        },
        {
            path: '/admin/users/:id/edit',
            name: 'user-edit',
            component: UserForm,
            meta: {
                auth: true,
                title: i18n.t('editUser')
            }
        },
        {
            path: '/admin/departments/',
            name: 'departments',
            component: Departments,
            meta: {
                auth: true,
                title: i18n.t('departments')
            }
        },
        {
            path: '/admin/departments/create',
            name: 'department-add',
            component: DepartmentForm,
            meta: {
                auth: true,
                title: i18n.t('addDepartment')
            }
        },
        {
            path: '/admin/departments/:id',
            name: 'department-view',
            component: Department,
            meta: {
                auth: true,
                title: i18n.t('viewDepartment')
            }
        },
        {
            path: '/admin/departments/:id/edit',
            name: 'department-edit',
            component: DepartmentForm,
            meta: {
                auth: true,
                title: i18n.t('editDepartment')
            }
        },
    ],
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.auth)) {
        if (store.getters.getAccessToken == null) {
            next({
                 path: '/login',
                 params: {nextUrl: to.fullPath}
            })
        }
        next();
    } else if (to.matched.some(record => record.meta.guest)) {
        if (store.getters.getAccessToken == null) {
            next()
        } else {
            next({name: 'dashboard'})
        }
    } else {
        next()
    }
});

export default router;