<template>
    <div>

    </div>
</template>

<script>
    export default {
        name: "tag-selection",
        props: ['tenant_id'],
        data() {
            return {
                tags: []
            }
        },
        created() {
            this.getAllTags();
        },
        methods: {
            getAllTags: function () {
                const url = window.location.protocol + "//" + window.location.host + '/api/tag/' + this.tenant_id + '/get-tag-list';
                axios.get(url).then(response => {
                    console.log(response.data);
                }).catch(error => {
                    console.log(error);
                })
            }
        }
    }
</script>

<style scoped>

</style>