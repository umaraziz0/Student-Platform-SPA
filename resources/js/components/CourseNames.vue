<template>
    <p>{{ courseName }}</p>
</template>

<script>
export default {
    props: {
        data: {}
    },

    data() {
        return {
            courseName: this.data.course_name.join(", ")
        };
    }
};
</script>
