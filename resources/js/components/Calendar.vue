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
                                    editMode ? "Edit Event" : "Create New Event"
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
                                editMode ? editEvent() : createEvent()
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
                                    @click="deleteEvent()"
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
            <div class="col-md-10">
                <h1 class="text-center">Calendar</h1>
                <hr />
                <div class="card">
                    <FullCalendar
                        defaultView="dayGridMonth"
                        :plugins="calendarPlugins"
                        :events="events"
                        @eventClick="showEvent"
                        :customButtons="{
                            addEvent: {
                                text: 'Add New Event',
                                click: function() {
                                    createModal();
                                }
                            }
                        }"
                        :header="{
                            left: 'title',
                            center: 'addEvent',
                            right: 'today prev next'
                        }"
                    />
                </div>
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
            calendarPlugins: [dayGridPlugin, interactionPlugin],
            editMode: false,
            url: "api/calendar/",
            events: "",
            form: new Form({
                id: "",
                student_id: "",
                name: "",
                start_date: "",
                end_date: "",
                start_time: "",
                end_time: "",
                details: ""
            })
        };
    },

    created() {
        this.getEvents();
    },

    methods: {
        createModal() {
            this.editMode = false;
            this.form.clear();
            this.form.reset();
            $("#newModal").modal("show");
        },

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

        showEvent(arg) {
            this.editMode = true;
            this.form.clear();
            this.form.reset();
            $("#newModal").modal("show");

            const {
                id,
                student_id,
                title,
                start,
                end,
                start_time,
                end_time,
                details
            } = this.events.find(event => event.id === +arg.event.id);

            let eventData = {
                id: id,
                student_id: student_id,
                name: title,
                start_date: start,
                end_date: end,
                start_time: start_time,
                end_time: end_time,
                details: details
            };

            this.form.fill(eventData);
        },

        editEvent(url = this.url) {
            this.form
                .put(url + this.form.id)
                .then(res => {
                    $("#newModal").modal("hide");
                    Toast.fire({
                        icon: "success",
                        title: "Event updated!"
                    });
                    this.getEvents();
                })
                .catch(err => {
                    console.log(err.response.data);
                });
        },

        createEvent(url = this.url) {
            this.form
                .post(url)
                .then(res => {
                    $("#newModal").modal("hide");
                    Toast.fire({
                        icon: "success",
                        title: "Event created!"
                    });
                    this.getEvents();
                })
                .catch(err => {
                    console.error(err);
                });
        },

        deleteEvent(url = this.url) {
            this.form
                .delete(url + this.form.id)
                .then(res => {
                    $("#newModal").modal("hide");
                    Toast.fire({
                        icon: "success",
                        title: "Event deleted!"
                    });
                    this.getEvents();
                })
                .catch(err => {
                    console.error(err);
                });
        }
    }
};
</script>
