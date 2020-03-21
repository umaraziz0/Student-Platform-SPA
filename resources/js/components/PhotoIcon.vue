<template>
    <div class="btn-group">
        <img src="" alt="" />
    </div>
</template>

<script>
export default {
    props: {
        data: {}
    },

    data() {
        return {
            url: "/api/teacher/",
            data: {}
        };
    },

    methods: {
        getData(url = this.url, options = this.tableProps) {
            axios
                .get(url, {
                    params: options
                })
                .then(response => {
                    this.data = response.data;
                })
                // eslint-disable-next-line
                .catch(errors => {
                    //Handle Errors
                });
        },

        getPhoto() {
            let photo;

            if (!data.photo) {
                photo = "/img/profile/default.png";
            } else {
                photo = "/img/teachers/" + data.photo;
            }

            return photo;
        }
    }
};
</script>
