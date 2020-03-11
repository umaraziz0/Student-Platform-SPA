<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <button
                        type="button"
                        class="btn btn-success"
                        @click="createModal()"
                    >
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Add New Event
                    </button>
                    <FullCalendar
                        defaultView="dayGridMonth"
                        :plugins="calendarPlugins"
                    />
                </div>
            </div>
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
                                        v-model="form.title"
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
                                        v-model="form.start"
                                        class="custom-select"
                                        :class="{
                                            'is-invalid': form.errors.has(
                                                'start'
                                            )
                                        }"
                                        id="inputStartDate"
                                        name="start"
                                    />
                                    <has-error
                                        :form="form"
                                        field="start"
                                    ></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="inputEndDate">End Date:</label>
                                    <input
                                        type="date"
                                        v-model="form.end"
                                        class="custom-select"
                                        :class="{
                                            'is-invalid': form.errors.has('end')
                                        }"
                                        id="inputEndDate"
                                        name="end"
                                    />
                                    <has-error
                                        :form="form"
                                        field="end"
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
            calendarPlugins: [dayGridPlugin],
            editMode: false,
            url: "api/calendar/",
            data: {},
            form: new Form({
                id: "",
                student_id: "",
                title: "",
                start: "",
                end: "",
                start_time: "",
                end_time: "",
                details: ""
            })
        };
    },

    methods: {
        createModal() {
            $("#newModal").modal("show");
        }
    }
};
</script>
