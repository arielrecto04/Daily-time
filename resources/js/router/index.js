import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "../stores/useAuthStore";

const routes = [
    {
        path: "/",
        name: "home",
        component: () => import("@/pages/LandingPage.vue"),
    },
    {
        path: "/login",
        name: "login",
        meta: { title: "Login", redirectIfAuthenticated: true },
        component: () => import("@/pages/auth/Login.vue"),
    },
    {
        path: "/dashboard",
        name: "dashboard",
        meta: { requiresAuth: true, title: "Dashboard" },
        component: () => import("@/pages/Dashboard.vue"),
    },
    {
        path: "/users",
        name: "users",
        meta: { requiresAuth: true, title: "Users" },
        component: () => import("@/pages/users/IndexUser.vue"),
    },
    {
        path: "/attendance",
        name: "attendance",
        meta: { requiresAuth: true, title: "Attendance" },
        component: () => import("@/pages/attendance/IndexAttendance.vue"),
    },
    {
        path: "/departments",
        name: "departments",
        meta: { requiresAuth: true, title: "Departments" },
        component: () => import("@/pages/department/IndexDepartment.vue"),
    },
    {
        path: "/leave-application",
        name: "leave-application",
        meta: { requiresAuth: true, title: "Leave Application" },
        redirect: "/leave-application/list",
        component: () =>
            import("@/pages/leave-application/ParentLeaveApplication.vue"),
        children: [
            {
                path: "list",
                name: "leave-application-list",
                meta: { requiresAuth: true, title: "Leave Application List" },
                component: () =>
                    import(
                        "@/pages/leave-application/IndexLeaveApplication.vue"
                    ),
            },
            {
                path: "create",
                name: "leave-application-create",
                meta: { requiresAuth: true, title: "Leave Application Create" },
                component: () =>
                    import(
                        "@/pages/leave-application/CreateLeaveApplication.vue"
                    ),
            },
        ],
    },
    {
        path: "/settings",
        name: "settings",
        meta: { requiresAuth: true, title: "Settings" },
        component: () => import("@/pages/setting/IndexSetting.vue"),
        redirect: "/settings/leave-types",
        children: [
            {
                path: "leave-types",
                name: "leave-types",
                meta: { requiresAuth: true, title: "Leave Types" },
                component: () =>
                    import("@/pages/setting/leave-type/IndexLeaveType.vue"),
            },
        ],
    },
    {
        path: "/:pathMatch(.*)*",
        name: "NotFound",
        component: () => import("@/Pages/NotFound.vue"),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const authStore = useAuthStore();

    if (to.meta.requiresAuth && !authStore.isAuthenticated) {
        next({ name: "login" });

        return;
    }
    if (to.meta.redirectIfAuthenticated && authStore.isAuthenticated) {
        next({ name: "dashboard" });

        return;
    }

    next();
});

router.afterEach((to, from) => {
    document.title = to.meta.title || "Daily Time Record System";
});

export default router;
