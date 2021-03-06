/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");

import DataTable from "laravel-vue-datatable";
Vue.use(DataTable);

import ButtonEdit from "./components/ButtonEdit.vue";
import ButtonDelete from "./components/ButtonDelete.vue";
import ButtonCheck from "./components/ButtonCheck.vue";
import UppercaseString from "./components/UppercaseString.vue";
import FormatDate from "./components/FormatDate.vue";
import PhotoIcon from "./components/PhotoIcon.vue";
import TeacherIds from "./components/TeacherIds.vue";
import TeacherNames from "./components/TeacherNames.vue";
import CourseNames from "./components/CourseNames.vue";

window.ButtonEdit = ButtonEdit;
window.ButtonDelete = ButtonDelete;
window.ButtonCheck = ButtonCheck;
window.UppercaseString = UppercaseString;
window.FormatDate = FormatDate;
window.PhotoIcon = PhotoIcon;
window.TeacherIds = TeacherIds;
window.TeacherNames = TeacherNames;
window.CourseNames = CourseNames;

import FullCalendar from "@fullcalendar/vue";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import resourceTimeGridPlugin from "@fullcalendar/resource-timegrid";
import listPlugin from "@fullcalendar/list";

window.FullCalendar = FullCalendar;
window.dayGridPlugin = dayGridPlugin;
window.interactionPlugin = interactionPlugin;
window.resourceTimeGridPlugin = resourceTimeGridPlugin;
window.listPlugin = listPlugin;

import moment from "moment";
import {
    Form,
    HasError,
    AlertError
} from "vform";
import VueProgressBar from "vue-progressbar";

Vue.use(VueProgressBar, {
    color: "rgb(143, 255, 199)",
    failedColor: "red",
    height: "3px",
    location: "top"
});

window.Swal = require("sweetalert2");

window.Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: false
});

// VForm
window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

import VueRouter from "vue-router";
Vue.use(VueRouter);

let routes = [{
        path: "/admin/home",
        component: require("./components/AdminHome.vue").default
    },
    {
        path: "/admin/users",
        component: require("./components/Users.vue").default
    },
    {
        path: "/edit-profile",
        component: require("./components/EditProfile.vue").default
    },
    {
        path: "/admin/majors",
        component: require("./components/Majors.vue").default
    },
    {
        path: "/admin/edit-grades",
        component: require("./components/EditGrades.vue").default
    },
    {
        path: "/admin/edit-courses",
        component: require("./components/EditCourses.vue").default
    },
    {
        path: "/admin/edit-teachers",
        component: require("./components/EditTeachers.vue").default
    },
    {
        path: "/admin/courses-taught",
        component: require("./components/CoursesTaught.vue").default
    },
    {
        path: "/home",
        component: require("./components/Dashboard.vue").default
    },
    {
        path: "/profile",
        component: require("./components/Profile.vue").default
    },
    {
        path: "/todo",
        component: require("./components/Todo.vue").default
    },
    {
        path: "/agenda/assignments",
        component: require("./components/Assignments.vue").default,
    },
    {
        path: "/agenda/exams",
        component: require("./components/Exams.vue").default
    },
    {
        path: "/calendar",
        component: require("./components/Calendar.vue").default
    },
    {
        path: "/timetable",
        component: require("./components/Timetable.vue").default
    },
    {
        path: "/grades",
        component: require("./components/Grades.vue").default
    },
    {
        path: "/courses",
        component: require("./components/Courses.vue").default
    },
    {
        path: "/teachers",
        component: require("./components/Teachers.vue").default
    },
    {
        path: "*",
        component: require("./components/404.vue").default
    },
    // {
    //     path: "/developer",
    //     component: require("./components/Developer.vue").default
    // },
];

const router = new VueRouter({
    mode: "history",
    routes, // short for `routes: routes`
    linkActiveClass: "active" // sets element tab class to 'active' if on current page
});

// Global vue filters

// reformat date
Vue.filter("formatDateDay", function (created) {
    return moment(created).format("dddd, MMMM Do @ h:mm a");
});

Vue.filter("formatDate", function (created) {
    return moment(created).format("MMMM Do, YYYY");
});

Vue.filter('toString', function (value) {
    if (!value) return ''
    return value.toString();
})


window.Fire = new Vue(); // custom global event bus

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component(
    "passport-clients",
    require("./components/passport/Clients.vue").default
);

Vue.component(
    "passport-authorized-clients",
    require("./components/passport/AuthorizedClients.vue").default
);

Vue.component(
    "passport-personal-access-tokens",
    require("./components/passport/PersonalAccessTokens.vue").default
);

Vue.component(
    "example-component",
    require("./components/ExampleComponent.vue").default
);

Vue.component(
    "logo",
    require("./components/Logo.vue").default
);

Vue.component(
    "profile-pic",
    require("./components/ProfilePicture.vue").default
);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app",
    router
});
