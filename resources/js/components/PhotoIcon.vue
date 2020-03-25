<template>
    <img class="img-circle img-bordered-sm icon-avatar" :src="url" />
</template>

<script>
export default {
    props: {
        data: {}
    },

    data() {
        return {
            url: this.data.photo
                ? "/img/teachers/" + this.data.photo
                : "/img/profile/default.png"
        };
    }
};
</script>

<style lang="scss">
.icon-avatar {
    border-radius: 50%;
    width: 2.5rem;
}
</style>
