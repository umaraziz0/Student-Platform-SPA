<template>
    <img
        class="img-circle img-bordered-sm icon-avatar"
        :src="'/img/teachers/' + data.photo"
    />
</template>

<script>
export default {
    props: {
        data: {}
    }
};
</script>

<style lang="scss">
.icon-avatar {
    border-radius: 50%;
    width: 2.5rem;
}
</style>
