<template>
    <div class="container">
        <div class="row justify-content-center">
            <!-- Modal -->
            <div
                class="modal fade"
                id="newModal"
                tabindex="-1"
                role="dialog"
                aria-labelledby="newModalLabel"
                aria-hidden="true"
            >
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                {{ editMode ? "Edit Class" : "Add New Class" }}
                            </h4>
                            <button
                                type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                            >
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form
                            @submit.prevent="
                                editMode ? editClass() : addClass()
                            "
                        >
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="inputCourseName"
                                        >Course Name:</label
                                    >
                                    <select
                                        name="course_name"
                                        id="inputCourseName"
                                        class="form-control custom-select"
                                        :class="{
                                            'is-invalid': form.errors.has(
                                                'course_id'
                                            )
                                        }"
                                        v-model="form.course_id"
                                        field="course_name"
                                    >
                                        <option
                                            v-for="course in courses"
                                            :key="course.course_id"
                                            :value="course.course_id"
                                            >{{
                                                course.course_name | toString
                                            }}</option
                                        >
                                    </select>
                                    <has-error
                                        :form="form"
                                        field="course_id"
                                    ></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="inputDay">Day:</label>
                                    <select
                                        type="text"
                                        v-model="form.day"
                                        class="custom-select"
                                        :class="{
                                            'is-invalid': form.errors.has('day')
                                        }"
                                        id="inputDay"
                                        name="day"
                                    >
                                        <option value="mon">Monday</option>
                                        <option value="tues">Tuesday</option>
                                        <option value="wed">Wednesday</option>
                                        <option value="thurs">Thursday</option>
                                        <option value="fri">Friday</option>
                                        <option value="sat">Saturday</option>
                                        <option value="sun">Sunday</option>
                                    </select>
                                    <has-error
                                        :form="form"
                                        field="day"
                                    ></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="inputDay">Type:</label><br />
                                    <div
                                        class="custom-control custom-radio custom-control-inline"
                                    >
                                        <input
                                            type="radio"
                                            v-model="form.class_type"
                                            id="lecture"
                                            value="lecture"
                                            name="type"
                                            class="custom-control-input"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'type'
                                                )
                                            }"
                                        />
                                        <label
                                            class="custom-control-label"
                                            for="lecture"
                                            >Lecture</label
                                        >
                                    </div>
                                    <div
                                        class="custom-control custom-radio custom-control-inline"
                                    >
                                        <input
                                            type="radio"
                                            v-model="form.class_type"
                                            id="lab"
                                            value="lab"
                                            name="type"
                                            class="custom-control-input"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'type'
                                                )
                                            }"
                                        />
                                        <label
                                            class="custom-control-label"
                                            for="lab"
                                            >Lab</label
                                        >
                                        <has-error
                                            :form="form"
                                            field="type"
                                        ></has-error>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputStartTime">Start:</label>
                                    <input
                                        type="time"
                                        v-model="form.start"
                                        class="form-control"
                                        :class="{
                                            'is-invalid': form.errors.has(
                                                'start'
                                            )
                                        }"
                                        id="inputStartTime"
                                        name="start"
                                    />
                                    <has-error
                                        :form="form"
                                        field="start"
                                    ></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="inputEndTime">End:</label>
                                    <input
                                        type="time"
                                        v-model="form.end"
                                        class="form-control"
                                        :class="{
                                            'is-invalid': form.errors.has('end')
                                        }"
                                        id="inputEndTime"
                                        name="end"
                                    />
                                    <has-error
                                        :form="form"
                                        field="end"
                                    ></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="inputRoom">Room:</label>
                                    <input
                                        type="text"
                                        v-model="form.room"
                                        class="form-control"
                                        :class="{
                                            'is-invalid': form.errors.has(
                                                'room'
                                            )
                                        }"
                                        id="inputRoom"
                                        name="room"
                                    />
                                    <has-error
                                        :form="form"
                                        field="room"
                                    ></has-error>
                                </div>

                                <div class="form-group">
                                    <label for="inputDetails">Details:</label>
                                    <textarea
                                        v-model="form.details"
                                        name="details"
                                        id="inputDetails"
                                        placeholder=""
                                        class="form-control"
                                        :class="{
                                            'is-invalid': form.errors.has(
                                                'details'
                                            )
                                        }"
                                    ></textarea>
                                    <has-error
                                        :form="form"
                                        field="details"
                                    ></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="color">Color: </label>
                                    <input
                                        type="color"
                                        id="color"
                                        v-model="form.color"
                                    />
                                    <input
                                        type="color"
                                        id="textColor"
                                        v-model="form.text_color"
                                        class="float-right"
                                    />
                                    <label for="textColor" class="float-right"
                                        >Text Color:&nbsp;
                                    </label>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button
                                    type="button"
                                    class="btn btn-danger"
                                    data-dismiss="modal"
                                >
                                    Close
                                </button>
                                <button
                                    v-show="editMode"
                                    type="button"
                                    class="btn btn-danger"
                                    @click="deleteClass()"
                                >
                                    Delete
                                </button>
                                <button
                                    type="submit"
                                    class="btn"
                                    :class="{
                                        'btn-success': !editMode,
                                        'btn-primary': editMode
                                    }"
                                >
                                    {{ editMode ? "Update" : "Add" }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal End -->
            <div class="col-md-12">
                <h1 class="text-center">Timetable</h1>
                <hr />
                <FullCalendar
                    defaultView="resourceTimeGridDay"
                    :minTime="minTime"
                    :maxTime="maxTime"
                    :plugins="calendarPlugins"
                    :events="classes"
                    @eventClick="showClass"
                    :resources="[
                        { id: 'mon', title: 'Monday' },
                        { id: 'tues', title: 'Tuesday' },
                        { id: 'wed', title: 'Wednesday' },
                        { id: 'thurs', title: 'Thursday' },
                        { id: 'fri', title: 'Friday' },
                        { id: 'sat', title: 'Saturday' },
                        { id: 'sun', title: 'Sunday' }
                    ]"
                    :customButtons="{
                        addEvent: {
                            text: 'Add New Class',
                            click: function() {
                                createModal();
                            }
                        }
                    }"
                    :header="{
                        left: '',
                        center: 'addEvent',
                        right: ''
                    }"
                    :allDaySlot="false"
                />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    components: {
        FullCalendar // make the <FullCalendar> tag available
    },
    data() {
        return {
            calendarPlugins: [resourceTimeGridPlugin, interactionPlugin],
            minTime: "06:00:00",
            maxTime: "22:00:00",
            editMode: false,
            url: "api/timetable/",
            eventExample: [
                {
                    id: 1,
                    resourceId: "mon",
                    title: "test",
                    start: "2020-03-14 12:00:00",
                    end: "2020-03-14 13:00:00"
                }
            ],
            classes: "",
            courses: {},
            form: new Form({
                id: "",
                student_id: "",
                course_id: "",
                class_type: "lecture",
                day: "",
                start: "",
                end: "",
                room: "",
                building: "",
                details: "",
                color: "#3788d9",
                text_color: "#ffffff"
            })
        };
    },

    created() {
        this.getClasses();
        this.getCourseNames();
    },

    methods: {
        getClasses(url = this.url) {
            axios
                .get(url)
                .then(res => {
                    this.classes = res.data.data;
                })
                .catch(err => {
                    console.error(err.response.data);
                });
        },

        getCourseNames() {
            axios
                .get("/api/takenCourses/")
                .then(response => {
                    this.courses = response.data;
                })
                // eslint-disable-next-line
                .catch(errors => {
                    //Handle Errors
                });
        },

        createModal() {
            this.editMode = false;
            this.form.clear();
            this.form.reset();
            $("#newModal").modal("show");
        },

        addClass(url = this.url) {
            this.form
                .post(url)
                .then(res => {
                    $("#newModal").modal("hide");
                    Toast.fire({
                        icon: "success",
                        title: "Class added."
                    });
                    this.getClasses();
                })
                .catch(err => {
                    console.error(err);
                });
        },

        showClass(arg) {
            this.editMode = true;
            this.form.clear();
            this.form.reset();
            $("#newModal").modal("show");

            const {
                id,
                student_id,
                course_id,
                title,
                resourceId,
                class_type,
                start,
                end,
                room,
                building,
                details,
                backgroundColor,
                textColor
            } = this.classes.find(event => event.id === +arg.event.id);

            let classData = {
                id: id,
                student_id: student_id,
                course_id: course_id,
                class_type: class_type,
                day: resourceId,
                start: start.slice(11),
                end: end.slice(11),
                room: room,
                building: building,
                details: details,
                color: backgroundColor,
                text_color: textColor
            };

            this.form.fill(classData);
        },

        editClass(url = this.url) {
            this.form
                .put(url + this.form.id)
                .then(res => {
                    $("#newModal").modal("hide");
                    Toast.fire({
                        icon: "success",
                        title: "Class updated."
                    });
                    this.getClasses();
                })
                .catch(err => {
                    console.log(err.response.data);
                });
        },

        deleteClass(url = this.url) {
            this.form
                .delete(url + this.form.id)
                .then(res => {
                    $("#newModal").modal("hide");
                    Toast.fire({
                        icon: "success",
                        title: "Class deleted."
                    });
                    this.getClasses();
                })
                .catch(err => {
                    console.error(err);
                });
        }
    }
};
</script>
