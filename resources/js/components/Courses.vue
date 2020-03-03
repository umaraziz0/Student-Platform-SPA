<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Courses Taken</h3>
                        <div class="card-tools"></div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Course ID</th>
                                    <th>Course Name</th>
                                    <th>Credits</th>
                                    <th>Teacher</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="course in coursesTaken"
                                    :key="course.id"
                                >
                                    <td>{{ course.course_id }}</td>
                                    <td>{{ course.course_name }}</td>
                                    <td>{{ course.credits }}</td>
                                    <td>{{ course.teacher }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- card -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Courses List</h3>
                        <div class="card-tools"></div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Course ID</th>
                                    <th>Course Name</th>
                                    <th>Credits</th>
                                    <th>Teacher</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="course in courses" :key="course.id">
                                    <td>{{ course.course_id }}</td>
                                    <td>{{ course.course_name }}</td>
                                    <td>{{ course.credits }}</td>
                                    <td>{{ course.teacher }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- card -->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            courses: {},
            coursesTaken: {},
            form: new Form({
                id: "",
                course_id: "",
                course_name: "",
                credits: "",
                teacher: ""
            })
        };
    },

    methods: {
        loadAssignments() {
            axios
                .get("api/course")
                .then(({ data }) => (this.courses = data.data));
        }
    },

    created() {
        this.$Progress.start();
        this.loadAssignments();
        this.$Progress.finish();
    }
};
</script>
