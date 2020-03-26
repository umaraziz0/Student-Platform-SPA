<template>
    <p>{{ teacherName }}</p>
</template>

<script>
export default {
    props: {
        data: {}
    },

    data() {
        return {
            teacherName: this.data.teacher_name.join(", ")
        };
    }
};
</script>
