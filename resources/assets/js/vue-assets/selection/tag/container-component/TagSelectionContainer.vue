<template>
    <div>

        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search_text" id="search_text" placeholder="Search Tag..."/>
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <a :href="tag.report_url" role="button" v-for="tag in tags">
                <div class="col-lg-3 col-xs-6">
                    <div class="panel text-center" v-bind:style="{ 'background': tag.bgColor }">
                        <span style="color: white;">{{ tag.name }}</span>
                    </div>
                </div>
            </a>
        </div>
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
                    this.tags = response.data.data;
                }).catch(error => {
                    console.log(error);
                })
            }
        }
    }
</script>

<style scoped>

</style>