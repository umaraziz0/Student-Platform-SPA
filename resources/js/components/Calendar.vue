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
                                    <label for="inputStart">Start:</label>
                                    <input
                                        type="datetime-local"
                                        v-model="form.start"
                                        class="custom-select"
                                        :class="{
                                            'is-invalid': form.errors.has(
                                                'start'
                                            )
                                        }"
                                        id="inputStart"
                                        name="start"
                                    />
                                    <has-error
                                        :form="form"
                                        field="start"
                                    ></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="inputEnd">End:</label>
                                    <input
                                        type="datetime-local"
                                        v-model="form.end"
                                        class="custom-select"
                                        :class="{
                                            'is-invalid': form.errors.has('end')
                                        }"
                                        id="inputEnd"
                                        name="end"
                                    />
                                    <has-error
                                        :form="form"
                                        field="end"
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
                                <div class="form-check">
                                    <input
                                        type="checkbox"
                                        class="form-check-input"
                                        id="allDay"
                                        v-model="form.all_day"
                                    />
                                    <label class="form-check-label" for="allDay"
                                        >All Day Event</label
                                    >
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
        FullCalendar
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
                start: "",
                end: "",
                details: "",
                color: "#3788d9",
                text_color: "#ffffff",
                all_day: false
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

            // get values from the event object
            const {
                id,
                student_id,
                title,
                start,
                end,
                details,
                backgroundColor,
                textColor,
                allDay
            } = this.events.find(event => event.id === +arg.event.id);

            let eventData = {
                id: id,
                student_id: student_id,
                name: title,
                start: start.replace(" ", "T"),
                end: end ? end.replace(" ", "T") : "",
                details: details,
                color: backgroundColor,
                text_color: textColor,
                all_day: allDay
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
