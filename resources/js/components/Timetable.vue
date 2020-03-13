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
                                {{
                                    editMode ? "Edit Class" : "Create New Class"
                                }}
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
                                editMode ? editClass() : createClass()
                            "
                        >
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="inputName">Name:</label>
                                    <input
                                        type="text"
                                        v-model="form.name"
                                        class="form-control"
                                        :class="{
                                            'is-invalid': form.errors.has(
                                                'name'
                                            )
                                        }"
                                        id="inputName"
                                        placeholder=""
                                        field="name"
                                    />
                                    <has-error
                                        :form="form"
                                        field="name"
                                    ></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="inputStartDate"
                                        >Start Date:</label
                                    >
                                    <input
                                        type="date"
                                        v-model="form.start_date"
                                        class="custom-select"
                                        :class="{
                                            'is-invalid': form.errors.has(
                                                'start_date'
                                            )
                                        }"
                                        id="inputStartDate"
                                        name="start_date"
                                    />
                                    <has-error
                                        :form="form"
                                        field="start_date"
                                    ></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="inputEndDate">End Date:</label>
                                    <input
                                        type="date"
                                        v-model="form.end_date"
                                        class="custom-select"
                                        :class="{
                                            'is-invalid': form.errors.has(
                                                'end_date'
                                            )
                                        }"
                                        id="inputEndDate"
                                        name="end_date"
                                    />
                                    <has-error
                                        :form="form"
                                        field="end_date"
                                    ></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="inputStartTime"
                                        >Start Time:</label
                                    >
                                    <input
                                        type="time"
                                        v-model="form.start_time"
                                        class="custom-select"
                                        :class="{
                                            'is-invalid': form.errors.has(
                                                'start_time'
                                            )
                                        }"
                                        id="inputStartTime"
                                        name="start_time"
                                    />
                                    <has-error
                                        :form="form"
                                        field="start_time"
                                    ></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="inputEndTime">End Time:</label>
                                    <input
                                        type="time"
                                        v-model="form.end_time"
                                        class="custom-select"
                                        :class="{
                                            'is-invalid': form.errors.has(
                                                'end_time'
                                            )
                                        }"
                                        id="inputEndTime"
                                        name="end_time"
                                    />
                                    <has-error
                                        :form="form"
                                        field="end_time"
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
                                    {{ editMode ? "Update" : "Create" }}
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
                    :plugins="calendarPlugins"
                    :events="events"
                    @eventClick="showClass"
                    :visibleRange="{
                        start: '2020-03-09',
                        end: '2020-03-15'
                    }"
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
            events: "",
            form: new Form({
                id: "",
                student_id: "",
                course_name: "",
                class_type: "",
                day: "",
                start: "",
                end: "",
                room: "",
                building: "",
                details: ""
            })
        };
    },

    created() {
        this.getEvents();
    },

    methods: {
        getEvents(url = this.url) {
            axios
                .get(url)
                .then(res => {
                    this.events = res.data.data;
                })
                .catch(err => {
                    console.error(err.response.data);
                });
        },

        createModal() {
            //
        },

        createClass() {
            //
        },

        editClass() {
            //
        },

        deleteClass() {
            //
        },

        showClass() {
            //
        }
    }
};
</script>
