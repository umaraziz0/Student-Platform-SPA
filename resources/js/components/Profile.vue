<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <!-- Widget: user widget style 1 -->
                <div class="card card-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-info">
                        <h3 class="widget-user-username">{{ form.name }}</h3>
                        <h5 class="widget-user-desc">{{ form.student_id }}</h5>
                    </div>
                    <div class="widget-user-image">
                        <img
                            class="img-circle elevation-2"
                            :src="getPhoto()"
                            @error="defaultPhoto"
                        />
                    </div>
                    <div class="card-footer">
                        <div class="row justify-content-center">
                            <div class="col-sm-3 border-right" v-if="form.year">
                                <div class="description-block">
                                    <h5 class="description-header">
                                        {{ form.year }}
                                    </h5>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div
                                class="col-sm-3 border-right"
                                v-if="form.major"
                            >
                                <div class="description-block">
                                    <h5 class="description-header">
                                        {{ form.major }}
                                    </h5>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div
                                class="col-sm-3 border-right"
                                v-if="form.email"
                            >
                                <div class="description-block">
                                    <h5 class="description-header">
                                        {{ form.email }}
                                    </h5>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <div class="col-sm-3" v-if="form.phone">
                                <div class="description-block">
                                    <h5 class="description-header">
                                        {{ form.phone }}
                                    </h5>
                                </div>
                                <!-- /.description-block -->
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
            </div>
            <!-- /.widget-user -->
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header p-2 pl-3">Edit Profile</div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="settings">
                                <form class="form-horizontal">
                                    <div class="form-group row">
                                        <label
                                            for="inputName"
                                            class="col-sm-2 col-form-label"
                                            >Name</label
                                        >
                                        <div class="col-sm-10">
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
                                                placeholder="Name"
                                            />
                                            <has-error
                                                :form="form"
                                                field="name"
                                            ></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label
                                            for="studentId"
                                            class="col-sm-2 col-form-label"
                                            >Student ID</label
                                        >
                                        <div class="col-sm-10">
                                            <input
                                                type="number"
                                                v-model="form.student_id"
                                                class="form-control"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'student_id'
                                                    )
                                                }"
                                                id="studentId"
                                                placeholder="Student ID"
                                            />
                                            <has-error
                                                :form="form"
                                                field="student_id"
                                            ></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label
                                            for="sex"
                                            class="col-sm-2 col-form-label"
                                            >Gender</label
                                        >
                                        <div class="col-sm-10">
                                            <div
                                                class="custom-control custom-radio custom-control-inline"
                                            >
                                                <input
                                                    type="radio"
                                                    v-model="form.sex"
                                                    id="male"
                                                    value="male"
                                                    name="sex"
                                                    class="custom-control-input"
                                                    :class="{
                                                        'is-invalid': form.errors.has(
                                                            'sex'
                                                        )
                                                    }"
                                                />
                                                <label
                                                    class="custom-control-label"
                                                    for="male"
                                                    >Male</label
                                                >
                                            </div>
                                            <div
                                                class="custom-control custom-radio custom-control-inline"
                                            >
                                                <input
                                                    type="radio"
                                                    v-model="form.sex"
                                                    id="female"
                                                    value="female"
                                                    name="sex"
                                                    class="custom-control-input"
                                                    :class="{
                                                        'is-invalid': form.errors.has(
                                                            'sex'
                                                        )
                                                    }"
                                                />
                                                <label
                                                    class="custom-control-label"
                                                    for="female"
                                                    >Female</label
                                                >
                                            </div>
                                            <has-error
                                                :form="form"
                                                field="sex"
                                            ></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label
                                            for="inputBirthdate"
                                            class="col-sm-2 col-form-label"
                                            >Birth Date:</label
                                        >
                                        <div class="col-sm-10">
                                            <input
                                                type="date"
                                                v-model="form.birthdate"
                                                class="form-control"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'birthdate'
                                                    )
                                                }"
                                                id="inputBirthdate"
                                            />
                                            <has-error
                                                :form="form"
                                                field="birthdate"
                                            ></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label
                                            for="inputBirthplace"
                                            class="col-sm-2 col-form-label"
                                            >Birth Place:</label
                                        >
                                        <div class="col-sm-10">
                                            <input
                                                type="text"
                                                v-model="form.birthplace"
                                                class="form-control"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'birthplace'
                                                    )
                                                }"
                                                id="inputBirthplace"
                                            />
                                            <has-error
                                                :form="form"
                                                field="birthplace"
                                            ></has-error>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="form-group row">
                                        <label
                                            for="inputYear"
                                            class="col-sm-2 col-form-label"
                                            >Year</label
                                        >
                                        <div class="col-sm-10">
                                            <input
                                                type="number"
                                                v-model="form.year"
                                                class="form-control"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'year'
                                                    )
                                                }"
                                                id="inputYear"
                                                placeholder="Year"
                                            />
                                            <has-error
                                                :form="form"
                                                field="year"
                                            ></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label
                                            for="inputMajor"
                                            class="col-sm-2 col-form-label"
                                            >Major</label
                                        >
                                        <div class="col-sm-10">
                                            <select
                                                v-model="form.major"
                                                class="custom-select"
                                                id="inputMajor"
                                                name="major"
                                            >
                                                <option value="Computer Science"
                                                    >Computer Science</option
                                                >
                                                <option
                                                    value="Software Engineering"
                                                    >Software
                                                    Engineering</option
                                                >
                                                <option
                                                    value="Computer Engineering"
                                                    >Computer
                                                    Engineering</option
                                                >
                                            </select>
                                            <has-error
                                                :form="form"
                                                field="major"
                                            ></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label
                                            for="inputEmail"
                                            class="col-sm-2 col-form-label"
                                            >Email</label
                                        >
                                        <div class="col-sm-10">
                                            <input
                                                type="email"
                                                class="form-control"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'email'
                                                    )
                                                }"
                                                id="inputEmail"
                                                v-model="form.email"
                                                placeholder="Email"
                                            />
                                            <has-error
                                                :form="form"
                                                field="email"
                                            ></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label
                                            for="inputPhone"
                                            class="col-sm-2 col-form-label"
                                            >Phone Number</label
                                        >
                                        <div class="col-sm-10">
                                            <input
                                                type="number"
                                                class="form-control"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'phone'
                                                    )
                                                }"
                                                v-model="form.phone"
                                                id="inputPhone"
                                                placeholder="Phone Number"
                                            />
                                            <has-error
                                                :form="form"
                                                field="phone"
                                            ></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label
                                            for="inputPhone"
                                            class="col-sm-2 col-form-label"
                                            >Password (leave empty if not
                                            changing)</label
                                        >
                                        <div class="col-sm-10">
                                            <input
                                                type="password"
                                                class="form-control"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'password'
                                                    )
                                                }"
                                                v-model="form.password"
                                                id="inputPassword"
                                                placeholder="Password"
                                            />
                                            <has-error
                                                :form="form"
                                                field="password"
                                            ></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label
                                            for="photo"
                                            class="col-sm-2 col-form-label"
                                            >Profile Picture</label
                                        >
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                            <div class="custom-file">
                                                <input
                                                    type="file"
                                                    @change="updatePhoto"
                                                    name="photo"
                                                    class="form-control"
                                                    id="photo"
                                                />
                                                <label
                                                    for="photo"
                                                    class="custom-file-label"
                                                ></label></div>
                                                <div class="input-group-append">
                                                    <span
                                                        class="input-group-text"
                                                        style="cursor:pointer"
                                                        @click.prevent="removePhoto"
                                                        >Remove
                                                    </span>
                                                </div>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button
                                                type="submit"
                                                @click.prevent="updateInfo"
                                                class="btn btn-danger"
                                            >
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: new Form({
                id: "",
                student_id: "",
                name: "",
                email: "",
                password: "",
                photo: "",
                major: "",
                year: "",
                phone: "",
                sex: "",
                birthdate: "",
                birthplace: ""
            })
        };
    },

    methods: {
        getPhoto() {
            //   let photo =
            //     this.form.photo.length > 100
            //       ? this.form.photo
            //       : "img/profile/" + this.form.photo;

            //   return photo;

            return "img/profile/" + this.form.photo;
        },

        getInfo() {
            axios.get("api/profile").then(({ data }) => this.form.fill(data));
            // this.getPhoto();
        },

        defaultPhoto(e) {
            e.target.src = "img/profile/default.png";
        },

        removePhoto() {
            this.$Progress.start();
            this.form
                .delete("api/removePhoto")
                .then(() => {
                    this.$Progress.finish();
                    Toast.fire({
                        icon: "success",
                        title: "Picture removed."
                    });
                    Fire.$emit("refresh");
                })
                .catch(() => {
                    this.$Progress.fail();
                    Toast.fire({
                        icon: "error",
                        title: "An error occurred."
                    });
                });
        },

        updatePhoto(e) {
            let file = e.target.files[0];
            let reader = new FileReader();
            if (file["size"] < 2111775) {
                //change the file to base64
                reader.onloadend = file => {
                    // console.log("RESULT", reader.result);
                    this.form.photo = reader.result;
                };
                reader.readAsDataURL(file);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "File size too large. Maximum size is 2MB."
                });
            }
        },

        updateInfo() {
            this.$Progress.start();
            this.form
                .put("api/profile")
                .then(() => {
                    this.$Progress.finish();
                    Swal.fire({
                        icon: "success",
                        title: "Profile updated."
                    });
                    Fire.$emit("refresh");
                    // window.scrollTo(0, 0);
                })
                .catch(() => {
                    this.$Progress.fail();
                });
        }
    },

    created() {
        this.$Progress.start();
        this.getInfo();
        Fire.$on("refresh", () => {
            this.getInfo();
        });
        this.$Progress.finish();
    }
};
</script>
