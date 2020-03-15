<template>
    <div class="image">
        <img :src="url" class="img-circle elevation-2" />
    </div>
</template>

<script>
export default {
    props: ["userphoto"],

    data() {
        return {
            url: "/img/profile/" + this.userphoto
        };
    }
};
</script>
